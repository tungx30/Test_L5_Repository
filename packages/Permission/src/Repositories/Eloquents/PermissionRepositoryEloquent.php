<?php

namespace Packages\Permission\Repositories\Eloquents;

use Packages\Permission\Repositories\Contracts\PermissionRepository;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Spatie\Permission\Models\Permission;

/**
 * Class PermissionRepositoryEloquent.
 */
class PermissionRepositoryEloquent extends BaseRepository implements PermissionRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Permission::class;
    }

    /**
     * Danh sách các field có thể tìm kiếm.
     */
    protected $fieldSearchable = [
        'name' => 'like', // Tìm kiếm Permission theo tên
        'guard_name' => 'exact', // Tìm kiếm theo guard_name chính xác
    ];

    /**
     * Boot up the repository, pushing criteria.
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Lọc danh sách permissions theo phân trang
     */
    public function filterIndex($attributes)
    {
        return $this->paginate(config('constants.SETTING.RECORD_PER_PAGE'));
    }

    /**
     * Lấy tất cả quyền mà không có nhóm (permission_group_id == null).
     */
    public function getUserPermission()
    {
        return $this->model->whereNull('permission_group_id')->get();
    }
}
