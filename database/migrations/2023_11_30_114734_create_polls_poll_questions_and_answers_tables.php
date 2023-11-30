<?php

use App\Enums\PollQuestionTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('polls', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description')->nullable();
            $table->date('start_date')->default(now());
            $table->date('end_date')->default(now()->addDays(3));
            $table->unsignedBigInteger('pollable_id')->nullable();
            $table->string('pollable_type')->nullable();
            $table->timestamps();
        });

        Schema::create('poll_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('poll_id')->constrained()->cascadeOnDelete();
            $table->string('question');
            $table->enum('type', PollQuestionTypeEnum::getValues());
            $table->boolean('required')->default(true);
            $table->timestamps();
        });

        Schema::create('poll_question_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('poll_question_id')->constrained()->cascadeOnDelete();
            $table->text('content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('polls');
        Schema::dropIfExists('poll_questions');
        Schema::dropIfExists('poll_question_answers');
    }
};
