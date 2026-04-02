<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Course;
use App\Models\Instructor;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    protected $model = Course::class;

    public function definition(): array
    {
        $categories = Category::pluck('id')->toArray();
        $price = fake()->randomElement([0, 49, 99, 149, 199, 299]);

        return [
            'title' => fake()->randomElement([
                'Advanced Cardiovascular Imaging',
                'Pediatric Emergency Medicine',
                'Neurological Assessment Techniques',
                'Surgical Suturing Masterclass',
                'Diagnostic Radiology Essentials',
                'Clinical Cardiology Update',
                'Pediatric Growth & Development',
                'Neurosurgery Fundamentals',
                'Orthopedic Surgery Techniques',
                'MRI Interpretation Course',
            ]),
            'description' => fake()->paragraph(3),
            'category_id' => fake()->randomElement($categories),
            'image' => null,
            'price' => $price,
            'original_price' => $price > 0 ? $price + fake()->randomElement([20, 50, 100]) : null,
            'duration' => fake()->randomElement(['4 weeks', '6 weeks', '8 weeks', '12 hours', '20 hours']),
            'students_count' => fake()->numberBetween(50, 5000),
            'rating' => fake()->randomFloat(2, 4.0, 5.0),
            'is_new' => fake()->boolean(20),
            'status' => 'active',
            'objectives' => [
                'Understand core medical concepts',
                'Apply theoretical knowledge in practice',
                'Develop clinical decision-making skills',
            ],
            'requirements' => [
                'Basic medical knowledge',
                'Active medical license (for some courses)',
            ],
            'instructor_id' => fake()->randomElement(Instructor::pluck('id')->toArray()),
        ];
    }
}
