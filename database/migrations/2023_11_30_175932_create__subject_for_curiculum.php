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
        Schema::create('_subject_for_curiculum', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('owner_id', 255);
            $table->string('sub_code', 255);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_subject_for_curiculum');
    }
};
