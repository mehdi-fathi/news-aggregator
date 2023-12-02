<?php

namespace App\Logic\Content;

use App\Logic\Content\NewsSources\NewsAPISource;

class NewsCollector
{


    public function collectData()
    {
        $news = app('NewsAPISource');

        $queryParams = [
            'q' => 'apple',
            'from' => '2023-11-30',
            'to' => '2023-11-30',
            'sortBy' => 'popularity',
            // more parameters...
        ];

        $data = $news->setUrl('everything')->setParams($queryParams)->getData();


        $GuardianAPISource = app('GuardianAPISource');

        $queryParams = [
            'q' => 'apple',
            'from' => '2023-11-30',
            'to' => '2023-11-30',
            'sortBy' => 'popularity',
            // more parameters...
        ];

        $data2 = $GuardianAPISource->setUrl('search')->setParams([])->getData();
    }
}
