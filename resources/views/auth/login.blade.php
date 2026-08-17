@extends('layouts.frontend')

@section('title', 'Log In')

@section('content')
    <div class="min-h-[70vh] flex items-center justify-center py-16 px-4 bg-[#FAF6F0]/30">
        <div class="max-w-md w-full bg-[#FAF6F0] border border-[#C49A6C]/50 p-8 sm:p-10 rounded-2xl shadow-xl">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-serif font-bold text-gray-900">Welcome Back</h2>
                <p class="text-sm text-gray-500 mt-2 font-sans">Log in to manage your orders and account.</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4 text-sm font-semibold text-green-700 bg-green-50 border border-green-200 px-4 py-3 rounded-lg" :status="session('status')" />


            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 text-sm text-gray-900 shadow-sm focus:outline-none focus:border-[#C49A6C] focus:ring-1 focus:ring-[#C49A6C]/20 transition duration-200">
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-red-600" />
                </div>

                <!-- Password -->
                <div x-data="{ showPassword: false }">
                    <label for="password" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Password</label>
                    <div class="relative">
                        <input id="password" :type="showPassword ? 'text' : 'password'" name="password" required autocomplete="current-password" class="w-full bg-white border border-gray-300 rounded-lg pl-4 pr-10 py-3 text-sm text-gray-900 shadow-sm focus:outline-none focus:border-[#C49A6C] focus:ring-1 focus:ring-[#C49A6C]/20 transition duration-200">
                        <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-[#C49A6C] focus:outline-none cursor-pointer" title="Toggle Password Visibility">
                            <i class="fa-solid text-sm" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-red-600" />
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between text-sm">
                    <label for="remember_me" class="inline-flex items-center cursor-pointer">
                        <input id="remember_me" type="checkbox" name="remember" class="rounded border-gray-300 text-primary focus:ring-primary h-4 w-4" style="color: #C49A6C;">
                        <span class="ms-2 text-xs text-gray-500">Remember me</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-xs text-primary hover:text-primary-dark font-medium underline" href="{{ route('password.request') }}">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white font-bold py-4 rounded-lg tracking-wider text-sm transition shadow-md uppercase" style="background-color: #C49A6C; color: white;">
                        Log In
                    </button>
                </div>
            </form>

            <div class="mt-8 pt-6 border-t border-gray-250 text-center text-sm">
                <span class="text-gray-500">Don't have an account?</span>
                <a href="{{ route('register') }}" class="text-primary hover:text-primary-dark font-bold ml-1 hover:underline">Register here</a>
            </div>
        </div>
    </div>
@endsection
