<?php

namespace App\Logic\Service\Contracts;

use App\Repositories\News\NewsRepository;
use Illuminate\Pagination\LengthAwarePaginator;

interface NewsServiceInterface
{
    /**
     * NewsService constructor.
     * @param NewsRepository $news
     */
    public function __construct(NewsRepository $news);
    /**
     * @param $data
     * @param int $limit
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getFilteredNews($data, int $limit = 10): LengthAwarePaginator;
    /**
     * @param $text
     * @param int $limit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function searchNews($text, int $limit = 10): \Illuminate\Contracts\Pagination\LengthAwarePaginator;
    /**
     * @param int $sourceId
     * @param string $publishedAt
     * @return int
     */
    public function getCountNewsBySourceIdPublished(int $sourceId, string $publishedAt);

    /**
     * @param int $sourceId
     * @param string $publishedAt
     * @return int
     */
    public function getLatestNewsBySourceIdPublished(int $sourceId, string $publishedAt);
    /**
     * @param array $data
     * @return mixed
     */
    public function createNews(array $data);
}
