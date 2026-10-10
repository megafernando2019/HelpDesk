<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tickets_tags', function (Blueprint $table) {
            $table->string('color')->nullable()->after('description');
            $table->boolean('status')->default(true)->after('color');
            $table->foreignId('created_by')
                  ->nullable()
                  ->after('status')
                  ->constrained('users')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('tickets_tags', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropColumn(['color', 'status', 'created_by']);
        });
    }
};