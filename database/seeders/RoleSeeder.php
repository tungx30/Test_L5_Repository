<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Enums\Role as RoleEnum;

class RoleSeeder extends Seeder
{
    public function run()
    {
        foreach (config('permissions.default_permission') as $roleName => $permissions) {
            $roleId = RoleEnum::fromName($roleName); // Chuyển từ chuỗi thành Enum
            $role = Role::firstOrCreate(['name' => RoleEnum::getText($roleId)]);
            $role->givePermissionTo($permissions);
        }
    }
}
