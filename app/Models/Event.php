<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $event_name
 * @property string|null $event_type
 * @property string $event_date
 * @property string|null $event_time
 * @property string|null $event_location
 * @property string|null $description
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Participant> $participants
 * @property-read int|null $participants_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Task> $tasks
 * @property-read int|null $tasks_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereEventDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereEventLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereEventName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereEventTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereEventType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
