<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('padres', function (Blueprint $table) {

            if (!Schema::hasColumn('padres', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('id');
                $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            }

            if (!Schema::hasColumn('padres', 'estado')) {
                $table->enum('estado', ['activo', 'inactivo'])->default('activo')->after('observaciones');
            }

            if (!Schema::hasColumn('padres', 'lugar_trabajo')) {
                $table->string('lugar_trabajo', 150)->nullable()->after('ocupacion');
            }

            if (!Schema::hasColumn('padres', 'telefono_trabajo')) {
                $table->string('telefono_trabajo', 15)->nullable()->after('lugar_trabajo');
            }
        });

        // Ampliar el enum user_type en users para incluir 'padre'
        DB::statement("ALTER TABLE users MODIFY COLUMN user_type ENUM('super_admin','admin','profesor','estudiante','padre') DEFAULT 'estudiante'");
    }

    public function down(): void
    {
        Schema::table('padres', function (Blueprint $table) {
            if (Schema::hasColumn('padres', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
            if (Schema::hasColumn('padres', 'estado')) {
                $table->dropColumn('estado');
            }
            if (Schema::hasColumn('padres', 'lugar_trabajo')) {
                $table->dropColumn('lugar_trabajo');
            }
            if (Schema::hasColumn('padres', 'telefono_trabajo')) {
                $table->dropColumn('telefono_trabajo');
            }
        });

        DB::statement("ALTER TABLE users MODIFY COLUMN user_type ENUM('super_admin','admin','profesor','estudiante') DEFAULT 'estudiante'");
    }
};