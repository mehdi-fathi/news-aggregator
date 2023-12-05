<?php

namespace App\Logic\Content\NewsSources;

use App\Logic\Utility\EndPointFetcher;
use App\Logic\Utility\NewsFetcherUtility;

use function PHPUnit\Framework\throwException;

/**
 *
 */
class GuardianAPISource implements NewsSource
{
    /**
     *
     */
    public const NAME = "guardian-api";

    /**
     *
     */
    public const ID = 2;

    /**
     * @var \App\Logic\Utility\EndPointFetcher
     */
    public EndPointFetcher $newsFetcherUtility;

    /**
     * @var array
     */
    public array $params;

    /**
     * @var string
     */
    public string $apiKey;

    /**
     * @var string
     */
    public string $url;

    /**
     * @param \App\Logic\Utility\EndPointFetcher $newsFetcherUtility
     * @param string $apiKey
     */
    public function __construct(EndPointFetcher $newsFetcherUtility, string $apiKey)
    {
        $this->newsFetcherUtility = $newsFetcherUtility;
        $this->setApiKey($apiKey);
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
    public function setParams(array $params = [])
    {
        $this->params = $params;
        return $this;
    }

    /**
     * @return mixed
     */
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

    /**
     * @param string $url
     * @return $this
     */
    public function setUrl(string $url): static
    {
        $this->url = $url;
        return $this;

    }

    /**
     * @return mixed
     */
    public function getData()
    {
        $this->params['api-key'] = $this->getApiKey();
        return $this->newsFetcherUtility->get($this->getUrl(), $this->getParams());
    }
}
