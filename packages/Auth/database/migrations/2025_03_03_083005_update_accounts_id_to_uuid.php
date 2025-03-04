<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Nếu bảng chưa có dữ liệu, chỉ cần đổi kiểu dữ liệu của `id`
        DB::statement('ALTER TABLE accounts MODIFY id CHAR(36) NOT NULL');
    }

    public function down(): void
    {
        // Khôi phục về kiểu INT nếu cần
        DB::statement('ALTER TABLE accounts MODIFY id INT NOT NULL AUTO_INCREMENT');
    }
};
