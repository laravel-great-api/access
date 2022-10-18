<?php

namespace LaravelGreatApi\Access;

use Illuminate\Database\Eloquent\Model;
use LaravelGreatApi\Access\Models\Permission;

class PermissionManager
{
    /**
     * Undocumented variable
     *
     * @var Model
     */
    private Model $model;

    /**
     * Undocumented variable
     *
     * @var array
     */
    private array $slugs = [];

    /**
     * Undocumented function
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Undocumented function
     *
     * @param string $slug
     * @return void
     */
    public function attach(string $slug): void
    {
        $this->slugs[] = $slug;
    }

    /**
     * Undocumented function
     *
     * @return array
     */
    private function getPermissionsIds(): array
    {
        return array_filter(Permission::whereIn('slug', $this->slugs)->pluck('id')->toArray());
    }

    /**
     * Undocumented function
     */
    public function __destruct()
    {
        $this->model->permissions()->sync($this->getPermissionsIds());
    }
}
