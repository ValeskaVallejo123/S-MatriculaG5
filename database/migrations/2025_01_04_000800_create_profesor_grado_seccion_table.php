<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('profesor_grado_seccion', function (Blueprint $table) {
        $table->id();

        $table->unsignedBigInteger('profesor_id');
        $table->unsignedBigInteger('grado_id');
        $table->string('seccion', 5);

        $table->timestamps();

        // Relaciones
        $table->foreign('profesor_id')
            ->references('id')->on('profesores')
            ->onDelete('cascade');

        $table->foreign('grado_id')
            ->references('id')->on('grados')
            ->onDelete('cascade');

        // Evita duplicados
        $table->unique(['profesor_id', 'grado_id', 'seccion'], 'profesor_grado_seccion_unique');
    });
}

public function down()
{
    Schema::dropIfExists('profesor_grado_seccion');
}
};
