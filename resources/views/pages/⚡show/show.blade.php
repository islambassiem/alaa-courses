{{-- Import Google Fonts --}}
<div class="min-h-screen bg-gray-50 font-sans pb-32" x-data="{
    activeTab: 'overview',
    showShareMenu: false,
    bookmarked: false,
    showFullDescription: false
}">

    {{-- Header --}}
    <div class="sticky top-0 z-50 bg-white border-b border-gray-200 shadow-sm">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between py-4">
                <a href="{{ route('courses.index') }}" wire:navigate
                    class="flex items-center gap-2 text-gray-700 hover:text-blue-600 transition-colors group">
                    <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="font-medium hidden sm:inline">Back to Courses</span>
                </a>
            </div>
        </div>
    </div>

    {{-- Hero Image Section --}}
    <div
        class="relative aspect-video lg:aspect-[21/9] bg-linear-to-br from-blue-500 via-blue-600 to-teal-600 overflow-hidden">
        @if ($course->image)
            <img src="{{ $course->image }}" alt="{{ $course->title }}" class="w-full h-full object-cover">
        @else
            <div class="absolute inset-0 flex items-center justify-center">
                <svg class="w-20 h-20 lg:w-24 lg:h-24 text-white opacity-30" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2">
                    <path d="M12 14l9-5-9-5-9 5 9 5z" />
                    <path
                        d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                </svg>
            </div>
        @endif

        {{-- Category Badge --}}
        <div class="absolute top-6 left-6">
            <span
                class="inline-flex items-center gap-2 bg-white/95 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-bold text-gray-900 shadow-lg">
                <svg class="w-4 h-4 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                    <path
                        d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                </svg>
                {{ ucfirst($course->category->name) }}
            </span>
        </div>

        @if ($course->is_new)
            <div class="absolute top-6 right-6">
                <span class="bg-teal-500 text-white px-3 py-1.5 rounded-full text-xs font-bold shadow-lg">
                    NEW
                </span>
            </div>
        @endif
    </div>

    {{-- Main Content Container --}}
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 -mt-20 lg:-mt-12 relative z-10">
        <div class="grid lg:grid-cols-3 gap-8">
            {{-- Main Content --}}
            <div class="lg:col-span-2">
                {{-- Course Header Card --}}
                <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8 mb-8 border border-gray-100">
                    <h1
                        class="font-serif text-3xl sm:text-4xl lg:text-5xl font-normal text-gray-900 mb-4 leading-tight">
                        {{ $course->title }}
                    </h1>

                    <div class="text-gray-600 leading-relaxed mb-4 transition-all duration-300"
                        :class="showFullDescription ? '' : 'line-clamp-3'">
                        {{ $course->description }}
                    </div>

                    <button @click="showFullDescription = !showFullDescription"
                        class="text-blue-600 hover:text-blue-700 text-sm font-semibold flex items-center gap-1 group">
                        <span x-text="showFullDescription ? 'Show less' : 'Read more'"></span>
                        <svg class="w-4 h-4 transition-transform" :class="showFullDescription ? 'rotate-180' : ''"
                            viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>

                    {{-- Course Meta --}}
                    <div class="flex flex-wrap items-center gap-6 mt-8 pt-8 border-t border-gray-200">
                        @if ($course->rating)
                            <div class="flex items-center gap-2">
                                <div class="flex items-center gap-1 text-yellow-500">
                                    @for ($i = 0; $i < 5; $i++)
                                        <svg class="w-5 h-5 {{ $i < floor($course->rating) ? 'fill-current' : 'fill-gray-300' }}"
                                            viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endfor
                                </div>
                                <span class="font-bold text-gray-900">{{ number_format($course->rating, 1) }}</span>
                                <span class="text-gray-600">({{ number_format($course->reviews_count ?? 0) }}
                                    reviews)</span>
                            </div>
                        @endif

                        @if ($course->students_count)
                            <div class="flex items-center gap-2 text-gray-600">
                                <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path
                                        d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                </svg>
                                <span class="font-medium">{{ number_format($course->students_count) }} students
                                    enrolled</span>
                            </div>
                        @endif

                        @if ($course->duration)
                            <div class="flex items-center gap-2 text-gray-600">
                                <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="font-medium">{{ $course->duration }}</span>
                            </div>
                        @endif
                    </div>

                    {{-- Instructor --}}
                    @if ($course->instructor)
                        <div
                            class="flex items-center gap-4 mt-6 p-5 bg-linear-to-br from-blue-50 to-teal-50 rounded-xl border border-blue-100">
                            <div
                                class="w-16 h-16 bg-linear-to-br from-blue-600 to-teal-600 rounded-full overflow-hidden flex-shrink-0 ring-4 ring-white shadow-lg">
                                @if ($course->instructor?->avatar)
                                    <img src="{{ $course->instructor?->avatar }}" alt="{{ $course->instructor->name }}"
                                        class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <span
                                            class="text-white font-bold text-2xl">{{ substr($course->instructor->name, 0, 1) }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-gray-600 font-medium uppercase tracking-wider mb-1">Course
                                    Instructor</p>
                                <p class="font-bold text-gray-900 text-lg truncate">{{ $course->instructor->name }}</p>
                                @if ($course->instructor->bio)
                                    <p class="text-sm text-gray-600 truncate">{{ $course->instructor->bio }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Tabs Navigation --}}
                <div
                    class="bg-white rounded-t-2xl shadow-sm border-b border-gray-200 overflow-x-auto scrollbar-hide sticky top-14 z-40">
                    <div class="flex gap-1 p-2 min-w-max">
                        <button x-on:click="activeTab = 'overview'"
                            class="px-6 py-3 rounded-xl font-semibold text-sm transition-all duration-300 whitespace-nowrap"
                            :class="activeTab === 'overview' ?
                                'bg-linear-to-r from-blue-600 to-teal-600 text-white shadow-lg' :
                                'text-gray-600 hover:bg-gray-50'">
                            Overview
                        </button>
                        {{-- <button x-on:click="activeTab = 'curriculum'"
                            class="px-6 py-3 rounded-xl font-semibold text-sm transition-all duration-300 whitespace-nowrap"
                            :class="activeTab === 'curriculum' ?
                                'bg-linear-to-r from-blue-600 to-teal-600 text-white shadow-lg' :
                                'text-gray-600 hover:bg-gray-50'">
                            Curriculum
                        </button> --}}
                        <button x-on:click="activeTab = 'reviews'"
                            class="px-6 py-3 rounded-xl font-semibold text-sm transition-all duration-300 whitespace-nowrap"
                            :class="activeTab === 'reviews' ?
                                'bg-linear-to-r from-blue-600 to-teal-600 text-white shadow-lg' :
                                'text-gray-600 hover:bg-gray-50'">
                            Reviews
                        </button>
                    </div>
                </div>

                {{-- Tab Content --}}
                <div class="bg-white rounded-b-2xl shadow-sm p-6 sm:p-8">
                    {{-- Overview Tab --}}
                    <div x-show="activeTab === 'overview'" x-transition>
                        <div class="space-y-8">
                            {{-- What You'll Learn --}}
                            @if ($course->objectives)
                                <div>
                                    <h2
                                        class="font-serif text-2xl font-normal text-gray-900 mb-6 flex items-center gap-3">
                                        <span
                                            class="w-1 h-8 bg-linear-to-b from-blue-600 to-teal-600 rounded-full"></span>
                                        What you'll learn
                                    </h2>
                                    <div class="grid sm:grid-cols-2 gap-4">
                                        @foreach ($course->objectives as $objective)
                                            <div class="flex gap-3 group">
                                                <div
                                                    class="flex-shrink-0 w-6 h-6 bg-linear-to-br from-teal-500 to-teal-600 rounded-full flex items-center justify-center mt-0.5 group-hover:scale-110 transition-transform">
                                                    <svg class="w-4 h-4 text-white" viewBox="0 0 20 20"
                                                        fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                                <p class="text-gray-700 flex-1 leading-relaxed">{{ $objective }}
                                                </p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- Requirements --}}
                            @if ($course->requirements)
                                <div>
                                    <h2
                                        class="font-serif text-2xl font-normal text-gray-900 mb-6 flex items-center gap-3">
                                        <span
                                            class="w-1 h-8 bg-linear-to-b from-blue-600 to-teal-600 rounded-full"></span>
                                        Requirements
                                    </h2>
                                    <div class="space-y-3">
                                        @foreach ($course->requirements as $requirement)
                                            <div class="flex gap-3">
                                                <svg class="w-5 h-5 text-gray-400 flex-shrink-0 mt-0.5"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                <p class="text-gray-700 flex-1">{{ $requirement }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- Course Features --}}
                            {{-- <div>
                                <h2 class="font-serif text-2xl font-normal text-gray-900 mb-6 flex items-center gap-3">
                                    <span class="w-1 h-8 bg-linear-to-b from-blue-600 to-teal-600 rounded-full"></span>
                                    This course includes
                                </h2>
                                <div class="grid sm:grid-cols-2 gap-4">
                                    @foreach ([['icon' => 'M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => '12 hours', 'subtitle' => 'Video content'], ['icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'title' => '24 articles', 'subtitle' => 'Reading materials'], ['icon' => 'M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z', 'title' => 'Mobile access', 'subtitle' => 'Learn anywhere'], ['icon' => 'M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7', 'title' => 'Certificate', 'subtitle' => 'On completion']] as $feature)
                                        <div
                                            class="flex items-center gap-4 p-4 bg-linear-to-br from-gray-50 to-blue-50 rounded-xl border border-gray-100 hover:shadow-md transition-all duration-300 group">
                                            <div
                                                class="w-12 h-12 bg-linear-to-br from-blue-600 to-teal-600 text-white rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                                                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2">
                                                    <path d="{{ $feature['icon'] }}" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-900">{{ $feature['title'] }}</p>
                                                <p class="text-sm text-gray-600">{{ $feature['subtitle'] }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div> --}}
                        </div>
                    </div>

                    {{-- Curriculum Tab --}}
                    <div x-show="activeTab === 'curriculum'" x-transition>
                        <div class="flex items-center justify-between mb-8">
                            <h2 class="font-serif text-2xl font-normal text-gray-900 flex items-center gap-3">
                                <span class="w-1 h-8 bg-linear-to-b from-blue-600 to-teal-600 rounded-full"></span>
                                Course Content
                            </h2>
                            <span class="text-sm text-gray-600 font-medium bg-gray-100 px-4 py-2 rounded-full">8
                                sections • 42 lectures</span>
                        </div>

                        <div class="space-y-3" x-data="{ openSection: 1 }">
                            @for ($i = 1; $i <= 5; $i++)
                                <div
                                    class="border border-gray-200 rounded-xl overflow-hidden hover:border-blue-300 transition-colors">
                                    <button
                                        @click="openSection = openSection === {{ $i }} ? null : {{ $i }}"
                                        class="w-full flex items-center justify-between p-5 bg-linear-to-r from-gray-50 to-blue-50 hover:from-blue-50 hover:to-teal-50 transition-all duration-300 group">
                                        <div class="flex items-center gap-4 flex-1 text-left">
                                            <div
                                                class="w-10 h-10 bg-white rounded-lg flex items-center justify-center group-hover:bg-linear-to-br group-hover:from-blue-600 group-hover:to-teal-600 transition-all duration-300">
                                                <svg class="w-5 h-5 text-gray-600 group-hover:text-white transition-all duration-300"
                                                    :class="openSection === {{ $i }} ? 'rotate-180' : ''"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-900">Section {{ $i }}:
                                                    Introduction to Advanced Topics</p>
                                                <p class="text-xs text-gray-600 mt-1">6 lectures • 45 min</p>
                                            </div>
                                        </div>
                                    </button>

                                    <div x-show="openSection === {{ $i }}" x-collapse class="bg-white">
                                        <div class="divide-y divide-gray-100">
                                            @for ($j = 1; $j <= 3; $j++)
                                                <div
                                                    class="flex items-center justify-between p-4 hover:bg-blue-50 transition-colors group">
                                                    <div class="flex items-center gap-3 flex-1">
                                                        <div
                                                            class="w-10 h-10 bg-linear-to-br from-blue-100 to-teal-100 group-hover:from-blue-600 group-hover:to-teal-600 rounded-lg flex items-center justify-center transition-all duration-300">
                                                            <svg class="w-5 h-5 text-blue-600 group-hover:text-white transition-colors"
                                                                viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd"
                                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                        </div>
                                                        <div>
                                                            <p class="text-sm font-medium text-gray-900">Lecture
                                                                {{ $j }}: Clinical Case Study Analysis</p>
                                                            <p class="text-xs text-gray-600">12:30 min</p>
                                                        </div>
                                                    </div>
                                                    @if ($j === 1)
                                                        <span
                                                            class="text-xs font-semibold text-blue-600 bg-blue-100 px-3 py-1 rounded-full">Preview</span>
                                                    @else
                                                        <svg class="w-5 h-5 text-gray-400" viewBox="0 0 20 20"
                                                            fill="currentColor">
                                                            <path fill-rule="evenodd"
                                                                d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    @endif
                                                </div>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>

                    {{-- Reviews Tab --}}
                    <div x-show="activeTab === 'reviews'" x-transition>
                        <div class="space-y-8">
                            @if ($this->reviews->count() > 0)
                                <livewire:review-list :course="$course"/>
                            @else
                                <div>There are no reviews for this course yet</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar - Enrollment Card --}}
            <div class="lg:col-span-1">
                <div class="sticky top-24 space-y-6">
                    {{-- Enrollment Card --}}
                    @if (!$isEnrolled)
                        <livewire:enrollment :course="$course"/>
                    @endif

                    {{-- Review Card (Only for enrolled users who haven't reviewed) --}}
                    @if ($isEnrolled)
                        <livewire:review :course="$course" />
                    @endif
                </div>
            </div>

        </div>

        {{-- Related Courses --}}
        @if ($relatedCourses->count() > 0)
            <div class="mt-16">
                <h2 class="font-serif text-3xl font-normal text-gray-900 mb-8 flex items-center gap-3">
                    <span class="w-1 h-10 bg-linear-to-b from-blue-600 to-teal-600 rounded-full"></span>
                    More in {{ ucfirst($course->category) }}
                </h2>
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($relatedCourses as $related)
                        <a href="{{ route('courses.show', $related) }}"
                            class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-gray-100">
                            <div
                                class="relative aspect-video bg-linear-to-br from-blue-500 to-teal-500 overflow-hidden">
                                @if ($related->image)
                                    <img src="{{ $related->image }}" alt="{{ $related->title }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @endif
                                <div class="absolute inset-0 bg-linear-to-t from-black/50 to-transparent"></div>
                                <div class="absolute bottom-3 left-3 right-3">
                                    <span
                                        class="bg-white/95 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold text-gray-900">
                                        {{ ucfirst($related->category) }}
                                    </span>
                                </div>
                            </div>
                            <div class="p-5">
                                <h3
                                    class="font-semibold text-gray-900 mb-2 line-clamp-2 leading-snug group-hover:text-blue-600 transition-colors">
                                    {{ $related->title }}
                                </h3>
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-600">{{ number_format($related->students_count) }}
                                        students</span>
                                    @if ($related->price > 0)
                                        <span
                                            class="font-bold text-blue-600">${{ number_format($related->price, 0) }}</span>
                                    @else
                                        <span class="font-bold text-teal-600">Free</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    {{-- Success Message --}}
    @if (session()->has('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" x-transition
            class="fixed top-24 left-4 right-4 mx-auto max-w-md z-50 bg-linear-to-r from-teal-500 to-teal-600 text-white px-6 py-4 rounded-xl shadow-2xl">
            <div class="flex items-center gap-3">
                <svg class="w-6 h-6" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                <p class="flex-1 font-medium">{{ session('success') }}</p>
            </div>
        </div>
    @endif
</div>

{{-- Tailwind Custom Styles --}}
<style>
    .font-serif {
        font-family: 'Instrument Serif', serif;
    }

    .font-sans {
        font-family: 'DM Sans', sans-serif;
    }

    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }

    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>
