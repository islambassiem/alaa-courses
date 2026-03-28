<?php

use App\Models\Category;
use App\Models\Course;
use App\Models\User;
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

    public $objectives = '';

    public $instructor_id = '';

    // Handling JSON requirements as an array
    public $requirements = [''];

    public function addRequirement()
    {
        $this->requirements[] = '';
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
            'instructor_id' => 'nullable|exists:users,id',
            'requirements' => 'nullable|array',
        ]);

        if ($this->image) {
            $validated['image'] = $this->image->store('courses', 'public');
        }

        Course::create($validated + [
            'is_new' => $this->is_new,
            'objectives' => $this->objectives,
            'requirements' => array_filter($this->requirements), // Clean empty values
        ]);

        return redirect()->route('admin.courses.index');
    }
};
