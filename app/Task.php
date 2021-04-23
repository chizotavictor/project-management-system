<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Task extends Model
{
    protected $fillable = [
        'title', 'description', 'start_date', 'delivery_date', 'initiator_id', 'designator_id', 'status'
    ];

    /**
     * Get the initiator_id that owns the Task
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function initiator()
    {
        return $this->belongsTo(User::class, 'initiator_id');
    }

    /**
     * Get the designator_id that owns the Task
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function designator()
    {
        return $this->belongsTo(User::class, 'designator_id');
    }

    public function items()
    {
        return $this->hasMany(\App\TaskItem::class);
    }
}
