<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPreference extends Model
{
    protected $casts = [
        'preferences' => 'array',
    ];


    protected $fillable = [
        'name',
        'preferences'
    ];

    use HasFactory;
}
