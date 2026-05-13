<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::table('profesores', function (Blueprint $table) {
    if (!Schema::hasColumn('profesores', 'user_id')) {
        $table->unsignedBigInteger('user_id')->nullable()->after('id');
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    }

    if (!Schema::hasColumn('profesores', 'grado_guia_id')) {
        $table->unsignedBigInteger('grado_guia_id')->nullable()->after('user_id');
        $table->foreign('grado_guia_id')->references('id')->on('grados')->onDelete('set null');
    }

    if (!Schema::hasColumn('profesores', 'seccion_guia')) {
        $table->string('seccion_guia')->nullable()->after('grado_guia_id');
    }
});

    }

    public function down(): void
    {
        Schema::table('profesores', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');

            $table->dropForeign(['grado_guia_id']);
            $table->dropColumn('grado_guia_id');

            $table->dropColumn('seccion_guia');
        });
    }
};
