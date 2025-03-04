<?php

namespace Packages\User\Repositories\Eloquents;

use App\Models\User;
use Packages\User\Repositories\Contracts\UserRepository;
use Prettus\Repository\Eloquent\BaseRepository;

class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    public function model()
    {
        return User::class;
    }

    public function getAll()
    {
        return $this->all();
    }

    public function findById($id)
    {
        return $this->find($id);
    }

    public function createAccount($repository, $request)
    {
        $account = $repository->create($request->all());
        if($request->password){
            $account->password =  bcrypt($request->password);
            $account->save();
        }
        if ($request->role) {
            $account->syncRoles($request->role);
        }
        return $account;
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
