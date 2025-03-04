<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class Permission extends Enum
{
    // Admin Permissions
    const MANAGE_STAFF = 'manage-staff'; // CRUD Nhân viên
    const MANAGE_USER = 'manage-user';   // CRUD Người dùng
    const SEARCH_STAFF = 'search-staff';
    const SEARCH_USER = 'search-user';

    // Staff Permissions
    const STAFF_MANAGE_USER = 'staff-manage-user'; // CRUD Người dùng
    const STAFF_SEARCH_USER = 'staff-search-user';

    // User Permissions
    const USER_READ_STAFF = 'user-read-staff'; // Chỉ xem Nhân viên
    const USER_READ_SELF = 'user-read-self';   // Chỉ xem chính mình
    const USER_SEARCH_STAFF = 'user-search-staff';

    /**
     * Lấy danh sách tất cả permissions
     */
    public static function all(): array
    {
        return [
            self::MANAGE_STAFF, self::MANAGE_USER, self::SEARCH_STAFF, self::SEARCH_USER,
            self::STAFF_MANAGE_USER, self::STAFF_SEARCH_USER,
            self::USER_READ_STAFF, self::USER_READ_SELF, self::USER_SEARCH_STAFF,
        ];
    }

    /**
     * Chuyển Permission thành text để frontend dễ xử lý
     */
    public static function getText(string $permission): string
    {
        return match ($permission) {
            self::MANAGE_STAFF => 'CRUD Nhân viên',
            self::MANAGE_USER => 'CRUD Người dùng',
            self::SEARCH_STAFF => 'Tìm kiếm Nhân viên',
            self::SEARCH_USER => 'Tìm kiếm Người dùng',
            self::STAFF_MANAGE_USER => 'Nhân viên CRUD Người dùng',
            self::STAFF_SEARCH_USER => 'Nhân viên tìm kiếm Người dùng',
            self::USER_READ_STAFF => 'Người dùng xem Nhân viên',
            self::USER_READ_SELF => 'Người dùng xem chính mình',
            self::USER_SEARCH_STAFF => 'Người dùng tìm kiếm Nhân viên',
            default => 'Unknown Permission',
        };
    }
}
