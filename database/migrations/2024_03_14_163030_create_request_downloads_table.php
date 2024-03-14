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
        Schema::create('request_recipe_downloads', function (Blueprint $table) {
            $table->id();
            $table->string('full_name', 225);
            $table->integer('age');
            $table->string('phone_number', 20);
            $table->string('email', 225);
            $table->json('additional_information');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_recipe_downloads');
    }
};
