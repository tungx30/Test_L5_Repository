<?php

namespace Database\Seeders;

use App\Enums\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Packages\User\Models\User;
use Illuminate\Support\Str;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Xóa tất cả phân quyền cũ
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('role_has_permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Tạo tài khoản admin
        $user = User::firstOrCreate(
            ['email' => 'admin@gmail.com'], // Kiểm tra nếu đã có
            [
                'id' => Str::uuid(),
                'full_name' => 'admin'
            ]
        );

        // Tạo account liên kết với User
        $user->account()->create([
            'id' => Str::uuid(),
            'account_id' => $user->id,
            'account_type' => get_class($user),
            'email' => 'admin@gmail.com',
            'name'  => 'admin',
            'password' => bcrypt('123456789')
        ]);




        // Gán role Admin và quyền hạn
        $user->syncRoles(Role::Admin);
        $user->givePermissionTo(Permission::all());
    }
}
