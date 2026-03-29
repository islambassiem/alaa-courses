<?php

use App\Models\Category;
use App\Models\Coupon;
use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;

new class extends Component
{
    use WithFileUploads;

    public Course $course;

    // Form Properties
    public $title;

    public $description;

    public $category_id;

    public $image; // New upload

    public $price;

    public $original_price;

    public $duration;

    public $is_new;

    public $status;

    public $objectives = [];

    public $requirements = [];

    public $instructor_id;

    public $coupon;

    public $couponCode;

    public $expiryDate;

    public $discount;

    public function mount(Course $course)
    {
        $this->course = $course;

        $this->coupon = $course->getActiveCoupon();

        $this->fill(
            $course->only([
                'title', 'description', 'category_id', 'price',
                'original_price', 'duration', 'is_new', 'status',
                'objectives', 'instructor_id',
            ])
        );
        $this->objectives = count($course->objectives ?? []) > 0 ? $course->objectives : [''];
        $this->requirements = $course->requirements ?? [''];

        $this->couponCode = $this->coupon?->code;
        $this->expiryDate = $this->coupon?->expiry_date?->toDateString();
        $this->discount = $this->coupon?->discount;
    }

    #[Computed()]
    public function categories()
    {
        return Category::all();
    }

    #[Computed()]
    public function instructors()
    {
        return User::role('admin')->get();
    }

    public function addRequirement()
    {
        $this->requirements[] = '';
    }

    public function addObjective()
    {
        $this->objectives[] = '';
    }

    public function removeRequirement($index)
    {
        unset($this->requirements[$index]);
        $this->requirements = array_values($this->requirements);
    }

    public function removeObjective($index)
    {
        unset($this->objectives[$index]);
        $this->objectives = array_values($this->objectives);
    }

    public function update()
    {
        $validated = $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:1024',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|gt:price',
            'duration' => 'nullable|string',
            'status' => 'required|in:active,draft,archived',
            'instructor_id' => 'nullable|exists:users,id',
            'requirements' => 'nullable|array',
        ]);

        $this->validate([
            'expiryDate' => 'nullable|date|after:today|required_with:couponCode',
            'discount' => 'nullable|int|required_with:couponCode',
        ]);

        if ($this->image) {
            if ($this->course->image) {
                Storage::disk('public')->delete($this->course->image);
            }
            $validated['image'] = $this->image->store('courses', 'public');
        }

        $this->course->update($validated + [
            'is_new' => $this->is_new,
            'objectives' => $this->objectives,
            'requirements' => array_filter($this->requirements),
        ]);

        if ($this->coupon) {
            $this->coupon->update([
                'code' => $this->couponCode,
                'discount' => $this->discount,
                'expiry_date' => $this->expiryDate,
            ]);
        } elseif ($this->couponCode !== null && $this->discount !== null && $this->expiryDate !== null) {
            Coupon::create([
                'course_id' => $this->course->id,
                'code' => $this->couponCode,
                'discount' => $this->discount,
                'expiry_date' => $this->expiryDate,
            ]);
        }

        return redirect()->route('admin.courses.show', $this->course);
    }
};
