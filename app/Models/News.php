<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 */
class News extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
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

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Source()
    {
        return $this->belongsTo(Source::class);
    }
    /**
     * @param $query
     * @param string $fromDate
     * @param string|null $toDate
     * @return mixed
     */
    public function scopeGetPublishedAt($query, string $fromDate, ?string $toDate = null)
    {
        $toDate = $toDate ?? now();

        return $query->whereBetween('published_at', [$fromDate, $toDate]);

    }

    /**
     * @param $query
     * @param $sources
     * @return mixed
     */
    public function scopeGetSources($query, $sources)
    {
        return $query->whereHas('Source', function ($q) use ($sources) {
            $q->whereIn('name', $sources);
        });
    }

    /**
     * @param $query
     * @param $categories
     * @return mixed
     */
    public function scopeGetCategories($query, $categories)
    {
        return $query->whereIn('category', $categories);
    }

    /**
     * @param $query
     * @param $authors
     * @return mixed
     */
    public function scopeGetAuthors($query, $authors)
    {
        return $query->whereIn('author', $authors);
    }

    /**
     * @param $query
     * @param string|null $text
     * @return mixed
     */
    public function scopeSearch($query, ?string $text = null)
    {
        return $query->where('description', 'like', "%{$text}%");
    }
}
