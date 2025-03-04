<?php

namespace Packages\Permission\Transformers;

use League\Fractal\TransformerAbstract;
use Spatie\Permission\Models\Role;

/**
 * Class RoleTransformer.
 */
class RoleTransformer extends TransformerAbstract
{
    /**
     * Transform the role model into an array.
     *
     * @param Role $role
     * @return array
     */
    public function transform(Role $role): array
    {
        return [
            'id' => $role->id,
            'name' => $role->name,
            'guard_name' => $role->guard_name,
            'created_at' => $role->created_at ? $role->created_at->toDateTimeString() : null,
            'updated_at' => $role->updated_at ? $role->updated_at->toDateTimeString() : null,
        ];
    }
}

