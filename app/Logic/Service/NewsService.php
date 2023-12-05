<?php

namespace App\Logic\Service;

use App\Logic\Service\Contracts\NewsServiceInterface;
use App\Repositories\News\NewsRepository;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class NewsService
 * @package App\Service\Logic
 */
final class NewsService extends AppService implements NewsServiceInterface
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
     * @param int $limit
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getFilteredNews($data, int $limit = 10): LengthAwarePaginator
    {
        if (!empty($data['preference'])) {
            $UserPreferenceData = $this->UserPreferenceService->findOrFailByName($data['preference']);
            $data = $UserPreferenceData['preferences'];
        }

        $this->filterNewsByData($data);

        $out = $this->newsRepo->getFilteredDataPaginate(['Source.DataSource'], $limit);
        return $out;
    }

    /**
     * @param mixed $data
     * @return void
     */
    private function filterNewsByData(mixed $data): void
    {
        collect($data)->filter()->each(function ($item, $key) {
            match ($key) {
                'source' => $this->newsRepo->getFilteredBySource($item),
                'published_at' => $this->newsRepo->getFilteredByPublishedAt($item['from'], $item['to'] ?? null),
                'category' => $this->newsRepo->getFilteredByCategory($item),
            };
        });
    }

    /**
     * @param $text
     * @param int $limit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function searchNews($text, int $limit = 10): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $this->newsRepo->searchByText($text);

        $out = $this->newsRepo->getFilteredDataPaginate(['Source.DataSource'], $limit);

        return $out;
    }

    /**
     * @param int $sourceId
     * @param string $publishedAt
     * @return int
     */
    public function getCountNewsBySourceIdPublished(int $sourceId, string $publishedAt)
    {
        return $this->newsRepo->getCountNewsBySourceIdPublished($sourceId, $publishedAt);
    }


    /**
     * @param int $sourceId
     * @param string $publishedAt
     * @return int
     */
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
