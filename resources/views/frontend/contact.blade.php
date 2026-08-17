@extends('layouts.frontend')

@section('title', 'Contact Us')

@section('content')
    <!-- Page Header -->
    <div class="bg-[#fdfaf6] py-5 md:py-12 text-center border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-[10px] md:text-sm text-gray-500 uppercase tracking-widest leading-relaxed">
                <a href="/" class="hover:text-primary transition">Home</a> / 
                <span class="text-gray-900 font-medium">Contact Us</span>
            </p>
            <h1 class="text-2xl sm:text-4xl font-serif font-bold text-gray-900 mt-1 md:mt-2">Contact Us</h1>
        </div>
    </div>

    <!-- Contact Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 md:gap-16">
            
            <!-- Contact Info -->
            <div>
                <h2 class="text-2xl sm:text-3xl font-serif font-bold text-gray-900 mb-6">Get In Touch</h2>
                <p class="text-sm text-gray-600 mb-8 leading-relaxed">
                    We'd love to hear from you. Whether you have a question about products, shipping, or need spiritual guidance regarding which item is right for you, our team is ready to answer all your questions.
                </p>
                
                <div class="space-y-6">
                    <div class="flex items-start">
                        <div class="bg-primary/10 p-3 rounded-full text-primary mr-4 flex-shrink-0">
                            <i class="fa-solid fa-location-dot text-xl w-5 text-center" style="color: #C49A6C;"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 font-serif">Address</h4>
                            <p class="text-sm text-gray-600 mt-1">123 Spiritual Avenue, New Delhi, India 110001</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="bg-primary/10 p-3 rounded-full text-primary mr-4 flex-shrink-0">
                            <i class="fa-solid fa-phone text-xl w-5 text-center" style="color: #C49A6C;"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 font-serif">Phone</h4>
                            <p class="text-sm text-gray-600 mt-1">+91 9217530653</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="bg-primary/10 p-3 rounded-full text-primary mr-4 flex-shrink-0">
                            <i class="fa-solid fa-envelope text-xl w-5 text-center" style="color: #C49A6C;"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 font-serif">Email</h4>
                            <p class="text-sm text-gray-600 mt-1">info@vedicbotanica.com</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
                <h3 class="text-xl sm:text-2xl font-serif font-bold text-gray-900 mb-6">Send us a message</h3>
                <form action="#" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 mb-4 sm:mb-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">First Name *</label>
                            <input type="text" class="w-full bg-white border border-gray-300 rounded-xl px-4 py-3 text-sm text-gray-900 shadow-sm focus:outline-none focus:border-[#C49A6C] focus:ring-1 focus:ring-[#C49A6C]/20 transition duration-200" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Last Name *</label>
                            <input type="text" class="w-full bg-white border border-gray-300 rounded-xl px-4 py-3 text-sm text-gray-900 shadow-sm focus:outline-none focus:border-[#C49A6C] focus:ring-1 focus:ring-[#C49A6C]/20 transition duration-200" required>
                        </div>
                    </div>
                    <div class="mb-4 sm:mb-6">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Email Address *</label>
                        <input type="email" class="w-full bg-white border border-gray-300 rounded-xl px-4 py-3 text-sm text-gray-900 shadow-sm focus:outline-none focus:border-[#C49A6C] focus:ring-1 focus:ring-[#C49A6C]/20 transition duration-200" required>
                    </div>
                    <div class="mb-4 sm:mb-6">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Message *</label>
                        <textarea rows="4" class="w-full bg-white border border-gray-300 rounded-xl px-4 py-3 text-sm text-gray-900 shadow-sm focus:outline-none focus:border-[#C49A6C] focus:ring-1 focus:ring-[#C49A6C]/20 transition duration-200" required></textarea>
                    </div>
                    <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white font-bold py-4 rounded-xl tracking-wider text-xs uppercase transition shadow cursor-pointer" style="background-color: #C49A6C; color: white;">
                        Send Message
                    </button>
                </form>
            </div>
        </div>

        <!-- Map -->
        <div class="mt-12 sm:mt-16 bg-gray-200 rounded-2xl overflow-hidden h-64 sm:h-96 shadow-sm border border-gray-100">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d224345.83923192776!2d77.06889754725782!3d28.52758200617607!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390cfd5b347eb62d%3A0x52c2b7494e204dce!2sNew%20Delhi%2C%20Delhi%2C%20India!5e0!3m2!1sen!2sus!4v1700000000000!5m2!1sen!2sus" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
@endsection
