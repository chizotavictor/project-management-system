<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Repositories\TaskRepository;
use App\Http\Repositories\UserRepository;
use App\Http\Repositories\TaskItemRepository;
use Carbon\Carbon;

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

    public function index(Request $request, \App\Task $t)
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
        return view('admin.create-task')->with(['staff' => $staff]);
    }

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
            $data['start_date']         = $this->formatDate($data['start_date']);
            $data['delivery_date']      = $this->formatDate($data['delivery_date']);

            $this->tr->insert($data);
            $request->session()->flash('success', "Task created successfully.");
        } catch (\Throwable $th) {
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
            'task' => $r    
        ]);
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
        // return $r;
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
        } catch (\Throwable $th) {
           $request->session()->flash('error', "Error occurred while adding new task item.");
        }
        return redirect()->back();
    }

    private function formatDate($str) {
        $fd = Carbon::parse($str)->format('Y/d/m');
        return $fd;
    }
}
