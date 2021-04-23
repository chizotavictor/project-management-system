<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskItem extends Model
{
    protected $fillable = [
        'task_indicator',
        'description',
        'designator_id',
        'task_id',
        'status',
        'approved_by'
    ];

    public function task() {
        return $this->belongsTo(\App\Task::class, 'task_id');
    }

    public function designator() {
        return $this->belongsTo(\App\User::class, 'designator_id');
    }

    public function approved() {
        return $this->belongsTo(\App\User::class, 'approved_by');
    }
}
