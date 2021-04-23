<?php
namespace App\Http\Repositories;

use App\Http\Repositories\Repository;
use App\TaskItem;

class TaskItemRepository extends Repository 
{
    private $model;

    public function __construct()
    {
        $this->model = new TaskItem;
        parent::__construct($this->model);
    }
}
