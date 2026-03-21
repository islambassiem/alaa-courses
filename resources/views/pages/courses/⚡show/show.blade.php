<div class="min-h-screen bg-gray-50 pb-24 container mx-auto" x-data="{
    showShareMenu: false,
    bookmarked: false,
    showFullDescription: false
}">

    {{-- Mobile Header --}}
    <div class="sticky top-0 z-50 bg-white border-b border-gray-200">
        <div class="flex items-center justify-between px-4 py-3">
            <a href="{{ route('home') }}" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                <flux:icon.arrow-left class="w-6 h-6 text-gray-700" />
            </a>
        </div>
    </div>

    {{-- Course Hero Image --}}
    <div class="relative aspect-video bg-linear-to-br from-blue-500 via-purple-500 to-pink-500">
        @if ($course->image)
            <img src="{{ $course->image }}" alt="{{ $course->title }}" class="w-full h-full object-cover">
        @else
            <div class="absolute inset-0 flex items-center justify-center">
                <flux:icon.academic-cap class="w-24 h-24 text-white opacity-40" />
            </div>
        @endif

        <div class="absolute top-4 left-4">
            <span class="px-4 py-2 bg-white/95 backdrop-blur-sm rounded-full text-sm font-bold text-gray-900 shadow-lg">
                {{ ucfirst($course->category->name) }}
            </span>
        </div>

        @if ($course->is_new)
            <div class="absolute top-4 right-4">
                <span class="px-3 py-1.5 bg-green-500 text-white text-xs font-bold rounded-full shadow-lg">
                    NEW
                </span>
            </div>
        @endif
    </div>

    {{-- Main Content --}}
    <div>
        {{-- Course Header --}}
        <div class="px-4 py-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-3 leading-tight">
                {{ $course->title }}
            </h1>

            <p class="text-gray-600 mb-4 leading-relaxed" :class="showFullDescription ? '' : 'line-clamp-3'">
                {{ $course->description }}
            </p>

            <button @click="showFullDescription = !showFullDescription" class="text-blue-600 text-sm font-semibold"
                x-show="$el.previousElementSibling.scrollHeight > $el.previousElementSibling.clientHeight || showFullDescription">
                <span x-text="showFullDescription ? 'Show less' : 'Read more'"></span>
            </button>

            {{-- Course Stats --}}
            <div class="flex flex-wrap items-center gap-4 mt-6 text-sm">
                @if ($course->rating)
                    <div class="flex items-center gap-1.5">
                        <flux:icon.star class="w-5 h-5 text-yellow-400 fill-current" />
                        <span class="font-bold text-gray-900">{{ number_format($course->rating, 1) }}</span>
                        <span class="text-gray-500">({{ number_format($course->reviews_count ?? 0) }} reviews)</span>
                    </div>
                @endif

                @if ($course->students_count)
                    <div class="flex items-center gap-1.5 text-gray-600">
                        <flux:icon.users class="w-5 h-5" />
                        <span>{{ number_format($course->students_count) }} students</span>
                    </div>
                @endif

                @if ($course->duration)
                    <div class="flex items-center gap-1.5 text-gray-600">
                        <flux:icon.clock class="w-5 h-5" />
                        <span>{{ $course->duration }}</span>
                    </div>
                @endif
            </div>
        </div>

        {{-- Tabs --}}
        <div class="border-t border-b border-gray-200 px-4 overflow-x-auto scrollbar-hide">
            <div class="flex gap-6 min-w-max">
                <button wire:click="setActiveTab('overview')"
                    class="py-4 text-sm font-semibold border-b-2 transition-colors whitespace-nowrap"
                    :class="'{{ $activeTab }}'
                    === 'overview' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-600'">
                    Overview
                </button>
                <button wire:click="setActiveTab('reviews')"
                    class="py-4 text-sm font-semibold border-b-2 transition-colors whitespace-nowrap"
                    :class="'{{ $activeTab }}'
                    === 'reviews' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-600'">
                    Reviews
                </button>
            </div>
        </div>

        {{-- Tab Content --}}
        <div class="px-4 py-6">
            {{-- Overview Tab --}}
            @if ($activeTab === 'overview')
                <div class="space-y-6">
                    {{-- What You'll Learn --}}
                    @if ($course->objectives)
                        <div>
                            <h2 class="text-lg font-bold text-gray-900 mb-4">What you'll learn</h2>
                            <div class="space-y-3">
                                @foreach (json_decode($course->objectives) as $objective)
                                    <div class="flex gap-3">
                                        <div
                                            class="flex-shrink-0 w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mt-0.5">
                                            <flux:icon.check class="w-4 h-4 text-green-600" />
                                        </div>
                                        <p class="text-gray-700 flex-1">{{ $objective }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Requirements --}}
                    @if ($course->requirements)
                        <div>
                            <h2 class="text-lg font-bold text-gray-900 mb-4">Requirements</h2>
                            <div class="space-y-2">
                                @foreach ($course->requirements as $requirement)
                                    <div class="flex gap-3">
                                        <flux:icon.check-circle class="w-5 h-5 text-gray-400 shrink-0 mt-0.5" />
                                        <p class="text-gray-700 flex-1">{{ $requirement }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            {{-- Reviews Tab --}}
            @if ($activeTab === 'reviews')
                <div class="space-y-6">
                    {{-- Rating Overview --}}
                    <div class="flex items-start gap-6 p-6 bg-gray-50 rounded-xl">
                        @if ($this->reviews->count() > 0)
                            <div class="text-center">
                                <div class="text-5xl font-bold text-gray-900 mb-2">
                                    {{ number_format($course->rating ?? 4.8, 1) }}</div>
                                <div class="flex items-center justify-center gap-1 mb-2">
                                    @for ($r = 1; $r <= 5; $r++)
                                        <x-star :width="$course->rating >= $r
                                            ? 'w-full'
                                            : ($course->rating >= $r - 0.5
                                                ? 'w-1/2'
                                                : 'w-0')" />
                                    @endfor
                                </div>
                                <p class="text-sm text-gray-600">Course rating</p>
                            </div>

                            <div class="flex-1 space-y-2">
                                @foreach ($course->ratingBreakdown() as $star => $percentage)
                                    <div class="flex items-center gap-3">
                                        <span class="text-sm text-gray-600 w-12">{{ $star }} star</span>

                                        <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                            <div class="h-full bg-yellow-400" style="width: {{ $percentage }}%">
                                            </div>
                                        </div>

                                        <span class="text-sm text-gray-600 w-8">{{ $percentage }}%</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div>There are no reviews for this course</div>
                        @endif
                    </div>

                    {{-- Reviews List --}}
                    <div class="space-y-6">
                        @if ($this->reviews->count() > 0)
                            @foreach ($this->reviews as $review)
                                <div class="border-b border-gray-200 pb-6 last:border-0">
                                    <div class="flex items-start gap-3 mb-3">
                                        <div
                                            class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center shrink-0">
                                            <span class="text-white font-bold">{{ $review->user->initials() }}</span>
                                        </div>
                                        <div class="flex-1">
                                            <p class="font-semibold text-gray-900">{{ $review->user->name }}</p>
                                            <div class="flex items-center gap-2 mt-1">
                                                <div class="flex items-center">
                                                    @for ($j = 1; $j <= $review->rating; $j++)
                                                        <flux:icon.star class="w-4 h-4 text-yellow-400 fill-current" />
                                                    @endfor
                                                </div>
                                                <span
                                                    class="text-xs text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-gray-700 leading-relaxed">
                                        {{ $review->review }}
                                    </p>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    {{-- <flux:button variant="ghost" class="w-full">
                        Load More Reviews
                    </flux:button> --}}
                </div>
            @endif
        </div>
    </div>

    {{-- Fixed Bottom Enrollment Bar --}}
    <div class="fixed bottom-0 left-0 right-0 bg-blue-600 border-t border-gray-200 px-4 py-4 z-40 shadow-xl">
        <div class="flex items-center justify-between gap-4 max-w-2xl mx-auto">
            <div>
                @if ($course->price > 0)
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl font-bold text-gray-900">${{ number_format($course->price, 0) }}</span>
                        @if ($course->original_price)
                            <span
                                class="text-lg text-gray-400 line-through">${{ number_format($course->original_price, 0) }}</span>
                        @endif
                    </div>
                    @if ($course->original_price)
                        <p class="text-xs text-green-600 font-semibold">
                            Save
                            {{ round((($course->original_price - $course->price) / $course->original_price) * 100) }}%
                        </p>
                    @endif
                @else
                    <span class="text-3xl font-bold text-green-600">Free</span>
                @endif
            </div>

            @if ($isEnrolled)
                <flux:button href="{{ route('courses.learn', $course) }}" variant="primary" class="flex-1 max-w-xs">
                    Continue Learning
                    <flux:icon.arrow-right class="w-5 h-5" />
                </flux:button>
            @else
            <form action="{{ route('checkout', $course) }}" method="post">
                @csrf
                <flux:button type="submit" variant="primary" icon:trailing="arrow-right"
                    class="max-w-xs shadow-lg">
                    {{ $authenticated ? 'Checkout' :'Enroll Now' }}
                </flux:button>
            </form>
            @endif
        </div>
    </div>

    {{-- Success/Error Messages --}}
    @if (session()->has('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
            class="fixed top-20 left-4 right-4 mx-auto max-w-md z-50 bg-green-500 text-white px-4 py-3 rounded-lg shadow-lg">
            <div class="flex items-center gap-3">
                <flux:icon.check-circle class="w-6 h-6" />
                <p class="flex-1">{{ session('success') }}</p>
            </div>
        </div>
    @endif
</div>

<style>
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }

    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>
