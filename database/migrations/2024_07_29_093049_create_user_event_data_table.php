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
            $table->unsignedBigInteger('event_id');
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->integer('question_index')->nullable();
            $table->integer('personal_index')->nullable();
            $table->string('image')->nullable();
            $table->string('input_text')->nullable();
            $table->string('option_val')->nullable();
            $table->enum('option_types', ['input', 'textarea', 'checkbox','dropdown','radio','file','rating','number','date','mobile']);
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
