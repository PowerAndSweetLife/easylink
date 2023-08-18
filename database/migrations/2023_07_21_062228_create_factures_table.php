<?php

use App\Models\Booking;
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
        Schema::create('factures', function (Blueprint $table) {
            $table->id();
            $table->float('amount', 30, 2)->nullable()->default(null);
            $table->float('amount_ariary', 30, 2)->nullable()->default(null);
            $table->float('amount_paid', 30, 2)->nullable()->default(null);
            $table->float('rest', 30, 2)->nullable()->default(null);
            $table->boolean('is_paid')->default(false);
            $table->foreignIdFor(Booking::class)->nullable()->default(null)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factures');
    }
};
