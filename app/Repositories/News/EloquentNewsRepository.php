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
    public function __construct(News $news)
    {
        $this->model = $news;
    }

    /**
     */
    public function getNews()
    {
    }

    public function getLatestNewsBySourceId(int $source_id)
    {
        $this->model->where('source_id', $source_id);
        return $this;
    }


    public function createMany(array $data)
    {
        $this->model->createMany($data);
    }

}
