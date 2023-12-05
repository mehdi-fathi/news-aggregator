<?php

namespace App\Logic\Service\Contracts;

use App\Repositories\User\UserPreferenceRepository;

interface UserPreferenceServiceInterface
{
    /**
     * UserPreferenceService constructor.
     * @param UserPreferenceRepository $sourceRepo
     */
    public function __construct(UserPreferenceRepository $sourceRepo);

    /**
     * @param string $name
     * @param array $data
     * @return void
     */
    public function create(string $name, array $data);

    /**
     * @param string $name
     * @param array $data
     * @return void
     */
    public function update(string $name, array $data);

    /**
     * @param string $name
     * @return void|null
     */
    public function destroy(string $name);

    /**
     * @param string $name
     * @return void|null
     */
    public function findOrFailByName(string $name);

    /**
     * @return void|null
     */
    public function paginate();
}
