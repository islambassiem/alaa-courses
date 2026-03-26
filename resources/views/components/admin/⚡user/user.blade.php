<div>
    <div class="font-sans font-bold text-2xl flex items-center gap-2 text-blue-600 mb-6">
        <flux:icon.users />
        Users
    </div>
    <div class="flex justify-between mb-5 gap-6">
        <flux:input icon="magnifying-glass" placeholder="Search..." class="max-w-md" wire:model.live.debounce.250ms='search'
            clearable />
    </div>
    <div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default">
        <table class="w-full text-sm text-left rtl:text-right text-body">
            <thead class="text-sm text-body bg-neutral-100 border-b rounded-base border-default">
                <tr>
                    <th scope="col" class="px-6 py-3 font-medium">
                        Name
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium">
                        Email
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium">
                        No of courses
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium">
                        Registered At
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($this->users as $users)
                    <tr class="bg-neutral-primary border-b border-default" wire:key="{{ $users->id }}">
                        <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                            {{ $users->name }}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                            {{ $users->email }}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                            {{ $users->enrollments_count }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $users->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 flex gap-2">
                            <flux:modal.trigger name="edit-users.{{ $users->id }}"
                                wire:click='loadUser({{ $users->id }})'>
                                <flux:button variant="primary" icon="pencil">Edit</flux:button>
                            </flux:modal.trigger>

                            <flux:modal name="edit-users.{{ $users->id }}" class="md:w-96">
                                <div class="space-y-6">
                                    <div>
                                        <flux:heading size="lg">Edit a User</flux:heading>
                                        <flux:text class="mt-2">Edit a users</flux:text>
                                    </div>
                                    <form wire:submit.prevent="editUser" class="space-y-4">
                                        <flux:input label="Name" placeholder="Users name" wire:model="name" />
                                        <flux:error>{{ $errors->first('name') }}</flux:error>
                                        <flux:input label="Email" placeholder="Users email" wire:model="email" />
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
        {{ $this->users->links() }}
    </div>
</div>

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('user-updated', (data) => {
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
