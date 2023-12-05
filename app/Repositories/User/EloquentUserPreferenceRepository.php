<?php

namespace App\Repositories\User;

use App\Models\UserPreference;

/**
 * Class EloquentUserPreferenceRepository
 */
class EloquentUserPreferenceRepository implements UserPreferenceRepository
{
    /**
     * @var UserPreference
     */
    protected UserPreference $model;

    /**
     * EloquentUserPreferenceRepository constructor.
     * @param \App\Models\UserPreference $userPreference
     */
    public function __construct(UserPreference $userPreference)
    {
        $this->model = $userPreference;
    }

    /**
     * @param array $data
     * @return void
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * @param array $data
     * @return void
     */
    public function update($name, $data)
    {
        return $this->model->where('name', $name)->update(['preferences' => $data]);
    }

    /**
     * @return void
     */
    public function delete(string $name)
    {
        return $this->model->where('name', $name)->delete();
    }

    /**
     * @return void
     */
    public function findOrFailByName(string $name)
    {
        return $this->model->where('name', $name)->firstOrFail();
    }

    /**
     * @return void
     */
    public function paginate()
    {
        return $this->model->paginate();
    }

}
