<div class="min-h-screen container mx-auto" x-data="{
    showFilters: false,
    scrolled: false
}" x-init="window.addEventListener('scroll', () => {
    scrolled = window.scrollY > 20
})">
    <div class="flex justify-between items-center">
        <div class="font-sans font-bold text-2xl flex items-center gap-2 text-blue-600">
            <flux:icon.academic-cap />
            My Courses
        </div>
        <a href="{{ route('courses.index') }}" wire:navigate class="group flex items-center justify-between gap-2 px-3 py-2 rounded-md text-blue-600 hover:bg-blue-600 hover:text-white transition duration-300">
            <flux:icon.home variant="mini" class="text-blue-600 group-hover:text-white transition duration-300" />
            All Courses
        </a>
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
                <a href="{{ route('courses.index') }}" wire:navigate>
                    <flux:button variant="primary">
                        View All Courses
                    </flux:button>
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                @foreach ($this->courses as $course)
                    <div class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-300 border border-gray-100 active:scale-98"
                        x-data="{ bookmarked: false }">

                        {{-- Course Image --}}
                        <div
                            class="relative aspect-[4/3] bg-gradient-to-br from-blue-500 via-purple-500 to-pink-500 overflow-hidden">
                            @if ($course->image)
                                <img src="{{ $course->image }}" alt="{{ $course->title }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                    loading="lazy">
                            @else
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <flux:icon.academic-cap class="w-20 h-20 text-white opacity-40" />
                                </div>
                            @endif

                            {{-- Category Badge --}}
                            <div class="absolute top-3 left-3">
                                <span
                                    class="px-3 py-1.5 bg-white/95 backdrop-blur-sm rounded-full text-xs font-bold text-gray-900 shadow-lg">
                                    {{ ucfirst($course->category->name) }}
                                </span>
                            </div>

                            {{-- Duration Badge --}}
                            @if ($course->duration)
                                <div class="absolute bottom-3 right-3">
                                    <span
                                        class="px-2.5 py-1 bg-black/70 backdrop-blur-sm rounded-lg text-xs font-medium text-white flex items-center gap-1.5">
                                        <flux:icon.clock class="w-3.5 h-3.5" />
                                        {{ $course->duration }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        {{-- Course Info --}}
                        <a href="{{ route('courses.show', $course) }}"
                            class="block p-4 hover:bg-gray-50 transition-colors">
                            <h3
                                class="font-bold text-gray-900 text-base mb-2 line-clamp-2 leading-snug group-hover:text-blue-600 transition-colors">
                                {{ $course->title }}
                            </h3>

                            <p class="text-gray-600 text-sm mb-4 line-clamp-2 leading-relaxed">
                                {{ $course->description }}
                            </p>

                            {{-- Course Meta --}}
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-3 text-xs text-gray-500">
                                    @if ($course->students_count)
                                        <span class="flex items-center gap-1">
                                            <flux:icon.users class="w-4 h-4" />
                                            {{ number_format($course->students_count) }}
                                        </span>
                                    @endif

                                    @if ($course->rating)
                                        <span class="flex items-center gap-1">
                                            <flux:icon.star class="w-4 h-4 text-yellow-400 fill-current" />
                                            <span
                                                class="font-semibold text-gray-700">{{ number_format($course->rating, 1) }}</span>
                                        </span>
                                    @endif
                                </div>

                                @if ($course->is_new)
                                    <span
                                        class="px-2 py-1 bg-green-50 text-green-700 text-xs font-bold rounded-md border border-green-200">
                                        NEW
                                    </span>
                                @endif
                            </div>

                            {{-- Price and CTA --}}
                            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                <div>
                                    @if ($course->price > 0)
                                        <div class="flex items-baseline gap-2">
                                            <span class="text-2xl font-bold text-gray-900">
                                                ${{ number_format($course->price, 0) }}
                                            </span>
                                            @if ($course->original_price)
                                                <span class="text-sm text-gray-400 line-through">
                                                    ${{ number_format($course->original_price, 0) }}
                                                </span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-2xl font-bold text-green-600">Free</span>
                                    @endif
                                </div>

                                <flux:button size="sm" variant="primary" icon:trailing="eye"
                                    class="group-hover:scale-105 transition-transform shadow-lg">
                                    Show
                                </flux:button>
                            </div>
                        </a>
                    </div>
                @endforeach
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
