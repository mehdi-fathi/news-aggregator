<?php

namespace App\Logic\Utility;

use GuzzleHttp\ClientInterface;

class NewsFetcherUtility implements EndPointFetcher
{

    public ClientInterface $client;

    public function __construct($base_url)
    {
        $this->client = new \GuzzleHttp\Client([
            'base_uri' => $base_url, // Replace with the actual base URI
            'headers' => [
                'Authorization' => 'Bearer ' . env('NEWSCRED_API_KEY'),
            ],
        ]);
    }


    public function get(string $uri, $queryParams)
    {
        $res = $this->client->request('GET', $uri, ['query' => $queryParams]);
        return json_decode($res->getBody()->getContents(), true);
    }
}
