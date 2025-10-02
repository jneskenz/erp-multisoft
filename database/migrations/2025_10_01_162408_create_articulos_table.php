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
        Schema::create('articulos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 50)->unique();
            $table->string('nombre', 200);
            $table->text('descripcion')->nullable();
            $table->string('marca', 100)->nullable();
            $table->string('modelo', 100)->nullable();
            $table->string('unidad_medida', 20)->default('UND');
            $table->decimal('precio_costo', 10, 2)->default(0);
            $table->decimal('precio_venta', 10, 2)->default(0);
            $table->integer('stock_minimo')->default(0);
            $table->integer('stock_actual')->default(0);
            $table->integer('stock_maximo')->default(0);
            $table->string('ubicacion', 100)->nullable();
            $table->string('imagen', 255)->nullable();
            $table->json('especificaciones')->nullable();
            $table->boolean('estado')->default(true);
            $table->boolean('inventariable')->default(true);
            $table->boolean('vendible')->default(true);
            $table->boolean('comprable')->default(true);
            
            // Relaciones
            $table->unsignedBigInteger('categoria_id')->nullable();
            $table->unsignedBigInteger('proveedor_id')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index(['codigo', 'estado']);
            $table->index(['nombre', 'estado']);
            $table->index(['categoria_id']);
            $table->index(['proveedor_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articulos');
    }
};
