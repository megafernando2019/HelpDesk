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
        Schema::create('tickets_services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('created_by')->nullable()->index('tickets_services_created_by_foreign');
            $table->string('uid', 45)->unique();
            $table->unsignedBigInteger('category_id')->index();
            $table->unsignedBigInteger('department_id')->index();
            $table->unsignedBigInteger('status_id')->index();
            $table->string('name');
            $table->text('description');
            $table->text('template')->nullable();
            $table->string('color')->nullable();
            $table->boolean('supervisor');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets_services');
    }
};
