<?php

namespace App\Logic\Content\NewsSources;

use App\Logic\Utility\EndPointFetcher;

/**
 *
 */
interface NewsSource
{

    public function __construct(EndPointFetcher $newsFetcherUtility, string $apiKey);

    /**
     * @param string $apiKey
     * @return mixed
     */
    public function setApiKey(string $apiKey);

    /**
     * @param array $params
     * @return mixed
     */
    public function setParams(array $params = []);

    /**
     * @param string $url
     * @return mixed
     */
    public function setUrl(string $url);

    /**
     * @return mixed
     */
    public function getData();

    /**
     * @return mixed
     */
    public function getUrl();

}
