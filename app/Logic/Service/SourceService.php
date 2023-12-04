<?php


namespace App\Logic\Service;

use App\Repositories\Source\SourceRepository;

/**
 * Class SourceService
 * @package App\Service\Logic
 */
class SourceService extends AppService
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
     * @param array $data
     * @return void
     */
    public function createSource(array $data)
    {
        return $this->model->create($data);
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
