<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'avatar_url',
        'password',
    ];

    protected $visible = [
        'id',
        'first_name',
        'last_name',
        'email',
        'avatar_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    /**
     * Get the time capsules for the user.
     */
    public function timeCapsules(): HasMany
    {
        return $this->hasMany(TimeCapsule::class, 'user_id');
    }

    /**
     * The capsules that the user has favorited.
     */
    public function favorites(): BelongsToMany
    {
        return $this->belongsToMany(
            TimeCapsule::class,
            'favorite_time_capsules',
            'user_id',
            'time_capsule_id'
        );
    }
}
