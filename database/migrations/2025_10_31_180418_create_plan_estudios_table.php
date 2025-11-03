<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plan_estudios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 150);
            $table->string('nivel_educativo', 50); // E.g., Licenciatura, Máster
            $table->string('grado', 50)->nullable(); // E.g., 3er año, Grado 5
            $table->unsignedSmallInteger('anio')->nullable(); // Año de implementación
            $table->unsignedSmallInteger('duracion')->comment('Duración en años o ciclos');
            $table->string('jornada', 50); // E.g., Diurna, Vespertina
            $table->date('fecha_aprobacion');
            $table->text('descripcion')->nullable();

            // Relación con el Centro
            $table->foreignId('centro_id')
                  ->constrained('centros') // Asume que ya tienes una tabla 'centros'
                  ->onDelete('cascade'); 
                  
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plan_estudios');
    }
};