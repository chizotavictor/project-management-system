<?php
namespace App\Http\Repositories;

use App\Http\Repositories\Repository;
use App\User;

class UserRepository extends Repository 
{
    private $model;

    public function __construct()
    {
        $this->model = new User;
        parent::__construct($this->model);
    }
}
