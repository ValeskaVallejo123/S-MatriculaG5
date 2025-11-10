<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('estudiantes')) {
            Schema::table('estudiantes', function (Blueprint $table) {
                // Solo si la columna existe, se vuelve nullable
                if (Schema::hasColumn('estudiantes', 'email')) {
                    $table->string('email')->nullable()->change();
                }
            });
        }
    }

    public function down(): void
    {
        // No revertimos nada porque no sabemos si originalmente era unique o no
    }
};
