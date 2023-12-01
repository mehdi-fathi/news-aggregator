<?php


namespace App\Logic\Service;


use Illuminate\Support\Facades\Redis;

class AppService
{

    /**
     * @param string $key
     * @return mixed
     */
    protected function getCacheData(string $key)
    {
        $data = Redis::get($key);
        $data = json_decode($data, true);

        return $data;
    }

    /**
     * @param string $key
     * @param $data
     * @param int $expCache
     * @return mixed
     */
    protected function setCacheData(string $key, $data, $expCache = 10)
    {
        $data = json_encode($data);
        Redis::setex($key, $expCache, $data);

        return $data;
    }
}
