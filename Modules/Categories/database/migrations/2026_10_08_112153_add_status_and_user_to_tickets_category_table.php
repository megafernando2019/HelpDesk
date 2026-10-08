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
        Schema::table('tickets_categories', function (Blueprint $table) {
                // Campo para el Switch (1 = Activado, 0 = Desactivado)
                $table->boolean('status')->default(true)->after('department_id');

                // Relación con la tabla users para saber quién lo creó
                $table->foreignId('created_by')
                      ->nullable()
                      ->after('status')
                      ->constrained('users')
                      ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets_categories', function (Blueprint $table) {
             $table->dropForeign(['created_by']);
             $table->dropColumn(['status', 'created_by']);
        });
    }
};
