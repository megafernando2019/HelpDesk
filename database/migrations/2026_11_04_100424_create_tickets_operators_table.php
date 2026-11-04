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
        Schema::create('tickets_operators', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uid', 45)->unique();
            $table->string('country');
            $table->string('city');
            $table->string('name');
            $table->string('rfc');
            $table->string('phone');
            $table->string('email');
            $table->string('fee');
            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets_operators');
    }
};
