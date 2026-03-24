<?php

namespace Database\Factories;

use App\Enums\ConversationStatusEnum;
use App\Models\ChatConversation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ChatConversation>
 */
class ChatConversationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fake()->randomElement(User::pluck('id')->toArray()),
            'status' => fake()->randomElement(ConversationStatusEnum::cases())->value,
            'last_message_at' => fake()->dateTime(),
        ];
    }
}
