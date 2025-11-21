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
            // Agregar la nueva columna id_rol si no existe
            if (!Schema::hasColumn('users', 'id_rol')) {
                $table->foreignId('id_rol')->nullable()->after('email')->constrained('roles')->onDelete('set null');
            }
            
            // Opcional: Si quieres eliminar la columna role antigua
            // Descomenta estas líneas SOLO si ya no necesitas la columna role
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
            // Eliminar la relación y la columna
            if (Schema::hasColumn('users', 'id_rol')) {
                $table->dropForeign(['id_rol']);
                $table->dropColumn('id_rol');
            }
            
            // Opcional: Restaurar la columna role si la eliminaste
            // if (!Schema::hasColumn('users', 'role')) {
            //     $table->string('role')->default('user');
            // }
        });
    }
};