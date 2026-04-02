<?php

use App\Models\Category;
use App\Models\Coupon;
use App\Models\Course;
use App\Models\Instructor;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;

new class extends Component
{
    use WithFileUploads;

    // Form Properties
    public $title = '';

    public $description = '';

    public $category_id = '';

    public $image;

    public $price = 0;

    public $original_price;

    public $duration = '';

    public $is_new = false;

    public $status = 'draft';

    public $objectives = [''];

    public $instructor_id = '';

    public $requirements = [''];

    public $couponCode;

    public $expiryDate;

    public $discount;

    public function addRequirement()
    {
        $this->requirements[] = '';
    }

    public function addObjective()
    {
        $this->objectives[] = '';
    }

    #[Computed()]
    public function categories()
    {
        return Category::all();
    }

    #[Computed()]
    public function instructors()
    {
        return Instructor::get(['id', 'name']);
    }

    public function removeRequirement($index)
    {
        unset($this->requirements[$index]);
        $this->requirements = array_values($this->requirements);
    }

    public function save()
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
            'instructor_id' => 'required|exists:instructors,id',
            'requirements' => 'nullable|array',
            'objectives' => 'nullable|array',
        ]);
        // dd($validated);
        if ($this->image) {
            $validated['image'] = $this->image->store('courses', 'public');
        }

        DB::transaction(function () use ($validated) {
            $course = Course::create($validated + [
                'is_new' => $this->is_new,
                'objectives' => array_filter($this->objectives),
                'requirements' => array_filter($this->requirements), // Clean empty values
            ]);

            if ($this->couponCode !== null && $this->discount !== null && $this->expiryDate !== null) {
                Coupon::create([
                    'course_id' => $course->id,
                    'code' => $this->couponCode,
                    'discount' => $this->discount,
                    'expiry_date' => $this->expiryDate,
                ]);
            }
        });

        $this->redirect(route('admin.courses.index'));
    }
};
