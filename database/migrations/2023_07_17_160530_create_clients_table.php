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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('uid');
            $table->string('email');
            $table->string('contact');
            $table->string('type');
            $table->float('cbm')->default(0);
            $table->string('app_lang')->default('fr');
            $table->string('civility', 5)->nullable()->default(null);
            $table->string('firstname')->nullable()->default(null);
            $table->string('lastname')->nullable()->default(null);
            $table->string('company_name')->nullable()->default(null);
            $table->string('nif')->nullable()->default(null);
            $table->string('stat')->nullable()->default(null);
            $table->string('rcs')->nullable()->default(null);
            $table->string('cif_card')->nullable()->default(null);
            $table->string('password');
            $table->string('email_confirmation_code')->nullable()->default(null);
            $table->dateTime('confirmed_at')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
