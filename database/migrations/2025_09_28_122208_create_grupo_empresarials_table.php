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
        Schema::create('grupo_empresarials', function (Blueprint $table) {
            $table->id();
            $table->string('user_uuid')->unique();
            $table->string('nombre', 200);
            $table->text('descripcion')->nullable();
            $table->string('codigo', 20)->unique();
            $table->string('slug', 100)->unique();
            $table->string('pais_origen', 100)->nullable();
            $table->string('telefono', 20)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('sitio_web', 255)->nullable();
            $table->text('direccion_matriz')->nullable();
            $table->boolean('estado')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['estado', 'nombre']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grupo_empresarials');
    }
};
