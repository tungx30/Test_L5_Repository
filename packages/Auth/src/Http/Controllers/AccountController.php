<?php

namespace Packages\Auth\Http\Controllers;

use App\Enums\Permission;
use App\Enums\Role;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Packages\Auth\Http\Requests\AccountCreateRequest;
use Packages\Auth\Repositories\Contracts\AccountRepository;
use Illuminate\Support\Facades\Hash;
use Packages\Auth\Models\Account;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;


class AccountController extends Controller
{
    protected $repository;
    public function __construct(AccountRepository $repository)
    {
        $this->repository = $repository;
    }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        // Tìm user trong bảng accounts thay vì users
        $account = Account::where('email', $credentials['email'])->first();

        if (!$account || !Hash::check($credentials['password'], $account->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Login failed',
                'errors' => ['Invalid credentials']
            ], 401);
        }
        // Tạo JWT token cho account
        $token = JWTAuth::fromUser($account);

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'token' => $token,
            'user_info' => [
                'id' => $account->id,
                'name' => $account->name,
                'email' => $account->email,
                'account_type' => $account->account_type,
                'account_id' => $account->account_id,
            ]
        ], 200);
    }

    public function register(AccountCreateRequest $request)
    {
        $data = $this->repository->handleCreateUserAndAccount($this->repository, $request);
        return response()->json([
            'status' => true,
            'data' => $data,
            'message' => 'Account created and linked to User successfully'
        ]);
    }
    public function logout()
    {
        try {
            $user = Auth::user();
            // Xóa token hiện tại
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json([
                'status' => true,
                'message' => 'Logout successful.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to logout.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function profile()
    {
        try {
            // Lấy user từ token JWT
            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found or unauthorized'
                ], 401);
            }

            return response()->json([
                'status' => true,
                'message' => 'User profile retrieved successfully',
                'data' => [
                    'id' => $user->id,
                    'full_name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'address' => $user->address
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to retrieve profile',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
