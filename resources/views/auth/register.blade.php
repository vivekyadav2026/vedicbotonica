@extends('layouts.frontend')

@section('title', 'Register')

@section('content')
    <div class="min-h-[80vh] flex items-center justify-center py-16 px-4 bg-[#FAF6F0]/30">
        <div class="max-w-2xl w-full bg-[#FAF6F0] border border-[#C49A6C]/50 p-8 sm:p-10 rounded-2xl shadow-xl">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-serif font-bold text-gray-900">Create Account</h2>
                <p class="text-sm text-gray-500 mt-2 font-sans">Register to track orders and save your details.</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Name</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 text-sm text-gray-900 shadow-sm focus:outline-none focus:border-[#C49A6C] focus:ring-1 focus:ring-[#C49A6C]/20 transition duration-200">
                        <x-input-error :messages="$errors->get('name')" class="mt-2 text-xs text-red-600" />
                    </div>

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Email Address</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 text-sm text-gray-900 shadow-sm focus:outline-none focus:border-[#C49A6C] focus:ring-1 focus:ring-[#C49A6C]/20 transition duration-200">
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-red-600" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Password -->
                    <div x-data="{ showPassword: false }">
                        <label for="password" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Password</label>
                        <div class="relative">
                            <input id="password" :type="showPassword ? 'text' : 'password'" name="password" required autocomplete="new-password" class="w-full bg-white border border-gray-300 rounded-lg pl-4 pr-10 py-3 text-sm text-gray-900 shadow-sm focus:outline-none focus:border-[#C49A6C] focus:ring-1 focus:ring-[#C49A6C]/20 transition duration-200">
                            <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-[#C49A6C] focus:outline-none cursor-pointer" title="Toggle Password Visibility">
                                <i class="fa-solid text-sm" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-red-600" />
                    </div>

                    <!-- Confirm Password -->
                    <div x-data="{ showConfirmPassword: false }">
                        <label for="password_confirmation" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Confirm Password</label>
                        <div class="relative">
                            <input id="password_confirmation" :type="showConfirmPassword ? 'text' : 'password'" name="password_confirmation" required autocomplete="new-password" class="w-full bg-white border border-gray-300 rounded-lg pl-4 pr-10 py-3 text-sm text-gray-900 shadow-sm focus:outline-none focus:border-[#C49A6C] focus:ring-1 focus:ring-[#C49A6C]/20 transition duration-200">
                            <button type="button" @click="showConfirmPassword = !showConfirmPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-[#C49A6C] focus:outline-none cursor-pointer" title="Toggle Password Visibility">
                                <i class="fa-solid text-sm" :class="showConfirmPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-xs text-red-600" />
                    </div>
                </div>

                <!-- Shipping Header -->
                <div class="pt-4">
                    <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider pb-1.5 border-b border-gray-200 flex items-center justify-between">
                        <span>Shipping Details</span>
                        <i class="fa-solid fa-truck text-[#C49A6C] text-xs"></i>
                    </h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Phone Number</label>
                        <input id="phone" type="text" name="phone" value="{{ old('phone') }}" required class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 text-sm text-gray-900 shadow-sm focus:outline-none focus:border-[#C49A6C] focus:ring-1 focus:ring-[#C49A6C]/20 transition duration-200" placeholder="+91">
                        <x-input-error :messages="$errors->get('phone')" class="mt-2 text-xs text-red-600" />
                    </div>

                    <!-- Zip -->
                    <div>
                        <label for="zip" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">ZIP / Pin Code</label>
                        <input id="zip" type="text" name="zip" value="{{ old('zip') }}" required class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 text-sm text-gray-900 shadow-sm focus:outline-none focus:border-[#C49A6C] focus:ring-1 focus:ring-[#C49A6C]/20 transition duration-200">
                        <x-input-error :messages="$errors->get('zip')" class="mt-2 text-xs text-red-600" />
                    </div>
                </div>

                <!-- Address Line 1 -->
                <div>
                    <label for="address" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Flat / House No. / Building <span class="text-red-500">*</span></label>
                    <input id="address" type="text" name="address" value="{{ old('address') }}" required class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 text-sm text-gray-900 shadow-sm focus:outline-none focus:border-[#C49A6C] focus:ring-1 focus:ring-[#C49A6C]/20 transition duration-200" placeholder="e.g. Flat 104, Building A, Shanti Vihar">
                    <x-input-error :messages="$errors->get('address')" class="mt-2 text-xs text-red-600" />
                </div>

                <!-- Address Line 2 -->
                <div>
                    <label for="address2" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Area / Colony / Street / Sector / Landmark <span class="text-red-500">*</span></label>
                    <input id="address2" type="text" name="address2" value="{{ old('address2') }}" required class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 text-sm text-gray-900 shadow-sm focus:outline-none focus:border-[#C49A6C] focus:ring-1 focus:ring-[#C49A6C]/20 transition duration-200" placeholder="e.g. Sector 12, near Kali Temple, Dwarka">
                    <x-input-error :messages="$errors->get('address2')" class="mt-2 text-xs text-red-600" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- City -->
                    <div>
                        <label for="city" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">City</label>
                        <input id="city" type="text" name="city" value="{{ old('city') }}" required class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 text-sm text-gray-900 shadow-sm focus:outline-none focus:border-[#C49A6C] focus:ring-1 focus:ring-[#C49A6C]/20 transition duration-200">
                        <x-input-error :messages="$errors->get('city')" class="mt-2 text-xs text-red-600" />
                    </div>

                    <!-- State -->
                    <div>
                        <label for="state" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">State</label>
                        <input id="state" type="text" name="state" value="{{ old('state') }}" required class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 text-sm text-gray-900 shadow-sm focus:outline-none focus:border-[#C49A6C] focus:ring-1 focus:ring-[#C49A6C]/20 transition duration-200">
                        <x-input-error :messages="$errors->get('state')" class="mt-2 text-xs text-red-600" />
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white font-bold py-4 rounded-lg tracking-wider text-sm transition shadow-md uppercase cursor-pointer" style="background-color: #C49A6C; color: white;">
                        Register
                    </button>
                </div>
            </form>

            <div class="mt-8 pt-6 border-t border-gray-250 text-center text-sm">
                <span class="text-gray-500">Already have an account?</span>
                <a href="{{ route('login') }}" class="text-primary hover:text-primary-dark font-bold ml-1 hover:underline">Log in here</a>
            </div>
        </div>
    </div>
@endsection
