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
        Schema::create('property_scores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('score_id');
            $table->string('property_id');
            $table->string('type');
            $table->longText('logic');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_scores');
    }
};
