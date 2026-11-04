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
        Schema::create('logs_actions_category', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('category_id')->index('logs_actions_category_category_id_foreign');
            $table->unsignedBigInteger('user_id')->index('logs_actions_category_user_id_foreign');
            $table->string('resource_name');
            $table->string('section_name');
            $table->text('message')->nullable();
            $table->json('values')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs_actions_category');
    }
};
