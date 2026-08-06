<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Esta migración quedó duplicada: la tabla "sessions" ya se crea dentro
     * de 2025_01_01_000100_create_users_table.php (junto con users y
     * password_reset_tokens, que es el patrón por defecto de Laravel).
     * Se deja como no-op para no romper el historial de migraciones.
     */
    public function up(): void
    {
        //
    }

    public function down(): void
    {
        //
    }
};
