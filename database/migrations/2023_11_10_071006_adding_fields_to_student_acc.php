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
        Schema::table('student_account', function (Blueprint $table) {

            $table->string('sex', 255); 
            $table->string('sivil_status', 255); 
            $table->integer('citizenship'); 
            $table->string('age'); 
            $table->string('birthplace');

            $table->string('ContactNo', 255); 

            $table->string('father_fname', 255); 
            $table->string('father_mname', 255); 
            $table->string('father_lname', 255); 

            $table->string('mother_fname', 255); 
            $table->string('mother_mname', 255); 
            $table->string('mother_lname', 255); 

            $table->string('m_occupation', 255); 
            $table->string('f_occupation', 255); 

            $table->string('emergency_fname', 255); 
            $table->string('emergency_mname', 255); 
            $table->string('emergency_lname', 255); 

            $table->string('emergency_relation', 255); 
            $table->string('emergency_contact', 255); 
            $table->string('emergency_address', 255); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_acc', function (Blueprint $table) {
            //
        });
    }
};
