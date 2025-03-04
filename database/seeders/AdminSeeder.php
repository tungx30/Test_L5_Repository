<?php

namespace Database\Seeders;

use App\Enums\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Packages\User\Models\User;
use Packages\Auth\Models\Account;
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

        // Tạo tài khoản Admin (User)
        $user = User::firstOrCreate(
            ['email' => 'admin@gmail.com'], // Kiểm tra nếu đã tồn tại
            [
                'id' => Str::uuid(),
                'full_name' => 'admin',
                'status' => 'ACTIVE',
                'account_id' => Str::uuid(),
            ]
        );

        // Kiểm tra nếu tài khoản đã tồn tại trước đó
        $account = Account::where('email', 'admin@gmail.com')->first();

        if (!$account) {
            // Tạo tài khoản liên kết với User
            $account = Account::create([
                'id' => Str::uuid(),
                'email' => 'admin@gmail.com',
                'name'  => 'admin',
                'password' => Hash::make('123456789'),
                'account_type' => User::class,
                'account_id' => $user->account_id,
            ]);
        }

        $user->syncRoles(Role::Admin);
        $user->givePermissionTo(Permission::all());
    }
}
