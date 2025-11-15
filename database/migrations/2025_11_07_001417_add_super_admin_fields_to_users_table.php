<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'is_super_admin')) {
                $table->boolean('is_super_admin')->default(false);
            }

            if (!Schema::hasColumn('users', 'permissions')) {
                $table->json('permissions')->nullable();
            }

            if (!Schema::hasColumn('users', 'is_protected')) {
                $table->boolean('is_protected')->default(false);
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'is_super_admin')) {
                $table->dropColumn('is_super_admin');
            }

            if (Schema::hasColumn('users', 'permissions')) {
                $table->dropColumn('permissions');
            }

            if (Schema::hasColumn('users', 'is_protected')) {
                $table->dropColumn('is_protected');
            }
        });
    }
};
