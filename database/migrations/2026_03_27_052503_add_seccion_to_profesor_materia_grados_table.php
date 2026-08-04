<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profesor_materia_grados', function (Blueprint $table) {
            if (!Schema::hasColumn('profesor_materia_grados', 'seccion')) {
                $table->string('seccion')->nullable()->after('grado_id');
            }
        });
    }
    public function down(): void
    {
        Schema::table('profesor_materia_grados', function (Blueprint $table) {
            $table->dropColumn('seccion');
        });
    }
};