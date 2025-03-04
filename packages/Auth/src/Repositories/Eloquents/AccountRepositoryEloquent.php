<?php

namespace Packages\Auth\Repositories\Eloquents;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Packages\Auth\Repositories\Contracts\AccountRepository;
use Packages\Auth\Models\Account;
use Prettus\Repository\Eloquent\BaseRepository;
use Illuminate\Support\Str;
use Packages\User\Models\User as ModelsUser;
use Spatie\Permission\Models\Role as RoleModel;

class AccountRepositoryEloquent extends BaseRepository implements AccountRepository
{
    public function model()
    {
        return Account::class;
    }

    public function getAll()
    {
        return $this->all();
    }

    public function findById($id)
    {
        return $this->find($id);
    }

    public function handleCreateUserAndAccount($repository, $request)
    {
        return DB::transaction(function () use ($repository, $request) {
            // **Tạo User**
            $user = ModelsUser::create([
                'id'        => Str::uuid(),
                'email'     => $request->email,
                'full_name' => $request->name,
                'status'    => 'ACTIVE',
            ]);

            // **Tạo Account thông qua relationship**
            $user->account()->create([
                'id'             => $user->id,
                'name'           => $request->name ?? 'User Default',
                'email'          => $request->email,
                'password'       => Hash::make($request->password)
            ]);

            // **Gán Role đúng cách**
            $roleId = ($user->email === 'admin@gmail.com') ? Role::Admin : Role::User;
            $roleName = Role::getText($roleId); // Chuyển ID thành tên Role

            // Tìm Role trong database (dùng model Role của Spatie)
            $roleModel = RoleModel::where('name', $roleName)->where('guard_name', 'web')->first();

            if ($roleModel) {
                $user->assignRole($roleModel);
            } else {
                throw new \Exception("Role '$roleName' with guard 'web' not found!");
            }

            return [
                'account' => $user->userAccount, // Sửa lỗi trả về account đúng
                'user'    => $user
            ];
        });
    }


    // public function update($id, array $data)
    // {
    //     return $this->update($data, $id);
    // }
    // public function delete($id)
    // {
    //     return $this->delete($id);
    // }
}
