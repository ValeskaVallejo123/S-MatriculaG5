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
        Schema::create('documentos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('estudiante_id');
            $table->unsignedBigInteger('padre_id');
            $table->string('nombre');
            $table->string('tipo'); // jpg, png, pdf
            $table->integer('tamano'); // tamaño en bytes
            $table->string('ruta');
            $table->timestamp('fecha_carga')->useCurrent();
            $table->string('estado')->default('activo');
            $table->timestamps();


            if (Schema::hasTable('estudiantes')) {
                $table->foreign('estudiante_id')
                    ->references('id')
                    ->on('estudiantes')
                    ->onDelete('cascade');
            }

            if (Schema::hasTable('padres')) {
                $table->foreign('padre_id')
                    ->references('id')
                    ->on('padres')
                    ->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos');
    }
};

