<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('registro_calificaciones', function (Blueprint $table) {
            $table->decimal('primer_parcial',   5, 2)->nullable()->after('nota');
            $table->decimal('segundo_parcial',  5, 2)->nullable()->after('primer_parcial');
            $table->decimal('tercer_parcial',   5, 2)->nullable()->after('segundo_parcial');
            $table->decimal('recuperacion',     5, 2)->nullable()->after('tercer_parcial');
        });
    }

    public function down(): void
    {
        Schema::table('registro_calificaciones', function (Blueprint $table) {
            $table->dropColumn(['primer_parcial', 'segundo_parcial', 'tercer_parcial', 'recuperacion']);
        });
    }
};
