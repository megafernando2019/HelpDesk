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
        Schema::create('tickets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uid', 45)->unique();
            $table->unsignedBigInteger('ticket_type_id')->index();
            $table->unsignedBigInteger('ticket_service_id')->index();
            $table->unsignedBigInteger('ticket_priority_id')->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('team_id')->nullable()->index('tickets_team_id_foreign');
            $table->unsignedBigInteger('status_id')->index();
            $table->string('title');
            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
