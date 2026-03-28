<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

        <div class="lg:col-span-2 space-y-8">
            <header class="space-y-4">
                <div class="flex items-center gap-2">
                    <flux:badge color="zinc" variant="outline">{{ $course->category?->name }}</flux:badge>
                    @if ($course->is_new)
                        <flux:badge color="green" variant="solid">New</flux:badge>
                    @endif
                    <flux:badge color="orange" variant="subtle" icon="star">{{ $course->rating ?? 'No ratings' }}
                    </flux:badge>
                </div>

                <flux:heading size="xl" class="text-3xl md:text-4xl font-bold">{{ $course->title }}</flux:heading>

                <div class="flex items-center gap-4 text-zinc-500">
                    <div class="flex items-center gap-1">
                        <flux:icon.user class="size-4" />
                        <span class="text-sm">Instructor:
                            <strong>{{ $course->instructor->name ?? 'Guest' }}</strong></span>
                    </div>
                    <div class="flex items-center gap-1">
                        <flux:icon.users class="size-4" />
                        <span class="text-sm">{{ number_format($course->students_count) }} students</span>
                    </div>
                </div>
            </header>

            <section>
                <flux:heading size="xs" class="mb-4">Description</flux:heading>
                <div class="prose prose-zinc dark:prose-invert max-w-none">
                    {!! nl2br(e($course->description)) !!}
                </div>
            </section>

            <flux:separator variant="faint" />

            <div class="grid md:grid-cols-2 gap-8">
                <section>
                    <flux:heading size="md" class="mb-3">What you'll learn</flux:heading>
                    <ul class="space-y-2">
                        @foreach (explode("\n", $course->objectives) as $objective)
                            @if (trim($objective))
                                <li class="flex gap-3 text-sm text-zinc-600 dark:text-zinc-400">
                                    <flux:icon.check class="size-5 text-green-500 shrink-0" />
                                    {{ $objective }}
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </section>

                <section>
                    <flux:heading size="md" class="mb-3">Requirements</flux:heading>
                    <ul class="space-y-2">
                        @foreach ($course->requirements ?? [] as $requirement)
                            <li class="flex gap-3 text-sm text-zinc-600 dark:text-zinc-400">
                                <flux:icon.minus class="size-5 text-zinc-300 shrink-0" />
                                {{ $requirement }}
                            </li>
                        @endforeach
                    </ul>
                </section>
            </div>
        </div>

        <aside class="lg:col-span-1">
            <div class="sticky top-6 space-y-6">
                <flux:card class="p-0 overflow-hidden border-none shadow-xl">
                    <div class="relative aspect-video bg-zinc-800 flex items-center justify-center">
                        @if ($course->image)
                            <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}"
                                class="absolute inset-0 w-full h-full object-cover opacity-60">
                        @else
                            <div
                                class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-indigo-500 to-purple-600">
                                <svg class="w-20 h-20 text-white opacity-40" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                    <path
                                        d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                </svg>
                            </div>
                        @endif
                        <flux:button icon="play" variant="primary" size="xs"
                            class="rounded-full h-16 w-16 shadow-2xl scale-110" />
                    </div>

                    <div class="p-6 space-y-6">
                        <div class="flex items-baseline gap-3">
                            <span
                                class="text-3xl font-bold text-zinc-900 dark:text-white">${{ number_format($course->price, 2) }}</span>
                            @if ($course->original_price > $course->price)
                                <span
                                    class="text-lg text-zinc-400 line-through">${{ number_format($course->original_price, 2) }}</span>
                                <span class="text-sm font-medium text-green-600">
                                    {{ round((($course->original_price - $course->price) / $course->original_price) * 100) }}%
                                    OFF
                                </span>
                            @endif
                        </div>

                        <div class="space-y-3">
                            <flux:button variant="primary" class="w-full" size="xs">Enroll Now</flux:button>
                            <flux:button variant="outline" class="w-full">Add to Wishlist</flux:button>
                        </div>

                        <div class="space-y-4 pt-4 border-t border-zinc-100 dark:border-zinc-800">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-zinc-500">Duration</span>
                                <span class="font-medium">{{ $course->duration }}</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-zinc-500">Status</span>
                                <flux:badge size="sm" :color="$course->status === 'active' ? 'green' : 'zinc'">
                                    {{ ucfirst($course->status) }}
                                </flux:badge>
                            </div>
                        </div>
                    </div>
                </flux:card>

                <p class="text-center text-xs text-zinc-500 px-4">
                    Full lifetime access. 30-day money-back guarantee.
                </p>
            </div>
        </aside>

    </div>
</div>
