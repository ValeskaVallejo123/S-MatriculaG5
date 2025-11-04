<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // La tabla estudiantes ya existe, así que no la creamos de nuevo
    }

    public function down(): void
    {
        // Igual, no la borramos porque contiene datos
    }
};
