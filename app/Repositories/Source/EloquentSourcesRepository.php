<?php

namespace App\Repositories\Source;

use App\Models\Source;

/**
 * Class EloquentSourcesRepository
 */
class EloquentSourcesRepository implements SourceRepository
{
    /**
     * @var Source
     */
    protected Source $model;

    /**
     * EloquentUserRepository constructor.
     * @param Source $source
     */
    public function __construct(Source $source)
    {
        $this->model = $source;
    }

    /**
     * @param array $data
     * @return void
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function findByNameOrCreate(string $sourceName, int $dataSourceId)
    {
        $source = $this->model->query()->where('name', $sourceName)->first();

        if (empty($source)) {
            $source = Source::query()->create([
                'name' => $sourceName,
                'data_source_id' => $dataSourceId,
            ]);
        }
        return $source;

    }

}
