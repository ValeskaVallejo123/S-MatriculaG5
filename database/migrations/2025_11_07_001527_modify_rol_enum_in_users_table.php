<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Cambiamos el nombre correcto de la columna: user_type
        DB::statement("ALTER TABLE users MODIFY COLUMN user_type ENUM('super_admin', 'admin', 'profesor', 'estudiante') DEFAULT 'estudiante'");
    }

    public function down(): void
    {
        // Revertir al estado anterior si fuera necesario
        DB::statement("ALTER TABLE users MODIFY COLUMN user_type ENUM('super_admin', 'admin', 'estudiante') DEFAULT 'estudiante'");
    }
};
