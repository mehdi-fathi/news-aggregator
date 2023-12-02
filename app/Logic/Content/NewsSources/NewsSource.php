<?php

namespace App\Logic\Content\NewsSources;

interface NewsSource
{
    public function setApiKey(string $apiKey);

    public function setParams($params);

    public function setData();

    public function setUrl($url);

    public function getData();

    public function getUrl();

}
