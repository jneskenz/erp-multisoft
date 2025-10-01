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
        Schema::table('empresas', function (Blueprint $table) {
            $table->unsignedBigInteger('grupo_empresarial_id')->nullable()->after('estado');
            $table->foreign('grupo_empresarial_id')->references('id')->on('grupo_empresarials')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('empresas', function (Blueprint $table) {
            $table->dropForeign(['grupo_empresarial_id']);
            $table->dropColumn('grupo_empresarial_id');
        });
    }
};
