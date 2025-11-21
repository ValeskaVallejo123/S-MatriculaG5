<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    if (!Schema::hasTable('padres')) {
        Schema::create('padres', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 50);
            $table->string('apellido', 50);
            $table->string('dni', 13)->unique();
            $table->enum('parentesco', ['padre', 'madre', 'tutor_legal']);
            $table->string('parentesco_otro', 50)->nullable();

            // Información de Contacto
         $table->string('correo')->nullable();
            $table->string('telefono', 8);
            $table->string('telefono_secundario', 8)->nullable();
            $table->string('direccion', 200);
            $table->string('ocupacion', 100)->nullable();
            $table->string('lugar_trabajo', 100)->nullable();
            $table->string('telefono_trabajo', 8)->nullable();
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }
}

    public function down(): void
    {
        Schema::dropIfExists('padres');
    }
};


