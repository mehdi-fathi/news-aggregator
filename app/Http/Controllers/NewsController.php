<?php

namespace App\Http\Controllers;

use App\Jobs\GuardianNewsAPICollectorJob;
use App\Jobs\NewsAPICollectorJob;
use App\Logic\Content\NewsSources\NewsAPISource;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function getNews()
    {
        // $client = new Client([
        //     'base_uri' => 'https://api.newscred.com', // Replace with the actual base URI
        //     'headers' => [
        //         'Authorization' => 'Bearer ' . env('NEWSCRED_API_KEY'),
        //     ],
        // ]);
        //
        // // Replace '/endpoint' with the actual endpoint and add parameters as needed
        // $response = $client->request('GET', '/endpoint');
        // dd(json_decode($response->getBody(), true));

        // $yesterday = today()->toDate()->format('Y-m-d');
        //
        // $total_records_gurdian = $this->NewsService->getCountNewsBySourceIdPublished(2, $yesterday);
        // $page = $total_records_gurdian >= 50 ? round(($total_records_gurdian / 50) + 1, 1) : 1;
        //
        // GuardianNewsAPICollectorJob::dispatch();
        //
        // dd("test",$total_records_gurdian);
        //
        // $news = $this->NewsService->getLatestNewsBySourceId(1);
        //
        // dump($news);

        $total_records_news_api = News::query()->whereDate('published_at', today()->subDay(1)->toDate()->format('Y-m-d'))->count();

        dump($total_records_news_api);

        $page = $total_records_news_api >= 1 ? round(($total_records_news_api / 100) + 1,1) : 1;
        dd(4545,$page);

        NewsAPICollectorJob::dispatch($page);

        dd(4545,$page);

        $news = app('NewsAPISource');

        $queryParams = [
            'q' => 'apple',
            'from' => '2023-11-30',
            'to' => '2023-11-30',
            'sortBy' => 'popularity',
            // more parameters...
        ];

        $data1 = $news->setApiKey('cedc49391f90414382ff139b743013c8')->setUrl('everything')->setParams($queryParams)->getData();

        $GuardianAPISource = app('GuardianAPISource');

        $data = $GuardianAPISource->setUrl('search')->setParams([
            'show-fields' => 'all',
            'from-date' => '2023-12-02T02:00:41Z',
            'order-by' => 'oldest',
        ])->getData();

        dd($this->NewsService->getNews(), $data, $data1);
    }
}
