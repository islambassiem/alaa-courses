<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

        <div class="lg:col-span-2 space-y-10">
            <header class="space-y-4">
                <div class="flex items-center gap-3">
                    <flux:badge color="zinc" variant="outline" size="sm">{{ $course->category->name }}</flux:badge>
                    @if ($course->is_new)
                        <flux:badge color="green" inset="top" variant="solid">NEW</flux:badge>
                    @endif
                </div>

                <flux:heading size="xl" class="text-4xl font-extrabold tracking-tight">{{ $course->title }}
                </flux:heading>

                <div class="flex flex-wrap items-center gap-6 text-zinc-500">
                    <div class="flex items-center gap-2">
                        <flux:icon.user class="size-5 text-zinc-400" />
                        <span class="text-sm font-medium">Instructor: <span
                                class="text-zinc-900 dark:text-white">{{ $course->instructor?->name ?? 'TBD' }}</span></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <flux:icon.star variant="solid" class="size-5 text-orange-400" />
                        <span
                            class="text-sm font-bold text-zinc-900 dark:text-white">{{ $course->rating ?? 'No ratings yet' }}</span>
                    </div>
                </div>
            </header>

            <section>
                <flux:heading size="lg" class="mb-4">About this course</flux:heading>
                <div class="prose prose-zinc dark:prose-invert max-w-none text-zinc-600 dark:text-zinc-400">
                    {{ $course->description }}
                </div>
            </section>

            <flux:separator variant="faint" />

            <div class="grid md:grid-cols-2 gap-12">
                <section class="space-y-4">
                    <flux:heading icon="check-circle" class="text-green-600">What you'll learn
                    </flux:heading>
                    <ul class="space-y-3">
                        @forelse($course->objectives ?? [] as $objective)
                            <li class="flex items-start gap-3 text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed">
                                <flux:icon.check class="size-4 mt-0.5 text-green-500 shrink-0" />
                                {{ $objective }}
                            </li>
                        @empty
                            <li class="text-sm text-zinc-400 italic">No specific objectives listed.</li>
                        @endforelse
                    </ul>
                </section>

                <section class="space-y-4">
                    <flux:heading icon="information-circle">Requirements</flux:heading>
                    <ul class="space-y-3">
                        @forelse($course->requirements ?? [] as $requirement)
                            <li class="flex items-start gap-3 text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed">
                                <flux:icon.minus class="size-4 mt-0.5 text-zinc-300 shrink-0" />
                                {{ $requirement }}
                            </li>
                        @empty
                            <li class="text-sm text-zinc-400 italic">No special requirements.</li>
                        @endforelse
                    </ul>
                </section>
            </div>
        </div>

        <aside>
            <div class="sticky top-8 space-y-6">
                <flux:card class="p-0 overflow-hidden shadow-2xl border-none">
                    <div class="relative aspect-video w-full bg-zinc-900 overflow-hidden group">
                        @if ($course->image)
                            <img src="{{ asset('storage/' . $course->image) }}"
                                class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                alt="{{ $course->title }}">
                        @else
                            <div
                                class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-indigo-600 to-violet-700">
                                <svg class="w-20 h-20 text-white opacity-40" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                    <path
                                        d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                </svg>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-black/20 flex items-center justify-center">
                            <flux:button icon="play" variant="primary" class="rounded-full shadow-lg scale-125" />
                        </div>
                    </div>

                    <div class="p-6 space-y-6">
                        <div class="space-y-1">
                            <div class="flex items-center gap-3">
                                <span
                                    class="text-4xl font-bold text-zinc-900 dark:text-white">${{ number_format($course->price, 2) }}</span>
                                @if ($course->original_price > $course->price)
                                    <span
                                        class="text-lg text-zinc-400 line-through">${{ number_format($course->original_price, 2) }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="pt-4 border-t border-zinc-100 dark:border-zinc-800 space-y-3">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-zinc-500">Duration</span>
                                <span class="font-semibold">{{ $course->duration }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-zinc-500">Students</span>
                                <span class="font-semibold">{{ number_format($course->students_count) }}</span>
                            </div>
                            @if ($coupon->code)
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-zinc-500">Coupon Code</span>
                                    <span class="font-semibold">{{ $coupon->code }}</span>
                                </div>
                            @endif
                            @if ($coupon->discount)
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-zinc-500">Coupon Discount</span>
                                    <span class="font-semibold">{{ $coupon->discount }}%</span>
                                </div>
                            @endif
                            @if ($coupon->expiry_date)
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-zinc-500">Expiry Date</span>
                                    <span class="font-semibold">{{ $coupon->expiry_date->toDateString() }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </flux:card>

                <div class="text-center">
                    <flux:button :href="route('admin.courses.edit', $course)" variant="subtle" size="sm"
                        icon="pencil-square">
                        Edit this course
                    </flux:button>
                </div>
            </div>
        </aside>
    </div>
</div>
