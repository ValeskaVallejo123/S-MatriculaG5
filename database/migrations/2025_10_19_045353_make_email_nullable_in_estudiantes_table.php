<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('estudiantes', function (Blueprint $table) {
            // Primero eliminamos la restricción única si existe
            $table->dropUnique(['email']);
            
            // Luego modificamos la columna para que sea nullable
            $table->string('email')->nullable()->change();
            
            // Y volvemos a agregar la restricción única
            $table->unique('email');
        });
    }

    public function down(): void
    {
        Schema::table('estudiantes', function (Blueprint $table) {
            $table->dropUnique(['email']);
            $table->string('email')->nullable(false)->change();
            $table->unique('email');
        });
    }
};