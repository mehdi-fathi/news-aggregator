<?php

namespace App\Http\Controllers;

use App\Jobs\NewsAPICollectorJob;
use App\Logic\Content\NewsSources\NewsAPISource;
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

        $news = $this->NewsService->getLatestNewsBySourceId(1);

        NewsAPICollectorJob::dispatch($news);

        dd(4545);

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

        $queryParams = [
            'q' => 'apple',
            'from' => '2023-11-30',
            'to' => '2023-11-30',
            'sortBy' => 'popularity',
            // more parameters...
        ];

        $data = $GuardianAPISource->setUrl('search')->setParams([
            'show-fields' => 'all',
            'from-date' => '2023-12-02T02:00:41Z',
            'order-by' => 'oldest',
        ])->getData();

        dd($this->NewsService->getNews(),$data ,$data1);
    }
}
