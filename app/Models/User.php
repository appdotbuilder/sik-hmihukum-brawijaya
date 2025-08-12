<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $nomor_induk_kader
 * @property string $role
 * @property string $status
 * @property string|null $phone
 * @property \Illuminate\Support\Carbon|null $birth_date
 * @property string|null $address
 * @property string|null $angkatan
 * @property string|null $fakultas
 * @property string|null $jurusan
 * @property bool $profile_completed
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Borrowing> $borrowings
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\KaryaKader> $karyaKaders
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ActivityParticipant> $activityParticipants
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User administrators()
 * @method static \Illuminate\Database\Eloquent\Builder|User pengurus()
 * @method static \Illuminate\Database\Eloquent\Builder|User kader()
 * @method static \Illuminate\Database\Eloquent\Builder|User verified()
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'nomor_induk_kader',
        'role',
        'status',
        'phone',
        'birth_date',
        'address',
        'angkatan',
        'fakultas',
        'jurusan',
        'profile_completed',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birth_date' => 'date',
            'profile_completed' => 'boolean',
        ];
    }

    /**
     * Get the borrowings for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function borrowings(): HasMany
    {
        return $this->hasMany(Borrowing::class);
    }

    /**
     * Get the karya kaders for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function karyaKaders(): HasMany
    {
        return $this->hasMany(KaryaKader::class);
    }

    /**
     * Get the activity participants for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activityParticipants(): HasMany
    {
        return $this->hasMany(ActivityParticipant::class);
    }

    /**
     * Scope a query to only include administrators.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAdministrators($query)
    {
        return $query->where('role', 'administrator');
    }

    /**
     * Scope a query to only include pengurus.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePengurus($query)
    {
        return $query->where('role', 'pengurus');
    }

    /**
     * Scope a query to only include kader.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeKader($query)
    {
        return $query->where('role', 'kader');
    }

    /**
     * Scope a query to only include verified users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeVerified($query)
    {
        return $query->where('status', 'verified');
    }

    /**
     * Check if user is administrator.
     *
     * @return bool
     */
    public function isAdministrator(): bool
    {
        return $this->role === 'administrator';
    }

    /**
     * Check if user is pengurus.
     *
     * @return bool
     */
    public function isPengurus(): bool
    {
        return $this->role === 'pengurus';
    }

    /**
     * Check if user is kader.
     *
     * @return bool
     */
    public function isKader(): bool
    {
        return $this->role === 'kader';
    }

    /**
     * Check if user is verified.
     *
     * @return bool
     */
    public function isVerified(): bool
    {
        return $this->status === 'verified';
    }
}