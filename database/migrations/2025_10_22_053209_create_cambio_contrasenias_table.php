<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cambio_contrasenias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('old_password');
            $table->string('new_password');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cambio_contrasenias');
    }
};
