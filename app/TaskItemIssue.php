<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskItemIssue extends Model
{
    protected $fillable = ['comment', 'task_item_id'];

    public function taskItem() {
        return $this->belongsTo(\App\TaskItem::class, 'task_item_id');
    }

    public function task() {
        return $this->belongsTo(\App\Task::class, 'task_id');
    }

    public function approved() {
        return $this->belongsTo(\App\User::class, 'approved_by');
    }
}
