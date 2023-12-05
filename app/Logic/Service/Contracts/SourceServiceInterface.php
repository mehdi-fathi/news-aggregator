<?php

namespace App\Logic\Service\Contracts;

use App\Repositories\Source\SourceRepository;

interface SourceServiceInterface
{
    /**
     * SourceService constructor.
     * @param SourceRepository $sourceRepo
     */
    public function __construct(SourceRepository $sourceRepo);

    /**
     * @param string $sourceName
     * @param int $dataSourceId
     * @return void
     */
    public function findByNameOrCreate(string $sourceName, int $dataSourceId);
}
