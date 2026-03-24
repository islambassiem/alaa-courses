<?php

namespace Database\Factories;

use App\Enums\MessageSenderTypeEnum;
use App\Models\ChatConversation;
use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ChatMessage>
 */
class ChatMessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'conversation_id' => fake()->randomElement(ChatConversation::pluck('id')->toArray()),
            'sender_id' => fake()->randomElement(User::pluck('id')->toArray()),
            'sender_type' => fake()->randomElement(MessageSenderTypeEnum::cases())->value,
            'message' => fake()->realText(),
            'is_read' => fake()->boolean(),
        ];
    }
}
