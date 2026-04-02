<?php

use App\Models\Instructor;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    #[Validate(['name' => 'required|string|max:255'])]
    public $name = '';

    #[Validate(['bio' => 'nullable|string|max:1000'])]
    public $bio = '';

    public $search = '';

    public $editingInstructorId = null;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function resetInputs()
    {
        $this->name = '';
        $this->bio = '';
    }

    #[Computed()]
    public function instructors()
    {
        auth()->user()->can('viewAny', Instructor::class);

        return Instructor::query()
            ->withCount('courses')
            ->where('name', 'like', "%{$this->search}%")
            ->orWhere('bio', 'like', "%{$this->search}%")
            ->orderBy('created_at', 'desc')
            ->paginate(5);
    }

    public function loadInstructor($id)
    {
        $instructor = Instructor::findOrFail($id);

        $this->editingInstructorId = $id;
        $this->name = $instructor->name;
        $this->bio = $instructor->bio;
    }

    public function addInstructor()
    {
        auth()->user()->can('create', Instructor::class);
        $this->validate();

        Instructor::create([
            'name' => $this->name,
            'bio' => $this->bio,
        ]);

        $this->reset('name', 'bio');
        $this->dispatch('instructor-added',
            message: 'Instructor added successfully',
            type: 'success',
            title: 'Success',
            modal: 'add-instructor',
        );
    }

    public function editInstructor()
    {
        $instructor = Instructor::findOrFail($this->editingInstructorId);

        auth()->user()->can('update', $instructor);

        $this->validate();

        $instructor->update([
            'name' => $this->name,
            'bio' => $this->bio,
        ]);

        $this->reset('editingInstructorId', 'name', 'bio');
        $this->dispatch(
            'instructor-updated',
            message: 'Instructor updated successfully',
            type: 'success',
            title: 'Success',
            modal: "edit-instructor.{$instructor->id}",
        );
    }

    public function deleteInstructor(Instructor $instructor)
    {
        auth()->user()->can('delete', Instructor::class);
        $instructor->loadCount('courses');
        if ($instructor->courses_count > 0) {
            $this->dispatch('cannot-delete-instructor',
                instructor_id: $instructor->id,
                message: "Instructor cannot be deleted because they have $instructor->courses_count associated courses",
                type: 'error',
                title: 'Error',
                modal: "delete-instructor.$instructor->id",
            );

            return;
        }
        $instructor->delete();
        $this->dispatch('instructor-deleted',
            message: 'Instructor deleted successfully',
            type: 'success',
            title: 'Success',
            modal: "delete-instructor.$instructor->id",
        );
    }
};
