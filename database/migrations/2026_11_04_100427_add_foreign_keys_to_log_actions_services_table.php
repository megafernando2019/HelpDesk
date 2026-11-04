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
        Schema::table('log_actions_services', function (Blueprint $table) {
            $table->foreign(['service_id'])->references(['id'])->on('tickets_services')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['user_id'])->references(['id'])->on('users')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('log_actions_services', function (Blueprint $table) {
            $table->dropForeign('log_actions_services_service_id_foreign');
            $table->dropForeign('log_actions_services_user_id_foreign');
        });
    }
};
