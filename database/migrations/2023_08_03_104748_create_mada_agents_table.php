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
        Schema::create('mada_agents', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('password');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email');
            $table->string('contact');
            $table->string('app_lang')->default('fr');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mada_agents');
    }
};