<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('padres', function (Blueprint $table) {
            $table->id();

            // Información del Padre/Tutor
            $table->string('nombre', 50);
            $table->string('apellido', 50);
            $table->string('dni', 13)->unique();

            $table->enum('parentesco', ['padre', 'madre', 'tutor_legal', 'otro']);
            $table->string('parentesco_otro', 100)->nullable();

            // Información de Contacto
            $table->string('correo', 255)->nullable();
            $table->string('telefono', 15);
            $table->string('telefono_secundario', 15)->nullable();
            $table->string('direccion', 200);

            // Información Laboral
            $table->string('ocupacion', 100)->nullable();

            // Información del Sistema
            $table->text('observaciones')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('padres');
    }
};
