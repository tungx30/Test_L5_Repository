<?php

namespace Packages\User\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Packages\Auth\Models\Account;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory, Notifiable, SoftDeletes, HasRoles;
    use HasUuids;

    protected $fillable = [
        'id',
        'full_name',
        'phone',
        'email',
        'address',
        'status'
    ];
    public $incrementing = false; // UUID không phải là số tự động tăng
    protected $keyType = 'string'; // UUID là chuỗi
    protected $guard_name = 'web';
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
    public function userAccount()
    {
        return $this->hasOne(Account::class, 'account_id');
    }




}
