<?php

use App\Models\Course;
use App\Models\Review;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts::home')] class extends Component
{
    public Course $course;

    public $activeTab = 'overview';

    public $showEnrollModal = false;

    public $isEnrolled = false;

    public $authenticated;

    public function mount(Course $course)
    {
        $this->course = $course;
        $this->course->load(['reviews'])->loadCount('reviews');
        $this->authenticated = Auth::check();
        $this->checkEnrollmentStatus();
    }

    public function hydrate()
    {
        $this->course->load(['reviews'])->loadCount('reviews');
    }

    #[Computed()]
    public function reviews()
    {
        return Review::where('course_id', $this->course->id)
            ->orderBy('rating', 'desc')
            ->get();
    }

    public function checkEnrollmentStatus()
    {
        if (Auth::check()) {
            $this->isEnrolled = $this->course->isEnrolledBy(Auth::user());
        }
    }

    public function enrollCourse()
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        if ($this->isEnrolled) {
            return;
        }

        // Create enrollment
        Auth::user()->enrollments()->create([
            'course_id' => $this->course->id,
            'status' => 'enrolled',
            'enrolled_at' => now(),
        ]);

        $this->isEnrolled = true;
        $this->showEnrollModal = false;

        // Update course students count
        $this->course->increment('students_count');

        session()->flash('success', 'Successfully enrolled in '.$this->course->title);

        // Redirect to course learning page or dashboard
        // return redirect()->route('courses.learn', $this->course);
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function toggleEnrollModal()
    {
        $this->showEnrollModal = ! $this->showEnrollModal;
    }
};
