<?php

namespace App\Logic\Content\NewsSources;

use App\Logic\Utility\EndPointFetcher;
use App\Logic\Utility\NewsFetcherUtility;
use function PHPUnit\Framework\throwException;

class NewsAPISource implements NewsSource
{

    public EndPointFetcher $newsFetcherUtility;

    public $params;

    public $apiKey;

    public $url;

    public function __construct(EndPointFetcher $newsFetcherUtility)
    {
        $this->newsFetcherUtility = $newsFetcherUtility;
        $this->setApiKey('cedc49391f90414382ff139b743013c8');
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param mixed $params
     */
    public function setParams($params)
    {
        $this->params = $params;
        return $this;
    }

    public function getUrl()
    {
        if (empty($this->apiKey)) {
            throwException("Url is empty!");
        }
        return $this->url;
    }

    /**
     * @param mixed $apiKey
     */
    public function setApiKey(string $apiKey)
    {
        $this->apiKey = $apiKey;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getApiKey()
    {
        if (empty($this->apiKey)) {
            throwException("APi key is empty!");
        }
        return $this->apiKey;
    }

    public function setData()
    {
    }

    public function setUrl($url)
    {
        $this->url = $url;
        return $this;

    }

    public function getData()
    {
        $this->params['apiKey'] = $this->getApiKey();

        return $this->newsFetcherUtility->get($this->getUrl(), $this->getParams());
    }
}
