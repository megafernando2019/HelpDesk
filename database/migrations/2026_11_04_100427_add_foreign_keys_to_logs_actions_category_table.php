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
        Schema::table('logs_actions_category', function (Blueprint $table) {
            $table->foreign(['category_id'])->references(['id'])->on('tickets_categories')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['user_id'])->references(['id'])->on('users')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('logs_actions_category', function (Blueprint $table) {
            $table->dropForeign('logs_actions_category_category_id_foreign');
            $table->dropForeign('logs_actions_category_user_id_foreign');
        });
    }
};
