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
        Schema::table('profesor_materia_grados', function (Blueprint $table) {
            // Permitir materia asignada a grado sin profesor aún definido
            $table->dropForeign(['profesor_id']);
            $table->unsignedBigInteger('profesor_id')->nullable()->change();
            $table->foreign('profesor_id')
                  ->references('id')
                  ->on('profesores')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('profesor_materia_grados', function (Blueprint $table) {
            $table->dropForeign(['profesor_id']);
            $table->unsignedBigInteger('profesor_id')->nullable(false)->change();
            $table->foreign('profesor_id')
                  ->references('id')
                  ->on('profesores')
                  ->onDelete('cascade');
        });
    }
};
