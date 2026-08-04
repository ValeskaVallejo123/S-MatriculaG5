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
    Schema::table('padres', function (Blueprint $table) {
        $table->string('dni', 20)->nullable()->change();
        $table->string('nombre', 100)->change();
        $table->string('apellido', 100)->change();
        $table->string('telefono', 15)->nullable()->change();
        $table->string('direccion', 255)->nullable()->change();
        $table->enum('parentesco', [
            'padre','madre','tutor_legal','abuelo','abuela',
            'hermano','tio','tia','tutor','otro'
        ])->change();
    });
}

public function down(): void
{
    Schema::table('padres', function (Blueprint $table) {
        $table->string('dni', 13)->change();
        $table->string('nombre', 50)->change();
        $table->string('apellido', 50)->change();
        $table->string('telefono', 15)->change();
        $table->string('direccion', 200)->change();
        $table->enum('parentesco', ['padre','madre','tutor_legal','otro'])->change();
    });
}
};
