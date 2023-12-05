<?php

namespace App\Logic\Utility;

interface EndPointFetcher
{
    public function __construct($base_ur);


    public function get(string $uri, $queryParams);
}
