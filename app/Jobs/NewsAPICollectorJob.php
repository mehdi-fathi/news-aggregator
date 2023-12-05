<?php

namespace App\Jobs;

use App\Logic\Content\NewsSources\NewsAPISource;
use App\Logic\Content\NewsSources\NewsSource;
use App\Logic\Service\Contracts\NewsServiceInterface;
use App\Logic\Service\Contracts\SourceServiceInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 *
 */
class NewsAPICollectorJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;


    /**
     * @var \App\Logic\Service\NewsService|\Illuminate\Contracts\Foundation\Application|\Illuminate\Foundation\Application|mixed
     */
    protected NewsServiceInterface $newsService;
    /**
     * @var \App\Logic\Service\SourceService|\Illuminate\Contracts\Foundation\Application|\Illuminate\Foundation\Application|mixed
     */
    protected SourceServiceInterface $sourceService;

    /**
     * @var \App\Logic\Content\NewsSources\NewsAPISource
     */
    protected NewsSource $newsSource;

    /**
     * @var int
     */
    protected int $page;
    /**
     * @var int
     */
    protected int $limit;

    /**
     * Create a new job instance.
     *
     */
    public function __construct(int $limit = 100)
    {
        $this->onQueue(QueueType::high);
        $this->newsService = app(NewsServiceInterface::class);
        $this->sourceService = app(SourceServiceInterface::class);

        $this->limit = $limit;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->newsSource = app(NewsAPISource::class);

        $resApi = $this->callRequest();

        $this->saveNews($resApi['articles']);

    }

    /**
     * @return mixed
     */
    private function callRequest(): mixed
    {
        $yesterday = today()->subDay(1)->toDate()->format('Y-m-d');
        $total_records_news_api = $this->newsService->getCountNewsBySourceIdPublished(NewsAPISource::ID, $yesterday);

        $page = $total_records_news_api >= 1 ? round(($total_records_news_api / $this->limit) + 1, 1) : 1;

        $queryParams = [
            'domains' => $this->newsSource->getSources(),
            'page' => $page,
            'from' => $yesterday,
            'sortBy' => 'publishedAt',
            // more parameters...
        ];

        $resApi = $this->newsSource->setUrl('everything')->setParams($queryParams)->getData();

        $resApi['articles'] = array_reverse($resApi['articles']);

        return $resApi;
    }

    /**
     * @param $articles
     * @return void
     */
    private function saveNews($articles): void
    {
        foreach ($articles as $data) {

            $source_id = 0;
            if (!empty($data['source']['id'])) {
                $source = $this->sourceService->findByNameOrCreate($data['source']['id'], NewsAPISource::ID);
                $source_id = $source->id;
            }

            $data_value = [
                'data_source_id' => NewsAPISource::ID,
                'source_id' => (int)$source_id,
                'author' => $data['author'],
                'title' => $data['title'],
                'description' => $data['description'],
                'content' => $data['content'],
                'image' => $data['urlToImage'],
                'published_at' => $data['publishedAt'],
            ];

            try {
                $this->newsService->createNews($data_value);

            } catch (\PDOException $e) {

                dump("error: ", $data['title'], $e);

                continue;
            }
        }
    }
}
