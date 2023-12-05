<?php

namespace App\Repositories\Source;

/**
 * Interface SourceRepository
 */
interface SourceRepository
{
    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * @param string $sourceName
     * @param int $dataSourceId
     * @return mixed
     */
    public function findByNameOrCreate(string $sourceName, int $dataSourceId);
}
