<?php

namespace App\Http\Controllers;

use App\Http\Constants\Index;
use App\TaskItemIssue;
use Illuminate\Http\Request;
use App\Http\Repositories\UserRepository;
use App\Http\Repositories\TaskRepository;
use App\Http\Repositories\TaskItemRepository;

class HomeController extends Controller
{
    private $tr;
    private $tir;
    private $str;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->tr = new TaskRepository;
        $this->tir = new TaskItemRepository;
        $this->str = new UserRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(auth()->user()->is_admin == "1")
            return view('home')->with([
                'totalTask'                 => $this->totalTask(),
                'totalCompletedTask'        => $this->totalCompletedTask(),
                'totalPendingTask'          => $this->totalPendingTask(),
                'totalInprogressTask'       => $this->totalInprogressTask(),
                'totalAdministrator'        => $this->totalAdministrator(),
                'totalUser'                 => $this->totalUser(),
                'commissioned_users'        => $this->comissionedUsers(),
                'uncomissionedUsers'        => $this->uncomissionedUsers(),
                'totalUserIssue'            => $this->totalUserIssues(),
                'totalUserInReviewIssues'   => $this->totalUserInReviewIssues(),
                'totalUserOpenIssues'       => $this->totalUserOpenIssues(),
                'totalUserClosedIssues'     => $this->totalUserClosedIssues()
            ]);
        else
            return view('user-home')->with([
                'totalTask'                 => $this->totalUserTask(),
                'totalCompletedTask'        => $this->totalUserCompletedTask(),
                'totalPendingTask'          => $this->totalUserPendingTask(),
                'totalInprogressTask'       => $this->totalUserInprogressTask(),
                'totalSubTask'              => $this->totalSubUserTask(),
                'totalSubCompletedTask'     => $this->totalSubUserCompletedTask(),
                'totalSubPendingTask'       => $this->totalSubUserPendingTask(),
                'totalSubInprogressTask'    => $this->totalSubUserInprogressTask(),
                'totalUserIssue'            => $this->totalUserIssues(),
                'totalUserInReviewIssues'   => $this->totalUserInReviewIssues(),
                'totalUserOpenIssues'       => $this->totalUserOpenIssues(),
                'totalUserClosedIssues'     => $this->totalUserClosedIssues()
            ]);
    }

    public function logout()
    {
        \Auth::logout();
        return redirect()->back();
    }

    private function getUserId()
    {
        return auth()->user()->id;
    }

    public function totalTask()
    {
        return sizeof($this->tr->all());
    }

    public function totalUserTask()
    {
        return sizeof($this->tr->findWhere(['designator_id' => $this->getUserId()]));
    }

    public function totalSubUserTask()
    {
        return sizeof($this->tir->findWhere(['designator_id' => $this->getUserId()]));
    }

    public function totalCompletedTask()
    {
        return sizeof($this->tr->findwhere(['status' => 'Completed']));
    }

    public function totalUserCompletedTask()
    {
        return sizeof($this->tr->findwhere(['status' => 'Completed', 'designator_id' => $this->getUserId()]));
    }

    public function totalSubUserCompletedTask()
    {
        return sizeof($this->tir->findwhere(['status' => 'Completed', 'designator_id' => $this->getUserId()]));
    }

    public function totalPendingTask()
    {
        return sizeof($this->tr->findwhere(['status' => 'Pending']));
    }

    public function totalUserPendingTask()
    {
        return sizeof($this->tr->findwhere(['status' => 'Pending', 'designator_id' => $this->getUserId()]));
    }

    public function totalSubUserPendingTask()
    {
        return sizeof($this->tir->findwhere(['status' => 'Pending', 'designator_id' => $this->getUserId()]));
    }

    public function totalInprogressTask()
    {
        return sizeof($this->tr->findwhere(['status' => 'In-Progress']));
    }

    public function totalUserInprogressTask()
    {
        return sizeof($this->tr->findwhere(['status' => 'In-Progress', 'designator_id' => $this->getUserId()]));
    }

    public function totalSubUserInprogressTask()
    {
        return sizeof($this->tir->findwhere(['status' => 'In-Progress', 'designator_id' => $this->getUserId()]));
    }

    public function totalAdministrator()
    {
        return sizeof($this->str->findWhere(['is_admin' => '1']));
    }

    public function totalUser()
    {
        return sizeof($this->str->findWhere(['is_admin' => '0']));
    }

    public function comissionedUsers()
    {
        $comissioned_user_ids = [];
        $comissioned_tasks = \App\TaskItem::query()
            ->where('status', '!=' , 'Completed')
            ->get();
        foreach ($comissioned_tasks as $tks ) {
            if(!is_null($tks->designator_id)) {
                array_push($comissioned_user_ids, $tks->designator_id);
            }
        }
        if(sizeof($comissioned_user_ids))
            return sizeof(array_unique($comissioned_user_ids));
        else
            return 0;
    }

    public function uncomissionedUsers()
    {
        $totalUsers = sizeof($this->str->findWhere(['is_admin' => 0]));
        if($totalUsers == 0) {
            return 0;
        }
        return $totalUsers - $this->comissionedUsers();
    }

    public function userIssues()
    {
        if(auth()->user()->is_admin == "0") {
            $user_id = auth()->user()->id;
            return TaskItemIssue::select('task_item_issues.id')
                ->join('task_items', 'task_item_issues.task_item_id', '=', 'task_items.id')
                ->where('designator_id', $user_id);
        } else {
            return TaskItemIssue::select('task_item_issues.id');
        }

    }
    public function totalUserIssues()
    {
        return $this->userIssues()->count();
    }

    public function totalUserInReviewIssues()
    {
        return $this->userIssues()->where(['task_item_issues.status' => Index::IN_REVIEW])->count();
    }

    public function totalUserOpenIssues()
    {
        return $this->userIssues()->where(['task_item_issues.status' => Index::OPEN])->count();
    }

    public function totalUserClosedIssues()
    {
        return $this->userIssues()->where(['task_item_issues.status' => Index::CLOSED])->count();
    }
}
