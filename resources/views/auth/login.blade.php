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

            <!-- Divider -->
            <div class="relative flex items-center justify-center my-6">
                <div class="flex-grow border-t border-gray-350/50"></div>
                <span class="flex-shrink mx-4 text-xs font-bold text-gray-400 uppercase tracking-widest bg-[#FAF6F0] px-2 font-sans">or</span>
                <div class="flex-grow border-t border-gray-350/50"></div>
            </div>

            <!-- Google OAuth Button -->
            <div>
                <a href="{{ route('auth.google') }}" class="w-full flex items-center justify-center gap-3 bg-white border border-gray-300/70 hover:border-[#C49A6C]/50 hover:bg-white text-gray-700 font-bold py-3.5 rounded-lg tracking-wide text-xs transition-all duration-300 shadow-xs hover:shadow-md cursor-pointer group active:scale-98">
                    <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110" viewBox="0 0 24 24" width="20" height="20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" fill="#EA4335"/>
                    </svg>
                    <span class="font-sans font-bold tracking-wider uppercase text-gray-700 group-hover:text-gray-900">Continue with Google</span>
                </a>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-250 text-center text-sm">
                <span class="text-gray-500">Don't have an account?</span>
                <a href="{{ route('register') }}" class="text-primary hover:text-primary-dark font-bold ml-1 hover:underline">Register here</a>
            </div>
        </div>
    </div>
@endsection
