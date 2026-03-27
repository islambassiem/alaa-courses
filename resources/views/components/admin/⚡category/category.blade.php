<div>
    <div class="font-sans font-bold text-2xl flex items-center gap-2 text-blue-600 mb-6">
        <flux:icon.tag />
        Categories
    </div>
    <div class="flex justify-between mb-5 gap-6">
        <flux:input icon="magnifying-glass" placeholder="Search..." class="max-w-md" wire:model.live.debounce.250ms='search' clearable/>
        <flux:modal.trigger name="add-category" class="ml-auto">
            <flux:button variant="primary">Add A Category</flux:button>
        </flux:modal.trigger>
    </div>
    <div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default">
        <table class="w-full text-sm text-left rtl:text-right text-body">
            <thead class="text-sm text-body bg-neutral-100 border-b rounded-base border-default">
                <tr>
                    <th scope="col" class="px-6 py-3 font-medium">
                        Category name
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium">
                        No of courses
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium">
                        Created At
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium">
                        Updated At
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($this->categories as $category)
                    <tr class="bg-neutral-primary border-b border-default" wire:key="{{ $category->id }}">
                        <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                            {{ $category->name }}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                            {{ $category->courses_count }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $category->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $category->updated_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 flex gap-2">
                            <flux:modal.trigger name="delete-category.{{ $category->id }}">
                                <flux:button variant="primary" color="red" icon="trash" size="xs" />
                            </flux:modal.trigger>

                            <flux:modal name="delete-category.{{ $category->id }}" class="min-w-[22rem]">
                                <div class="space-y-6">
                                    <div>
                                        <flux:heading size="lg">Delete category?</flux:heading>

                                        <flux:text class="mt-2">
                                            You're about to delete this category.<br>
                                            This action cannot be reversed.
                                        </flux:text>
                                    </div>

                                    <div class="flex gap-2">
                                        <flux:spacer />

                                        <flux:modal.close>
                                            <flux:button variant="ghost">Cancel</flux:button>
                                        </flux:modal.close>

                                        <flux:button type="submit" variant="danger"
                                            wire:click="deleteCategory({{ $category }})">Delete
                                            category</flux:button>
                                    </div>
                                </div>
                            </flux:modal>

                            <flux:modal.trigger name="edit-category.{{ $category->id }}"
                                wire:click="loadCategory({{ $category->id }})">
                                <flux:button variant="primary" icon="pencil" size="xs" />
                            </flux:modal.trigger>

                            <flux:modal name="edit-category.{{ $category->id }}" class="md:w-96">
                                <div class="space-y-6">
                                    <div>
                                        <flux:heading size="lg">Edit a new Category</flux:heading>
                                        <flux:text class="mt-2">Edit a new course category.</flux:text>
                                    </div>
                                    <form wire:submit.prevent="editCategory" class="space-y-4">
                                        <flux:input label="Name" placeholder="Category name" wire:model="name" />
                                        <flux:error>{{ $errors->first('name') }}</flux:error>
                                        <div class="flex">
                                            <flux:spacer />
                                            <flux:button type="submit" variant="primary">Save changes</flux:button>
                                        </div>
                                    </form>
                                </div>
                            </flux:modal>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $this->categories->links() }}
    </div>

    <flux:modal name="add-category" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Add a new Category</flux:heading>
                <flux:text class="mt-2">Add a new course category.</flux:text>
            </div>
            <form wire:submit.prevent="addCategory" class="space-y-4">
                <flux:input label="Name" placeholder="Category name" wire:model="name" />
                <flux:error>{{ $errors->first('name') }}</flux:error>
                <div class="flex">
                    <flux:spacer />
                    <flux:button type="submit" variant="primary">Save changes</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
</div>

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('category-added', (data) => {
            Flux.modal(data.modal).close()
            Swal.fire({
                icon: data.type,
                title: data.title,
                text: data.message,
                timer: 2000,
                showConfirmButton: false,
                toast: true
            });
        });
        Livewire.on('category-deleted', (data) => {
            Flux.modal(data.modal).close()
            Swal.fire({
                icon: data.type,
                title: data.title,
                text: data.message,
                timer: 2000,
                showConfirmButton: false,
                toast: true
            });
        });
        Livewire.on('cannot-delete-category', (data) => {
            Flux.modal('delete-category.' + data.category_id).close()
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: data.message,
                footer: "<a href=\"#\">Check the related courses</a>",
            });
        });
        Livewire.on('category-updated', (data) => {
            Flux.modal(data.modal).close()
            Swal.fire({
                icon: data.type,
                title: data.title,
                text: data.message,
                timer: 2000,
                showConfirmButton: false,
                toast: true
            });
        });
    });
</script>
