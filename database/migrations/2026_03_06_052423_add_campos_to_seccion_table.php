<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('secciones', function (Blueprint $table) {
            if (!Schema::hasColumn('secciones', 'grado')) {
                $table->string('grado', 20)->after('id');
            }
            if (!Schema::hasColumn('secciones', 'nombre')) {
                $table->string('nombre', 10)->after('grado');
            }
        });
    }

    public function down(): void
    {
        Schema::table('secciones', function (Blueprint $table) {
            $table->dropColumn(['grado', 'nombre']);
        });
    }
};