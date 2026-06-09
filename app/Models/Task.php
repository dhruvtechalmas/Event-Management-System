<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
   protected $fillable = [
       'title',
        'event_id',
        'assigned_to',
        'due_date',
        'status',
        'comment',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

     public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
