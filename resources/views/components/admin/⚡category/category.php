<?php

use App\Models\Category;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    #[Validate(['name' => 'required|unique:categories,name,'.'$editingCategoryId'])]
    public $name = '';

    public $search = '';

    public $editingCategoryId = null;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function resetInputs()
    {
        $this->name = '';
    }

    #[Computed()]
    public function categories()
    {
        auth()->user()->can('viewAny', Category::class);

        return Category::query()
            ->withCount('courses')
            ->where('name', 'like', "%{$this->search}%")
            ->orderBy('created_at', 'desc')
            ->paginate(5);
    }

    public function addCategory()
    {
        auth()->user()->can('create', Category::class);
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
        auth()->user()->can('delete', Category::class);
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

    public function loadCategory($id)
    {
        $category = Category::findOrFail($id);

        $this->editingCategoryId = $id;
        $this->name = $category->name;
    }

    public function editCategory()
    {
        $category = Category::findOrFail($this->editingCategoryId);

        auth()->user()->can('update', $category);

        $this->validate();

        $category->update([
            'name' => $this->name,
        ]);
        $this->reset('editingCategoryId', 'name');
        $this->dispatch(
            'category-updated',
            message: 'Category updated successfully',
            type: 'success',
            title: 'Success',
            modal: "edit-category.{$category->id}",
        );
    }
};
