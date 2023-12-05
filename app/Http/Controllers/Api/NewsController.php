<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsListRequest;
use App\Http\Requests\NewsSearchRequest;
use App\Http\Resources\NewsResource;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="News-aggregator API Documentation",
 *      description="Swagger OpenAPI Description",
 *      @OA\Contact(
 *          email="mehdifathi.developer@gmail.com"
 *      ),
 * )
 */
class NewsController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/news/list",
     *      @OA\Parameter  (
     *       description="source",
     *       in="query",
     *       name="source",
     *       example="bbc-news",
     *    ),
     *    @OA\Parameter  (
     *       description="published_at from",
     *       in="query",
     *       name="published_at[from]",
     *       example="2023-12-03",
     *    ),
     *    @OA\Parameter  (
     *       description="published_at to",
     *       in="query",
     *       name="published_at[to]",
     *       example="2023-12-04",
     *    ),
     *    @OA\Parameter  (
     *       description="category",
     *       in="query",
     *       name="category",
     *       example="sport",
     *    ),
     *    @OA\Parameter  (
     *       description="preferences",
     *       in="query",
     *       name="preference",
     *       example="my_favorite",
     *    ),
     *     @OA\Response(response="200", description="An example resource")
     * )
     */
    public function list(NewsListRequest $request)
    {
        $items = $this->NewsService->getFilteredNews($request->query->all());

        $items->appends($request->query->all());
        return NewsResource::collection($items);

    }

    /**
     * @OA\Get(
     *     path="/api/v1/news/search",
     *      @OA\Parameter  (
     *       description="text",
     *       in="query",
     *       name="text",
     *       example="movie",
     *    ),
     *     @OA\Response(response="200", description="An example resource")
     * )
     */
    public function search(NewsSearchRequest $request)
    {
        $items = $this->NewsService->searchNews($request->query->get('text'));

        $items->appends($request->query->all());

        return NewsResource::collection($items);

    }
}
