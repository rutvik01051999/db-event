<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_event_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('question_id');
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
            $table->integer('question_index')->nullable();
            $table->string('option_val')->nullable();
            $table->enum('option_types', ['input', 'textarea', 'checkbox', 'dropdown', 'radio', 'date', 'rating', 'number', 'pdf', 'image', 'video', 'audio', 'pdf_multiple', 'image_multiple', 'video_multiple', 'audio_multiple']);
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
