<?php

namespace Packages\User\Http\Controllers;

use App\Enums\Permission;
use App\Enums\Role;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Packages\Auth\Http\Requests\AccountCreateRequest;
use Illuminate\Support\Facades\Hash;
use Packages\User\Repositories\Contracts\UserRepository;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    protected $repository;
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }
    public function test()
    {
        return response()->json(['message' => 'test API ']);
    }
    
}
