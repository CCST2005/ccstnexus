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
        Schema::create('student_account', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('username', 255);
            $table->string('password', 255);
            
            $table->string('verify_question', 255);
            $table->string('verify_answer', 255);

            
            $table->string('firstname', 255); 
            $table->string('middlename', 255); 
            $table->string('lastname', 255); 
            $table->string('student_no', 255); 
            $table->string('image_file_name', 255); 
            $table->integer('darkmode'); 
            $table->string('disabled'); 
            $table->string('email');

            $table->string('region', 255); 
            $table->string('city', 255); 
            $table->string('province', 255); 
            $table->string('barangay', 255); 
            $table->string('block_lot', 255); 

            $table->string('birth_month', 255); 
            $table->string('birth_year', 255); 
            $table->string('birth_day', 255); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_account');
    }
};
