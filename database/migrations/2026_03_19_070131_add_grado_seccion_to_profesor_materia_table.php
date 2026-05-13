<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('profesor_materia', function (Blueprint $table) {
        $table->foreignId('grado_id')->nullable()->constrained('grados')->onDelete('cascade');
        $table->string('seccion')->nullable();
    });
}

public function down()
{
    Schema::table('profesor_materia', function (Blueprint $table) {
        $table->dropForeign(['grado_id']);
        $table->dropColumn(['grado_id', 'seccion']);
    });
}
};
