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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('tier')->default(1);
            $table->integer('power')->default(5);
            $table->json('attributes')->nullable();
            $table->integer('usable_amount')->default(1);
        });

        Schema::create('user_item', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('item_id')->constrained();
            $table->unsignedInteger('amount')->default(0);
            $table->unsignedInteger('used_amount')->default(0);
            $table->unsignedInteger('sold_amount')->default(0);
            $table->unsignedInteger('reserved_amount')->default(0);
            $table->unsignedInteger('bought_amount')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_item');
        Schema::dropIfExists('items');
    }
};
