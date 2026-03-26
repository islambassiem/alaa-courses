<?php

use App\Models\Category;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    #[Validate(['name' => 'required'])]
    public $name = '';

    #[Computed()]
    public function categories()
    {
        return Category::orderBy('created_at', 'desc')->paginate();
    }

    public function addCategory()
    {
        Gate::authorize('create', Category::class);
        $this->validate();
        Category::create([
            'name' => $this->name,
        ]);
        $this->reset('name');
        $this->dispatch('category-added',
            message: 'Category added successfully',
            type: 'success',
            title: 'Success',
            modal: 'add-category',
        );
    }

    public function deleteCategory(Category $category)
    {
        Gate::authorize('delete', Category::class);
        $category->loadCount('courses');
        if ($category->courses_count > 0) {
            $this->dispatch('cannot-delete-category',
                category_id: $category->id,
                message: "Category cannot be deleted because it has $category->courses_count associated courses",
                type: 'error',
                title: 'Error',
                modal: "delete-category.$category->id",
            );

            return;
        }
        $category->delete();
        $this->dispatch('category-deleted',
            message: 'Category deleted successfully',
            type: 'success',
            title: 'Success',
            modal: "delete-category.$category->id",
        );
    }
};
