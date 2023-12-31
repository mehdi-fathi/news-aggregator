<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @property  \App\Logic\Service\NewsService NewsService
 * @property  \App\Logic\Service\UserPreferenceService UserPreferenceService
 */
class Controller extends BaseController
{
    use AuthorizesRequests;
    use ValidatesRequests;

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
