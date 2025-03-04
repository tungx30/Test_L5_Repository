<?php

namespace Packages\User\Http\Controllers;

use App\Enums\Permission;
use App\Enums\Role;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Packages\Auth\Http\Requests\AccountCreateRequest;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    protected $repository;
    public function __construct(User $repository)
    {
        $this->repository = $repository;
    }
    public function test()
    {
        return response()->json(['message' => 'test API ']);
    }
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        // Kiểm tra xác thực bằng JWTAuth
        if (! $token = JWTAuth::attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Login failed',
                'errors' => ['Invalid credentials']
            ], 401);
        }

        // Lấy thông tin user từ JWT
        $user = JWTAuth::user();

        // Lấy thông tin tài khoản liên kết (account_id, account_type)
        $account = $user->account;

        // Kiểm tra trạng thái tài khoản
        if ($account && $account->status !== 'ACTIVE') {
            JWTAuth::invalidate($token);
            return response()->json([
                'success' => false,
                'message' => 'Account is inactive',
            ], 403);
        }

        // Kiểm tra vai trò của user
        $roles = $user->getRoleNames();
        $permissions = $user->getAllPermissions()->pluck('name');

        // Kiểm tra user thuộc loại nào (Admin, Staff, User)
        $userType = Role::getText(Role::User);
        if ($user->hasRole(Role::getText(Role::Admin))) {
            $userType = 'Admin';
        } elseif ($user->hasRole(Role::getText(Role::Staff))) {
            $userType = 'Staff';
        }

        // Kiểm tra quyền đặc biệt
        $hasManageUser = $user->hasPermissionTo(Permission::MANAGE_USER);
        $hasSearchStaff = $user->hasPermissionTo(Permission::SEARCH_STAFF);

        // Dữ liệu trả về
        $loginData = [
            'token' => $token,
            'type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
            'user_info' => [
                'id' => $user->id,
                'full_name' => $user->full_name,
                'phone' => $user->phone,
                'email' => $user->email,
                'account_id' => $account ? $account->id : null,
                'account_type' => $account ? $account->account_type : null,
                'roles' => $roles,
                'permissions' => $permissions,
                'user_type' => $userType,
                'has_manage_user' => $hasManageUser,
                'has_search_staff' => $hasSearchStaff,
            ],
        ];

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'data' => $loginData
        ], 200);
    }

    public function register(AccountCreateRequest $request)
    {
        $repository = $this->repository->createAccount($this->repository, $request);
        return response()->json([
            'status' => true,
            'data' => $repository,
            'message' => 'Account created successfully'
        ]);
    }
}
