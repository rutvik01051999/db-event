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
        Schema::table('personal_information', function (Blueprint $table) {
            $table->enum('option_types', ['input', 'textarea', 'checkbox','dropdown','radio','file','rating','number','date','mobile_otp','pincode','multiple_file'])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('personal_information', function (Blueprint $table) {
            $table->enum('option_types', ['input', 'textarea', 'checkbox','dropdown','radio','file','rating','number','date','mobile_otp','pincode'])->change();
        });
    }
};
