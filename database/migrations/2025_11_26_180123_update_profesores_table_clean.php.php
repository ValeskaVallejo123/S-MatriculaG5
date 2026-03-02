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
    Schema::table('profesores', function (Blueprint $table) {
        if (!Schema::hasColumn('profesores', 'genero')) {
            $table->string('genero')->nullable()->after('fecha_nacimiento');
        }

        if (!Schema::hasColumn('profesores', 'nivel_academico')) {
            $table->enum('nivel_academico', ['bachillerato','licenciatura','maestria','doctorado'])
                  ->nullable()
                  ->after('especialidad');
        }

        // Handle the renaming OR creation of hiring date
        if (Schema::hasColumn('profesores', 'fecha_ingreso')) {
            $table->renameColumn('fecha_ingreso', 'fecha_contratacion');
        } elseif (!Schema::hasColumn('profesores', 'fecha_contratacion')) {
            $table->date('fecha_contratacion')->nullable()->after('nivel_academico');
        }
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('profesores', function (Blueprint $table) {
        if (Schema::hasColumn('profesores', 'genero')) {
            $table->dropColumn('genero');
        }

        if (Schema::hasColumn('profesores', 'nivel_academico')) {
            $table->dropColumn('nivel_academico');
        }

        // Check if we should rename back or just drop it
        if (Schema::hasColumn('profesores', 'fecha_contratacion')) {
            if (!Schema::hasColumn('profesores', 'fecha_ingreso')) {
                // If it was originally a rename, put it back
                $table->renameColumn('fecha_contratacion', 'fecha_ingreso');
            } else {
                // If it was a fresh creation, just drop it
                $table->dropColumn('fecha_contratacion');
            }
        }
    });
}
};