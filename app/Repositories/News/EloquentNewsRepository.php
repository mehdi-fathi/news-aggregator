<?php

namespace App\Repositories\News;

use App\Models\News;
use Illuminate\Support\Facades\DB;

/**
 * Class EloquentUserRepository
 */
class EloquentNewsRepository implements NewsRepository
{
    /**
     * @var User
     */
    protected $model;

    /**
     * EloquentUserRepository constructor.
     * @param News $news
     */
    public function __coonstruct(News $news)
    {
        $this->model = $news;
    }

    /**
     */
    public function getNews()
    {
    }

}
