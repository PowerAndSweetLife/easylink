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
        Schema::table('manifests', function (Blueprint $table) {
            $table->dateTime('eta')->nullable()->default(null);
            $table->dateTime('ata')->nullable()->default(null);
            $table->dateTime('pic')->nullable()->default(null);
            $table->integer('freetime')->nullable()->default(null);
            $table->dateTime('del')->nullable()->default(null);
            $table->float('bmoi_rate')->nullable()->default(null);
            $table->string('unit')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('manifests', function (Blueprint $table) {
            //
        });
    }
};
