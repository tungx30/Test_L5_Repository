<?php

namespace Packages\User\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Packages\Auth\Models\Account;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, SoftDeletes, HasRoles;

    protected $fillable = [
        'full_name',
        'phone',
        'email',
        'address',
        'status'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * JWT - Trả về key định danh người dùng
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * JWT - Trả về một mảng chứa các claims tùy chỉnh
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Kiểm tra xem người dùng có quyền thực hiện hành động nào đó không
     */
    public function hasPermission($permission): bool
    {
        return $this->hasPermissionTo($permission);
    }

    /**
     * Kiểm tra nếu người dùng có quyền quản lý nhân viên
     */
    public function canManageStaff(): bool
    {
        return $this->hasPermission('manage-staff');
    }

    /**
     * Kiểm tra nếu người dùng có quyền CRUD người dùng
     */
    public function canManageUser(): bool
    {
        return $this->hasPermission('manage-user') || $this->hasPermission('staff-manage-user');
    }

    /**
     * Kiểm tra nếu người dùng có quyền tìm kiếm nhân viên
     */
    public function canSearchStaff(): bool
    {
        return $this->hasPermission('search-staff') || $this->hasPermission('user-search-staff');
    }

    /**
     * Kiểm tra nếu người dùng có quyền tìm kiếm người dùng
     */
    public function canSearchUser(): bool
    {
        return $this->hasPermission('search-user') || $this->hasPermission('staff-search-user');
    }

    /**
     * Kiểm tra nếu người dùng chỉ có quyền đọc thông tin nhân viên
     */
    public function canReadStaff(): bool
    {
        return $this->hasPermission('user-read-staff');
    }

    /**
     * Kiểm tra nếu người dùng chỉ có quyền đọc thông tin chính mình
     */
    public function canReadSelf(): bool
    {
        return $this->hasPermission('user-read-self');
    }
    public function account()
    {
        return $this->morphOne(Account::class, 'account');
    }


}
