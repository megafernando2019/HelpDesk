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
            $table->foreign(['created_by'])->references(['id'])->on('users')->onUpdate('no action')->onDelete('set null');
            $table->foreign(['department_id'])->references(['id'])->on('departments')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['team_id'])->references(['id'])->on('teams')->onUpdate('no action')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets_categories', function (Blueprint $table) {
            $table->dropForeign('tickets_categories_created_by_foreign');
            $table->dropForeign('tickets_categories_department_id_foreign');
            $table->dropForeign('tickets_categories_team_id_foreign');
        });
    }
};
