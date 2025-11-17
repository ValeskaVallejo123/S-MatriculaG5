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
            // SOLO agregar los nuevos campos, sin tocar nada existente
            $table->boolean('is_super_admin')->default(false)->after('rol');
            $table->json('permissions')->nullable()->after('is_super_admin');
            $table->boolean('is_protected')->default(false)->after('permissions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Solo eliminar los campos que agregamos
            $table->dropColumn(['is_super_admin', 'permissions', 'is_protected']);
        });
    }
};