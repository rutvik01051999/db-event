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
        Schema::create('personal_information', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('option_types_id')->nullable();
            $table->unsignedBigInteger('event_id');
            $table->foreign('option_types_id')->references('id')->on('option_types')->onDelete('cascade');;
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');;
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('required');
            $table->enum('option_types', ['input', 'textarea', 'checkbox','dropdown','radio','file']);
            $table->string('option_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_information');
    }
};
