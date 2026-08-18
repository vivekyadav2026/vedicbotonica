@extends('layouts.frontend')

@section('title', 'Contact Us')

@section('content')
    <!-- Page Header -->
    <div class="bg-[#FAF6F0]/50 py-10 text-center border-b border-gray-150/70">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-[10px] md:text-sm text-gray-500 uppercase tracking-widest leading-relaxed">
                <a href="/" class="hover:text-primary transition">Home</a> / 
                <span class="text-gray-900 font-medium">Contact Us</span>
            </p>
            <h1 class="text-3xl sm:text-4xl font-serif font-bold text-gray-900 mt-2">Contact Us</h1>
        </div>
    </div>

    <!-- Contact Section -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-20">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-16 items-start">
            
            <!-- Left: Contact Card (Slide 12 Style) - Span 5 -->
            <div class="lg:col-span-5 bg-white border border-[#C49A6C]/20 rounded-3xl p-8 shadow-md text-center relative overflow-hidden flex flex-col items-center justify-between min-h-[500px]">
                <div class="absolute inset-0 bg-gradient-to-br from-[#FAF6F0]/40 to-transparent pointer-events-none"></div>

                <div class="space-y-6 relative z-10 w-full">
                    <!-- Brand Logo -->
                    <img src="{{ asset('images/logo.png') }}" alt="Vedic Botanica" class="h-16 w-auto object-contain mx-auto bg-[#FAF6F0] p-1.5 rounded-full border border-[#C49A6C]/25 shadow-sm">
                    
                    <h3 class="font-serif font-bold text-2xl text-gray-955 uppercase tracking-widest">Vedic Botanica</h3>
                    <p class="text-[10px] text-[#C49A6C] uppercase font-bold tracking-widest font-serif block -mt-4">360° Vedic Essence of Life</p>
                    
                    <div class="w-12 h-[1px] bg-[#C49A6C] mx-auto my-3"></div>

                    <!-- Contact details -->
                    <div class="space-y-4 text-left max-w-xs mx-auto text-sm text-gray-650 font-sans">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-[#FAF6F0] border border-[#C49A6C]/25 flex items-center justify-center text-[#C49A6C] flex-shrink-0">
                                <i class="fa-solid fa-phone text-xs"></i>
                            </div>
                            <span class="font-medium">+91 9217530653</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-[#FAF6F0] border border-[#C49A6C]/25 flex items-center justify-center text-[#C49A6C] flex-shrink-0">
                                <i class="fa-solid fa-envelope text-xs"></i>
                            </div>
                            <span class="font-medium">info@vedicbotanica.com</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-[#FAF6F0] border border-[#C49A6C]/25 flex items-center justify-center text-[#C49A6C] flex-shrink-0">
                                <i class="fa-solid fa-globe text-xs"></i>
                            </div>
                            <span class="font-medium">www.vedicbotanica.com</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-[#FAF6F0] border border-[#C49A6C]/25 flex items-center justify-center text-[#C49A6C] flex-shrink-0">
                                <i class="fa-solid fa-location-dot text-xs"></i>
                            </div>
                            <span class="font-medium">Delhi, India</span>
                        </div>
                    </div>
                </div>

                <!-- QR Code & Slogan -->
                <div class="relative z-10 w-full pt-8 mt-8 border-t border-gray-100 flex flex-col items-center gap-4">
                    <!-- Stylized Mock QR Code -->
                    <div class="p-2 border border-gray-200 rounded-2xl bg-white shadow-xs">
                        <div class="w-20 h-20 bg-gray-50 flex items-center justify-center rounded-xl border border-dashed border-[#C49A6C]/30 relative overflow-hidden">
                            <!-- QR Pattern Lines using pure CSS -->
                            <div class="absolute inset-2 grid grid-cols-5 gap-1 opacity-70">
                                <div class="bg-gray-800 rounded-sm"></div>
                                <div class="bg-gray-800 rounded-sm"></div>
                                <div class="bg-transparent"></div>
                                <div class="bg-gray-800 rounded-sm"></div>
                                <div class="bg-gray-800 rounded-sm"></div>
                                
                                <div class="bg-gray-800 rounded-sm"></div>
                                <div class="bg-transparent"></div>
                                <div class="bg-gray-800 rounded-sm"></div>
                                <div class="bg-transparent"></div>
                                <div class="bg-gray-800 rounded-sm"></div>
                                
                                <div class="bg-transparent"></div>
                                <div class="bg-gray-800 rounded-sm"></div>
                                <div class="bg-gray-800 rounded-sm"></div>
                                <div class="bg-gray-800 rounded-sm"></div>
                                <div class="bg-transparent"></div>
                                
                                <div class="bg-gray-800 rounded-sm"></div>
                                <div class="bg-transparent"></div>
                                <div class="bg-gray-800 rounded-sm"></div>
                                <div class="bg-transparent"></div>
                                <div class="bg-gray-800 rounded-sm"></div>
                                
                                <div class="bg-gray-800 rounded-sm"></div>
                                <div class="bg-gray-800 rounded-sm"></div>
                                <div class="bg-transparent"></div>
                                <div class="bg-gray-800 rounded-sm"></div>
                                <div class="bg-gray-800 rounded-sm"></div>
                            </div>
                            <!-- Brand Dot in Center -->
                            <div class="absolute w-4 h-4 rounded bg-white shadow-sm border border-[#C49A6C]/20 flex items-center justify-center">
                                <div class="w-1.5 h-1.5 rounded-full bg-[#C49A6C]"></div>
                            </div>
                        </div>
                    </div>
                    <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest font-sans">Scan to Connect</span>

                    <!-- Social Icons -->
                    <div class="flex justify-center items-center gap-3 text-[#C49A6C] text-sm mt-2">
                        <a href="#" class="w-8 h-8 rounded-full border border-gray-150 hover:bg-[#C49A6C] hover:text-white transition flex items-center justify-center"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" class="w-8 h-8 rounded-full border border-gray-150 hover:bg-[#C49A6C] hover:text-white transition flex items-center justify-center"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" class="w-8 h-8 rounded-full border border-gray-150 hover:bg-[#C49A6C] hover:text-white transition flex items-center justify-center"><i class="fa-brands fa-youtube"></i></a>
                        <a href="#" class="w-8 h-8 rounded-full border border-gray-150 hover:bg-[#C49A6C] hover:text-white transition flex items-center justify-center"><i class="fa-brands fa-pinterest-p"></i></a>
                    </div>
                </div>
            </div>

            <!-- Right: Contact Form - Span 7 -->
            <div class="lg:col-span-7 bg-[#FAF6F0]/20 border border-[#C49A6C]/10 rounded-3xl p-6 sm:p-8 shadow-xs">
                <h3 class="text-xl sm:text-2xl font-serif font-bold text-gray-900 mb-6">Send us a message</h3>
                <form action="#" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">First Name *</label>
                            <input type="text" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-900 shadow-xs focus:outline-none focus:border-[#C49A6C] focus:ring-1 focus:ring-[#C49A6C]/25 transition duration-200" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Last Name *</label>
                            <input type="text" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-900 shadow-xs focus:outline-none focus:border-[#C49A6C] focus:ring-1 focus:ring-[#C49A6C]/25 transition duration-200" required>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Email Address *</label>
                        <input type="email" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-900 shadow-xs focus:outline-none focus:border-[#C49A6C] focus:ring-1 focus:ring-[#C49A6C]/25 transition duration-200" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Message *</label>
                        <textarea rows="4" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-900 shadow-xs focus:outline-none focus:border-[#C49A6C] focus:ring-1 focus:ring-[#C49A6C]/25 transition duration-200" required></textarea>
                    </div>
                    <button type="submit" class="w-full bg-[#C49A6C] hover:bg-[#b0875b] text-white font-bold py-4 rounded-xl tracking-wider text-xs uppercase transition shadow-md hover:shadow-[#C49A6C]/25 cursor-pointer">
                        Send Message
                    </button>
                </form>
            </div>
        </div>

        <!-- Google Map Section -->
        <div class="mt-16 bg-gray-200 rounded-3xl overflow-hidden h-64 sm:h-96 shadow-md border border-gray-150/70">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d224345.83923192776!2d77.06889754725782!3d28.52758200617607!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390cfd5b347eb62d%3A0x52c2b7494e204dce!2sNew%20Delhi%2C%20Delhi%2C%20India!5e0!3m2!1sen!2sus!4v1700000000000!5m2!1sen!2sus" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
@endsection
