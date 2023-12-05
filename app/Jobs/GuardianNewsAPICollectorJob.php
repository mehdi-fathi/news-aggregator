<?php

namespace App\Jobs;

use App\Logic\Service\NewsService;
use App\Models\News;
use App\Models\Source;
use App\Repositories\News\NewsRepository;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
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
     * @var \Illuminate\Contracts\Foundation\Application|\Illuminate\Foundation\Application|mixed
     */
    protected NewsRepository $newsRepo;

    /**
     * @var \App\Logic\Service\NewsService|\Illuminate\Contracts\Foundation\Application|\Illuminate\Foundation\Application|mixed
     */
    protected NewsService $newsService;

    /**
     * @var int
     */
    protected int $limit;

    /**
     * Create a new job instance.
     */
    public function __construct(int $limit = 50)
    {
        $this->newsRepo = app(NewsRepository::class);
        $this->newsService = app('NewsService');

        $this->limit = $limit;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $GuardianAPISource = app('GuardianAPISource');

        $today = today()->format('Y-m-d');

        $last = $this->newsService->getLatestNewsBySourceIdPublished(2, $today);

        $today = today()->format('c');

        $published_at = $today;
        if (!empty($last)) {
            $published_at = Carbon::create($last['published_at'])->format('c');
        }

        $resApi = $GuardianAPISource->setUrl('search')->setParams([
            'show-fields' => 'all',
            'from-date' => $published_at,
            'order-by' => 'oldest',
            'page-size' => $this->limit,
        ])->getData();

        dump("******startIndex : ", $resApi['response']['startIndex'], "total: " . $resApi['response']['total']);

        foreach ($resApi['response']['results'] as $data) {

            $data_value = [
                'slug' => 'x',
                'data_source_id' => 2,
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

                dump("error");

                continue;
            }
        }


    }
}
