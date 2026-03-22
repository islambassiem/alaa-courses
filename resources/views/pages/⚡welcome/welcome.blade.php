<div class="min-h-screen bg-gray-50 container mx-auto" x-data="{
    showFilters: false,
    scrolled: false
}" x-init="window.addEventListener('scroll', () => {
    scrolled = window.scrollY > 20
})">
    {{-- Mobile Header with Search --}}
    <div class="sticky top-0 z-40 bg-white transition-shadow duration-200"
        :class="scrolled ? 'shadow-md' : 'border-b border-gray-200'">

        {{-- Logo and Title --}}
        <div class="px-4 py-4 ">
            <div class="flex items-center justify-between mb-4 ">
                <a wire:navigate href="{{ route('home') }}" class="flex items-center gap-3 ">
                    <x-app-logo-icon />
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">{{ config('app.name') }}</h1>
                        <p class="text-xs text-gray-600">Your Medical Education</p>
                    </div>
                </a>

                <nav class="flex items-center justify-end gap-4">
                    @auth
                        <a href="{{ route('dashboard') }}" wire:navigate
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                            Dashboard
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <flux:button type="submit" icon="arrow-right-start-on-rectangle"
                                class="w-full cursor-pointer" data-test="logout-button">
                                {{ __('Log out') }}
                            </flux:button>
                        </form>
                    @else
                        <a href="{{ route('login') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal">
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            </div>
            {{-- Search Bar --}}
            <flux:input wire:model.live.debounce.300ms="searchQuery" type="search" icon="magnifying-glass"
                placeholder="Search courses..." />
        </div>

        {{-- Category Pills (Horizontal Scroll) --}}
        <div class="px-4 pb-3 overflow-x-auto scrollbar-hide">
            <div class="flex gap-2">
                <button wire:click="selectCategory('all')"
                    class="px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap transition-all duration-200 active:scale-95
                    {{ $selectedCategory === 'all'
                        ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30'
                        : 'bg-gray-100 text-gray-700 active:bg-gray-200' }}">All</button>
                @foreach ($categories as $key => $label)
                    <button wire:click="selectCategory('{{ $label->id }}')"
                        class="px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap transition-all duration-200 active:scale-95
                               {{ $selectedCategory === (string) $label->id
                                   ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30'
                                   : 'bg-gray-100 text-gray-700 active:bg-gray-200' }}">
                        {{ ucfirst($label->name) }}
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Course Cards Grid --}}
    <div class="px-4 py-6">
        @if ($this->courses->isEmpty())
            {{-- Empty State --}}
            <div class="flex flex-col items-center justify-center py-20 text-center">
                <div
                    class="w-32 h-32 mb-6 bg-linear-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center">
                    <flux:icon.academic-cap class="w-16 h-16 text-gray-400" />
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">No courses found</h3>
                <p class="text-gray-600 text-sm mb-6 max-w-xs">
                    We couldn't find any courses matching your criteria. Try adjusting your filters.
                </p>
                <flux:button wire:click="$set('selectedCategory', 'all'); $set('searchQuery', '')" variant="primary">
                    View All Courses
                </flux:button>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($this->courses as $course)
                    <livewire:course-card
                        :key="$course->id"
                        :course="$course"
                    />
                @endforeach
            </div>

            <div class="mt-8 text-center">
                <flux:button wire:click='loadMore' variant="primary" icon:trailing="arrow-down"
                    class="w-full sm:w-auto">
                    Load More Courses
                </flux:button>
            </div>
        @endif
    </div>

    {{-- Bottom Navigation (Mobile) --}}
    @auth
        <nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 sm:hidden z-50">
            <div class="grid grid-cols-4 gap-1 px-2 py-2">
                <a href="#"
                    class="flex flex-col items-center justify-center py-2 px-3 rounded-lg bg-blue-50 text-blue-600">
                    <flux:icon.home class="w-6 h-6 mb-1" />
                    <span class="text-xs font-medium">Home</span>
                </a>
                <a href="#"
                    class="flex flex-col items-center justify-center py-2 px-3 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors">
                    <flux:icon.academic-cap class="w-6 h-6 mb-1" />
                    <span class="text-xs font-medium">My Courses</span>
                </a>
                <a href="#"
                    class="flex flex-col items-center justify-center py-2 px-3 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors">
                    <flux:icon.heart class="w-6 h-6 mb-1" />
                    <span class="text-xs font-medium">Saved</span>
                </a>
                <a href="{{ route('profile.edit') }}"
                    class="flex flex-col items-center justify-center py-2 px-3 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors">
                    <flux:icon.user class="w-6 h-6 mb-1" />
                    <span class="text-xs font-medium">Profile</span>
                </a>
            </div>
        </nav>
    @endauth

    {{-- Bottom Padding for Mobile Nav --}}
    <div class="h-20 sm:hidden"></div>
</div>

{{-- Custom Styles --}}
<style>
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }

    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    .active\:scale-98:active {
        transform: scale(0.98);
    }
</style>
