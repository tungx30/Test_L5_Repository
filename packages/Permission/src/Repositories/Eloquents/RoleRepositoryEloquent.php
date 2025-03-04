<?php

namespace Packages\Permission\Repositories\Eloquents;

use Packages\Permission\Presenters\PermissionPresenter;
use Packages\Permission\Presenters\RolePresenter;
use Packages\Permission\Repositories\Contracts\RoleRepository;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * Class BranchRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class RoleRepositoryEloquent extends BaseRepository implements RoleRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Role::class;
    }

    protected $fieldSearchable = [];

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
