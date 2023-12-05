<?php

namespace App\Logic\Utility;

/**
 *
 */
interface EndPointFetcher
{
    /**
     * @param $base_ur
     */
    public function __construct($base_ur);


    /**
     * @param string $uri
     * @param $queryParams
     * @return mixed
     */
    public function get(string $uri, $queryParams);
}
