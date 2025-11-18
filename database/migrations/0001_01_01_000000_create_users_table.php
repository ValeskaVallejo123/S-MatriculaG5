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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            
            // Campo de rol principal (user_type)
            $table->enum('user_type', ['super_admin', 'admin', 'profesor', 'estudiante'])
                ->default('estudiante');
                
            $table->boolean('is_super_admin')->default(false);
            $table->json('permissions')->nullable();
            $table->boolean('is_protected')->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            
            // Campo 'rol' (Mantenido y corregido para evitar duplicidad)
            // Se asume que necesitas este campo por compatibilidad con código antiguo.
            // He incluido 'superadmin' en este ENUM, que era lo que intentabas añadir después.
            $table->enum('rol', ['superadmin', 'admin', 'estudiante', 'usuario'])->default('estudiante');
            
            $table->rememberToken();
            $table->timestamps();
        });
        
        // --- SECCIÓN ELIMINADA: ELIMINAMOS LA REDEFINICIÓN CONFLICTIVA ---
        // Se ha ELIMINADO el bloque Schema::table() que causaba el conflicto
        // al intentar modificar la tabla justo después de crearla.
        /*
        Schema::table('users', function (Blueprint $table) {
             $table->enum('rol', ['superadmin', 'admin', 'usuario'])->default('usuario');
        });
        */
        // ------------------------------------------------------------------

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

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};