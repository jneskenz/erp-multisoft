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
        Schema::table('locales', function (Blueprint $table) {
            $table->foreignId('tipo_local_id')->nullable()->after('codigo')->constrained('tipo_locales');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('locales', function (Blueprint $table) {
            $table->dropForeign(['tipo_local_id']);
            $table->dropColumn('tipo_local_id');
        });
    }
};
