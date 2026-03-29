<form wire:submit="save" class="space-y-8">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <section class="space-y-6">
            <flux:heading size="lg">General Information</flux:heading>

            <flux:input wire:model="title" label="Course Title" placeholder="e.g. Advanced Laravel Mastery" />

            <flux:textarea wire:model="description" label="Description"
                description="Provide a detailed overview of the course." rows="5" />

            <div class="grid grid-cols-2 gap-4">
                <flux:select wire:model="category_id" label="Category" placeholder="Select a category...">
                    @foreach ($this->categories as $category)
                        <flux:select.option value="{{ $category->id }}">{{ $category->name }}</flux:select.option>
                    @endforeach
                </flux:select>

                <flux:select wire:model="instructor_id" label="Instructor" placeholder="Assign instructor...">
                    @foreach ($this->instructors as $instructor)
                        <flux:select.option value="{{ $instructor->id }}">{{ $instructor->name }}</flux:select.option>
                    @endforeach
                </flux:select>
                <div class="flex gap-1">
                    <flux:input wire:model="couponCode" label="Coupon Code" />
                    <flux:input type="number" wire:model="discount" label="Discount" wire:model='discount' />
                </div>
                <div class="grid">
                    <label for="expiry_date">Date of Expiry</label>
                    <input type="date" id="expiry_date" class="rounded-md border-2 py-1 px-2"
                        wire:model='expiryDate'>
                    <span class="text-sm text-red-500">
                        @error('expiryDate')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
            </div>

            <flux:input wire:model="duration" label="Duration" placeholder="e.g. 6 weeks or 12 hours" />
        </section>

        <section class="space-y-6">
            <flux:heading size="lg">Details & Pricing</flux:heading>

            <div class="grid grid-cols-2 gap-4">
                <flux:input wire:model="price" type="number" step="0.01" label="Price" icon="currency-dollar" />
                <flux:input wire:model="original_price" type="number" step="0.01" label="Original Price (Optional)"
                    icon="currency-dollar" />
            </div>

            <flux:radio.group wire:model="status" label="Course Status" variant="segmented">
                <flux:radio value="draft" label="Draft" />
                <flux:radio value="active" label="Active" />
                <flux:radio value="archived" label="Archived" />
            </flux:radio.group>

            <flux:checkbox wire:model="is_new" label="Mark as 'New' course"
                description="This will display a badge on the course card." />

            <flux:field>
                <flux:label>Course Thumbnail</flux:label>
                <input type="file" wire:model="image"
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-zinc-100 file:text-zinc-700 hover:file:bg-zinc-200" />
                <flux:error name="image" />
            </flux:field>
        </section>
    </div>

    <flux:separator />

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <section class="space-y-3">
            <div class="flex justify-between items-center">
                <flux:label>Learning Objectives</flux:label>
                <flux:button wire:click="addObjective" size="sm" variant="subtle" icon="plus" />
            </div>

            <div class="space-y-2">
                @foreach ($objectives as $index => $objective)
                    <div class="flex gap-2">
                        <flux:input wire:model="objectives.{{ $index }}"
                            placeholder="e.g. Master Eloquent relationships" class="flex-1" />
                        <flux:button wire:click="removeObjective({{ $index }})" variant="ghost" icon="trash"
                            color="red" />
                    </div>
                @endforeach
            </div>
            <flux:error name="objectives" />
        </section>
        <section class="space-y-4">
            <div class="flex items-center justify-between">
                <flux:heading size="lg">Requirements</flux:heading>
                <flux:button wire:click="addRequirement" variant="subtle" size="sm" icon="plus">Add
                </flux:button>
            </div>

            <div class="space-y-2">
                @foreach ($requirements as $index => $requirement)
                    <div class="flex gap-2">
                        <flux:input wire:model="requirements.{{ $index }}" placeholder="e.g. Basic PHP knowledge"
                            class="flex-1" />
                        <flux:button wire:click="removeRequirement({{ $index }})" variant="ghost" icon="trash"
                            color="red" />
                    </div>
                @endforeach
            </div>
        </section>
    </div>

    <div class="flex justify-end gap-4">
        <flux:button variant="ghost">Cancel</flux:button>
        <flux:button type="submit" variant="primary">Create Course</flux:button>
    </div>
</form>
