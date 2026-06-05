<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    protected $fillable = [
        'full_name',
        'email',
        'event_id',
        'phone',
        'address',
        'notes',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}
