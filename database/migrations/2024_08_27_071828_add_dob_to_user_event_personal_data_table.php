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
        Schema::table('user_event_personal_data', function (Blueprint $table) {
            $table->date('dob')->after('mobile_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_event_personal_data', function (Blueprint $table) {
            $table->dropColumn('dob');
        });
    }
};
