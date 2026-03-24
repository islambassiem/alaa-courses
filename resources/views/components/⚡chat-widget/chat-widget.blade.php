<div class="fixed bottom-6 right-6 z-50" x-data="{ open: @entangle('isOpen') }">
    {{-- Chat Button (Closed State) --}}
    <button @click="open = !open" x-show="!open" x-transition
        class="w-16 h-16 bg-gradient-to-br from-blue-600 to-teal-600 hover:from-blue-700 hover:to-teal-700 text-white rounded-full shadow-2xl hover:shadow-3xl transition-all duration-300 hover:scale-110 flex items-center justify-center group relative">
        <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z" />
        </svg>

        {{-- Unread Badge --}}
        @if (Auth::check() && $conversation && $conversation->unread_count > 0)
            <span
                class="absolute -top-1 -right-1 w-6 h-6 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center ring-4 ring-white">
                {{ $conversation->unread_count }}
            </span>
        @endif

        {{-- Pulse Animation --}}
        <span class="absolute inset-0 rounded-full bg-blue-400 animate-ping opacity-20"></span>
    </button>

    {{-- Chat Window (Open State) --}}
    <div x-show="open" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-y-4 scale-95"
        x-transition:enter-end="opacity-100 transform translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 transform translate-y-4 scale-95"
        class="fixed bottom-6 right-6 w-[calc(100vw-3rem)] sm:w-96 h-[600px] max-h-[80vh] bg-white rounded-2xl shadow-2xl overflow-hidden flex flex-col"
        x-cloak>
        {{-- Header --}}
        <div class="bg-gradient-to-r from-blue-600 to-teal-600 p-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-white">Support Chat</h3>
                    <p class="text-xs text-blue-100">We're here to help</p>
                </div>
            </div>
            <button @click="open = false"
                class="w-8 h-8 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-lg flex items-center justify-center transition-colors">
                <svg class="w-5 h-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </button>
        </div>

        {{-- Messages Area --}}
        <div class="flex-1 overflow-y-auto p-4 space-y-4 bg-gray-50" x-init="$el.scrollTop = $el.scrollHeight"
            x-on:scroll-to-bottom.window="$el.scrollTop = $el.scrollHeight" wire:poll.5s="loadMessages">
            @if (Auth::check())
                @if (count($messages) === 0)
                    {{-- Welcome Message --}}
                    <div class="flex flex-col items-center justify-center py-12 text-center">
                        <div
                            class="w-20 h-20 bg-gradient-to-br from-blue-100 to-teal-100 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-10 h-10 text-blue-600" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <path
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                        </div>
                        <h4 class="font-semibold text-gray-900 mb-2">Welcome to Support Chat!</h4>
                        <p class="text-sm text-gray-600 max-w-xs">
                            Have questions about our courses? We're here to help. Send us a message below.
                        </p>
                    </div>
                @else
                    @foreach ($messages as $msg)
                        @if ($msg['sender_type'] === 'user')
                            {{-- User Message (Right) --}}
                            <div class="flex justify-end">
                                <div class="max-w-[80%]">
                                    <div
                                        class="bg-gradient-to-r from-blue-600 to-teal-600 text-white rounded-2xl rounded-br-sm px-4 py-3 shadow-md">
                                        <p class="text-sm leading-relaxed break-words">{{ $msg['message'] }}</p>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1 text-right">
                                        {{ \Carbon\Carbon::parse($msg['created_at'])->format('g:i A') }}
                                    </p>
                                </div>
                            </div>
                        @else
                            {{-- Admin Message (Left) --}}
                            <div class="flex justify-start">
                                <div class="max-w-[80%]">
                                    <div class="flex items-start gap-2 mb-1">
                                        <div
                                            class="w-8 h-8 bg-gradient-to-br from-gray-200 to-gray-300 rounded-full flex items-center justify-center flex-shrink-0">
                                            <svg class="w-5 h-5 text-gray-600" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <span class="text-xs font-semibold text-gray-700 mt-1">Support Team</span>
                                    </div>
                                    <div
                                        class="bg-white border border-gray-200 rounded-2xl rounded-tl-sm px-4 py-3 shadow-sm ml-10">
                                        <p class="text-sm text-gray-800 leading-relaxed break-words">
                                            {{ $msg['message'] }}</p>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1 ml-10">
                                        {{ \Carbon\Carbon::parse($msg['created_at'])->format('g:i A') }}
                                    </p>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endif

                {{-- Typing Indicator --}}
                @if ($isTyping)
                    <div class="flex justify-start">
                        <div class="bg-white border border-gray-200 rounded-2xl rounded-tl-sm px-4 py-3 shadow-sm">
                            <div class="flex items-center gap-1">
                                <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"
                                    style="animation-delay: 0ms"></div>
                                <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"
                                    style="animation-delay: 150ms"></div>
                                <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"
                                    style="animation-delay: 300ms"></div>
                            </div>
                        </div>
                    </div>
                @endif
            @else
                {{-- Guest State --}}
                <div class="flex flex-col items-center justify-center py-12 text-center">
                    <div
                        class="w-20 h-20 bg-gradient-to-br from-blue-100 to-teal-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-10 h-10 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-2">Sign in to chat</h4>
                    <p class="text-sm text-gray-600 mb-6 max-w-xs">
                        Please sign in to start a conversation with our support team.
                    </p>
                    <a href="{{ route('login') }}"
                        class="bg-gradient-to-r from-blue-600 to-teal-600 hover:from-blue-700 hover:to-teal-700 text-white font-semibold px-6 py-3 rounded-xl shadow-lg transition-all duration-300">
                        Sign In
                    </a>
                </div>
            @endif
        </div>

        {{-- Input Area --}}
        @if (Auth::check())
            <div class="p-4 bg-white border-t border-gray-200">
                <form wire:submit.prevent="sendMessage" class="flex items-end gap-2">
                    <div class="flex-1">
                        <textarea wire:model="message" rows="1" placeholder="Type your message..."
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none text-sm"
                            x-on:keydown.enter.prevent="if (!$event.shiftKey) { $wire.sendMessage(); }"
                            x-on:input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'"></textarea>
                        @error('message')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit"
                        class="w-12 h-12 bg-gradient-to-r from-blue-600 to-teal-600 hover:from-blue-700 hover:to-teal-700 text-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 flex items-center justify-center flex-shrink-0 disabled:opacity-50 disabled:cursor-not-allowed"
                        :disabled="!$wire.message">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z" />
                        </svg>
                    </button>
                </form>
                <p class="text-xs text-gray-500 mt-2 text-center">
                    Press Enter to send • Shift + Enter for new line
                </p>
            </div>
        @endif
    </div>
</div>

{{-- Custom Styles --}}
<style>
    [x-cloak] {
        display: none !important;
    }
</style>
