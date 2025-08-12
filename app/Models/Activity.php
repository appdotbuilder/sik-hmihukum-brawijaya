<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Activity
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon $date
 * @property string|null $start_time
 * @property string|null $end_time
 * @property string|null $location
 * @property string $participant_type
 * @property string $status
 * @property int $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \App\Models\User $creator
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ActivityParticipant> $participants
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Activity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Activity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Activity query()
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Activity upcoming()
 * @method static \Illuminate\Database\Eloquent\Builder|Activity completed()
 * @method static \Database\Factories\ActivityFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Activity extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'description',
        'date',
        'start_time',
        'end_time',
        'location',
        'participant_type',
        'status',
        'created_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'date',
        'created_by' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that created the activity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the participants for the activity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function participants(): HasMany
    {
        return $this->hasMany(ActivityParticipant::class);
    }

    /**
     * Scope a query to only include upcoming activities.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUpcoming($query)
    {
        return $query->where('date', '>=', now()->toDateString())
                    ->whereIn('status', ['planned', 'ongoing']);
    }

    /**
     * Scope a query to only include completed activities.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Get attendance rate for the activity.
     *
     * @return float
     */
    public function getAttendanceRate(): float
    {
        $totalParticipants = $this->participants()->count();
        if ($totalParticipants === 0) {
            return 0;
        }

        $attendedParticipants = $this->participants()->where('is_present', true)->count();
        return round(($attendedParticipants / $totalParticipants) * 100, 2);
    }

    /**
     * Get total participants count.
     *
     * @return int
     */
    public function getTotalParticipants(): int
    {
        return $this->participants()->count();
    }

    /**
     * Get attended participants count.
     *
     * @return int
     */
    public function getAttendedParticipants(): int
    {
        return $this->participants()->where('is_present', true)->count();
    }
}