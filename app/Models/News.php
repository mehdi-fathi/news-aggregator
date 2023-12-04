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
        'category',
        'author',
        'title',
        'description',
        'content',
        'image',
        'published_at',
    ];

    use HasFactory;

    /**
     * Creator / User of the resource.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function source()
    {
        return $this->belongsTo(Source::class);
    }

    // Scope by a specific field
    public function scopeGetSource($query, $value)
    {
        return $query->whereHas('source', function ($q) use ($value) {
            $q->where('name', $value);
        });
    }

    // Scope by a specific field
    public function scopeGetPublishedAt($query, string $fromDate, ?string $toDate = null)
    {
        $toDate = $toDate ?? now();

        return $query->whereBetween('published_at', [$fromDate, $toDate]);

    }

    // Scope by a specific field
    public function scopeGetCategory($query, ?string $category = null)
    {
        return $query->where('category', $category);
    }
}
