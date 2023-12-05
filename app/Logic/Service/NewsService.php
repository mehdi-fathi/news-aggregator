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
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getFilteredNews($data): \Illuminate\Database\Eloquent\Collection
    {
        if (!empty($data['preference'])) {
            $UserPreferenceData = $this->UserPreferenceService->findOrFailByName($data['preference']);
            $data = $UserPreferenceData['preferences'];
        }

        $this->filterNewsByData($data);

        $out = $this->newsRepo->getFilteredData(['Source.DataSource']);

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
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function searchNews($text)
    {
        $this->newsRepo->searchByText($text);

        return $this->newsRepo->getFilteredData(['Source.DataSource']);
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
