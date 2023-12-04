<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsListRequest;
use App\Http\Requests\NewsSearchRequest;
use App\Http\Resources\NewsResource;
use App\Jobs\GuardianNewsAPICollectorJob;
use App\Jobs\NewsAPICollectorJob;
use App\Logic\Content\NewsSources\NewsAPISource;
use App\Models\News;
use Illuminate\Http\Request;

/**
 *
 */
class NewsController extends Controller
{
    /**
     * @param \App\Http\Requests\NewsListRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function list(NewsListRequest $request)
    {
        $items = $this->NewsService->getFilteredNews($request->query->all());

        return NewsResource::collection($items);

    }

    /**
     * @param \App\Http\Requests\NewsSearchRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function search(NewsSearchRequest $request)
    {
        $items = $this->NewsService->searchNews($request->query->get('text'));

        return NewsResource::collection($items);

    }
}
