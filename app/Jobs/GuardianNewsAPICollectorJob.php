<?php

namespace App\Jobs;

use App\Logic\Content\NewsSources\GuardianAPISource;
use App\Logic\Content\NewsSources\NewsSource;
use App\Logic\Service\Contracts\NewsServiceInterface;
use App\Logic\Service\NewsService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GuardianNewsAPICollectorJob implements ShouldQueue
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
     * @var \App\Logic\Content\NewsSources\GuardianAPISource
     */
    protected NewsSource $newsSource;


    /**
     * @var int
     */
    protected int $limit;

    /**
     * Create a new job instance.
     */
    public function __construct(int $limit = 50)
    {
        $this->newsService = app(NewsServiceInterface::class);

        $this->limit = $limit;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->newsSource = app(GuardianAPISource::class);

        $resApi = $this->callRequest();

        $this->saveNews($resApi['response']['results']);

    }

    /**
     * @return mixed
     */
    private function callRequest(): mixed
    {
        $today = today()->format('Y-m-d');

        $last = $this->newsService->getLatestNewsBySourceIdPublished(GuardianAPISource::ID, $today);

        $today = today()->format('c');

        $published_at = $today;
        if (!empty($last)) {
            $published_at = Carbon::create($last['published_at'])->format('c');
        }

        $resApi = $this->newsSource->setUrl('search')->setParams([
            'show-fields' => 'all',
            'from-date' => $published_at,
            'order-by' => 'oldest',
            'page-size' => $this->limit,
        ])->getData();

        return $resApi;
    }

    /**
     * @param $results
     * @return void
     */
    private function saveNews($results): void
    {
        foreach ($results as $data) {

            $data_value = [
                'data_source_id' => GuardianAPISource::ID,
                'source_id' => 0,
                'author' => $data['fields']['byline'] ?? "",
                'category' => $data['sectionId'] ?? null,
                'title' => $data['webTitle'],
                'description' => mb_substr($data['fields']['main'], 0, 300),
                'content' => $data['fields']['body'],
                'image' => $data['fields']['thumbnail'] ?? null,
                'published_at' => $data['webPublicationDate'],
            ];

            try {
                $this->newsService->createNews($data_value);

            } catch (\PDOException $e) {

                continue;
            }
        }
    }
}
