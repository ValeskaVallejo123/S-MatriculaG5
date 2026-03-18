<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('matriculas', function (Blueprint $table) {
            // La columna seccion_id ya existe, solo agregamos la foreign key
            $table->foreign('seccion_id')
                  ->references('id')
                  ->on('seccion')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('matriculas', function (Blueprint $table) {
            $table->dropForeign(['seccion_id']);
        });
    }
};
