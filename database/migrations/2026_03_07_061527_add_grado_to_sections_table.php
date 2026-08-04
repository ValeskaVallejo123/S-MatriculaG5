<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // grado/nombre/capacidad ya existen desde create_secciones_table.php;
        // se dejan estos guards de forma segura e idempotente.
        Schema::table('secciones', function (Blueprint $table) {
            if (!Schema::hasColumn('secciones', 'grado')) {
                $table->string('grado');
            }
            if (!Schema::hasColumn('secciones', 'nombre')) {
                $table->string('nombre');
            }
            if (!Schema::hasColumn('secciones', 'capacidad')) {
                $table->integer('capacidad')->default(40);
            }
        });
    }

    public function down(): void
    {
        // No se revierte nada: estas columnas pertenecen a
        // 2026_02_10_173336_create_secciones_table.php.
    }
};
