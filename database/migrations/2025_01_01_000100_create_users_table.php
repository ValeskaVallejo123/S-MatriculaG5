<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('email')->unique();

            // Tipo de usuario
            $table->enum('user_type', ['super_admin', 'admin', 'profesor', 'estudiante'])
                  ->default('estudiante');

            // Flags especiales
            $table->boolean('is_super_admin')->default(false);
            $table->boolean('is_protected')->default(false);

            // Permisos adicionales
            $table->json('permissions')->nullable();

            // Relación con rol
            $table->unsignedBigInteger('id_rol')->nullable();
            $table->foreign('id_rol')->references('id')->on('roles')->nullOnDelete();

            // Estado del usuario
            $table->boolean('activo')->default(true);

            // Seguridad y sistema
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();

            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};
