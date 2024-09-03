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
        Schema::table('user_event_data', function (Blueprint $table) {
            $table->enum('option_types', ['input', 'textarea', 'checkbox','dropdown','radio','file','rating','number','date','mobile','pdf','image','audio','video','pdf_multiple','image_multiple','video_multiple','audio_multiple'])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_event_data', function (Blueprint $table) {
            $table->enum('option_types', ['input', 'textarea', 'checkbox','dropdown','radio','file','rating','number','date','mobile'])->change();
        });
    }
};
