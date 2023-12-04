<?php


namespace App\Logic\Service;

use App\Logic\Utility\NewsFetcherUtility;
use App\Repositories\News\NewsRepository;

/**
 * Class NewsService
 * @package App\Service\Logic
 */
class NewsService extends AppService
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
     * @param int $cnt_posts
     * @param int $last_days
     * @return array|null
     */
    public function getNews()
    {
        $news = new NewsFetcherUtility('https://newsapi.org/v2/');


        $queryParams = [
            'q' => 'apple',
            'from' => '2023-11-30',
            'to' => '2023-11-30',
            'sortBy' => 'popularity',
            'apiKey' => 'cedc49391f90414382ff139b743013c8',
            // more parameters...
        ];


        return $news->get('everything', $queryParams);

        // $client = new \GuzzleHttp\Client();
        // $request = new \GuzzleHttp\Psr7\Request('GET', 'https://newsapi.org/v2/everything?q=apple&from=2023-11-30&to=2023-11-30&sortBy=popularity&apiKey=cedc49391f90414382ff139b743013c8');
        // $res = $client->sendAsync($request)->wait();
        // return json_decode($res->getBody()->getContents(), true);
    }

    public function getCountNewsBySourceIdPublished(int $sourceId, string $publishedAt)
    {
        return $this->newsRepo->getCountNewsBySourceIdPublished($sourceId, $publishedAt);
    }


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
        return $this->model->create($data);
    }

}
