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
        Schema::create('user_event_data', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('personal_information_id')->nullable()->after('id');
            // $table->foreign('personal_information_id')->references('id')->on('personal_information')->onDelete('cascade');
            // $table->unsignedBigInteger('questions_id')->nullable()->after('personal_information_id');
            // $table->foreign('questions_id')->references('id')->on('questions')->onDelete('cascade');
            // $table->unsignedBigInteger('questions_id')->nullable()->after('personal_information_id');
            // $table->foreign('questions_id')->references('id')->on('questions')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_event_data');
    }
};
