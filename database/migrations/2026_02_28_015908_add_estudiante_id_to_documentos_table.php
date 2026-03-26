<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // La columna estudiante_id y su foreign key ya existen en documentos
        // No se requiere ninguna acción
    }

    public function down(): void
    {
        // Nada que revertir
    }
};
