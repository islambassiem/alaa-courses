<?php

use App\Models\Course;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    public $search = '';

    #[Computed()]
    public function courses()
    {
        return Course::query()
            ->with('category')
            ->whereAny(['title', 'description'], 'like', "%{$this->search}%")
            ->orderByDesc('created_at')
            ->paginate(5);
    }
};
