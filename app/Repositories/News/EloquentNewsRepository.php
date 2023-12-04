<?php

namespace App\Repositories\News;

use App\Models\News;
use Illuminate\Support\Facades\DB;

/**
 * Class EloquentUserRepository
 */
class EloquentNewsRepository implements NewsRepository
{
    /**
     * @var User
     */
    protected News $model;

    /**
     * EloquentUserRepository constructor.
     * @param News $news
     */
    public function __construct(News $news)
    {
        $this->model = $news;
    }

    /**
     */
    public function getNews()
    {
    }

    /**
     * @param int $sourceId
     * @param string $publishedAt
     * @return int
     */
    public function getCountNewsBySourceIdPublished(int $sourceId, string $publishedAt): int
    {
        return News::query()->where('data_source_id', $sourceId)->whereDate('published_at', $publishedAt)->count();
    }


    /**
     * @param int $sourceId
     * @param string $publishedAt
     * @return int
     */
    public function getLatestNewsBySourceIdPublished(int $sourceId, string $publishedAt)
    {
        // return News::query()->where('data_source_id', $sourceId)->whereDate('published_at', $publishedAt)->count();

        return News::query()->where('data_source_id', $sourceId)->whereDate('published_at', $publishedAt)->orderByDesc('id')->latest()->first();

    }


    /**
     * @param array $data
     * @return void
     */
    public function createMany(array $data)
    {
        $this->model->create($data);
    }

}
