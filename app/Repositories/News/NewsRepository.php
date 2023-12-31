<?php

namespace App\Repositories\News;

use App\Models\News;
use Illuminate\Database\Eloquent\Builder;

/**
 * Interface NewsRepository
 */
interface NewsRepository
{
    /**
     * @return \App\Models\News
     */
    public function getModel(): News;

    /**
     * @param \Illuminate\Database\Eloquent\Builder $builder
     */
    public function setBuilder(Builder $builder): void;

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getBuilder(): Builder;

    /**
     * @param int $sourceId
     * @param string $publishedAt
     * @return int
     */
    public function getCountNewsBySourceIdPublished(int $sourceId, string $publishedAt): int;

    /**
     * @param int $sourceId
     * @param string $publishedAt
     * @return int
     */
    public function getLatestNewsBySourceIdPublished(int $sourceId, string $publishedAt);

    /**
     * @param array $data
     * @return void
     */
    public function create(array $data);

    /**
     * @param string|array $sources
     * @return void
     */
    public function getFilteredBySources(string|array $sources): void;

    /**
     * @param $from_published_at
     * @param $to_published_at
     * @return void
     */
    public function getFilteredByPublishedAt($from_published_at, $to_published_at): void;

    /**
     * @param string|array $categories
     * @return void
     */
    public function getFilteredByCategories(string|array $categories): void;

    /**
     * @param string|array $authors
     * @return void
     */
    public function getFilteredByAuthors(string|array $authors): void;

    /**
     * @param string $text
     * @return void
     */
    public function searchByText(string $text): void;

    /**
     * @param array $relations
     * @param int $limit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getFilteredDataPaginate(array $relations, int $limit = 10): \Illuminate\Contracts\Pagination\LengthAwarePaginator;


}
