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
        Schema::table('college_crourse', function (Blueprint $table) {
            $table->string('adviser', 255);
            $table->string('imageName', 255);
            $table->string('adviserPosition', 255);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('college_crourse', function (Blueprint $table) {
            //
        });
    }
};
