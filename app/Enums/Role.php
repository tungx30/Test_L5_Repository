<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class Role extends Enum
{
    const Admin = 0;
    const User  = 1;
    const Staff = 2;

    /**
     * Lấy danh sách Role dưới dạng mảng để có thể xuất ra dropdown
     */
    public static function all(): array
    {
        return [
            self::Admin,
            self::User,
            self::Staff,
        ];
    }

    /**
     * Chuyển Role ID thành chuỗi text để fe có thể lấy dễ dàng hơn
     */
    public static function getText(int $roleId): string
    {
        return match ($roleId) {
            self::Admin => 'admin',
            self::User => 'user',
            self::Staff => 'staff',
            default => 'unknown',
        };
    }

    /**
     * Chuyển sang chuỗi để có thể thừa kế ở class config/permissions
     */
    public static function fromName(string $name): int
    {
        return match ($name) {
            'admin' => self::Admin,
            'staff' => self::Staff,
            'user' => self::User,
            default => throw new \Exception('Invalid Role'),
        };
    }
}
