<?php

use App\Enums\GuildRoleEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('guild_character', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guild_id')->constrained('guilds');
            $table->foreignId('character_id')->constrained('characters')->cascadeOnDelete();
            $table->enum('role', GuildRoleEnum::getValues())->default(GuildRoleEnum::MEMBER->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guild_user');
    }
};
