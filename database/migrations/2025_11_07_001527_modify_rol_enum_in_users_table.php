<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Modificar la columna correcta: user_type
        DB::statement("ALTER TABLE users MODIFY COLUMN user_type ENUM('estudiante', 'admin', 'super_admin') DEFAULT 'estudiante'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN user_type ENUM('estudiante', 'admin') DEFAULT 'estudiante'");
    }
};
