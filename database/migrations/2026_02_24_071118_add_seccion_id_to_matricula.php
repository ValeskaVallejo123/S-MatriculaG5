<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Esta migración quedó obsoleta: intentaba agregar la FK seccion_id
     * apuntando a una tabla llamada "seccion", que nunca existió (el nombre
     * correcto es "secciones"). Además duplicaba la columna/FK que agrega
     * correctamente 2026_03_22_023120_add_seccion_id_to_matriculas_table.php.
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
