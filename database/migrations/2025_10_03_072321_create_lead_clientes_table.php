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
        Schema::create('lead_clientes', function (Blueprint $table) {
            $table->id();
            $table->string('empresa', 255);
            $table->string('ruc', 20)->nullable();
            $table->string('rubro_empresa', 100)->nullable();
            $table->integer('nro_empleados')->nullable();
            $table->string('pais', 100)->nullable();
            $table->text('descripcion')->nullable();
            $table->string('cliente', 255);
            $table->string('nro_documento', 20)->nullable();
            $table->string('correo', 255)->nullable();
            $table->string('telefono', 20)->nullable();
            $table->string('cargo', 100)->nullable();
            $table->string('plan_interes', 100)->nullable();
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_clientes');
    }
};
