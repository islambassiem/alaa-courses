<div>
    <div class="font-sans font-bold text-2xl flex items-center gap-2 text-blue-600 mb-6">
        <flux:icon.tv />
        Instructor
    </div>
    <div class="flex justify-between mb-5 gap-6">
        <flux:input icon="magnifying-glass" placeholder="Search..." class="max-w-md"
            wire:model.live.debounce.250ms='search' clearable />
        <flux:modal.trigger name="add-instructor" class="ml-auto">
            <flux:button variant="primary" wire:click="resetInputs" icon="plus">Add An Instructor</flux:button>
        </flux:modal.trigger>
    </div>

    <div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default">
        <table class="w-full text-sm text-left rtl:text-right text-body">
            <thead class="text-sm text-body bg-neutral-100 border-b rounded-base border-default">
                <tr>
                    <th scope="col" class="px-6 py-3 font-medium">
                        Instructor name
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium whitespace-nowrap">
                        No of courses
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium">
                        Bio
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium">
                        Created At
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($this->instructors as $instructor)
                    <tr class="bg-neutral-primary border-b border-default" wire:key="{{ $instructor->id }}">
                        <th scope="row"
                            class="px-6 py-4 font-medium text-heading whitespace-normal wrap-break-word max-w-xs">
                            {{ $instructor->name }}
                        </th>
                        <th scope="row"
                            class="px-6 py-4 font-medium text-heading whitespace-normal wrap-break-word max-w-xs">
                            {{ $instructor->courses_count }}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-heading">
                            {{ $instructor->bio }}
                        </th>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $instructor->created_at->format('M d, Y') }}
                        </td>
                        <td scope="row" class="px-6 py-4 flex items-center justify-center gap-2 ">
                            <flux:modal.trigger name="delete-instructor.{{ $instructor->id }}">
                                <flux:button variant="primary" color="red" icon="trash" size="xs" />
                            </flux:modal.trigger>

                            <flux:modal name="delete-instructor.{{ $instructor->id }}" class="min-w-[22rem]">
                                <div class="space-y-6">
                                    <div>
                                        <flux:heading size="lg">Delete instructor?</flux:heading>

                                        <flux:text class="mt-2">
                                            You're about to delete this instructor.<br>
                                            This action cannot be reversed.
                                        </flux:text>
                                    </div>

                                    <div class="flex gap-2">
                                        <flux:spacer />

                                        <flux:modal.close>
                                            <flux:button variant="ghost">Cancel</flux:button>
                                        </flux:modal.close>

                                        <flux:button type="submit" variant="danger"
                                            wire:click="deleteInstructor({{ $instructor }})">Delete
                                            instructor</flux:button>
                                    </div>
                                </div>
                            </flux:modal>

                            <flux:modal.trigger name="edit-instructor.{{ $instructor->id }}"
                                wire:click="loadInstructor({{ $instructor->id }})">
                                <flux:button variant="primary" icon="pencil" size="xs" />
                            </flux:modal.trigger>

                            <flux:modal name="edit-instructor.{{ $instructor->id }}" class="md:w-96">
                                <div class="space-y-6">
                                    <div>
                                        <flux:heading size="lg">Edit a new Instructor</flux:heading>
                                        <flux:text class="mt-2">Edit a new Instructor.</flux:text>
                                    </div>
                                    <form wire:submit.prevent="editInstructor" class="space-y-4">
                                        <flux:input label="Name" placeholder="Instructor name" wire:model="name" />
                                        <flux:error>{{ $errors->first('name') }}</flux:error>
                                        <flux:textarea label="Bio" placeholder="Instructor Bio ..." wire:model="bio" />
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
        {{ $this->instructors->links() }}
    </div>



    <flux:modal name="add-instructor" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Add a new instructor</flux:heading>
                <flux:text class="mt-2">Add a new instructor.</flux:text>
            </div>
            <form wire:submit.prevent="addInstructor" class="space-y-4">
                <flux:input label="Name" placeholder="Instructor name" wire:model="name" />
                <flux:error>{{ $errors->first('name') }}</flux:error>
                <flux:textarea label="Bio" placeholder="Instructor Bio ..." wire:model="bio" />
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
        Livewire.on('instructor-added', (data) => {
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

        Livewire.on('instructor-updated', (data) => {
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

        Livewire.on('instructor-deleted', (data) => {
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
        Livewire.on('cannot-delete-instructor', (data) => {
            Flux.modal('delete-instructor.' + data.instructor_id).close()
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: data.message,
            });
        });
    })

</script>
