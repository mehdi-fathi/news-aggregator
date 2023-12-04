<?php

namespace App\Repositories\News;

use App\Models\News;
use Illuminate\Database\Eloquent\Builder;
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

    protected Builder $builder;

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
     * @return \App\Models\News
     */
    public function getModel(): News
    {
        return $this->model;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $builder
     */
    public function setBuilder(Builder $builder): void
    {
        $this->builder = $builder;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getBuilder(): Builder
    {
        return $this->builder ?? News::query();
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
        return News::query()->where('data_source_id', $sourceId)->whereDate('published_at', $publishedAt)->orderByDesc('id')->latest()->first();

    }

    /**
     * @param array $data
     * @return void
     */
    public function create(array $data)
    {
        $this->model->create($data);
    }

    // public function getBySource($source)
    // {
    //     return $this->model->query()->getSource($source);
    // }
    //
    // public function getByPublishedAt($published_at)
    // {
    //     return $this->model->query()->getPublishedAt($published_at);
    //
    // }
    //
    // public function getByCategory($category)
    // {
    //     return $this->model->query()->getCategory($category);
    //
    // }


    public function getFilteredBySource($source)
    {
        $this->setBuilder($this->getBuilder()->getSource($source));
    }

    public function getFilteredByPublishedAt($from_published_at, $to_published_at)
    {
        $this->setBuilder($this->getBuilder()->getPublishedAt($from_published_at, $to_published_at));
    }

    public function getFilteredByCategory($category)
    {
        $this->setBuilder($this->getBuilder()->getCategory($category));
    }

    public function getFilteredData()
    {
        return $this->getBuilder()->get();
    }

}
