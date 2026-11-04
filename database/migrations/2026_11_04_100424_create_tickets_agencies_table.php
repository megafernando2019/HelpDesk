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
        Schema::create('tickets_agencies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('ticket_id')->index();
            $table->string('id_agency');
            $table->string('name_agency');
            $table->string('id_operator');
            $table->string('name_operator');
            $table->string('id_departure');
            $table->string('name_departure');
            $table->string('id_executive');
            $table->string('name_executive');
            $table->string('expedient');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets_agencies');
    }
};
