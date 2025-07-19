<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TimeCapsule extends Model
{
    /** @use HasFactory<\Database\Factories\TimeCapsuleFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'reveal_date',
        'color',
        'location',
        'is_surprise_mode',
        'visibility',
        'content_type',
        'content_text',
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'title',
        'reveal_date',
        'is_revealed',
        'color',
        'location',
        'is_surprise_mode',
        'visibility',
        'content_type',
        'content_text',
        'content_voice_url',
        'content_image_url',
        'created_at',
        'updated_at',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'title' => null,
        'color' => 'gray',
        'is_surprise_mode' => false,
    ];


    /**
     * Get the user that owns the time capsule.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * The users that have favorited the capsule.
     */
    public function favoritedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'favorite_time_capsules',
            'user_id',
            'time_capsule_id',
        );
    }
}
