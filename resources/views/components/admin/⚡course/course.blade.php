<div>
    <div class="font-sans font-bold text-2xl flex items-center gap-2 text-blue-600 mb-6">
        <flux:icon.academic-cap />
        Courses
    </div>
    <div class="flex justify-between mb-5 gap-6">
        <flux:input icon="magnifying-glass" placeholder="Search..." class="max-w-md" wire:model.live.debounce.250ms='search'
            clearable />
        <div class="ml-auto">
            <flux:link href="{{ route('admin.courses.create') }}">
                <flux:button variant="primary" icon="plus">Add A Course</flux:button>
            </flux:link>
        </div>
    </div>
    <div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default">
        <table class="w-full text-sm text-left rtl:text-right text-body">
            <thead class="text-sm text-body bg-neutral-100 border-b rounded-base border-default">
                <tr>
                    <th scope="col" class="px-6 py-3 font-medium">
                        Course name
                    </th>
                    <th scope="col" class="px-6 font-medium">
                        Category
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium">
                        No of Students
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium">
                        Rating
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium">
                        Price
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium">
                        Original Price
                    </th>
                    <th scope="col" class="px-6 py-3 font-medium">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($this->courses as $course)
                    <tr class="bg-neutral-primary border-b border-default" wire:key="{{ $course->id }}">
                        <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                            {{ $course->title }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $course->category->name }}
                        </td>
                        <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                            {{ $course->students_count }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $course->rating ?? '--' }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $course->price }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $course->original_price ?? 'Free' }}
                        </td>
                        <td class="px-6 py-4 flex gap-2">
                            <flux:link href="{{ route('admin.courses.show', $course) }}" variant="primary">
                                <flux:button variant="primary" color="blue" icon="eye" size="xs" />
                            </flux:link>
                            <flux:link href="{{ route('admin.courses.edit', $course) }}" variant="primary">
                                <flux:button variant="primary" color="indigo" icon="pencil" size="xs" />
                            </flux:link>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $this->courses->links() }}
    </div>
</div>
