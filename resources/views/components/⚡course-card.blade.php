<?php

use App\Models\Course;
use Livewire\Component;

new class extends Component {
    public $course;

    public function mount(Course $course)
    {
        $this->course = $course;
    }
};
?>

<a href="{{ route('courses.show', $course) }}" wire:navigate
    class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 animate-fade-in-up">
    {{-- Course Image --}}
    <div class="relative aspect-video bg-gradient-to-br from-blue-500 to-teal-500 overflow-hidden">
        @if ($course->image)
            <img src="{{ $course->image }}" alt="{{ $course->title }}"
                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" loading="lazy">
        @else
            <div class="absolute inset-0 flex items-center justify-center">
                <svg class="w-20 h-20 text-white opacity-40" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M12 14l9-5-9-5-9 5 9 5z" />
                    <path
                        d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                </svg>
            </div>
        @endif
        <div class="absolute top-4 left-4">
            <span class="bg-white/95 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-bold text-gray-900 shadow-lg">
                {{ ucfirst($course->category->name) }}
            </span>
        </div>
    </div>

    {{-- Course Content --}}
    <div class="p-6">
        <h3
            class="font-semibold text-xl text-gray-900 mb-3 line-clamp-2 leading-snug group-hover:text-blue-600 transition-colors">
            {{ $course->title }}
        </h3>
        <p class="text-gray-600 text-sm mb-4 line-clamp-2">
            {{ $course->description }}
        </p>

        {{-- Meta Info --}}
        <div class="flex items-center gap-4 mb-4 pb-4 border-b border-gray-100 text-sm text-gray-600">
            <div class="flex items-center gap-1 text-yellow-500 font-semibold">
                <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                    <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
                <span>{{ number_format($course->rating ?? 4.8, 1) }}</span>
            </div>
            <span>{{ number_format($course->students_count) }} students</span>
        </div>

        {{-- Footer --}}
        <div class="flex items-center justify-between">
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
                <div class="text-3xl font-bold text-teal-600">Free</div>
            @endif
            <div
                class="w-10 h-10 bg-gray-100 group-hover:bg-blue-600 rounded-xl flex items-center justify-center transition-all duration-300 group-hover:translate-x-1">
                <svg class="w-5 h-5 text-gray-600 group-hover:text-white transition-colors" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </div>
        </div>
    </div>
</a>
