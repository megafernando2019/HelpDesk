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
        Schema::create('tickets_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uid', 45)->unique();
            $table->unsignedBigInteger('team_id')->nullable()->index('tickets_categories_team_id_foreign');
            $table->unsignedBigInteger('department_id')->index();
            $table->boolean('status')->default(true);
            $table->unsignedBigInteger('created_by')->nullable()->index('tickets_categories_created_by_foreign');
            $table->string('name');
            $table->string('color')->nullable();
            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets_categories');
    }
};
