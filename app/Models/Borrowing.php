<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * App\Models\Borrowing
 *
 * @property int $id
 * @property int $user_id
 * @property string $borrowable_type
 * @property int $borrowable_id
 * @property \Illuminate\Support\Carbon $borrowed_at
 * @property \Illuminate\Support\Carbon $due_date
 * @property \Illuminate\Support\Carbon|null $returned_at
 * @property string $status
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $borrowable
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Borrowing newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Borrowing newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Borrowing query()
 * @method static \Illuminate\Database\Eloquent\Builder|Borrowing whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Borrowing whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Borrowing whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Borrowing active()
 * @method static \Illuminate\Database\Eloquent\Builder|Borrowing overdue()
 * @method static \Database\Factories\BorrowingFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Borrowing extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'borrowable_type',
        'borrowable_id',
        'borrowed_at',
        'due_date',
        'returned_at',
        'status',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'user_id' => 'integer',
        'borrowable_id' => 'integer',
        'borrowed_at' => 'date',
        'due_date' => 'date',
        'returned_at' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that made the borrowing.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the borrowable model (Book or KaryaKader).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function borrowable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Scope a query to only include active borrowings.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'borrowed');
    }

    /**
     * Scope a query to only include overdue borrowings.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOverdue($query)
    {
        return $query->where('status', 'overdue')
                    ->orWhere(function ($q) {
                        $q->where('status', 'borrowed')
                          ->where('due_date', '<', now()->toDateString());
                    });
    }

    /**
     * Check if borrowing is overdue.
     *
     * @return bool
     */
    public function isOverdue(): bool
    {
        return $this->status === 'borrowed' && $this->due_date < now();
    }

    /**
     * Get days until due date.
     *
     * @return int
     */
    public function getDaysUntilDue(): int
    {
        return (int) now()->diffInDays($this->due_date, false);
    }
}