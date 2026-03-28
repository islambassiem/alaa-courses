<form wire:submit="update" class="space-y-8">
    {{-- {{ dd($this->course) }} --}}
    <div class="flex items-center justify-between">
        <flux:heading size="xl">Edit Course: {{ $this->course->title }}</flux:heading>
        {{-- <flux:button href="{{ route('admin.courses.show', ['course' => $this->course]) }}" variant="ghost" icon="eye">View Course</flux:button> --}}
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="space-y-6">
            <flux:input wire:model="title" label="Course Title" />
            <flux:textarea wire:model="description" label="Description" rows="6" />

            <div class="grid grid-cols-2 gap-4">
                <flux:select wire:model="category_id" label="Category">
                    @foreach ($this->categories as $category)
                        <flux:select.option value="{{ $category->id }}">{{ $category->name }}</flux:select.option>
                    @endforeach
                </flux:select>

                <flux:select wire:model="instructor_id" label="Instructor">
                    @foreach ($this->instructors as $instructor)
                        <flux:select.option value="{{ $instructor->id }}">{{ $instructor->name }}</flux:select.option>
                    @endforeach
                </flux:select>
            </div>
        </div>

        <div class="space-y-6">
            <flux:field>
                <flux:label>Course Image</flux:label>

                <div class="mt-2 flex items-start gap-4">
                    <div
                        class="relative w-32 h-20 rounded-lg overflow-hidden bg-zinc-800 shrink-0 border border-zinc-200 dark:border-zinc-700">
                        @if ($image)
                            {{-- If a new one is uploaded but not saved yet --}}
                            <img src="{{ $image->temporaryUrl() }}" class="object-cover w-full h-full">
                        @elseif($course->image)
                            <img src="{{ asset('storage/' . $course->image) }}" class="object-cover w-full h-full">
                        @else
                            <div class="absolute inset-0 flex items-center justify-center">
                                <svg class="w-20 h-20 text-white opacity-40" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                    <path
                                        d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                </svg>
                            </div>
                        @endif
                    </div>

                    <div class="flex-1 space-y-2">
                        <input type="file" wire:model="image"
                            class="text-sm block w-full file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:bg-zinc-100 file:text-zinc-700" />
                        <p class="text-xs text-zinc-500">Upload a new image to replace the current one. Max 1MB.</p>
                        <flux:error name="image" />
                    </div>
                </div>
            </flux:field>

            <div class="grid grid-cols-2 gap-4">
                <flux:input wire:model="price" type="number" step="0.01" label="Price" icon="currency-dollar" />
                <flux:input wire:model="original_price" type="number" step="0.01" label="Sale Price"
                    icon="currency-dollar" />
            </div>

            <flux:radio.group wire:model="status" label="Status" variant="segmented">
                <flux:radio value="draft" label="Draft" />
                <flux:radio value="active" label="Active" />
                <flux:radio value="archived" label="Archived" />
            </flux:radio.group>

            <flux:checkbox wire:model="is_new" label="Show 'New' badge" />
        </div>
    </div>

    <flux:separator />

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <flux:textarea wire:model="objectives" label="Learning Objectives" rows="4" />

        <div class="space-y-3">
            <div class="flex justify-between items-center">
                <flux:label>Requirements</flux:label>
                <flux:button wire:click="addRequirement" size="sm" variant="subtle" icon="plus" />
            </div>
            @foreach ($requirements as $index => $requirement)
                <div class="flex gap-2">
                    <flux:input wire:model="requirements.{{ $index }}" class="flex-1" />
                    <flux:button wire:click="removeRequirement({{ $index }})" variant="ghost" icon="trash"
                        color="red" />
                </div>
            @endforeach
        </div>
    </div>

    <div class="flex justify-end gap-3 pt-6 border-t border-zinc-100 dark:border-zinc-800">
        <flux:button variant="ghost" href="{{ route('admin.courses.index') }}">Cancel</flux:button>
        <flux:button type="submit" variant="primary">Update Course</flux:button>
    </div>
</form>
