<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Webinar extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'badge',
        'instructor_name',
        'instructor_title',
        'date_time_text',
        'duration',
        'is_free',
        'price_text',
        'description',
        'join_link',
        'image',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_free' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];
}
