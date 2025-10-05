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
        Schema::table('grupo_empresarials', function (Blueprint $table) {
            $table->string('avatar')->nullable()->after('direccion_matriz');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('grupo_empresarials', function (Blueprint $table) {
            $table->dropColumn('avatar');
        });
    }
};
