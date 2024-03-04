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
        Schema::create('previousEducation', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('elementary', 255);
            $table->string('highschool', 255);
            $table->string('college', 255);
            $table->string('ownerID', 255);

            $table->string('elementaryYr', 255);
            $table->string('highschoolYr', 255);
            $table->string('collegeYr', 255);

            $table->string('collegeCourse', 255);
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('previousEducation');
    }
};
