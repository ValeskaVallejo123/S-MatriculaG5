<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profesor_materia', function (Blueprint $table) {
            if (!Schema::hasColumn('profesor_materia', 'grado_id')) {
                $table->foreignId('grado_id')->nullable()->constrained('grados')->onDelete('cascade');
            }
            if (!Schema::hasColumn('profesor_materia', 'seccion')) {
                $table->string('seccion')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('profesor_materia', function (Blueprint $table) {
            $table->dropForeign(['grado_id']);
            $table->dropColumn(['grado_id', 'seccion']);
        });
    }
};