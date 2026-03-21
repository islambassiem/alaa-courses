<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Enrollment>
 */
class EnrollmentFactory extends Factory
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
            'course_id' => fake()->randomElement(Course::pluck('id')->toArray()),
            'session_id' => fake()->lexify('?????????'),
            'payment_intent' => fake()->lexify('?????????'),
            'payment_status' => fake()->randomElement(['paid', 'failed']),
            'amount_total' => fake()->numberBetween(10, 500) * 100,
        ];
    }
}
