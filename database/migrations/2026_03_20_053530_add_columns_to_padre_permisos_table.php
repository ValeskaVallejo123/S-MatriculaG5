<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('padre_permisos', function (Blueprint $table) {
            // padre_id, estudiante_id y el resto de columnas de permisos ya se
            // crearon en 2025_01_04_001200_create_padre_permisos_table.php.
            // Aquí solo se agrega la columna que realmente es nueva:
            if (!Schema::hasColumn('padre_permisos', 'modificar_datos_contacto')) {
                $table->boolean('modificar_datos_contacto')->default(false);
            }
        });
    }

    public function down(): void
    {
        Schema::table('padre_permisos', function (Blueprint $table) {
            $table->dropColumn(['modificar_datos_contacto']);
        });
    }
};
