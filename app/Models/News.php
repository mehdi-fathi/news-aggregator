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
     * @param $value
     * @return mixed
     */
    public function scopeGetSource($query, $value)
    {
        return $query->whereHas('Source', function ($q) use ($value) {
            $q->where('name', $value);
        });
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
     * @param string|null $category
     * @return mixed
     */
    public function scopeGetCategory($query, ?string $category = null)
    {
        return $query->where('category', $category);
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
