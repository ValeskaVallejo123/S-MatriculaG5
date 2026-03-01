<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('matriculas', function (Blueprint $table) {
            $table->foreignId('seccion_id')
                  ->nullable()
                  ->constrained('secciones')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('matriculas', function (Blueprint $table) {
            $table->dropForeign(['seccion_id']);
            $table->dropColumn('seccion_id');
        });
    }
};