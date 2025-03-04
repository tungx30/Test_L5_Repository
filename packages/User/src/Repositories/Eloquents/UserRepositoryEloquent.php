<?php

namespace Packages\User\Repositories\Eloquents;

use App\Models\User;
use Packages\User\Repositories\Contracts\UserRepository;
use Prettus\Repository\Eloquent\BaseRepository;
use Illuminate\Support\Facades\Hash;

class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    public function model()
    {
        return User::class;
    }

    public function getAll(array $filters = [])
    {
        $query = User::query();

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        if (!empty($filters['search'])) {
            $query->where('full_name', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('email', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('phone', 'like', '%' . $filters['search'] . '%');
        }
        if (!empty($filters['order_by'])) {
            $query->orderBy($filters['order_by'], $filters['sort'] ?? 'asc');
        }

        return $query->paginate($filters['per_page'] ?? 10);
    }

    public function findById(string $id)
    {
        return $this->find($id);
    }

    public function findByEmail(string $email)
    {
        return $this->findWhere(['email' => $email])->first();
    }

    public function createUser(array $data)
    {
        $user = $this->create([
            'id' => \Illuminate\Support\Str::uuid(), // Tạo UUID tự động
            'full_name' => $data['full_name'],
            'phone' => $data['phone'] ?? null,
            'email' => $data['email'] ?? null,
            'address' => $data['address'] ?? null,
            'status' => $data['status'] ?? 'ACTIVE',
        ]);

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
            $user->save();
        }

        if (!empty($data['role'])) {
            $user->syncRoles($data['role']);
        }

        return $user;
    }

    public function updateUser(string $id, array $data)
    {
        $user = User::findOrFail($id);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);
        return $user;
    }

    public function deleteUser(string $id)
    {
        $user = User::findOrFail($id);

        if ($user->deleted_at) {
            throw new \Exception('User already deleted.');
        }

        return $user->delete();
    }

    /**
     * Khôi phục user đã bị xóa mềm
     */
    public function restoreUser(string $id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        return $user->restore();
    }

    /**
     * Xóa vĩnh viễn user
     */
    public function forceDeleteUser(string $id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        return $user->forceDelete();
    }
}
