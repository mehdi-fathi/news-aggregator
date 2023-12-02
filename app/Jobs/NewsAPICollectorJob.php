<?php

namespace App\Jobs;

use App\Repositories\News\NewsRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NewsAPICollectorJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * @var \App\Models\News
     */
    protected $news;

    /**
     * Create a new job instance.
     *
     * @param \App\Repositories\News\NewsRepository $news
     */
    public function __construct(NewsRepository $news)
    {
        $this->onQueue(QueueType::high); // must be long priority
        $this->news = $news;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $published_at = $this->news->published_at ?? today();

        dd($published_at);


        $news = app('NewsAPISource');

        $queryParams = [
            'from' => $published_at,
            'sortBy' => 'popularity',
            // more parameters...
        ];

        $data1 = $news->setUrl('everything')->setParams($queryParams)->getData();

        foreach ($data1['articles'] as $data) {

            $data_value[] = [
                'author' => $data['author'],
                'title' => $data['title'],
                'description' => $data['description'],
                'content' => $data['content'],
                'image' => $data['urlToImage'],
                'published_at' => $data['publishedAt'],
            ];
        }

        $this->news->createMany($data_value);

        dd($data1);

    }
}
