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
        Schema::create('admin_acc_info', function (Blueprint $table) {
            $table->id();
            $table->string('owner_id', 255); 
            $table->string('super_admin', 255); 
            $table->string('firstname', 255); 
            $table->string('middlename', 255); 
            $table->string('lastname', 255); 
            $table->string('employee_no', 255); 
            $table->string('image_file_name', 255); 
            $table->integer('darkmode'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_acc_info');
    }
};
