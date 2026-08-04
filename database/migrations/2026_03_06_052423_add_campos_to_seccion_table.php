<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('secciones', function (Blueprint $table) {
            // Solo agrega las que NO existan todavía
            // (secciones ya se creó con grado/nombre en create_secciones_table,
            // así que en la práctica esto ya no hace nada; se deja de forma
            // segura e idempotente por si el orden de migraciones cambia).
            if (!Schema::hasColumn('secciones', 'grado')) {
                $table->string('grado', 20)->after('id');
            }
            if (!Schema::hasColumn('secciones', 'nombre')) {
                $table->string('nombre', 10)->after('grado');
            }
        });
    }

    public function down(): void
    {
        // No se revierte nada aquí: las columnas grado/nombre pertenecen a
        // 2026_02_10_173336_create_secciones_table.php, no a esta migración.
    }
};
