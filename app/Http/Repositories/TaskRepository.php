<?php
namespace App\Http\Repositories;

use App\Http\Repositories\Repository;
use App\Task;

class TaskRepository extends Repository 
{
    private $model;

    public function __construct()
    {
        $this->model = new Task;
        parent::__construct($this->model);
    }
}
