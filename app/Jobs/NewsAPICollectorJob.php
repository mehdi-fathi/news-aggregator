<?php

namespace App\Jobs;

use App\Logic\Service\NewsService;
use App\Logic\Service\SourceService;
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
    protected NewsService $newsService;
    /**
     * @var \App\Logic\Service\SourceService|\Illuminate\Contracts\Foundation\Application|\Illuminate\Foundation\Application|mixed
     */
    protected SourceService $sourceService;
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
        $this->newsService = app('NewsService');
        $this->sourceService = app('SourceService');

        $this->limit = $limit;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $news = app('NewsAPISource');

        $yesterday = today()->subDay(1)->toDate()->format('Y-m-d');
        $total_records_news_api = $this->newsService->getCountNewsBySourceIdPublished(1, $yesterday);

        dump($total_records_news_api);

        $page = $total_records_news_api >= 1 ? round(($total_records_news_api / 100) + 1, 1) : 1;

        $queryParams = [
            'domains' => 'techcrunch.com,thenextweb.com,bbc.co.uk,engadget.com,androidcentral.com,wired.com,biztoc.com',
            'page' => $page,
            'from' => $yesterday,
            'sortBy' => 'publishedAt',
            // more parameters...
        ];

        $resApi = $news->setUrl('everything')->setParams($queryParams)->getData();

        $resApi['articles'] = array_reverse($resApi['articles']);

        foreach ($resApi['articles'] as $data) {

            $source_id = 0;
            if (!empty($data['source']['id'])) {
                $source = $this->sourceService->findByNameOrCreate($data['source']['id'], 1);
                $source_id = $source->id;
            }

            $data_value = [
                'slug' => 'x',
                'data_source_id' => 1,
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

                dump("error", $data['title']);

                continue;
            }
        }

    }
}
