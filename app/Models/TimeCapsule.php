<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
}
