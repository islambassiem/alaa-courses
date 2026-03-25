<div class="h-full bg-gray-50 -m-6">
    <div class="container mx-auto max-w-7xl">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden h-full">
            <div class="grid grid-cols-1 md:grid-cols-3 h-full">
                {{-- Conversations List --}}
                <div class="border-r border-gray-200 flex flex-col">
                    {{-- Header --}}
                    <div class="p-4 bg-gradient-to-r from-blue-600 to-teal-600">
                        <h2 class="text-xl font-bold text-white mb-4">Support Chats</h2>
                        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search conversations..."
                            class="w-full px-4 py-2 rounded-lg text-sm focus:ring-2 focus:ring-white focus:outline-none" />
                    </div>

                    {{-- Conversations --}}
                    <div class="flex-1 overflow-y-auto">
                        @forelse($conversations as $conversation)
                            <button wire:click="selectConversation({{ $conversation->id }})"
                                class="w-full p-4 border-b border-gray-200 hover:bg-gray-50 transition-colors text-left {{ $selectedConversation && $selectedConversation->id === $conversation->id ? 'bg-blue-50 border-l-4 border-l-blue-600' : '' }}">
                                <div class="flex items-start gap-3">
                                    <div
                                        class="w-12 h-12 bg-gradient-to-br from-blue-600 to-teal-600 rounded-full flex items-center justify-center flex-shrink-0 text-white font-bold">
                                        {{ strtoupper(substr($conversation->user->name, 0, 1)) }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between mb-1">
                                            <p class="font-semibold text-gray-900 truncate">
                                                {{ $conversation->user->name }}</p>
                                            @if ($conversation->unread_count > 0)
                                                <span
                                                    class="w-6 h-6 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center">
                                                    {{ $conversation->unread_count }}
                                                </span>
                                            @endif
                                        </div>
                                        @if ($conversation->lastMessage)
                                            <p class="text-sm text-gray-600 truncate">
                                                {{ Str::limit($conversation->lastMessage->message, 40) }}
                                            </p>
                                        @endif
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ $conversation->last_message_at ? $conversation->last_message_at->diffForHumans() : 'No messages yet' }}
                                        </p>
                                    </div>
                                </div>
                            </button>
                        @empty
                            <div class="p-8 text-center">
                                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <path
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                <p class="text-gray-600">No conversations yet</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- Chat Area --}}
                <div class="col-span-2 flex flex-col">
                    @if ($selectedConversation)
                        {{-- Chat Header --}}
                        <div class="p-4 bg-gradient-to-r from-blue-600 to-teal-600 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center text-white font-bold">
                                    {{ strtoupper(substr($selectedConversation->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <h3 class="font-bold text-white">{{ $selectedConversation->user->name }}</h3>
                                    <p class="text-xs text-blue-100">{{ $selectedConversation->user->email }}</p>
                                </div>
                            </div>
                            <button wire:click="closeConversation"
                                class="px-4 py-2 bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white text-sm font-semibold rounded-lg transition-colors">
                                Close Chat
                            </button>
                        </div>

                        {{-- Messages --}}
                        <div class="flex-1 overflow-y-auto p-6 space-y-4 bg-gray-50" x-init="$el.scrollTop = $el.scrollHeight"
                            x-on:scroll-to-bottom.window="$el.scrollTop = $el.scrollHeight" wire:poll.3s="loadMessages">
                            @foreach ($messages as $msg)
                                @if ($msg['sender_type'] === 'user')
                                    {{-- User Message --}}
                                    <div class="flex justify-start">
                                        <div class="max-w-[70%]">
                                            <div class="flex items-start gap-2 mb-1">
                                                <div
                                                    class="w-8 h-8 bg-gradient-to-br from-blue-600 to-teal-600 rounded-full flex items-center justify-center flex-shrink-0 text-white text-sm font-bold">
                                                    {{ strtoupper(substr($selectedConversation->user->name, 0, 1)) }}
                                                </div>
                                                <span
                                                    class="text-xs font-semibold text-gray-700 mt-1">{{ $selectedConversation->user->name }}</span>
                                            </div>
                                            <div
                                                class="bg-white border border-gray-200 rounded-2xl rounded-tl-sm px-4 py-3 shadow-sm ml-10">
                                                <p class="text-sm text-gray-800 leading-relaxed break-words">
                                                    {{ $msg['message'] }}</p>
                                            </div>
                                            <p class="text-xs text-gray-500 mt-1 ml-10">
                                                {{ \Carbon\Carbon::parse($msg['created_at'])->format('M d, g:i A') }}
                                            </p>
                                        </div>
                                    </div>
                                @else
                                    {{-- Admin Message --}}
                                    <div class="flex justify-end">
                                        <div class="max-w-[70%]">
                                            <div
                                                class="bg-gradient-to-r from-blue-600 to-teal-600 text-white rounded-2xl rounded-br-sm px-4 py-3 shadow-md">
                                                <p class="text-sm leading-relaxed break-words">{{ $msg['message'] }}
                                                </p>
                                            </div>
                                            <p class="text-xs text-gray-500 mt-1 text-right">
                                                {{ \Carbon\Carbon::parse($msg['created_at'])->format('M d, g:i A') }}
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        {{-- Input Area --}}
                        <div class="p-4 bg-white border-t border-gray-200">
                            <form wire:submit.prevent="sendMessage" class="flex items-end gap-3">
                                <div class="flex-1">
                                    <textarea wire:model="message" rows="2" placeholder="Type your reply..."
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none text-sm"
                                        x-on:keydown.enter.prevent="if (!$event.shiftKey) { $wire.sendMessage(); }"></textarea>
                                    @error('message')
                                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <button type="submit"
                                    class="px-6 py-3 bg-gradient-to-r from-blue-600 to-teal-600 hover:from-blue-700 hover:to-teal-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 flex items-center gap-2">
                                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2">
                                        <path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z" />
                                    </svg>
                                    Send
                                </button>
                            </form>
                        </div>
                    @else
                        {{-- No Conversation Selected --}}
                        <div class="flex-1 flex items-center justify-center bg-gray-50">
                            <div class="text-center">
                                <svg class="w-24 h-24 mx-auto text-gray-400 mb-4" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <path
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                <h3 class="text-xl font-semibold text-gray-900 mb-2">Select a conversation</h3>
                                <p class="text-gray-600">Choose a conversation from the list to start chatting</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
