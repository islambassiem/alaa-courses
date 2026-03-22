{{-- Import Google Fonts --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=DM+Sans:wght@400;500;600;700&display=swap"
    rel="stylesheet">

<div class="min-h-screen bg-white font-sans" x-data="{ mobileMenuOpen: false }">
    {{-- Hero Section --}}
    <section
        class="relative min-h-screen flex items-center overflow-hidden bg-gradient-to-br from-blue-50 via-white to-teal-50">
        {{-- Animated Background Elements --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            {{-- Gradient Orbs --}}
            <div
                class="absolute -top-40 -right-40 w-96 h-96 bg-gradient-to-br from-blue-400 to-teal-400 rounded-full opacity-20 blur-3xl animate-float">
            </div>
            <div
                class="absolute -bottom-40 -left-40 w-80 h-80 bg-gradient-to-br from-teal-400 to-blue-400 rounded-full opacity-20 blur-3xl animate-float-delayed">
            </div>
            <div
                class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-gradient-to-br from-blue-300 to-purple-300 rounded-full opacity-10 blur-3xl animate-float-slow">
            </div>

            {{-- Medical Grid Pattern --}}
            <div class="absolute inset-0 bg-grid-pattern opacity-5"></div>
        </div>

        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            {{-- Navigation --}}
            <nav class="py-6 mb-12 animate-slide-down">
                <div class="flex items-center justify-between ">
                    <div class="flex items-center gap-3">
                        <x-app-logo-icon />
                        <span class="text-2xl font-bold text-blue-900">{{ config('app.name') }}</span>
                    </div>
                    @auth
                        <div class="flex items-center justify-between gap-5">
                            <a href="{{ route('dashboard') }}" wire:navigate
                                class="hidden sm:block text-gray-700 hover:text-blue-600 font-medium px-4 py-2 transition-colors">
                                Dashboard
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="w-full">
                                @csrf
                                <flux:button variant="ghost" type="submit" icon="arrow-right-start-on-rectangle"
                                    >
                                    {{ __('Log out') }}
                                </flux:button>
                            </form>
                        </div>
                    @endauth
                    @guest
                        <div class="0">
                            <a href="{{ route('login') }}"
                                class="hidden sm:block text-gray-700 hover:text-blue-600 font-medium px-4 py-2 transition-colors">
                                Sign In
                            </a>
                            <a href="{{ route('register') }}"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2.5 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-0.5">
                                Get Started
                            </a>
                        </div>
                    @endguest
                </div>
            </nav>

            {{-- Hero Content --}}
            <div class="max-w-3xl mx-auto lg:mx-0 lg:max-w-2xl animate-fade-in-up">
                {{-- Badge --}}
                <div
                    class="inline-flex items-center gap-2 bg-white/80 backdrop-blur-sm border border-blue-200 px-4 py-2 rounded-full mb-8 shadow-sm">
                    <span class="relative flex h-2 w-2">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                    </span>
                    <span class="text-sm font-medium text-blue-900">Trusted by Medical Professionals Globally</span>
                </div>

                {{-- Main Heading --}}
                <h1 class="font-serif text-5xl sm:text-6xl lg:text-7xl font-normal leading-tight mb-6 text-gray-900">
                    Advance Your
                    <span class="italic text-blue-600">Medical Career</span>
                    On Your Terms
                </h1>

                {{-- Description --}}
                <p class="text-xl text-gray-600 leading-relaxed mb-10">
                    World-class medical education designed for busy healthcare professionals.
                    Learn from expert physicians, earn CME credits, and stay at the forefront of medicine.
                </p>

                {{-- CTA Buttons --}}
                <div class="flex flex-col sm:flex-row gap-4 mb-12">
                    <a href="{{ route('courses.index') }}" wire:navigate
                        class="group inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-4 rounded-xl shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-1">
                        Explore Courses
                        <flux:icon.arrow-right
                            class="size-5 font-extrabold group-hover:translate-x-1 transition-transform" />
                    </a>
                </div>

                {{-- Trust Badges --}}
                <div class="flex flex-wrap gap-6 text-sm text-gray-600">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-teal-600" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="font-medium">CME Accredited</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-teal-600" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="font-medium">Expert Instructors</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-teal-600" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="font-medium">Mobile Learning</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Stats Section --}}
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ([['icon' => 'M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z', 'number' => number_format($stats['courses']) . '+', 'label' => 'Medical Courses'], ['icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z', 'number' => number_format($stats['students']) . '+', 'label' => 'Healthcare Professionals'], ['icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'number' => $stats['satisfaction'] . '%', 'label' => 'Satisfaction Rate'], ['icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z', 'number' => number_format($stats['instructors']) . '+', 'label' => 'Expert Instructors']] as $index => $stat)
                    <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-lg transition-shadow duration-300 text-center animate-fade-in-up"
                        style="animation-delay: {{ $index * 100 }}ms">
                        <div class="w-12 h-12 mx-auto mb-4 text-blue-600">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="{{ $stat['icon'] }}" />
                            </svg>
                        </div>
                        <div class="font-serif text-4xl font-normal text-blue-600 mb-2">{{ $stat['number'] }}</div>
                        <div class="text-sm text-gray-600">{{ $stat['label'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Features Section --}}
    <section class="py-20">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Section Header --}}
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="font-serif text-4xl lg:text-5xl font-normal text-gray-900 mb-4">
                    Why Choose MedLearn?
                </h2>
                <p class="text-xl text-gray-600">
                    The most comprehensive medical education platform designed specifically for practicing healthcare
                    professionals
                </p>
            </div>

            {{-- Features Grid --}}
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ([
        ['icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', 'color' => 'blue', 'title' => 'Evidence-Based Content', 'description' => 'All courses are developed by board-certified physicians and backed by the latest clinical research and guidelines.'],
        ['icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'teal', 'title' => 'Learn On Your Schedule', 'description' => 'Access courses anytime, anywhere. Mobile-optimized platform lets you learn during breaks, commutes, or whenever you have time.'],
        ['icon' => 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z', 'color' => 'red', 'title' => 'CME Credits', 'description' => 'Earn continuing medical education credits while advancing your knowledge. All courses are fully accredited.'],
        ['icon' => 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z', 'color' => 'blue', 'title' => 'Case-Based Learning', 'description' => 'Apply knowledge with real clinical cases. Interactive scenarios help you develop critical thinking and decision-making skills.'],
        ['icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z', 'color' => 'teal', 'title' => 'Expert Community', 'description' => 'Connect with fellow healthcare professionals. Share insights, ask questions, and learn from collective experience.'],
        ['icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z', 'color' => 'red', 'title' => 'Track Your Progress', 'description' => 'Monitor your learning journey with detailed analytics. See your growth and maintain your competitive edge.'],
    ] as $index => $feature)
                    <div class="group p-8 bg-white border border-gray-200 rounded-2xl hover:border-{{ $feature['color'] }}-600 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 animate-fade-in-up"
                        style="animation-delay: {{ $index * 100 }}ms">
                        <div
                            class="w-14 h-14 bg-{{ $feature['color'] }}-100 text-{{ $feature['color'] }}-600 rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="{{ $feature['icon'] }}" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">{{ $feature['title'] }}</h3>
                        <p class="text-gray-600 leading-relaxed">{{ $feature['description'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Featured Courses --}}
    @if ($featuredCourses->count() > 0)
        <section class="py-20 bg-gray-50">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                {{-- Section Header --}}
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <h2 class="font-serif text-4xl lg:text-5xl font-normal text-gray-900 mb-4">
                        Featured Courses
                    </h2>
                    <p class="text-xl text-gray-600">
                        Explore our most popular and recently added courses
                    </p>
                </div>

                {{-- Courses Grid --}}
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                    @foreach ($featuredCourses as $index => $course)
                        <livewire:course-card :key="$index" :course="$course" />
                    @endforeach
                </div>

                {{-- View All Button --}}
                <div class="text-center">
                    <a href="{{ route('courses.index') }}" wire:navigate
                        class="inline-flex items-center gap-2 bg-white hover:bg-blue-600 text-blue-600 hover:text-white font-semibold px-8 py-4 rounded-xl border-2 border-blue-600 transition-all duration-300 hover:-translate-y-1 shadow-lg hover:shadow-xl">
                        View All Courses
                        <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>
        </section>
    @endif

    {{-- Testimonials Section --}}
    <section class="py-20 relative overflow-hidden">
        {{-- Background --}}
        <div class="absolute inset-0 bg-gradient-to-br from-blue-50/50 via-transparent to-teal-50/50"></div>

        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative">
            {{-- Section Header --}}
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="font-serif text-4xl lg:text-5xl font-normal text-gray-900 mb-4">
                    Trusted by Medical Professionals
                </h2>
                <p class="text-xl text-gray-600">
                    See what physicians are saying about their learning experience
                </p>
            </div>

            {{-- Testimonials Grid --}}
            <div class="grid md:grid-cols-3 gap-8">
                @foreach ($testimonials as $index => $testimonial)
                    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 animate-fade-in-up"
                        style="animation-delay: {{ $index * 150 }}ms">
                        {{-- Stars --}}
                        <div class="flex gap-1 mb-4 text-yellow-400">
                            @for ($i = 0; $i < 5; $i++)
                                <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            @endfor
                        </div>

                        {{-- Content --}}
                        <p class="text-gray-700 leading-relaxed mb-6 italic">
                            "{{ $testimonial['content'] }}"
                        </p>

                        {{-- Author --}}
                        <div class="flex items-center gap-3">
                            <div
                                class="w-12 h-12 bg-blue-600 text-white rounded-full flex items-center justify-center font-semibold text-lg">
                                {{ substr($testimonial['name'], 0, 1) }}
                            </div>
                            <div>
                                <div class="font-semibold text-gray-900">{{ $testimonial['name'] }}</div>
                                <div class="text-sm text-gray-600">{{ $testimonial['role'] }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section
        class="py-20 bg-gradient-to-br from-blue-600 via-blue-700 to-blue-800 text-white relative overflow-hidden">
        {{-- Background Pattern --}}
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0 bg-grid-pattern"></div>
        </div>

        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="font-serif text-4xl lg:text-5xl font-normal mb-6">
                    Ready to Advance Your Medical Career?
                </h2>
                <p class="text-xl text-blue-100 mb-10 leading-relaxed">
                    Join thousands of healthcare professionals who are staying ahead with MedLearn.
                    Start your first course today.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center mb-6">
                    <a href="{{ route('register') }}"
                        class="group inline-flex items-center justify-center gap-2 bg-white hover:bg-gray-50 text-blue-600 font-semibold px-8 py-4 rounded-xl shadow-2xl hover:shadow-3xl transition-all duration-300 hover:-translate-y-1">
                        Start Learning
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="{{ route('courses.index') }}" wire:navigate
                        class="inline-flex items-center justify-center gap-2 bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white font-semibold px-8 py-4 rounded-xl border-2 border-white/30 hover:border-white/50 transition-all duration-300">
                        Browse Courses
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-gray-900 text-gray-400 py-16">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 lg:grid-cols-5 gap-12 mb-12">
                {{-- Brand --}}
                <div class="lg:col-span-2">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M12 2L2 7L12 12L22 7L12 2Z" />
                                <path d="M2 17L12 22L22 17" />
                                <path d="M2 12L12 17L22 12" />
                            </svg>
                        </div>
                        <span class="text-2xl font-bold text-white">MedLearn</span>
                    </div>
                    <p class="text-sm leading-relaxed max-w-sm">
                        Empowering healthcare professionals with world-class medical education.
                    </p>
                </div>

                {{-- Links --}}
                <div>
                    <h4 class="text-white font-semibold mb-4 text-sm uppercase tracking-wider">Platform</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="{{ route('courses.index') }}" wire:navigate
                                class="hover:text-white transition-colors">Browse Courses</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Specialties</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">CME Credits</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Pricing</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-semibold mb-4 text-sm uppercase tracking-wider">Company</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="#" class="hover:text-white transition-colors">About Us</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Instructors</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Contact</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Careers</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-semibold mb-4 text-sm uppercase tracking-wider">Support</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="#" class="hover:text-white transition-colors">Help Center</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Terms of Service</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Accreditation</a></li>
                    </ul>
                </div>
            </div>

            {{-- Bottom Bar --}}
            <div class="flex flex-col sm:flex-row justify-between items-center pt-8 border-t border-gray-800 text-sm">
                <p>&copy; {{ date('Y') }} MedLearn. All rights reserved.</p>
                <div class="flex gap-4 mt-4 sm:mt-0">
                    <a href="#"
                        class="w-9 h-9 bg-gray-800 hover:bg-gray-700 rounded-lg flex items-center justify-center transition-colors"
                        aria-label="Twitter">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z" />
                        </svg>
                    </a>
                    <a href="#"
                        class="w-9 h-9 bg-gray-800 hover:bg-gray-700 rounded-lg flex items-center justify-center transition-colors"
                        aria-label="LinkedIn">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z" />
                            <circle cx="4" cy="4" r="2" />
                        </svg>
                    </a>
                    <a href="#"
                        class="w-9 h-9 bg-gray-800 hover:bg-gray-700 rounded-lg flex items-center justify-center transition-colors"
                        aria-label="YouTube">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M23 12s0-3.85-.46-5.58A2.9 2.9 0 0020.52 4.4C18.88 4 12 4 12 4s-6.88 0-8.52.46a2.9 2.9 0 00-2.02 2.02C1 8.15 1 12 1 12s0 3.85.46 5.58a2.9 2.9 0 002.02 2.02C5.12 20 12 20 12 20s6.88 0 8.52-.46a2.9 2.9 0 002.02-2.02C23 15.85 23 12 23 12z" />
                            <polygon points="10 15 15 12 10 9 10 15" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>
</div>

{{-- Custom Tailwind Animations --}}
<style>
    @layer utilities {
        @font-face {
            font-family: 'Instrument Serif';
            font-display: swap;
        }

        @font-face {
            font-family: 'DM Sans';
            font-display: swap;
        }

        .font-serif {
            font-family: 'Instrument Serif', serif;
        }

        .font-sans {
            font-family: 'DM Sans', sans-serif;
        }

        @keyframes float {

            0%,
            100% {
                transform: translate(0, 0) scale(1);
            }

            33% {
                transform: translate(30px, -30px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }
        }

        @keyframes float-delayed {

            0%,
            100% {
                transform: translate(0, 0) scale(1);
            }

            33% {
                transform: translate(-30px, 30px) scale(1.1);
            }

            66% {
                transform: translate(20px, -20px) scale(0.9);
            }
        }

        @keyframes float-slow {

            0%,
            100% {
                transform: translate(-50%, -50%) scale(1);
            }

            50% {
                transform: translate(calc(-50% + 20px), calc(-50% + 20px)) scale(1.05);
            }
        }

        @keyframes slide-down {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fade-in-up {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-float {
            animation: float 20s ease-in-out infinite;
        }

        .animate-float-delayed {
            animation: float-delayed 20s ease-in-out infinite;
        }

        .animate-float-slow {
            animation: float-slow 25s ease-in-out infinite;
        }

        .animate-slide-down {
            animation: slide-down 0.6s ease-out;
        }

        .animate-fade-in-up {
            animation: fade-in-up 0.8s ease-out both;
        }

        .bg-grid-pattern {
            background-image:
                linear-gradient(rgba(0, 0, 0, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 0, 0, 0.05) 1px, transparent 1px);
            background-size: 50px 50px;
        }
    }
</style>
