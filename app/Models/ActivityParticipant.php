<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\ActivityParticipant
 *
 * @property int $id
 * @property int $activity_id
 * @property int $user_id
 * @property bool $is_present
 * @property \Illuminate\Support\Carbon|null $attended_at
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \App\Models\Activity $activity
 * @property-read \App\Models\User $user
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityParticipant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityParticipant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityParticipant query()
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityParticipant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityParticipant whereActivityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityParticipant whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityParticipant whereIsPresent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityParticipant present()
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityParticipant absent()
 * @method static \Database\Factories\ActivityParticipantFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class ActivityParticipant extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'activity_id',
        'user_id',
        'is_present',
        'attended_at',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'activity_id' => 'integer',
        'user_id' => 'integer',
        'is_present' => 'boolean',
        'attended_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the activity that owns the participant.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class);
    }

    /**
     * Get the user that is the participant.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include present participants.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePresent($query)
    {
        return $query->where('is_present', true);
    }

    /**
     * Scope a query to only include absent participants.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAbsent($query)
    {
        return $query->where('is_present', false);
    }
}