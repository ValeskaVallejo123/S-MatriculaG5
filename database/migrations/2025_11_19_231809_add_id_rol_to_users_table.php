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
        Schema::table('users', function (Blueprint $table) {
            // Agregar campo id_rol si no existe
            if (!Schema::hasColumn('users', 'id_rol')) {
                $table->foreignId('id_rol')->nullable()->constrained('roles')->onDelete('set null');
            }
            
            // Eliminar campo role antiguo si existe (opcional)
            // if (Schema::hasColumn('users', 'role')) {
            //     $table->dropColumn('role');
            // }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'id_rol')) {
                $table->dropForeign(['id_rol']);
                $table->dropColumn('id_rol');
            }
        });
    }
};