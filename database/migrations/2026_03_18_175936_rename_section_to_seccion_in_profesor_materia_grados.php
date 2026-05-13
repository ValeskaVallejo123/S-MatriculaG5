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
    Schema::table('profesor_materia_grados', function (Blueprint $table) {
        $table->renameColumn('section', 'seccion');
    });
}

public function down(): void
{
    Schema::table('profesor_materia_grados', function (Blueprint $table) {
        $table->renameColumn('seccion', 'section');
    });
}
};