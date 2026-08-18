@extends('layouts.frontend')

@section('title', 'About Us')

@section('content')

    <!-- Slide 01: Cover Header -->
    <div class="relative bg-gradient-to-br from-[#FAF6F0] via-white to-[#FAF6F0] py-20 border-b border-gray-150/70 overflow-hidden text-center">
        <!-- Background elements -->
        <div class="absolute inset-0 opacity-40 mix-blend-overlay bg-cover bg-center" style="background-image: url('{{ asset('images/about_hero_banner.png') }}');"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-[#C49A6C]/5 rounded-full blur-3xl pointer-events-none"></div>
        
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 space-y-6">
            <img src="{{ asset('images/logo.png') }}" alt="Vedic Botanica Logo" class="h-20 w-auto object-contain mx-auto bg-white rounded-full p-2 border border-[#C49A6C]/20 shadow-md">
            
            <h1 class="text-4xl sm:text-5xl font-serif font-bold text-gray-955 uppercase tracking-widest">Vedic Botanica</h1>
            <p class="text-xs text-[#C49A6C] uppercase font-bold tracking-widest font-serif block">360° Vedic Essence of Life</p>
            
            <p class="text-lg sm:text-2xl font-serif italic text-gray-800 max-w-2xl mx-auto">
                "Nature Perfected. Tradition Elevated."
            </p>
            
            <div class="w-24 h-[1px] bg-[#C49A6C] mx-auto my-4"></div>
            
            <!-- Trust badges list -->
            <div class="flex flex-wrap justify-center items-center gap-4 sm:gap-6 text-[10px] sm:text-xs font-bold text-gray-650 uppercase tracking-widest font-sans">
                <span class="flex items-center gap-1.5 bg-white/80 backdrop-blur-md px-3 py-1.5 rounded-full border border-[#C49A6C]/10"><i class="fa-solid fa-circle-check text-[#C49A6C]"></i> Pure</span>
                <span class="flex items-center gap-1.5 bg-white/80 backdrop-blur-md px-3 py-1.5 rounded-full border border-[#C49A6C]/10"><i class="fa-solid fa-circle-check text-[#C49A6C]"></i> Natural</span>
                <span class="flex items-center gap-1.5 bg-white/80 backdrop-blur-md px-3 py-1.5 rounded-full border border-[#C49A6C]/10"><i class="fa-solid fa-circle-check text-[#C49A6C]"></i> Authentic</span>
                <span class="flex items-center gap-1.5 bg-white/80 backdrop-blur-md px-3 py-1.5 rounded-full border border-[#C49A6C]/10"><i class="fa-solid fa-circle-check text-[#C49A6C]"></i> Sustainable</span>
                <span class="flex items-center gap-1.5 bg-white/80 backdrop-blur-md px-3 py-1.5 rounded-full border border-[#C49A6C]/10"><i class="fa-solid fa-circle-check text-[#C49A6C]"></i> Premium</span>
            </div>
        </div>
    </div>

    <!-- Slide 02: Our Story -->
    <div id="story" class="bg-white py-16 sm:py-24 relative overflow-hidden">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Content -->
                <div class="space-y-6">
                    <span class="text-xs text-[#C49A6C] font-bold uppercase tracking-widest bg-[#C49A6C]/10 px-3.5 py-1.5 rounded-full font-serif">OUR STORY</span>
                    <h2 class="text-3xl sm:text-4xl font-serif font-bold text-gray-900 leading-tight">Rooted in Vedic Wisdom.<br>Inspired by Nature.</h2>
                    <div class="w-16 h-1 bg-[#C49A6C] rounded-full"></div>
                    
                    <p class="text-sm sm:text-base text-gray-600 leading-relaxed font-sans">
                        Vedic Botanica is born from the timeless wisdom of the Vedas and the rich botanical heritage of India. We create natural and spiritually enriching products that purify your space, calm your mind and elevate your everyday rituals.
                    </p>
                    <p class="text-sm sm:text-base text-gray-600 leading-relaxed font-sans">
                        Each product is a blend of ancient traditions, pure ingredients and modern quality standards – crafted with devotion, care and purpose.
                    </p>
                </div>
                
                <!-- Grid Values -->
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-2 gap-6">
                    <div class="bg-[#FAF6F0]/40 border border-[#C49A6C]/15 rounded-2xl p-5 text-center transition hover:border-[#C49A6C]">
                        <div class="w-10 h-10 rounded-full bg-white border border-[#C49A6C]/25 flex items-center justify-center mx-auto mb-3 text-[#C49A6C] shadow-xs">
                            <i class="fa-solid fa-book-open text-xs"></i>
                        </div>
                        <h4 class="font-serif font-bold text-gray-900 text-xs sm:text-sm uppercase tracking-wide">Ancient Wisdom</h4>
                    </div>

                    <div class="bg-[#FAF6F0]/40 border border-[#C49A6C]/15 rounded-2xl p-5 text-center transition hover:border-[#C49A6C]">
                        <div class="w-10 h-10 rounded-full bg-white border border-[#C49A6C]/25 flex items-center justify-center mx-auto mb-3 text-[#C49A6C] shadow-xs">
                            <i class="fa-solid fa-tree text-xs"></i>
                        </div>
                        <h4 class="font-serif font-bold text-gray-900 text-xs sm:text-sm uppercase tracking-wide">Botanical Heritage</h4>
                    </div>

                    <div class="bg-[#FAF6F0]/40 border border-[#C49A6C]/15 rounded-2xl p-5 text-center transition hover:border-[#C49A6C]">
                        <div class="w-10 h-10 rounded-full bg-white border border-[#C49A6C]/25 flex items-center justify-center mx-auto mb-3 text-[#C49A6C] shadow-xs">
                            <i class="fa-solid fa-flask text-xs"></i>
                        </div>
                        <h4 class="font-serif font-bold text-gray-900 text-xs sm:text-sm uppercase tracking-wide">Pure Ingredients</h4>
                    </div>

                    <div class="bg-[#FAF6F0]/40 border border-[#C49A6C]/15 rounded-2xl p-5 text-center transition hover:border-[#C49A6C]">
                        <div class="w-10 h-10 rounded-full bg-white border border-[#C49A6C]/25 flex items-center justify-center mx-auto mb-3 text-[#C49A6C] shadow-xs">
                            <i class="fa-solid fa-circle-check text-xs"></i>
                        </div>
                        <h4 class="font-serif font-bold text-gray-900 text-xs sm:text-sm uppercase tracking-wide">Modern Quality</h4>
                    </div>

                    <div class="bg-[#FAF6F0]/40 border border-[#C49A6C]/15 rounded-2xl p-5 text-center transition hover:border-[#C49A6C] col-span-2 sm:col-span-1 lg:col-span-2">
                        <div class="w-10 h-10 rounded-full bg-white border border-[#C49A6C]/25 flex items-center justify-center mx-auto mb-3 text-[#C49A6C] shadow-xs">
                            <i class="fa-solid fa-hands-praying text-xs"></i>
                        </div>
                        <h4 class="font-serif font-bold text-gray-900 text-xs sm:text-sm uppercase tracking-wide">Crafted With Devotion</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Slide 03: Our Philosophy -->
    <div id="philosophy" class="bg-[#FAF6F0]/40 py-16 sm:py-24 border-t border-b border-gray-150/70 relative overflow-hidden">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-12">
            <div class="space-y-4">
                <span class="text-xs text-[#C49A6C] font-bold uppercase tracking-widest bg-[#C49A6C]/10 px-3.5 py-1.5 rounded-full font-serif">OUR PHILOSOPHY</span>
                <h2 class="text-3xl sm:text-4xl font-serif font-bold text-gray-900">Our Philosophy</h2>
                <div class="w-16 h-1 bg-[#C49A6C] mx-auto mt-4 rounded-full"></div>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 text-center">
                <!-- Purity -->
                <div class="bg-white border border-[#C49A6C]/15 rounded-2xl p-6 shadow-xs hover:border-[#C49A6C] transition duration-300">
                    <div class="w-12 h-12 rounded-full bg-[#FAF6F0] border border-[#C49A6C]/20 flex items-center justify-center mx-auto mb-4 text-[#C49A6C]">
                        <i class="fa-solid fa-hands text-sm"></i>
                    </div>
                    <h4 class="font-serif font-bold text-gray-900 text-sm uppercase tracking-wider mb-2">Purity</h4>
                    <p class="text-xs text-gray-500 font-sans leading-relaxed">We use pure, natural and ethically sourced ingredients.</p>
                </div>

                <!-- Authenticity -->
                <div class="bg-white border border-[#C49A6C]/15 rounded-2xl p-6 shadow-xs hover:border-[#C49A6C] transition duration-300">
                    <div class="w-12 h-12 rounded-full bg-[#FAF6F0] border border-[#C49A6C]/20 flex items-center justify-center mx-auto mb-4 text-[#C49A6C]">
                        <i class="fa-solid fa-sun text-sm"></i>
                    </div>
                    <h4 class="font-serif font-bold text-gray-900 text-sm uppercase tracking-wider mb-2">Authenticity</h4>
                    <p class="text-xs text-gray-500 font-sans leading-relaxed">Inspired by Vedic traditions and time-honored practices.</p>
                </div>

                <!-- Sustainability -->
                <div class="bg-white border border-[#C49A6C]/15 rounded-2xl p-6 shadow-xs hover:border-[#C49A6C] transition duration-300">
                    <div class="w-12 h-12 rounded-full bg-[#FAF6F0] border border-[#C49A6C]/20 flex items-center justify-center mx-auto mb-4 text-[#C49A6C]">
                        <i class="fa-solid fa-globe text-sm"></i>
                    </div>
                    <h4 class="font-serif font-bold text-gray-900 text-sm uppercase tracking-wider mb-2">Sustainability</h4>
                    <p class="text-xs text-gray-500 font-sans leading-relaxed">Committed to eco-friendly and responsible practices.</p>
                </div>

                <!-- Mindful Living -->
                <div class="bg-white border border-[#C49A6C]/15 rounded-2xl p-6 shadow-xs hover:border-[#C49A6C] transition duration-300">
                    <div class="w-12 h-12 rounded-full bg-[#FAF6F0] border border-[#C49A6C]/20 flex items-center justify-center mx-auto mb-4 text-[#C49A6C]">
                        <i class="fa-solid fa-peace text-sm"></i>
                    </div>
                    <h4 class="font-serif font-bold text-gray-900 text-sm uppercase tracking-wider mb-2">Mindful Living</h4>
                    <p class="text-xs text-gray-500 font-sans leading-relaxed">Our products support a balanced, peaceful and conscious life.</p>
                </div>
            </div>
            
            <!-- Beautiful Quote -->
            <div class="bg-white border border-[#C49A6C]/20 rounded-3xl p-8 max-w-2xl mx-auto shadow-sm relative">
                <span class="absolute -top-6 left-1/2 transform -translate-x-1/2 bg-[#C49A6C] text-white w-12 h-12 rounded-full flex items-center justify-center text-2xl font-serif shadow-md border-2 border-white">“</span>
                <p class="text-lg sm:text-xl font-serif italic text-gray-800 mt-4 leading-relaxed">
                    "When nature is pure, everything in life becomes beautiful."
                </p>
            </div>
        </div>
    </div>

    <!-- Slide 04: Our Ingredients -->
    <div id="ingredients" class="bg-white py-16 sm:py-24 relative overflow-hidden">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-12">
            <div class="space-y-4">
                <span class="text-xs text-[#C49A6C] font-bold uppercase tracking-widest bg-[#C49A6C]/10 px-3.5 py-1.5 rounded-full font-serif">INGREDIENTS</span>
                <h2 class="text-3xl sm:text-4xl font-serif font-bold text-gray-900">The Finest Gifts from Nature</h2>
                <div class="w-16 h-1 bg-[#C49A6C] mx-auto mt-4 rounded-full"></div>
            </div>

            <!-- 8 Ingredients Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <!-- Ingredient 1 -->
                <div class="group flex flex-col items-center">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-[#FAF6F0] border border-[#C49A6C]/20 flex items-center justify-center group-hover:bg-[#C49A6C] group-hover:text-white transition duration-300 ring-6 ring-[#C49A6C]/5 shadow-xs">
                        <i class="fa-solid fa-cow text-xl sm:text-2xl text-[#C49A6C] group-hover:text-white transition duration-300"></i>
                    </div>
                    <h4 class="font-serif font-bold text-gray-900 text-xs sm:text-sm uppercase tracking-wider mt-3">Desi Cow Dung</h4>
                    <p class="text-[11px] text-gray-500 font-sans mt-0.5 leading-relaxed">Naturally purifying and sacred.</p>
                </div>

                <!-- Ingredient 2 -->
                <div class="group flex flex-col items-center">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-[#FAF6F0] border border-[#C49A6C]/20 flex items-center justify-center group-hover:bg-[#C49A6C] group-hover:text-white transition duration-300 ring-6 ring-[#C49A6C]/5 shadow-xs">
                        <i class="fa-solid fa-fire text-xl sm:text-2xl text-[#C49A6C] group-hover:text-white transition duration-300"></i>
                    </div>
                    <h4 class="font-serif font-bold text-gray-900 text-xs sm:text-sm uppercase tracking-wider mt-3">Guggul</h4>
                    <p class="text-[11px] text-gray-500 font-sans mt-0.5 leading-relaxed">Known for its cleansing properties.</p>
                </div>

                <!-- Ingredient 3 -->
                <div class="group flex flex-col items-center">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-[#FAF6F0] border border-[#C49A6C]/20 flex items-center justify-center group-hover:bg-[#C49A6C] group-hover:text-white transition duration-300 ring-6 ring-[#C49A6C]/5 shadow-xs">
                        <i class="fa-solid fa-wind text-xl sm:text-2xl text-[#C49A6C] group-hover:text-white transition duration-300"></i>
                    </div>
                    <h4 class="font-serif font-bold text-gray-900 text-xs sm:text-sm uppercase tracking-wider mt-3">Loban</h4>
                    <p class="text-[11px] text-gray-500 font-sans mt-0.5 leading-relaxed">Traditional resin for positivity.</p>
                </div>

                <!-- Ingredient 4 -->
                <div class="group flex flex-col items-center">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-[#FAF6F0] border border-[#C49A6C]/20 flex items-center justify-center group-hover:bg-[#C49A6C] group-hover:text-white transition duration-300 ring-6 ring-[#C49A6C]/5 shadow-xs">
                        <i class="fa-solid fa-tree text-xl sm:text-2xl text-[#C49A6C] group-hover:text-white transition duration-300"></i>
                    </div>
                    <h4 class="font-serif font-bold text-gray-900 text-xs sm:text-sm uppercase tracking-wider mt-3">Sandalwood</h4>
                    <p class="text-[11px] text-gray-500 font-sans mt-0.5 leading-relaxed">Soothing, fragrant and divine.</p>
                </div>

                <!-- Ingredient 5 -->
                <div class="group flex flex-col items-center">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-[#FAF6F0] border border-[#C49A6C]/20 flex items-center justify-center group-hover:bg-[#C49A6C] group-hover:text-white transition duration-300 ring-6 ring-[#C49A6C]/5 shadow-xs">
                        <i class="fa-solid fa-circle-notch text-xl sm:text-2xl text-[#C49A6C] group-hover:text-white transition duration-300"></i>
                    </div>
                    <h4 class="font-serif font-bold text-gray-900 text-xs sm:text-sm uppercase tracking-wider mt-3">Kapoor</h4>
                    <p class="text-[11px] text-gray-500 font-sans mt-0.5 leading-relaxed">Purifies and refreshes.</p>
                </div>

                <!-- Ingredient 6 -->
                <div class="group flex flex-col items-center">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-[#FAF6F0] border border-[#C49A6C]/20 flex items-center justify-center group-hover:bg-[#C49A6C] group-hover:text-white transition duration-300 ring-6 ring-[#C49A6C]/5 shadow-xs">
                        <i class="fa-solid fa-droplet text-xl sm:text-2xl text-[#C49A6C] group-hover:text-white transition duration-300"></i>
                    </div>
                    <h4 class="font-serif font-bold text-gray-900 text-xs sm:text-sm uppercase tracking-wider mt-3">Essential Oils</h4>
                    <p class="text-[11px] text-gray-500 font-sans mt-0.5 leading-relaxed">Natural aroma for well-being.</p>
                </div>

                <!-- Ingredient 7 -->
                <div class="group flex flex-col items-center">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-[#FAF6F0] border border-[#C49A6C]/20 flex items-center justify-center group-hover:bg-[#C49A6C] group-hover:text-white transition duration-300 ring-6 ring-[#C49A6C]/5 shadow-xs">
                        <i class="fa-solid fa-leaf text-xl sm:text-2xl text-[#C49A6C] group-hover:text-white transition duration-300"></i>
                    </div>
                    <h4 class="font-serif font-bold text-gray-900 text-xs sm:text-sm uppercase tracking-wider mt-3">Botanical Herbs</h4>
                    <p class="text-[11px] text-gray-500 font-sans mt-0.5 leading-relaxed">Handpicked for purity and quality.</p>
                </div>

                <!-- Ingredient 8 -->
                <div class="group flex flex-col items-center">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-[#FAF6F0] border border-[#C49A6C]/20 flex items-center justify-center group-hover:bg-[#C49A6C] group-hover:text-white transition duration-300 ring-6 ring-[#C49A6C]/5 shadow-xs">
                        <i class="fa-solid fa-filter text-xl sm:text-2xl text-[#C49A6C] group-hover:text-white transition duration-300"></i>
                    </div>
                    <h4 class="font-serif font-bold text-gray-900 text-xs sm:text-sm uppercase tracking-wider mt-3">Natural Resins</h4>
                    <p class="text-[11px] text-gray-500 font-sans mt-0.5 leading-relaxed">Enhances fragrance and efficacy.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Slide 06: Why Choose Vedic Botanica -->
    <div id="why-choose" class="bg-[#FAF6F0]/40 py-16 sm:py-24 border-t border-b border-gray-150/70 relative overflow-hidden">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-12">
            <div class="space-y-4">
                <span class="text-xs text-[#C49A6C] font-bold uppercase tracking-widest bg-[#C49A6C]/10 px-3.5 py-1.5 rounded-full font-serif">WHY US</span>
                <h2 class="text-3xl sm:text-4xl font-serif font-bold text-gray-900">Why Choose Vedic Botanica?</h2>
                <div class="w-16 h-1 bg-[#C49A6C] mx-auto mt-4 rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-center">
                <!-- Left features -->
                <div class="space-y-6 text-right flex flex-col items-end">
                    <div class="flex items-start gap-4">
                        <div class="flex-grow">
                            <h4 class="font-serif font-bold text-gray-900 text-sm sm:text-base">Premium Quality</h4>
                            <p class="text-xs text-gray-500 font-sans mt-1">Uncompromising quality in every product.</p>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-white border border-[#C49A6C]/35 flex items-center justify-center text-[#C49A6C] flex-shrink-0 shadow-xs">
                            <i class="fa-solid fa-award text-xs"></i>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="flex-grow">
                            <h4 class="font-serif font-bold text-gray-900 text-sm sm:text-base">Natural & Safe</h4>
                            <p class="text-xs text-gray-500 font-sans mt-1">100% charcoal-free & chemical-free.</p>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-white border border-[#C49A6C]/35 flex items-center justify-center text-[#C49A6C] flex-shrink-0 shadow-xs">
                            <i class="fa-solid fa-shield-halved text-xs"></i>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="flex-grow">
                            <h4 class="font-serif font-bold text-gray-900 text-sm sm:text-base">Eco-Conscious</h4>
                            <p class="text-xs text-gray-500 font-sans mt-1">Eco-friendly and sustainable products.</p>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-white border border-[#C49A6C]/35 flex items-center justify-center text-[#C49A6C] flex-shrink-0 shadow-xs">
                            <i class="fa-solid fa-leaf text-xs"></i>
                        </div>
                    </div>
                </div>

                <!-- Center graphic -->
                <div class="flex justify-center py-6 md:py-0">
                    <div class="w-44 h-44 rounded-full border-2 border-dashed border-[#C49A6C]/40 flex items-center justify-center bg-white shadow-md p-6">
                        <div class="w-full h-full rounded-full border border-[#C49A6C]/20 bg-[#FAF6F0] flex flex-col items-center justify-center text-center p-3">
                            <img src="{{ asset('images/logo.png') }}" alt="Vedic Botanica Logo" class="h-12 w-auto object-contain mb-1.5">
                            <span class="text-[8px] font-bold text-[#C49A6C] tracking-widest">ESTD 2026</span>
                        </div>
                    </div>
                </div>

                <!-- Right features -->
                <div class="space-y-6 text-left flex flex-col items-start">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-white border border-[#C49A6C]/35 flex items-center justify-center text-[#C49A6C] flex-shrink-0 shadow-xs">
                            <i class="fa-solid fa-hand-holding-hand text-xs"></i>
                        </div>
                        <div class="flex-grow">
                            <h4 class="font-serif font-bold text-gray-900 text-sm sm:text-base">Traditional Craftsmanship</h4>
                            <p class="text-xs text-gray-500 font-sans mt-1">Made using ancient Vedic methods.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-white border border-[#C49A6C]/35 flex items-center justify-center text-[#C49A6C] flex-shrink-0 shadow-xs">
                            <i class="fa-solid fa-seedling text-xs"></i>
                        </div>
                        <div class="flex-grow">
                            <h4 class="font-serif font-bold text-gray-900 text-sm sm:text-base">Botanical Excellence</h4>
                            <p class="text-xs text-gray-500 font-sans mt-1">Finest natural ingredients.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-white border border-[#C49A6C]/35 flex items-center justify-center text-[#C49A6C] flex-shrink-0 shadow-xs">
                            <i class="fa-solid fa-om text-xs"></i>
                        </div>
                        <div class="flex-grow">
                            <h4 class="font-serif font-bold text-gray-900 text-sm sm:text-base">Spiritual Benefits</h4>
                            <p class="text-xs text-gray-500 font-sans mt-1">For body, mind, soul and space.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <p class="text-xs text-[#C49A6C] uppercase font-bold tracking-widest pt-6 font-sans">
                Purity. Authenticity. Excellence. That's the Vedic Botanica promise.
            </p>
        </div>
    </div>

    <!-- Slide 07: Our Manufacturing -->
    <div id="manufacturing" class="bg-white py-16 sm:py-24 relative overflow-hidden">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-12">
            <div class="space-y-4">
                <span class="text-xs text-[#C49A6C] font-bold uppercase tracking-widest bg-[#C49A6C]/10 px-3.5 py-1.5 rounded-full font-serif">PROCESS</span>
                <h2 class="text-3xl sm:text-4xl font-serif font-bold text-gray-900">Crafted with Excellence</h2>
                <div class="w-16 h-1 bg-[#C49A6C] mx-auto mt-4 rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Step 1 -->
                <div class="bg-[#FAF6F0]/20 border border-[#C49A6C]/15 rounded-2xl p-6 relative flex flex-col justify-between">
                    <span class="absolute top-4 right-4 text-xs font-bold text-[#C49A6C]/30 font-sans">01</span>
                    <div>
                        <div class="w-12 h-12 rounded-full bg-white border border-[#C49A6C]/25 flex items-center justify-center mx-auto mb-4 text-[#C49A6C] shadow-xs">
                            <i class="fa-solid fa-magnifying-glass text-sm"></i>
                        </div>
                        <h4 class="font-serif font-bold text-gray-900 text-xs sm:text-sm uppercase tracking-wider mb-2">Selected with Care</h4>
                        <p class="text-xs text-gray-500 font-sans leading-relaxed">Finest raw ingredients selected for purity.</p>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="bg-[#FAF6F0]/20 border border-[#C49A6C]/15 rounded-2xl p-6 relative flex flex-col justify-between">
                    <span class="absolute top-4 right-4 text-xs font-bold text-[#C49A6C]/30 font-sans">02</span>
                    <div>
                        <div class="w-12 h-12 rounded-full bg-white border border-[#C49A6C]/25 flex items-center justify-center mx-auto mb-4 text-[#C49A6C] shadow-xs">
                            <i class="fa-solid fa-rotate text-sm"></i>
                        </div>
                        <h4 class="font-serif font-bold text-gray-900 text-xs sm:text-sm uppercase tracking-wider mb-2">Traditional Process</h4>
                        <p class="text-xs text-gray-500 font-sans leading-relaxed">Prepared using authentic Vedic methods.</p>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="bg-[#FAF6F0]/20 border border-[#C49A6C]/15 rounded-2xl p-6 relative flex flex-col justify-between">
                    <span class="absolute top-4 right-4 text-xs font-bold text-[#C49A6C]/30 font-sans">03</span>
                    <div>
                        <div class="w-12 h-12 rounded-full bg-white border border-[#C49A6C]/25 flex items-center justify-center mx-auto mb-4 text-[#C49A6C] shadow-xs">
                            <i class="fa-solid fa-list-check text-sm"></i>
                        </div>
                        <h4 class="font-serif font-bold text-gray-900 text-xs sm:text-sm uppercase tracking-wider mb-2">Quality Checks</h4>
                        <p class="text-xs text-gray-500 font-sans leading-relaxed">Rigorous quality control at every step.</p>
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="bg-[#FAF6F0]/20 border border-[#C49A6C]/15 rounded-2xl p-6 relative flex flex-col justify-between">
                    <span class="absolute top-4 right-4 text-xs font-bold text-[#C49A6C]/30 font-sans">04</span>
                    <div>
                        <div class="w-12 h-12 rounded-full bg-white border border-[#C49A6C]/25 flex items-center justify-center mx-auto mb-4 text-[#C49A6C] shadow-xs">
                            <i class="fa-solid fa-box-open text-sm"></i>
                        </div>
                        <h4 class="font-serif font-bold text-gray-900 text-xs sm:text-sm uppercase tracking-wider mb-2">Premium Packaging</h4>
                        <p class="text-xs text-gray-500 font-sans leading-relaxed">Elegant, hygienic and export-ready packaging.</p>
                    </div>
                </div>
            </div>
            
            <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider font-sans pt-6">
                Modern standards. Vedic traditions. Perfectly balanced.
            </p>
        </div>
    </div>

    <!-- Slide 08: Sustainability -->
    <div id="sustainability" class="bg-[#FAF6F0]/40 py-16 sm:py-24 border-t border-b border-gray-150/70 relative overflow-hidden">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-12">
            <div class="space-y-4">
                <span class="text-xs text-[#C49A6C] font-bold uppercase tracking-widest bg-[#C49A6C]/10 px-3.5 py-1.5 rounded-full font-serif">GREEN VISION</span>
                <h2 class="text-3xl sm:text-4xl font-serif font-bold text-gray-900">Our Commitment to a Better Tomorrow</h2>
                <div class="w-16 h-1 bg-[#C49A6C] mx-auto mt-4 rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 max-w-4xl mx-auto">
                <!-- Eco ingredients -->
                <div class="flex items-start gap-4 text-left bg-white p-5 rounded-2xl border border-[#C49A6C]/15 shadow-xs">
                    <div class="w-10 h-10 rounded-full bg-[#FAF6F0] border border-[#C49A6C]/20 flex items-center justify-center text-[#C49A6C] flex-shrink-0">
                        <i class="fa-solid fa-recycle text-xs"></i>
                    </div>
                    <div class="flex-grow">
                        <h4 class="font-serif font-bold text-gray-900 text-sm sm:text-base">Eco-Friendly Ingredients</h4>
                        <p class="text-xs text-gray-500 font-sans mt-1">Using natural, biodegradable and renewable resources.</p>
                    </div>
                </div>

                <!-- Responsible sourcing -->
                <div class="flex items-start gap-4 text-left bg-white p-5 rounded-2xl border border-[#C49A6C]/15 shadow-xs">
                    <div class="w-10 h-10 rounded-full bg-[#FAF6F0] border border-[#C49A6C]/20 flex items-center justify-center text-[#C49A6C] flex-shrink-0">
                        <i class="fa-solid fa-handshake-angle text-xs"></i>
                    </div>
                    <div class="flex-grow">
                        <h4 class="font-serif font-bold text-gray-900 text-sm sm:text-base">Responsible Sourcing</h4>
                        <p class="text-xs text-gray-500 font-sans mt-1">Ethically sourced from trusted farmers and local communities.</p>
                    </div>
                </div>

                <!-- Green manufacturing -->
                <div class="flex items-start gap-4 text-left bg-white p-5 rounded-2xl border border-[#C49A6C]/15 shadow-xs">
                    <div class="w-10 h-10 rounded-full bg-[#FAF6F0] border border-[#C49A6C]/20 flex items-center justify-center text-[#C49A6C] flex-shrink-0">
                        <i class="fa-solid fa-industry text-xs"></i>
                    </div>
                    <div class="flex-grow">
                        <h4 class="font-serif font-bold text-gray-900 text-sm sm:text-base">Green Manufacturing</h4>
                        <p class="text-xs text-gray-500 font-sans mt-1">Minimal waste, maximum care for our environment during production.</p>
                    </div>
                </div>

                <!-- Nature first -->
                <div class="flex items-start gap-4 text-left bg-white p-5 rounded-2xl border border-[#C49A6C]/15 shadow-xs">
                    <div class="w-10 h-10 rounded-full bg-[#FAF6F0] border border-[#C49A6C]/20 flex items-center justify-center text-[#C49A6C] flex-shrink-0">
                        <i class="fa-solid fa-hand-holding-heart text-xs"></i>
                    </div>
                    <div class="flex-grow">
                        <h4 class="font-serif font-bold text-gray-900 text-sm sm:text-base">Nature-First Philosophy</h4>
                        <p class="text-xs text-gray-500 font-sans mt-1">We pledge to give back to nature what we take from it.</p>
                    </div>
                </div>
            </div>
            
            <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider font-sans pt-6">
                Caring for nature today, for a better world tomorrow.
            </p>
        </div>
    </div>

    <!-- Slide 09: Global Vision -->
    <div id="global-vision" class="bg-white py-16 sm:py-24 relative overflow-hidden">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-12">
            <div class="space-y-4">
                <span class="text-xs text-[#C49A6C] font-bold uppercase tracking-widest bg-[#C49A6C]/10 px-3.5 py-1.5 rounded-full font-serif">GLOBAL VISION</span>
                <h2 class="text-3xl sm:text-4xl font-serif font-bold text-gray-900">Bringing Vedic Wellness to the World</h2>
                <div class="w-16 h-1 bg-[#C49A6C] mx-auto mt-4 rounded-full"></div>
            </div>

            <!-- Vision Pillars -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center max-w-4xl mx-auto">
                <div class="space-y-2">
                    <div class="w-10 h-10 rounded-full bg-[#FAF6F0] border border-[#C49A6C]/25 flex items-center justify-center mx-auto mb-3 text-[#C49A6C] shadow-xs">
                        <i class="fa-solid fa-heart text-xs"></i>
                    </div>
                    <h4 class="font-serif font-bold text-gray-900 text-sm uppercase tracking-wider">Rooted In India</h4>
                    <p class="text-xs text-gray-500 font-sans leading-relaxed">Inspired by Indian heritage, designed for modern global spaces.</p>
                </div>

                <div class="space-y-2">
                    <div class="w-10 h-10 rounded-full bg-[#FAF6F0] border border-[#C49A6C]/25 flex items-center justify-center mx-auto mb-3 text-[#C49A6C] shadow-xs">
                        <i class="fa-solid fa-square-poll-vertical text-xs"></i>
                    </div>
                    <h4 class="font-serif font-bold text-gray-900 text-sm uppercase tracking-wider">Premium Global Quality</h4>
                    <p class="text-xs text-gray-500 font-sans leading-relaxed">Meeting rigorous international standards for discerning global clients.</p>
                </div>

                <div class="space-y-2">
                    <div class="w-10 h-10 rounded-full bg-[#FAF6F0] border border-[#C49A6C]/25 flex items-center justify-center mx-auto mb-3 text-[#C49A6C] shadow-xs">
                        <i class="fa-solid fa-share-nodes text-xs"></i>
                    </div>
                    <h4 class="font-serif font-bold text-gray-900 text-sm uppercase tracking-wider">Trusted Worldwide</h4>
                    <p class="text-xs text-gray-500 font-sans leading-relaxed">Spreading purity, peace and positive spiritual vibrations globally.</p>
                </div>
            </div>
            
            <p class="text-xs text-[#C49A6C] font-bold uppercase tracking-widest pt-6 font-sans">
                Proudly Indian. Globally Loved. Spreading purity, peace and positivity worldwide.
            </p>
        </div>
    </div>

    <!-- Slide 10: Certifications & Quality -->
    <div id="quality" class="bg-[#FAF6F0]/40 py-16 sm:py-24 border-t border-b border-gray-150/70 relative overflow-hidden">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-12">
            <div class="space-y-4">
                <span class="text-xs text-[#C49A6C] font-bold uppercase tracking-widest bg-[#C49A6C]/10 px-3.5 py-1.5 rounded-full font-serif">TRUST & CERTIFICATION</span>
                <h2 class="text-3xl sm:text-4xl font-serif font-bold text-gray-900">Our Commitment to Quality & Safety</h2>
                <div class="w-16 h-1 bg-[#C49A6C] mx-auto mt-4 rounded-full"></div>
            </div>

            <!-- Badges -->
            <div class="grid grid-cols-2 md:grid-cols-5 gap-6 max-w-4xl mx-auto text-center">
                <div class="space-y-2">
                    <div class="w-12 h-12 rounded-full bg-white border border-[#C49A6C]/25 flex items-center justify-center mx-auto text-[#C49A6C] shadow-xs">
                        <i class="fa-solid fa-star text-sm"></i>
                    </div>
                    <h5 class="font-serif font-bold text-gray-900 text-[10px] sm:text-xs uppercase tracking-wider">Premium Quality</h5>
                </div>

                <div class="space-y-2">
                    <div class="w-12 h-12 rounded-full bg-white border border-[#C49A6C]/25 flex items-center justify-center mx-auto text-[#C49A6C] shadow-xs">
                        <i class="fa-solid fa-leaf text-sm"></i>
                    </div>
                    <h5 class="font-serif font-bold text-gray-900 text-[10px] sm:text-xs uppercase tracking-wider">Natural Ingredients</h5>
                </div>

                <div class="space-y-2">
                    <div class="w-12 h-12 rounded-full bg-white border border-[#C49A6C]/25 flex items-center justify-center mx-auto text-[#C49A6C] shadow-xs">
                        <i class="fa-solid fa-shield-virus text-sm"></i>
                    </div>
                    <h5 class="font-serif font-bold text-gray-900 text-[10px] sm:text-xs uppercase tracking-wider">Safe & Non-Toxic</h5>
                </div>

                <div class="space-y-2">
                    <div class="w-12 h-12 rounded-full bg-white border border-[#C49A6C]/25 flex items-center justify-center mx-auto text-[#C49A6C] shadow-xs">
                        <i class="fa-solid fa-vial-circle-check text-sm"></i>
                    </div>
                    <h5 class="font-serif font-bold text-gray-900 text-[10px] sm:text-xs uppercase tracking-wider">Lab Tested</h5>
                </div>

                <div class="space-y-2 col-span-2 md:col-span-1">
                    <div class="w-12 h-12 rounded-full bg-white border border-[#C49A6C]/25 flex items-center justify-center mx-auto text-[#C49A6C] shadow-xs">
                        <i class="fa-solid fa-plane-departure text-sm"></i>
                    </div>
                    <h5 class="font-serif font-bold text-gray-900 text-[10px] sm:text-xs uppercase tracking-wider">Export Quality</h5>
                </div>
            </div>
            
            <p class="text-xs sm:text-sm text-gray-600 max-w-xl mx-auto font-sans leading-relaxed">
                We follow stringent quality standards to ensure that every single product reaches you in its purest and finest form.
            </p>

            <!-- Bottom checklist -->
            <div class="flex flex-wrap justify-center items-center gap-6 text-[10px] font-bold text-red-500 uppercase tracking-widest font-sans pt-6 border-t border-[#C49A6C]/20 max-w-2xl mx-auto">
                <span class="flex items-center gap-1.5"><i class="fa-solid fa-ban"></i> No Charcoal</span>
                <span class="flex items-center gap-1.5"><i class="fa-solid fa-ban"></i> No Bamboo Stick</span>
                <span class="flex items-center gap-1.5"><i class="fa-solid fa-ban"></i> No Harmful Chemicals</span>
                <span class="flex items-center gap-1.5"><i class="fa-solid fa-ban"></i> No Artificial Fragrances</span>
            </div>
        </div>
    </div>

    <!-- Slide 11: Lifestyle -->
    <div id="lifestyle" class="bg-white py-16 sm:py-24 relative overflow-hidden">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-12">
            <div class="space-y-4">
                <span class="text-xs text-[#C49A6C] font-bold uppercase tracking-widest bg-[#C49A6C]/10 px-3.5 py-1.5 rounded-full font-serif">LIFESTYLE</span>
                <h2 class="text-3xl sm:text-4xl font-serif font-bold text-gray-900">Elevate Your Everyday Rituals</h2>
                <div class="w-16 h-1 bg-[#C49A6C] mx-auto mt-4 rounded-full"></div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-5 gap-6 text-center max-w-4xl mx-auto">
                <!-- Home -->
                <div class="bg-[#FAF6F0]/20 border border-[#C49A6C]/15 rounded-2xl p-5 hover:border-[#C49A6C] transition duration-300">
                    <div class="w-10 h-10 rounded-full bg-white border border-[#C49A6C]/25 flex items-center justify-center mx-auto mb-3 text-[#C49A6C]">
                        <i class="fa-solid fa-house text-xs"></i>
                    </div>
                    <h4 class="font-serif font-bold text-gray-900 text-xs sm:text-sm uppercase tracking-wide mb-1">Home</h4>
                    <p class="text-[10px] text-gray-400 font-sans leading-relaxed">Purify your living space</p>
                </div>

                <!-- Meditation -->
                <div class="bg-[#FAF6F0]/20 border border-[#C49A6C]/15 rounded-2xl p-5 hover:border-[#C49A6C] transition duration-300">
                    <div class="w-10 h-10 rounded-full bg-white border border-[#C49A6C]/25 flex items-center justify-center mx-auto mb-3 text-[#C49A6C]">
                        <i class="fa-solid fa-brain text-xs"></i>
                    </div>
                    <h4 class="font-serif font-bold text-gray-900 text-xs sm:text-sm uppercase tracking-wide mb-1">Meditation</h4>
                    <p class="text-[10px] text-gray-400 font-sans leading-relaxed">Enhance focus & inner peace</p>
                </div>

                <!-- Temple -->
                <div class="bg-[#FAF6F0]/20 border border-[#C49A6C]/15 rounded-2xl p-5 hover:border-[#C49A6C] transition duration-300">
                    <div class="w-10 h-10 rounded-full bg-white border border-[#C49A6C]/25 flex items-center justify-center mx-auto mb-3 text-[#C49A6C]">
                        <i class="fa-solid fa-gopuram text-xs"></i>
                    </div>
                    <h4 class="font-serif font-bold text-gray-900 text-xs sm:text-sm uppercase tracking-wide mb-1">Temple</h4>
                    <p class="text-[10px] text-gray-400 font-sans leading-relaxed">Sacred fragrance for rituals</p>
                </div>

                <!-- Yoga -->
                <div class="bg-[#FAF6F0]/20 border border-[#C49A6C]/15 rounded-2xl p-5 hover:border-[#C49A6C] transition duration-300">
                    <div class="w-10 h-10 rounded-full bg-white border border-[#C49A6C]/25 flex items-center justify-center mx-auto mb-3 text-[#C49A6C]">
                        <i class="fa-solid fa-child-yoga text-xs"></i>
                    </div>
                    <h4 class="font-serif font-bold text-gray-900 text-xs sm:text-sm uppercase tracking-wide mb-1">Yoga</h4>
                    <p class="text-[10px] text-gray-400 font-sans leading-relaxed">Support mindfulness</p>
                </div>

                <!-- Spa -->
                <div class="bg-[#FAF6F0]/20 border border-[#C49A6C]/15 rounded-2xl p-5 hover:border-[#C49A6C] transition duration-300 col-span-2 md:col-span-1">
                    <div class="w-10 h-10 rounded-full bg-white border border-[#C49A6C]/25 flex items-center justify-center mx-auto mb-3 text-[#C49A6C]">
                        <i class="fa-solid fa-spa text-xs"></i>
                    </div>
                    <h4 class="font-serif font-bold text-gray-900 text-xs sm:text-sm uppercase tracking-wide mb-1">Spa</h4>
                    <p class="text-[10px] text-gray-400 font-sans leading-relaxed">Create a relaxing ambiance</p>
                </div>
            </div>
            
            <p class="text-xs text-[#C49A6C] font-bold uppercase tracking-widest pt-6 font-sans">
                For every space. For every soul.
            </p>
        </div>
    </div>

@endsection
