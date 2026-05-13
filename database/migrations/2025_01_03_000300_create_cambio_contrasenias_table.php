<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cambio_contrasenias', function (Blueprint $table) {
            $table->id();

            // Usuario que hizo el cambio
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Información opcional del cambio
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('descripcion')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cambio_contrasenias');
    }
};
