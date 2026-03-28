<x-layouts::admin>
    <div class="space-y-8 p-6">
        <header class="flex items-center justify-between">
            <div>
                <flux:heading size="xl" level="1">Academy Overview</flux:heading>
                <flux:subheading>Metrics and activity across your platform</flux:subheading>
            </div>
            <flux:button variant="primary" icon="plus" href="{{ route('admin.courses.create') }}">New Course</flux:button>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <flux:card class="space-y-2">
                <div class="flex items-center gap-2 text-zinc-500">
                    <flux:icon.currency-dollar class="size-4" />
                    <span class="text-sm font-medium">Total Revenue</span>
                </div>
                <div class="text-2xl font-bold">${{ number_format($stats['revenue'], 2) }}</div>
            </flux:card>

            <flux:card class="space-y-2">
                <div class="flex items-center gap-2 text-zinc-500">
                    <flux:icon.users class="size-4" />
                    <span class="text-sm font-medium">Total Students</span>
                </div>
                <div class="text-2xl font-bold">{{ number_format($stats['students']) }}</div>
            </flux:card>

            <flux:card class="space-y-2">
                <div class="flex items-center gap-2 text-zinc-500">
                    <flux:icon.star class="size-4" />
                    <span class="text-sm font-medium">Avg. Rating</span>
                </div>
                <div class="text-2xl font-bold">{{ number_format($stats['avg_rating'], 1) }} / 5.0</div>
            </flux:card>

            <flux:card class="space-y-2">
                <div class="flex items-center gap-2 text-zinc-500">
                    <flux:icon.chat-bubble-left-right class="size-4" />
                    <span class="text-sm font-medium">Active Chats</span>
                </div>
                <div class="text-2xl font-bold text-indigo-600">{{ $stats['active_chats'] }}</div>
            </flux:card>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-4">
                <flux:heading size="lg">Recent Enrollments</flux:heading>
                <flux:card class="p-3 overflow-hidden">
                    <flux:table>
                        <flux:table.columns>
                            <flux:table.column>Student</flux:table.column>
                            <flux:table.column>Course</flux:table.column>
                            <flux:table.column>Amount</flux:table.column>
                            <flux:table.column>Status</flux:table.column>
                        </flux:table.columns>

                        <flux:table.rows>
                            @foreach ($recent_enrollments as $enrollment)
                                <flux:table.row>
                                    <flux:table.cell class="font-medium">{{ $enrollment->user->name }}</flux:table.cell>
                                    <flux:table.cell>{{ $enrollment->course->title }}</flux:table.cell>
                                    <flux:table.cell>${{ number_format($enrollment->amount_total / 100, 2) }}
                                    </flux:table.cell>
                                    <flux:table.cell>
                                        <flux:badge size="sm"
                                            :color="$enrollment->payment_status === 'paid' ? 'green' : 'zinc'"
                                            inset="top">
                                            {{ strtoupper($enrollment->payment_status ?? 'Pending') }}
                                        </flux:badge>
                                    </flux:table.cell>
                                </flux:table.row>
                            @endforeach
                        </flux:table.rows>
                    </flux:table>
                </flux:card>
            </div>

            <div class="space-y-8">
                <section class="space-y-4">
                    <flux:heading size="lg">Unread Messages</flux:heading>
                    <div class="space-y-3">
                        @forelse($unread_support as $chat)
                            <flux:card
                                class="p-3 hover:bg-zinc-50 dark:hover:bg-white/5 transition-colors cursor-pointer">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="size-8 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-700 dark:text-indigo-300 font-bold text-xs">
                                        {{ substr($chat->user->name, 0, 2) }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold truncate">{{ $chat->user->name }}</p>
                                        <p class="text-xs text-zinc-500 italic">Last active
                                            {{ $chat->last_message_at?->diffForHumans() }}</p>
                                    </div>
                                    <flux:icon.chevron-right class="size-4 text-zinc-300" />
                                </div>
                            </flux:card>
                        @empty
                            <p class="text-sm text-zinc-500 italic">Inbox is clear!</p>
                        @endforelse
                    </div>
                </section>

                <section class="space-y-4">
                    <flux:heading size="lg">Latest Feedback</flux:heading>
                    <div class="space-y-4">
                        @foreach ($latest_reviews as $review)
                            <div class="flex gap-3">
                                <div class="shrink-0">
                                    <flux:badge color="orange" size="sm" variant="subtle">{{ $review->rating }} ★
                                    </flux:badge>
                                </div>
                                <div class="space-y-1">
                                    <p class="text-xs font-bold">{{ $review->user->name }} <span
                                            class="text-zinc-400 font-normal">on</span> {{ $review->course->title }}
                                    </p>
                                    <p class="text-sm text-zinc-600 dark:text-zinc-400 line-clamp-2 italic">
                                        "{{ $review->comment }}"</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-layouts::admin>
