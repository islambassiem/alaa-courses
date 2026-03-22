<?php

use App\Models\Category;
use App\Models\Course;
use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts::home')] class extends Component
{
    public $searchQuery = '';

    public $limit = 6;

    public $selectedCategory = 'all';

    #[Computed()]
    public function courses()
    {
        return $this->getCourses($this->limit);
    }

    #[Computed()]
    public function studentCount()
    {
        return User::count();
    }

    #[Computed()]
    public function courseCount()
    {
        return Course::count();
    }

    #[Computed()]
    public function averageRating()
    {
        return round(Course::average('rating'), 1);
    }

    public $categories;

    public function mount()
    {
        $this->categories = Category::all();
    }

    public function getCourses($limit)
    {
        $query = Course::query()
            ->where('status', 'active')
            ->limit($limit)
            ->latest();

        if ($this->searchQuery) {
            $query->where(function ($q) {
                $q->where('title', 'like', "%{$this->searchQuery}%")
                    ->orWhere('description', 'like', "%{$this->searchQuery}%");
            });
        }

        if ($this->selectedCategory !== 'all') {
            $query->where('category_id', $this->selectedCategory);
        }

        return $query->get();
    }

    public function selectCategory($category)
    {
        $this->selectedCategory = $category;
    }

    public function loadMore()
    {
        $this->limit += 4;
    }
};
