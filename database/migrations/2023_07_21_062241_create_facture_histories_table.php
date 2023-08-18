<?php

use App\Models\Facture;
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
        Schema::create('facture_histories', function (Blueprint $table) {
            $table->id();
            $table->float('to_paid', 30, 2)->nullable()->default(null);
            $table->float('paid', 30 , 2)->nullable()->default(null);
            $table->float('rest', 30, 2)->nullable()->default(null);
            $table->dateTime('date_paiement')->nullable()->default(null);
            $table->foreignIdFor(Facture::class)->nullable()->default(null)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facture_histories');
    }
};
