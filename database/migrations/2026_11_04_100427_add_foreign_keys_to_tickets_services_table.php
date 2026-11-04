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
        Schema::table('tickets_services', function (Blueprint $table) {
            $table->foreign(['category_id'])->references(['id'])->on('tickets_categories')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['created_by'])->references(['id'])->on('users')->onUpdate('no action')->onDelete('set null');
            $table->foreign(['department_id'])->references(['id'])->on('departments')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['status_id'])->references(['id'])->on('status')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets_services', function (Blueprint $table) {
            $table->dropForeign('tickets_services_category_id_foreign');
            $table->dropForeign('tickets_services_created_by_foreign');
            $table->dropForeign('tickets_services_department_id_foreign');
            $table->dropForeign('tickets_services_status_id_foreign');
        });
    }
};
