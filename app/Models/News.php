<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
        'slug',
        'data_source_id',
        'source_id',
        'author',
        'title',
        'description',
        'content',
        'image',
        'published_at',
    ];


    use HasFactory;
}
