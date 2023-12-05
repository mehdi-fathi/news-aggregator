<?php

namespace App\Repositories\News;

use App\Models\News;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class EloquentNewsRepository
 */
class EloquentNewsRepository implements NewsRepository
{
    /**
     * @var News
     */
    protected News $model;

    /**
     * @var \Illuminate\Database\Eloquent\Builder
     */
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
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
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
        return $this->model->create($data);
    }

    /**
     * @param $source
     * @return void
     */
    public function getFilteredBySource($source)
    {
        $this->setBuilder($this->getBuilder()->getSource($source));
    }

    /**
     * @param $from_published_at
     * @param $to_published_at
     * @return void
     */
    public function getFilteredByPublishedAt($from_published_at, $to_published_at): void
    {
        $this->setBuilder($this->getBuilder()->getPublishedAt($from_published_at, $to_published_at));
    }

    /**
     * @param string $category
     * @return void
     */
    public function getFilteredByCategory(string $category): void
    {
        $this->setBuilder($this->getBuilder()->getCategory($category));
    }

    /**
     * @param $author
     * @return void
     */
    public function getFilteredByAuthor($author): void
    {
        $this->setBuilder($this->getBuilder()->getAuthor($author));
    }

    /**
     * @param string $text
     * @return void
     */
    public function searchByText(string $text): void
    {
        $this->setBuilder($this->getBuilder()->search($text));
    }

    /**
     * @param array $relations
     * @param int $limit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getFilteredDataPaginate(array $relations, int $limit = 10): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $this->getBuilder()->with($relations)->paginate($limit);
    }

}
