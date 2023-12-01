<?php


namespace App\Logic\Service;

use App\Repositories\News\NewsRepository;

/**
 * Class NewsService
 * @package App\Logic
 */
class NewsService extends AppService
{

    /**
     * NewsService constructor.
     * @param NewsRepository $news
     */
    public function __construct(NewsRepository $news)
    {
        $this->newsRepo = $news;
    }

    /**
     * @param int $cnt_posts
     * @param int $last_days
     * @return array|null
     */
    public function getNews(): ?array
    {
        dd("run");
    }

}
