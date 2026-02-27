<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Cambiar el ENUM para incluir 'padre'
        DB::statement("ALTER TABLE users MODIFY COLUMN user_type ENUM('super_admin', 'admin', 'profesor', 'estudiante', 'padre') DEFAULT 'estudiante'");
    }

    public function down(): void
    {
        // Volver al ENUM anterior
        DB::statement("ALTER TABLE users MODIFY COLUMN user_type ENUM('super_admin', 'admin', 'profesor', 'estudiante') DEFAULT 'estudiante'");
    }
};