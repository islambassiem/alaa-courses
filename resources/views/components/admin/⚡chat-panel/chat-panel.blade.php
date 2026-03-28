<div class="flex flex-col h-[calc(100vh-4.1rem)] md:h-[calc(100vh-2rem)] -m-6 overflow-hidden bg-white dark:bg-zinc-900">
    <div class="flex flex-1 overflow-hidden">
        {{-- Conversations List --}}
        <div
            class="flex flex-col w-full md:w-80 lg:w-96 border-e border-zinc-200 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-900/50">
            {{-- Search Header --}}
            <div class="p-4 border-b border-zinc-200 dark:border-zinc-800 space-y-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Messages</h2>

                    <button type="button" wire:click="$toggle('showUnreadOnly')"
                        class="text-xs px-2 py-1 rounded-md transition-colors {{ $showUnreadOnly ? 'bg-indigo-600 text-white' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400' }}">
                        Unread
                    </button>
                </div>

                <div class="relative">
                    <flux:icon name="magnifying-glass" class="absolute left-3 top-2.5 size-4 text-zinc-400" />
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search chats..."
                        class="w-full pl-9 pr-4 py-2 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:text-zinc-200" />
                </div>
            </div>

            {{-- Conversations Scroll Area --}}
            <div class="flex-1 overflow-y-auto custom-scrollbar">
                @forelse($this->conversations as $conversation)
                    <button wire:click="selectConversation({{ $conversation->id }})"
                        class="w-full p-4 flex items-start gap-3 transition-all border-b border-zinc-100 dark:border-zinc-800/50 hover:bg-white dark:hover:bg-zinc-800 {{ $selectedConversation && $selectedConversation->id === $conversation->id ? 'bg-white dark:bg-zinc-800 ring-1 ring-inset ring-indigo-500/10 shadow-sm' : '' }}">

                        <div class="relative flex-shrink-0">
                            <div
                                class="w-11 h-11 rounded-full bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-medium">
                                {{ strtoupper(substr($conversation->user->name, 0, 1)) }}
                            </div>
                            @if ($conversation->unread_count > 0)
                                <span class="absolute -top-1 -right-1 flex h-3 w-3">
                                    <span
                                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-3 w-3 bg-indigo-500"></span>
                                </span>
                            @endif
                        </div>

                        <div class="flex-1 min-w-0 text-left">
                            <div class="flex items-center justify-between mb-0.5">
                                <span class="font-medium text-zinc-900 dark:text-zinc-100 truncate">
                                    {{ $conversation->user->name }}
                                </span>
                                <span class="text-[10px] text-zinc-500 uppercase tracking-wider">
                                    {{ $conversation->last_message_at?->format('H:i') }}
                                </span>
                            </div>

                            @if ($conversation->lastMessage)
                                <p class="text-sm text-zinc-500 dark:text-zinc-400 truncate line-clamp-1">
                                    {{ $conversation->lastMessage->message }}
                                </p>
                            @endif
                        </div>
                    </button>
                @empty
                    <div class="p-12 text-center">
                        <flux:icon name="chat-bubble-left-right"
                            class="mx-auto size-10 text-zinc-300 dark:text-zinc-600 mb-3" />
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">No active chats</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Chat Area --}}
        <div class="flex-1 flex flex-col bg-white dark:bg-zinc-900 relative">
            @if ($selectedConversation)
                {{-- Chat Header --}}
                <div
                    class="h-[65px] flex items-center justify-between px-6 border-b border-zinc-200 dark:border-zinc-800 bg-white/80 dark:bg-zinc-900/80 backdrop-blur-md z-10">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-9 h-9 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center text-zinc-600 dark:text-zinc-400 text-sm font-bold">
                            {{ strtoupper(substr($selectedConversation->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-zinc-900 dark:text-white leading-none">
                                {{ $selectedConversation->user->name }}
                            </h3>
                            <p class="text-xs text-neutral-500 mt-1 flex items-center gap-1">
                                {{ $selectedConversation->user->email }}
                            </p>
                            {{-- <p class="text-xs text-green-600 dark:text-green-500 mt-1 flex items-center gap-1">
                                <span class="block w-1.5 h-1.5 rounded-full bg-current"></span>
                                Active Now
                            </p> --}}
                        </div>
                    </div>

                    <flux:button wire:click="closeConversation" variant="ghost" size="sm" icon="x-mark" />
                </div>

                {{-- Messages List --}}
                <div class="flex-1 overflow-y-auto p-6 space-y-6 bg-zinc-50/30 dark:bg-zinc-950/20"
                    x-init="$el.scrollTop = $el.scrollHeight" x-on:scroll-to-bottom.window="$el.scrollTop = $el.scrollHeight"
                    wire:poll.5s="loadMessages">

                    @foreach ($messages as $msg)
                        <div class="flex {{ $msg['sender_type'] === 'user' ? 'justify-start' : 'justify-end' }}">
                            <div
                                class="flex flex-col {{ $msg['sender_type'] === 'user' ? 'items-start' : 'items-end' }} max-w-[80%] lg:max-w-[70%]">
                                <div
                                    class="px-4 py-2.5 rounded-2xl text-sm shadow-sm {{ $msg['sender_type'] === 'user'
                                        ? 'bg-white dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200 border border-zinc-200 dark:border-zinc-700 rounded-tl-none'
                                        : 'bg-indigo-600 text-white rounded-tr-none' }}">
                                    {{ $msg['message'] }}
                                </div>
                                <span class="text-[10px] text-zinc-400 mt-1 px-1">
                                    {{ \Carbon\Carbon::parse($msg['created_at'])->format('g:i A') }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Message Input --}}
                <div class="p-4 bg-white dark:bg-zinc-900 border-t border-zinc-200 dark:border-zinc-800">
                    <form wire:submit.prevent="sendMessage" class="relative">
                        <textarea wire:model="message" rows="1" placeholder="Type a message..."
                            class="w-full pl-4 pr-12 py-3 bg-zinc-100 dark:bg-zinc-800 border-none rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 dark:text-zinc-200 resize-none"
                            x-on:keydown.enter.prevent="if (!$event.shiftKey) { $wire.sendMessage(); }"></textarea>

                        <button type="submit"
                            class="absolute right-2 top-1.5 p-2 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 rounded-lg transition-colors">
                            <flux:icon name="paper-airplane" class="size-5" />
                        </button>
                    </form>
                    @error('message')
                        <p class="text-[10px] text-red-500 mt-1 ml-2">{{ $message }}</p>
                    @enderror
                </div>
            @else
                {{-- Empty State --}}
                <div class="flex-1 flex flex-col items-center justify-center text-center p-12">
                    <div
                        class="w-20 h-20 bg-zinc-50 dark:bg-zinc-800 rounded-full flex items-center justify-center mb-4">
                        <flux:icon name="chat-bubble-left-right" class="size-10 text-zinc-300 dark:text-zinc-600" />
                    </div>
                    <h3 class="text-lg font-medium text-zinc-900 dark:text-white">Select a conversation</h3>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 max-w-xs mx-auto mt-1">
                        Choose a user from the left panel to start a support session.
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    /* Ensure the scrollbar doesn't cause shifting */
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #e4e4e7;
        border-radius: 10px;
    }

    .dark .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #3f3f46;
    }
</style>
