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
        Schema::create('student_list_w_sub_teacher', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('owner_id', 255);
            $table->string('stud_id', 255);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_list_w_sub_teacher');
    }
};
