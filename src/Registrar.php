<?php

namespace LaravelGreatApi\Access;

use Illuminate\Support\Str;
use LaravelGreatApi\Access\Models\Permission;
use LaravelGreatApi\Access\Models\Role;
use LaravelGreatApi\Access\Models\Team;
use LaravelGreatApi\Access\PermissionManager;

class Registrar
{
    /**
     * Undocumented variable
     *
     * @var Role|Permission|Team
     */
    private Role|Permission|Team $model;

    /**
     * Undocumented function
     *
     * @param Role|Permission|Team $model
     */
    public function __construct(Role|Permission|Team $model)
    {
        $this->model = $model;
    }

    /**
     * Undocumented function
     *
     * @param string $slug
     * @return boolean
     */
    private function canCreate(string $slug): bool
    {
        return $this->model->where('slug', $slug)->exists() === false;
    }

    /**
     * Undocumented function
     *
     * @param string $name
     * @param string|null $slug
     * @return \LaravelGreatApi\Access\Registrar
     */
    public function register(string $name, string $slug = null): Registrar
    {
        $slug = $slug ?? Str::slug($name, '_');

        if ($this->canCreate($slug)) {
            $this->model = $this->model->create([
                'name' => $name,
                'slug' => $slug
            ]);
        } else {
            $this->model = $this->model->where('slug', $slug)->first();
        }

        return $this;
    }

    public function root(): Registrar
    {
        $this->model->update(['root' => true]);

        return $this;
    }

    public function permissions(callable $callback): Registrar
    {
        $callback(new PermissionManager($this->model));

        return $this;
    }
}
