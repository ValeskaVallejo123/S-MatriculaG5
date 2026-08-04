<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Esta migración quedó duplicada: las columnas grado_id y seccion ya se
     * crean dentro de 2025_01_04_000600_create_profesor_materia_table.php,
     * junto con su índice único (profesor_materia_grado_unique).
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
