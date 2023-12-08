<?php

use App\Enums\MarketOfferRequestStatusEnum;
use App\Enums\OfferTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('trade_offers', function (Blueprint $table) {
            $table->id();
            $table->morphs('offerable');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->integer('at_price')->nullable();
            $table->integer('lat_price')->nullable();
            $table->enum('status', MarketOfferRequestStatusEnum::getValues());
            $table->enum('type', OfferTypeEnum::getValues());
            $table->text('message')->nullable();
            $table->timestamps();
        });

        Schema::create('trade_offer_item', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trade_offer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('item_id')->constrained()->cascadeOnDelete();
            $table->integer('amount')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trade_offer_item');
        Schema::dropIfExists('trade_offers');
    }
};
