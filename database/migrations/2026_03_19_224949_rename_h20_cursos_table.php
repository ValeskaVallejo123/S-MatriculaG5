<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('_h20_cursos') && !Schema::hasTable('h20_cursos')) {
            Schema::rename('_h20_cursos', 'h20_cursos');
        } elseif (!Schema::hasTable('h20_cursos')) {
            Schema::create('h20_cursos', function (Blueprint $table) {
                $table->id();
                $table->string('nombre');
                $table->integer('cupo_maximo')->default(30);
                $table->string('seccion')->nullable();
                $table->string('nivel')->default('Secundaria');
                $table->year('anio_lectivo')->default(date('Y'));
                $table->boolean('activo')->default(true);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('h20_cursos') && !Schema::hasTable('_h20_cursos')) {
            Schema::rename('h20_cursos', '_h20_cursos');
        }
    }
};
