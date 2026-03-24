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
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->constrained('chat_conversations');
            $table->foreignId('sender_id')->constrained('users');
            $table->string('sender_type')->default('user');
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->timestamps();

            $table->index('conversation_id');
            $table->index(['sender_type', 'is_read']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
    }
};
