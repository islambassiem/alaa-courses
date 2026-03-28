<?php

use App\Models\Course;
use Livewire\Component;

new class extends Component
{
    public Course $course;

    public function mount(Course $course)
    {
        $this->course = $course;
        $course->load(['category']);
    }
};
