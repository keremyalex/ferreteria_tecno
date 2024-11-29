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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('es_cliente')->default(false);
            $table->boolean('es_personal')->default(false);
            $table->boolean('es_administrador')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('es_cliente');
            $table->dropColumn('es_personal');
            $table->dropColumn('es_administrador');
        });
    }
};
