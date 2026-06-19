<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $event_id
 * @property string $full_name
 * @property string $email
 * @property string $phone
 * @property string|null $address
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Event|null $event
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Participant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Participant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Participant query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Participant whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Participant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Participant whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Participant whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Participant whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Participant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Participant whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Participant wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Participant whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Participant extends Model
{
    use HasFactory, SoftDeletes;
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
        return $this->belongsTo(Event::class)
            ->withTrashed();
    }
}
