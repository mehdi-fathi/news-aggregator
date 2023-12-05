<?php

namespace App\Logic\Utility;

use GuzzleHttp\ClientInterface;

/**
 *
 */
class NewsFetcherUtility implements EndPointFetcher
{
    /**
     * @var \GuzzleHttp\ClientInterface|\GuzzleHttp\Client
     */
    public ClientInterface|\GuzzleHttp\Client $client;

    /**
     * @param string $base_url
     */
    public function __construct(string $base_url)
    {
        $this->client = new \GuzzleHttp\Client([
            'base_uri' => $base_url, // Replace with the actual base URI

        ]);
    }


    /**
     * @param string $uri
     * @param $queryParams
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get(string $uri, $queryParams)
    {
        $res = $this->client->request('GET', $uri, ['query' => $queryParams]);
        return json_decode($res->getBody()->getContents(), true);
    }
}
