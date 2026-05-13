<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    // Si la tabla ya existe y quieres agregar columnas:
    Schema::table('seccions', function (Blueprint $table) {
        if (!Schema::hasColumn('seccions', 'grado')) {
            $table->string('grado'); // Para guardar "1er Grado"
        }
        if (!Schema::hasColumn('seccions', 'nombre')) {
            $table->string('nombre'); // Para guardar "A"
        }
        if (!Schema::hasColumn('seccions', 'capacidad')) {
            $table->integer('capacidad')->default(40);
        }
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('section', function (Blueprint $table) {
            //
        });
    }
};