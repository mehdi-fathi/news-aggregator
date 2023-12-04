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
     * @param UserPreference $source
     */
    public function __construct(UserPreference $source)
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
    public function destroy(string $name)
    {
        return $this->model->where('name', $name)->delete();
    }

}
