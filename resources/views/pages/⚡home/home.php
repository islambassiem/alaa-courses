<?php

use App\Models\Course;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts::home')] class extends Component
{
    public $stats = [
        'courses' => 0,
        'students' => 0,
        'instructors' => 0,
        'satisfaction' => 0,
    ];

    public $featuredCourses = [];

    public $testimonials = [];

    public function mount()
    {
        // Load statistics
        $this->stats = [
            'courses' => Course::where('status', 'active')->count(),
            'students' => 50000, // You can get this from enrollments
            'instructors' => 250, // From instructors count
            'satisfaction' => 98, // From reviews average
        ];

        // Load featured courses
        $this->featuredCourses = Course::where('status', 'active')
            ->where('is_featured', true)
            ->orWhere('is_new', true)
            ->limit(6)
            ->get();

        // Sample testimonials (you can load from database)
        $this->testimonials = [
            [
                'name' => 'Dr. Sarah Mitchell',
                'role' => 'Cardiologist',
                'avatar' => null,
                'content' => 'The cardiology courses have been instrumental in staying current with the latest treatment protocols. Excellent quality and highly relevant.',
                'rating' => 5,
            ],
            [
                'name' => 'Dr. James Chen',
                'role' => 'Pediatrician',
                'avatar' => null,
                'content' => 'As a busy physician, I appreciate the mobile-first approach. I can learn during my commute and apply new knowledge immediately.',
                'rating' => 5,
            ],
            [
                'name' => 'Dr. Maria Garcia',
                'role' => 'Emergency Medicine',
                'avatar' => null,
                'content' => 'The case-based learning approach is phenomenal. These courses have directly improved my clinical decision-making.',
                'rating' => 5,
            ],
        ];
    }
};
