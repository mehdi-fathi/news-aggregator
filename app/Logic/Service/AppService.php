<?php


namespace App\Logic\Service;


use Illuminate\Support\Facades\Redis;

/**
 * @property  \App\Logic\Service\NewsService NewsService
 * @property  \App\Logic\Service\UserPreferenceService UserPreferenceService
 */
class AppService
{

    /**
     * @param $property
     * @return mixed|void
     */
    public function __get($property)
    {
        if (app($property)) {
            return app($property);
        }
    }
}
