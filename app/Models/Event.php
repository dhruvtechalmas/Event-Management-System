<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'event_name',
        'event_type',
        'event_date',
        'event_time',
        'event_location',
        'description',
        'status',
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class, 'event_id');
    }

    public function participants()
    {
        return $this->hasMany(Participant::class, 'event_id');
    }
}
