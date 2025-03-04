<?php

namespace Packages\Auth\Repositories\Eloquents;

use Packages\Auth\Repositories\Contracts\AccountRepository;
use Packages\Auth\Models\Account;
use Prettus\Repository\Eloquent\BaseRepository;

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
