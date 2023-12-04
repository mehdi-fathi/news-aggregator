<?php


namespace App\Logic\Service;

use App\Repositories\News\NewsRepository;

/**
 * Class NewsService
 * @package App\Service\Logic
 */
final class NewsService extends AppService
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
     * @param $data
     * @return array|null
     */
    public function getFilteredNews($data)
    {
        collect($data)->filter()->each(function ($item, $key) {
            match ($key) {
                'source' => $this->newsRepo->getFilteredBySource($item),
                'published_at' => $this->newsRepo->getFilteredByPublishedAt($item['from'], $item['to'] ?? null),
                'category' => $this->newsRepo->getFilteredByCategory($item),
            };
        });

        return $this->newsRepo->getFilteredData();
    }

    public function searchNews($text)
    {
        $this->newsRepo->searchByText($text);

        return $this->newsRepo->getFilteredData();
    }

    public function getCountNewsBySourceIdPublished(int $sourceId, string $publishedAt)
    {
        return $this->newsRepo->getCountNewsBySourceIdPublished($sourceId, $publishedAt);
    }


    public function getLatestNewsBySourceIdPublished(int $sourceId, string $publishedAt)
    {
        return $this->newsRepo->getLatestNewsBySourceIdPublished($sourceId, $publishedAt);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function createNews(array $data)
    {
        return $this->newsRepo->create($data);
    }

}
