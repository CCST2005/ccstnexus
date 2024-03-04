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
        Schema::create('s_h_s_student_stands', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('ownerID', 255);
            $table->string('strand', 255);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('s_h_s_student_stands');
    }
};
