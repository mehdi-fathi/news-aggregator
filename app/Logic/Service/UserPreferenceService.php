<?php

namespace App\Logic\Service;

use App\Logic\Service\Contracts\UserPreferenceServiceInterface;
use App\Repositories\User\UserPreferenceRepository;

/**
 * Class UserPreferenceService
 * @package App\Service\Logic
 */
final class UserPreferenceService extends AppService implements UserPreferenceServiceInterface
{
    /**
     * @var \App\Repositories\User\UserPreferenceRepository
     */
    private UserPreferenceRepository $userPreferenceRepo;

    /**
     * UserPreferenceService constructor.
     * @param UserPreferenceRepository $sourceRepo
     */
    public function __construct(UserPreferenceRepository $sourceRepo)
    {
        $this->userPreferenceRepo = $sourceRepo;
    }

    /**
     * @param string $name
     * @param array $data
     * @return void
     */
    public function create(string $name, array $data)
    {
        $data = ['name' => $name, 'preferences' => $data];
        return $this->userPreferenceRepo->create($data);
    }

    /**
     * @param string $name
     * @param array $data
     * @return void|null
     */
    public function update(string $name, array $data)
    {
        $data = json_encode($data);
        return $this->userPreferenceRepo->update($name, $data);
    }

    /**
     * @param string $name
     * @return void|null
     */
    public function destroy(string $name)
    {
        return $this->userPreferenceRepo->delete($name);
    }

    /**
     * @param string $name
     * @return void|null
     */
    public function findOrFailByName(string $name)
    {
        return $this->userPreferenceRepo->findOrFailByName($name);
    }

    /**
     * @return void|null
     */
    public function paginate()
    {
        return $this->userPreferenceRepo->paginate();
    }
}
