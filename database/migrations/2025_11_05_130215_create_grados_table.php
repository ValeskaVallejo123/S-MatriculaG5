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
       // En la migración (database/migrations/xxxx_create_grados_table.php o ciclos)
Schema::create('grados', function (Blueprint $table) {
    $table->id();
    $table->string('nombre', 50);
    $table->string('seccion')->nullable();
    $table->string('nombre_maestro', 255); // Cambio aquí
    $table->enum('jornada', ['Matutina', 'Vespertina'])->default('Matutina'); // Cambio aquí
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grados');
    }
};