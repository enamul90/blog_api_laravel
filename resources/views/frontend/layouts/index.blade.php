<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

    <style>
        /* Custom font for a modern look */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        /* Smooth fade transition utility */
        [x-cloak] {
            display: none !important;
        }
    </style>

</head>

<body class="bg-whid">

    <nav class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Left: Brand -->
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="text-xl font-semibold text-[#3498db]">MySite</a>
                </div>

                <!-- Center/Right: Links (desktop) -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ url('/') }}" class="text-gray-700 hover:text-indigo-600">Home</a>
                    <a href="{{ url('/about') }}" class="text-gray-700 hover:text-indigo-600">About</a>
                    <a href="{{ url('/services') }}" class="text-gray-700 hover:text-indigo-600">Services</a>
                    <a href="{{ url('/contact') }}" class="text-gray-700 hover:text-indigo-600">Contact</a>
                </div>

                <!-- Mobile menu button -->
                <button
                    id="menuBtn"
                    class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:text-indigo-600 hover:bg-gray-100 focus:outline-none"
                    aria-label="Toggle menu"
                    aria-controls="mobileMenu"
                    aria-expanded="false">
                    <!-- Hamburger icon -->
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile menu -->
        <div id="mobileMenu" class="md:hidden hidden px-4 pb-4 space-y-2 text-center">
            <a href="{{ url('/') }}" class="block px-3 py-2 rounded-md text-gray-700 hover:text-indigo-600 hover:bg-gray-100">Home</a>
            <a href="{{ url('/about') }}" class="block px-3 py-2 rounded-md text-gray-700 hover:text-indigo-600 hover:bg-gray-100">About</a>
            <a href="{{ url('/services') }}" class="block px-3 py-2 rounded-md text-gray-700 hover:text-indigo-600 hover:bg-gray-100">Services</a>
            <a href="{{ url('/contact') }}" class="block px-3 py-2 rounded-md text-gray-700 hover:text-indigo-600 hover:bg-gray-100">Contact</a>
        </div>
    </nav>

    <main class="w-full">
        <section
            x-data="{ 
            activeSlide: 0, 
            slides: [
                { 
                    title: 'Welcome to MySite', 
                    text: 'Discover amazing features and services tailored for you.', 
                    bg: 'bg-neutarl-600',
                    icon: 'rocket_launch'
                },
                { 
                    title: 'Tailwind + Alpine.js', 
                    text: 'Build reactive, modern UIs quickly and efficiently.', 
                    bg: 'bg-neutarl-600',
                    icon: 'code'
                },
                { 
                    title: 'Responsive Design', 
                    text: 'Seamless experience across mobile, tablet, and desktop.', 
                    bg: 'bg-neutarl-600',
                    icon: 'devices'
                }
            ],
            nextSlide() {
                this.activeSlide = (this.activeSlide === this.slides.length - 1 ? 0 : this.activeSlide + 1);
            },
            prevSlide() {
                this.activeSlide = (this.activeSlide === 0 ? this.slides.length - 1 : this.activeSlide - 1);
            }
        }"
            x-init="setInterval(() => nextSlide(), 5000)"
            class="relative w-full h-[500px] md:h-[600px] overflow-hidden bg-[#34495e] group">
            <!-- Slides Loop -->
            <template x-for="(slide, index) in slides" :key="index">
                <div
                    x-show="activeSlide === index"
                    class="absolute inset-0 flex flex-col items-center justify-center text-center px-6 text-white"
                    :class="slide.bg"
                    x-cloak>
                    <!-- Dynamic Icon per slide -->
                    <div
                        class="h-16 w-16 flex items-center justify-center bg-white/20 backdrop-blur-sm rounded-full">
                        <span
                            class="material-symbols-outlined text-5xl"
                            x-text="slide.icon">
                        </span>
                    </div>

                    <h2
                        class="text-4xl md:text-6xl font-extrabold mb-4 tracking-tight drop-shadow-md"
                        x-text="slide.title"></h2>

                    <p
                        class="text-lg md:text-xl mb-8 max-w-2xl text-white/90 font-light"
                        x-text="slide.text"></p>

                    <a
                        href="#"
                        class="bg-[#1abc9c] hover:bg-[#3498db] text-white px-8 py-3 rounded-full font-bold shadow-lg  hover:scale-105 transition-all duration-300 transform">
                        Learn More
                    </a>
                </div>
            </template>

            <!-- Navigation Controls (Left/Right) -->
            <!-- Only show buttons on hover for desktop, always visible on mobile? Let's make them always visible but subtle -->
            <div
                class="absolute inset-0 flex items-center justify-between px-4 md:px-8 pointer-events-none">
                <!-- Previous Button -->
                <button
                    @click="prevSlide()"
                    class="cursor-pointer pointer-events-auto bg-white/10 hover:bg-white hover:text-[#3498db] backdrop-blur-md border border-white/30 rounded-full h-12 w-12 md:h-14 md:w-14 flex items-center justify-center transition-all duration-300 transform hover:scale-110 focus:outline-none focus:ring-2 focus:ring-white/50 group/btn">
                    <span
                        class="material-symbols-outlined text-white group-hover/btn:text-[#3498db] transition-colors">
                        arrow_back_ios
                    </span>
                </button>

                <!-- Next Button -->
                <button
                    @click="nextSlide()"
                    class="cursor-pointer pointer-events-auto bg-white/10 hover:bg-white hover:text-[#3498db] backdrop-blur-md border border-white/30 rounded-full h-12 w-12 md:h-14 md:w-14 flex items-center justify-center transition-all duration-300 transform hover:scale-110 focus:outline-none focus:ring-2 focus:ring-white/50 group/btn">
                    <span
                        class="material-symbols-outlined text-white group-hover/btn:text-[#3498db] transition-colors">
                        arrow_forward_ios
                    </span>
                </button>
            </div>

            <!-- Indicators (Bottom Dots) -->
            <div
                class="absolute bottom-6 left-1/2 transform -translate-x-1/2 flex space-x-3 pointer-events-auto">
                <template x-for="(slide, index) in slides" :key="index">
                    <button
                        @click="activeSlide = index"
                        :class="activeSlide === index ? 'bg-white w-8 scale-110' : 'bg-white/40 hover:bg-white/70 w-3'"
                        class="h-3 rounded-full transition-all duration-300 ease-out shadow-sm"
                        aria-label="Go to slide index + 1"></button>
                </template>
            </div>
        </section>


        <!-- blog section -->
        <section class="max-w-3xl mx-auto text-center mt-12 px-4">

        </section>
    </main>
</body>


</html>