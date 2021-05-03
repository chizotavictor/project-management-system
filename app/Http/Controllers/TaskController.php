<?php

namespace App\Http\Controllers;

use App\Http\Constants\Index;
use App\Http\Repositories\TaskItemIssueRepository;
use App\Notifications\TaskItemIssueClosedNotification;
use App\Notifications\TaskItemIssueNotification;
use App\Notifications\TaskItemIssueResolvedNotification;
use App\Task;
use App\TaskItemIssue;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Repositories\TaskRepository;
use App\Http\Repositories\UserRepository;
use App\Http\Repositories\TaskItemRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Throwable;

class TaskController extends Controller
{
    private $tr;
    private $ur;
    private $tir;
    private $tsr;

    public function __construct() {
        $this->tr = new TaskRepository;
        $this->ur = new UserRepository;
        $this->tir = new TaskItemRepository;
        $this->tsr = new TaskItemIssueRepository;
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
        $this->tr->update(['status' => Index::IN_PROGRESS], ['id' => $request->task_id]);
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
        $this->tir->update(['status' => Index::IN_PROGRESS], ['id' => $request->sub_task_id]);
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
     * @param Request $request
     * @return RedirectResponse
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
     * @param Request $request
     * @return RedirectResponse
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

    public function deleteTask(Request $request)
    {
        $task = $this->tr->find($request->id);
        try {
            $task->status = Index::IN_ACTIVE;
            $task->save();
            $request->session()->flash('success', "Task deleted successfully.");
        } catch (Throwable $th) {
            $request->session()->flash('error', "Error occurred while deleting this task.");
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

    public function deleteTaskItem(Request $request)
    {
        $item = $this->tir->find($request->id);
        try {
            $item->status = Index::IN_ACTIVE;
            $item->save();
            $request->session()->flash('success', "Task Item deleted successfully.");
        } catch (Throwable $th) {
            $request->session()->flash('error', "Error occurred while deleting this task item.");
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
        return view('admin.add-taskitem')->with(['task' => $r, 'staff' => $staff, 'item' => null]);
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

    public function allIssues($task_id, $item_id)
    {
        $issues = $this->tsr->findWhere(['task_item_id' => $item_id]);
        return view('admin.all-issues', compact('item_id', 'issues', 'task_id'));
    }

    public function addIssue($item_id)
    {
        $issue = null;
        $item = $this->tir->findOne(['id' => $item_id]);
        return view('admin.add-issue', compact('item', 'issue'));
    }

    public function editIssue($issue_id)
    {
        $issue = $this->tsr->findOne(['id' => $issue_id]);
        $item = $issue->taskItem;
        return view('admin.add-issue', compact('issue', 'item'));
    }

    public function createNewIssue(Request $request)
    {
        DB::beginTransaction();
        $this->validate($request, [
            'comment'   => 'required',
            'task_item_id'   => 'required|integer',
        ]);

        $item = $this->tir->find($request->task_item_id);
        $designator = $item->designator;
        $taskTitle = $item->task->title;

        try {
            $data = $request->except(['_token']);
            $this->tsr->insert($data);
            Notification::send($designator, new TaskItemIssueNotification($taskTitle));
            DB::commit();
            $request->session()->flash('success', "Task item issue created successfully.");
        } catch (Throwable $th) {
            DB::rollBack();
            $request->session()->flash('error', "Error occurred while adding new task item issue.");
        }
        return redirect()->back();
    }

    public function updateIssue(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'comment' => 'required',
            'task_item_id' => 'required|integer',
        ]);

        try {
            $this->tsr->update(
                ['comment' => $request->comment, 'task_item_id' => $request->task_item_id,],
                ['id' => $request->id]
            );
            $request->session()->flash('success', "Task item issue updated successfully.");
        } catch (Throwable $th) {
            $request->session()->flash('error', "Error occurred while updating this task issue.");
        }
        return redirect()->back();
    }

    public function viewUserTaskItemIssues($item_id)
    {
        $issues = $this->tsr->findWhere(['task_item_id' => $item_id]);
        return view('user.all-task-item-issues', compact('item_id', 'issues'));
    }

    public function resolveIssue(Request  $request)
    {
        DB::beginTransaction();
        $this->validate($request, [
            'id' => 'required',
        ]);

        $issue = $this->tsr->find($request->id);
        $taskTitle = $issue->taskItem->task->title;
        $users = $this->ur->findWhere(['is_admin' => 1]);

        try {
            $this->tsr->update(['status' => Index::IN_REVIEW], ['id' => $request->id]);
            foreach ($users as $user) {
                Notification::send($user, new TaskItemIssueResolvedNotification($taskTitle));
            }
            DB::commit();
            $request->session()->flash('success', "Admin has been notified successfully.");
        } catch (Throwable $th) {
            DB::rollBack();
            $request->session()->flash('error', "Error occurred while adding new task item issue.");
        }
        return redirect()->back();
    }

    public function closeIssue(Request $request)
    {
        DB::beginTransaction();
        $this->validate($request, [
            'id' => 'required',
        ]);

        $item = $this->tsr->find($request->id)->taskItem;
        $designator = $item->designator;
        $taskTitle = $item->task->title;
        try {
            $this->tsr->update(['status' => Index::CLOSED], ['id' => $request->id]);
            Notification::send($designator, new TaskItemIssueClosedNotification($taskTitle));
            DB::commit();
            $request->session()->flash('success', "Task item issue was closed successfully.");
        } catch (Throwable $th) {
            DB::rollBack();
            $request->session()->flash('error', "Error occurred while adding new task item issue.");
        }
        return redirect()->back();
    }

    public function viewUserAllIssues()
    {
        $user_id = auth()->user()->id;
        $issues = TaskItemIssue::select('task_item_issues.*')
            ->join('task_items', 'task_item_issues.task_item_id', '=', 'task_items.id')
            ->where('designator_id', $user_id)->get();
        return view('user.all-issues', compact('issues'));
    }
}
