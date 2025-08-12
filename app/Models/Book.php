<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * App\Models\Book
 *
 * @property int $id
 * @property string $title
 * @property string $author
 * @property string|null $description
 * @property string $type
 * @property string|null $isbn
 * @property int $stock
 * @property string|null $file_path
 * @property string|null $cover_image
 * @property string $category
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Borrowing> $borrowings
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Book newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Book newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Book query()
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book physical()
 * @method static \Illuminate\Database\Eloquent\Builder|Book digital()
 * @method static \Illuminate\Database\Eloquent\Builder|Book available()
 * @method static \Database\Factories\BookFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Book extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'author',
        'description',
        'type',
        'isbn',
        'stock',
        'file_path',
        'cover_image',
        'category',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'stock' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get all borrowings for this book.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function borrowings(): MorphMany
    {
        return $this->morphMany(Borrowing::class, 'borrowable');
    }

    /**
     * Scope a query to only include physical books.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePhysical($query)
    {
        return $query->where('type', 'physical');
    }

    /**
     * Scope a query to only include digital books.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDigital($query)
    {
        return $query->where('type', 'digital');
    }

    /**
     * Scope a query to only include available books.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    /**
     * Check if book is available for borrowing.
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
     * Get available stock for physical books.
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