<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use App\Http\Repositories\TaskRepository;
use App\Http\Repositories\UserRepository;
use App\Http\Repositories\TaskItemRepository;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Throwable;

class TaskController extends Controller
{
    private $tr;
    private $ur;
    private $tir;

    public function __construct() {
        $this->tr = new TaskRepository;
        $this->ur = new UserRepository;
        $this->tir = new TaskItemRepository;
    }

    public function index(Request $request, Task $t)
    {
        $t = $t->newQuery();

        if(isset($request->status))
        {
            $t->where('status', $request->status);
        }
        if(isset($request->designator_id))
        {
            $t->where('designator_id', $request->designator_id);
        }
        if(isset($request->initiator_id))
        {
            $t->where('initiator_id', $request->initiator_id);
        }
        $t->orderBy('id', 'DESC');
        $t->with(['initiator', 'designator']);
        $ts = $t->paginate(20);
        return view('admin.all-tasks')->with(['ts' => $ts]);
    }

    public function userAssignedTasks(Request $request)
    {
        $ts = $this->tr->findWherePaginate([
            'designator_id' => auth()->user()->id],
            ['initiator', 'designator', 'items']
        );
        return view('user.task-list')->with(['ts' => $ts]);
    }

    public function userAssignedSubTasks(Request $request)
    {
        $ts = $this->tir->findWherePaginateWithDistinct([
            'designator_id' => auth()->user()->id],
            ['task.initiator', 'designator']
        );

        return view('user.subtask-list')->with(['ts' => $ts]);
    }

    public function userAssignedTasksByStatus($status, Request $request)
    {
        $ts = $this->tr->findWherePaginate([
            'designator_id' => auth()->user()->id,
            'status' => $status
        ],
            ['initiator', 'designator', 'items']
        );
        return view('user.task-list')->with(['ts' => $ts]);
    }

    public function startAssignedTask(Request $request)
    {
        if(!isset($request->task_id)) {
            return redirect()->back();
        }

        $r = $this->tr->findOne(['id' => $request->task_id, 'designator_id' => auth()->user()->id]);
        if(!isset($r))
            return redirect()->back();
        $this->tr->update(['status' => 'In-Progress'], ['id' => $request->task_id]);
        $request->session()->flash('success', 'Task started successfully');
        return redirect()->back();
    }

    public function startSubAssignedTask(Request $request)
    {
        if(!isset($request->sub_task_id)) {
            return redirect()->back();
        }

        $r = $this->tir->findOne(['id' => $request->sub_task_id, 'designator_id' => auth()->user()->id]);
        if(!isset($r))
            return redirect()->back();
        $this->tir->update(['status' => 'In-Progress'], ['id' => $request->sub_task_id]);
        $request->session()->flash('success', 'Sub-Task started successfully');
        return redirect()->back();
    }

    public function createTask(Request $request)
    {
        $staff = $this->ur->findWhere(['is_admin' => 0]);
        return view('admin.create-task')->with(['staff' => $staff, 'task' => null]);
    }

    public function editTask(Request $request, $task_id)
    {
        $staff = $this->ur->findWhere(['is_admin' => 0]);
        $task = $this->tr->find($task_id);
        return view('admin.create-task')->with([
            'task' => $task, 'staff' => $staff
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function createNewTask(Request $request)
    {
        $this->validate($request, [
            'title'         => 'required|min:5',
            'description'   => 'required|min:10',
            'start_date'    => 'required|min:4',
            'delivery_date' => 'required|min:4',
        ]);

        try {
            $data                       = $request->except(['_token']);
            $data['initiator_id']       = auth()->user()->id;

            $this->tr->insert($data);
            $request->session()->flash('success', "Task created successfully.");
        } catch (Throwable $th) {
           $request->session()->flash('error', "Error occurred while adding new task.");
        }
        return redirect()->back();
    }

    /**
     * @throws ValidationException
     */
    public function updateTask(Request $request)
    {
        $this->validate($request, [
            'title'         => 'required|min:5',
            'description'   => 'required|min:10',
            'start_date'    => 'required|min:4',
            'delivery_date' => 'required|min:4',
        ]);

        try {
            $this->tr->update(
                [
                    'title' => $request->title,
                    'initiator_id' => auth()->user()->id,
                    'designator_id' => $request->designator_id,
                    'description' => $request->description,
                    'start_date'  => $request->start_date,
                    'delivery_date' => $request->delivery_date,
                ],
                ['id' => $request->id]
            );
            $request->session()->flash('success', "Task updated successfully.");
        } catch (Throwable $th) {
            $request->session()->flash('error', "Error occurred while adding new task.");
        }
        return redirect()->back();
    }

    public function addNewTaskItem($task_id, Request $request)
    {
        $r = $this->tr->find($task_id, ['initiator', 'designator', 'items', 'items.designator']);
        if(!isset($r))
            abort(404);
        return view('admin.task-detail')->with([
            'task' => $r, 'item' => null
        ]);
    }

    public function editTaskItem(Request $request, $task_id, $item_id)
    {
        $staff = $this->ur->findWhere(['is_admin' => 0]);
        $item = $this->tir->find($item_id);
        if(!isset($item)) abort(404);
        return view('admin.add-taskitem')->with([
            'item' => $item, 'staff' => $staff
        ]);
    }

    public function updateTaskItem(Request $request)
    {
        $this->validate($request, [
            'task_indicator'         => 'required|min:5',
            'description'            => 'required|min:10',
            'task_id'                => 'required|integer',
        ]);

        try {
            $this->tir->update(
                [
                    'task_indicator' => $request->task_indicator,
                    'task_id' => $request->task_id,
                    'designator_id' => $request->designator_id,
                    'description' => $request->description
                ],
                ['id' => $request->id]
            );
            $request->session()->flash('success', "Task item updated successfully.");
        } catch (Throwable $th) {
            $request->session()->flash('error', "Error occurred while updating this task item.");
        }
        return redirect()->back();
    }

    public function viewUserAssignedTask($task_id, Request $request)
    {
        $r = $this->tr->findOne(['id' => $task_id, 'designator_id' => auth()->user()->id], $with=['initiator', 'designator', 'items', 'items.designator']);
        if(!isset($r))
            abort(404);
        return view('user.task-detail')->with([
            'task' => $r
        ]);
    }

    public function viewUserAssignedSubTask($subtask_id, Request $request)
    {
        $r = $this->tir->findOne(['id' => $subtask_id, 'designator_id' => auth()->user()->id],
        $with=['task.initiator', 'designator', 'designator']);
        if(!isset($r))
            abort(404);
        return view('user.subtask-detail')->with([
            'task' => $r
        ]);
    }

    public function addTaskItem($task_id, Request $request)
    {
        $r = $this->tr->find($task_id);
        if(!isset($r))
            abort(404);
        $staff = $this->ur->findWhere(['is_admin' => 0]);
        return view('admin.add-taskitem')->with(['task' => $r, 'staff' => $staff]);
    }

    public function createNewTaskItem(Request $request)
    {
        $this->validate($request, [
            'task_indicator'         => 'required|min:5',
            'description'            => 'required|min:10',
            'task_id'                => 'required|integer',
        ]);

        try {
            $data  = $request->except(['_token']);

            $this->tir->insert($data);
            $request->session()->flash('success', "Task item created successfully.");
        } catch (Throwable $th) {
           $request->session()->flash('error', "Error occurred while adding new task item.");
        }
        return redirect()->back();
    }

    private function formatDate($str) {
        $fd = Carbon::parse($str)->format('Y/d/m');
        return $fd;
    }
}
