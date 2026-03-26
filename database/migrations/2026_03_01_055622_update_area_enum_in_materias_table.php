<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE materias MODIFY COLUMN area ENUM(
            'Matemáticas',
            'Español',
            'Ciencias Naturales',
            'Ciencias Sociales',
            'Educación Física',
            'Educación Artística',
            'Inglés',
            'Informática',
            'Formación Ciudadana',
            'Química',
            'Física',
            'Biología',
            'Historia',
            'Geografía'
        ) NOT NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE materias MODIFY COLUMN area ENUM(
            'Matemáticas',
            'Español',
            'Ciencias Naturales',
            'Ciencias Sociales',
            'Educación Física',
            'Educación Artística',
            'Inglés',
            'Informática'
        ) NOT NULL");
    }
};