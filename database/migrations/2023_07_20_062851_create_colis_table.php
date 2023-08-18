<?php

use App\Models\Agent;
use App\Models\Booking;
use App\Models\Category;
use App\Models\Client;
use App\Models\Expedition;
use App\Models\Subclient;
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
        Schema::create('colis', function (Blueprint $table) {
            $table->id();
            $table->string('receip_number');
            $table->string('courrier_company');
            $table->text('description');
            $table->text('dimensions')->nullable()->default(null);
            $table->text('attachments')->nullable()->default(null);
            $table->string('status');
            $table->string('shiporder');
            $table->dateTime('send_at');
            $table->dateTime('receive_at')->nullable()->default(null);
            $table->foreignIdFor(Client::class)->constrained();
            $table->foreignIdFor(Agent::class)->nullable()->default(null)->constrained()->nullOnDelete();
            $table->foreignIdFor(Booking::class)->nullable()->default(null)->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colis');
    }
};
