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
        Schema::create('registrar_acc', function (Blueprint $table) {
            $table->id();
            $table->timestamps();


            $table->string('username', 255);
            $table->string('password', 255);
            
            $table->string('verify_question', 255);
            $table->string('verify_answer', 255);

            $table->string('role', 255); 
            $table->string('firstname', 255); 
            $table->string('middlename', 255); 
            $table->string('lastname', 255); 
            $table->string('employee_no', 255); 
            $table->string('image_file_name', 255); 
            $table->integer('darkmode'); 
            $table->string('disabled'); 
            $table->string('email'); 
            

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrar_acc');
    }
};
