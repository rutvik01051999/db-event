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
            $table->unsignedBigInteger('personal_id')->after('event_id');
            $table->foreign('personal_id')->references('id')->on('user_event_data')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_event_data', function (Blueprint $table) {
            //
        });
    }
};
