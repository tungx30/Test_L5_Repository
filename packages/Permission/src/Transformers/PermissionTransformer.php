<?php

namespace Packages\Permission\Transformers;

use League\Fractal\TransformerAbstract;
use Spatie\Permission\Models\Permission;

/**
 * Class PermissionTransformer.
 */
class PermissionTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $defaultIncludes = [];

    /**
     * Array attribute doesn't parse.
     */
    protected $ignoreAttributes = ['created_at', 'updated_at', 'guard_name', 'permission_group_id'];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [];

    /**
     * Transform the Permission entity.
     *
     * @param Permission $model
     *
     * @return array
     */
    public function transform(Permission $model): array
    {
        return [
            'id' => $model->id,
            'name' => $model->name,
            'display_name' => $model->display_name ?? null,
        ];
    }
}
