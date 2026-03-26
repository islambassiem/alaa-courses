<?php

use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    #[Validate(['name' => 'required'])]
    public $name = '';

    #[Validate(['email' => 'required'])]
    public $email = '';

    public $search = '';

    public $editingUserId = null;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    #[Computed()]
    public function users()
    {
        return User::query()
            ->withoutRole('admin')
            ->withCount('enrollments')
            ->whereAny(['name', 'email'], 'like', "%{$this->search}%")
            ->orderBy('created_at', 'desc')
            ->paginate(5);
    }

    public function loadUser($id)
    {
        $user = User::findOrFail($id);

        $this->editingUserId = $id;
        $this->name = $user->name;
        $this->email = $user->email;
    }

    public function editUser()
    {
        $user = User::findOrFail($this->editingUserId);
        auth()->user()->can('update', $user);
        $this->validate();

        $user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        $this->dispatch(
            'user-updated',
            message: 'User updated successfully',
            type: 'success',
            title: 'Success',
            modal: "edit-users.{$user->id}",
        );
    }
};
