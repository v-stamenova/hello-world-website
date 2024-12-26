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
        Schema::create('partners', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->text('description');
            $table->string('website');
            $table->string('email');
            $table->string('type');
            $table->string('phone_number')->nullable();
            $table->string('logo_path')->nullable();
            $table->string('dark_logo_path')->nullable();
            $table->string('postcode')->nullable();
            $table->string('street')->nullable();
            $table->string('house_number')->nullable();
            $table->string('city')->nullable();

            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};
