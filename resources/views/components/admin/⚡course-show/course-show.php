<?php

use App\Models\Coupon;
use App\Models\Course;
use Livewire\Component;

new class extends Component
{
    public Course $course;

    public Coupon $coupon;

    public function mount(Course $course)
    {
        $this->course = $course;
        $course->load(['category']);
        $this->coupon = $course->getActiveCoupon() ?? new Coupon;
    }
};
