<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * App\Models\KaryaKader
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string|null $description
 * @property string $type
 * @property string $category
 * @property string|null $file_path
 * @property string|null $cover_image
 * @property int $stock
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Borrowing> $borrowings
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|KaryaKader newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|KaryaKader newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|KaryaKader query()
 * @method static \Illuminate\Database\Eloquent\Builder|KaryaKader whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KaryaKader whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KaryaKader whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KaryaKader whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KaryaKader whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KaryaKader whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KaryaKader physical()
 * @method static \Illuminate\Database\Eloquent\Builder|KaryaKader digital()
 * @method static \Illuminate\Database\Eloquent\Builder|KaryaKader available()
 * @method static \Database\Factories\KaryaKaderFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class KaryaKader extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'type',
        'category',
        'file_path',
        'cover_image',
        'stock',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'user_id' => 'integer',
        'stock' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that owns the karya kader.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all borrowings for this karya kader.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function borrowings(): MorphMany
    {
        return $this->morphMany(Borrowing::class, 'borrowable');
    }

    /**
     * Scope a query to only include physical karya.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePhysical($query)
    {
        return $query->where('type', 'physical');
    }

    /**
     * Scope a query to only include digital karya.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDigital($query)
    {
        return $query->where('type', 'digital');
    }

    /**
     * Scope a query to only include available karya.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    /**
     * Check if karya is available for borrowing.
     *
     * @return bool
     */
    public function isAvailable(): bool
    {
        if ($this->type === 'digital') {
            return $this->status === 'available';
        }
        
        return $this->status === 'available' && $this->stock > 0;
    }

    /**
     * Get available stock for physical karya.
     *
     * @return int
     */
    public function getAvailableStock(): int
    {
        if ($this->type === 'digital') {
            return PHP_INT_MAX;
        }
        
        $borrowed = $this->borrowings()->where('status', 'borrowed')->count();
        return max(0, $this->stock - $borrowed);
    }
}