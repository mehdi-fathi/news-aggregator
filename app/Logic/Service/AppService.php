<?php

namespace App\Logic\Service;

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
