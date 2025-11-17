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
            // Verifica si la columna user_type ya existe
            if (!Schema::hasColumn('users', 'user_type')) {
                $table->enum('user_type', ['super_admin', 'admin', 'profesor', 'estudiante'])
                      ->default('estudiante')
                      ->after('password');
            }

            // Agregar campos nuevos solo si no existen
            if (!Schema::hasColumn('users', 'is_super_admin')) {
                $table->boolean('is_super_admin')->default(false)->after('user_type');
            }

            if (!Schema::hasColumn('users', 'permissions')) {
                $table->json('permissions')->nullable()->after('is_super_admin');
            }

            if (!Schema::hasColumn('users', 'is_protected')) {
                $table->boolean('is_protected')->default(false)->after('permissions');
            }

            if (!Schema::hasColumn('users', 'remember_token')) {
                $table->rememberToken()->after('is_protected');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'user_type')) {
                $table->dropColumn('user_type');
            }
            if (Schema::hasColumn('users', 'is_super_admin')) {
                $table->dropColumn('is_super_admin');
            }
            if (Schema::hasColumn('users', 'permissions')) {
                $table->dropColumn('permissions');
            }
            if (Schema::hasColumn('users', 'is_protected')) {
                $table->dropColumn('is_protected');
            }
            if (Schema::hasColumn('users', 'remember_token')) {
                $table->dropColumn('remember_token');
            }
        });
    }
};
