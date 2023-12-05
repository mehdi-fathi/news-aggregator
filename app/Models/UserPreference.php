<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 */
class UserPreference extends Model
{
    use HasFactory;


    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'preferences'
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'preferences' => 'array',
    ];

}
