<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatsCounter extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'suffix',
        'label',
        'icon',
        'sort_order',
    ];
}
