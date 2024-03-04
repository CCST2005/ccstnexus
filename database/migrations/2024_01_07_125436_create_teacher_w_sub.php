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
        Schema::create('teacher_w_sub', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('owner_id', 255);
            $table->string('section', 255);
            $table->string('track', 255);
            $table->string('subject', 255);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_w_sub');
    }
};
