<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsListRequest;
use App\Http\Resources\NewsResource;
use App\Jobs\GuardianNewsAPICollectorJob;
use App\Jobs\NewsAPICollectorJob;
use App\Logic\Content\NewsSources\NewsAPISource;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function list(NewsListRequest $request)
    {
        $items = $this->NewsService->getFilteredNews($request->query->all());

        return NewsResource::collection($items);

    }
}
