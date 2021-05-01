<?php
namespace App\Http\Repositories;

use App\Http\Repositories\Repository;
use App\TaskItemIssue;

class TaskItemIssueRepository extends Repository
{
    private $model;

    public function __construct()
    {
        $this->model = new TaskItemIssue;
        parent::__construct($this->model);
    }
}
