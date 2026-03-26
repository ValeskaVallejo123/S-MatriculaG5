<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('seccion', function (Blueprint $table) {
            // Solo agrega las que NO existan todavía
            if (!Schema::hasColumn('seccion', 'grado')) {
                $table->string('grado', 20)->after('id');
            }
            if (!Schema::hasColumn('seccion', 'nombre')) {
                $table->string('nombre', 10)->after('grado');
            }
        });
    }

    public function down(): void
    {
        Schema::table('seccion', function (Blueprint $table) {
            $table->dropColumn(['grado', 'nombre']);
        });
    }
};