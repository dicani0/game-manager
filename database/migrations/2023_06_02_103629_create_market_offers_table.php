<?php

use App\Enums\MarketOfferStatusEnum;
use App\Enums\OfferTypeEnum;
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
        Schema::create('market_offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->enum('type', OfferTypeEnum::getValues());
            $table->dateTime('expires_at')->default(now()->addWeeks(2));
            $table->boolean('promoted')->default(false);
            $table->integer('at_price')->nullable();
            $table->integer('lat_price')->nullable();
            $table->text('description')->nullable();
            $table->enum('status', MarketOfferStatusEnum::getValues())->default(MarketOfferStatusEnum::ACTIVE->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('market_offers');
    }
};
