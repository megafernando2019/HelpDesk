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
        Schema::table('tickets_notifications', function (Blueprint $table) {
            $table->foreign(['ticket_action_id'])->references(['id'])->on('tickets_actions')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['ticket_id'])->references(['id'])->on('tickets')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['user_id'])->references(['id'])->on('users')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets_notifications', function (Blueprint $table) {
            $table->dropForeign('tickets_notifications_ticket_action_id_foreign');
            $table->dropForeign('tickets_notifications_ticket_id_foreign');
            $table->dropForeign('tickets_notifications_user_id_foreign');
        });
    }
};
