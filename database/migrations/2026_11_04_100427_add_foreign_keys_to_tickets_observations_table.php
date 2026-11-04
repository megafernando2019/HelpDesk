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
        Schema::table('tickets_observations', function (Blueprint $table) {
            $table->foreign(['status_id'])->references(['id'])->on('status')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['ticket_id'])->references(['id'])->on('tickets')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['ticket_priority_id'])->references(['id'])->on('tickets_priorities')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['user_id'])->references(['id'])->on('users')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets_observations', function (Blueprint $table) {
            $table->dropForeign('tickets_observations_status_id_foreign');
            $table->dropForeign('tickets_observations_ticket_id_foreign');
            $table->dropForeign('tickets_observations_ticket_priority_id_foreign');
            $table->dropForeign('tickets_observations_user_id_foreign');
        });
    }
};
