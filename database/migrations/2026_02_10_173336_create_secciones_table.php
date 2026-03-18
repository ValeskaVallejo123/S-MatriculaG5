<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('secciones', function (Blueprint $table) {
        $table->id();

        // QUITAMOS el ->after('id') de aquí:
        $table->string('grado', 20);

        $table->string('nombre', 10);

        // Columna virtual
        $table->string('letra', 10)->virtualAs('nombre');

        $table->unsignedSmallInteger('capacidad')->default(30);

        $table->timestamps();

        $table->unique(['grado', 'nombre']);
    });
}

    public function down(): void
    {
        Schema::dropIfExists('secciones');
    }
};