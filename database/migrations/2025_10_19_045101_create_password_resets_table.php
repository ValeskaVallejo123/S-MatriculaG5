<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('password_resets', function (Blueprint $table) {
            $table->id();
            $table->string('email')->index(); // correo del usuario
            $table->string('token');          // token único de recuperación
            $table->timestamp('created_at')->nullable(); // fecha de creación del token
            $table->timestamp('expires_at')->nullable(); // fecha de expiración opcional
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('password_resets');
    }
};
