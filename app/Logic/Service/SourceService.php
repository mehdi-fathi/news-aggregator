<?php


namespace App\Logic\Service;

use App\Repositories\Source\SourceRepository;

/**
 * Class SourceService
 * @package App\Service\Logic
 */
final class SourceService extends AppService
{

    /**
     * SourceService constructor.
     * @param SourceRepository $sourceRepo
     */
    public function __construct(SourceRepository $sourceRepo)
    {
        $this->sourceRepo = $sourceRepo;
    }

    /**
     * @param string $sourceName
     * @param int $dataSourceId
     * @return void
     */
    public function findByNameOrCreate(string $sourceName, int $dataSourceId)
    {
        return $this->sourceRepo->findByNameOrCreate($sourceName, $dataSourceId);
    }
}
