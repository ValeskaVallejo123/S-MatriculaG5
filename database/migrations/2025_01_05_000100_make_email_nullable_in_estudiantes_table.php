<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('estudiantes') && Schema::hasColumn('estudiantes', 'email')) {
            Schema::table('estudiantes', function (Blueprint $table) {
                $table->string('email')->nullable()->change();
            });
        }
    }

    public function down(): void
    {
        // Se deja vacío ya que no sabemos la definición original del campo.
    }
};
