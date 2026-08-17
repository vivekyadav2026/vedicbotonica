@extends('layouts.frontend')

@section('title', 'Edit Profile')

@section('content')
    <!-- Page Header -->
    <div class="bg-[#fdfaf6] py-5 md:py-12 text-center border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-[10px] md:text-sm text-gray-500 uppercase tracking-widest leading-relaxed">
                <a href="/" class="hover:text-primary transition">Home</a> / 
                <a href="/dashboard" class="hover:text-primary transition">Dashboard</a> / 
                <span class="text-gray-900 font-medium">Profile</span>
            </p>
            <h1 class="text-2xl sm:text-4xl font-serif font-bold text-gray-900 mt-1 md:mt-2">My Account</h1>
        </div>
    </div>

    <!-- Profile Editing Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-16">
        <div class="flex flex-col lg:flex-row gap-8 lg:gap-12">
            
            <!-- Sidebar Navigation (Desktop only) -->
            <div class="hidden lg:block w-full lg:w-1/4">
                <div class="bg-[#fdfaf6] border border-gray-200 rounded-xl p-6 space-y-2">
                    <div class="flex items-center space-x-3 mb-6 pb-4 border-b border-gray-250">
                        <div class="bg-[#C49A6C]/10 text-[#C49A6C] h-12 w-12 rounded-full flex items-center justify-center font-bold text-lg font-serif">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div>
                            <h4 class="font-serif font-bold text-gray-955 text-base leading-tight">{{ Auth::user()->name }}</h4>
                            <span class="text-xs text-gray-400 font-medium">Customer Account</span>
                        </div>
                    </div>
                    
                    <a href="{{ url('/dashboard') }}" class="w-full text-left px-4 py-3 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-55 transition-colors duration-250 flex items-center" style="font-family: 'Inter', sans-serif;">
                        <i class="fa-solid fa-chart-line mr-3 text-base"></i> Dashboard Overview
                    </a>
                    
                    <a href="{{ url('/dashboard') }}" class="w-full text-left px-4 py-3 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-55 transition-colors duration-250 flex items-center" style="font-family: 'Inter', sans-serif;">
                        <i class="fa-solid fa-box mr-3 text-base"></i> My Orders
                    </a>
                    
                    <a href="{{ route('profile.edit') }}" class="w-full text-left px-4 py-3 rounded-lg text-sm font-semibold bg-[#C49A6C] text-white transition-colors duration-250 flex items-center" style="font-family: 'Inter', sans-serif;">
                        <i class="fa-solid fa-user-gear mr-3 text-base"></i> Edit Profile
                    </a>
                    
                    <form method="POST" action="{{ route('logout') }}" class="pt-4 border-t border-gray-250">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-3 rounded-lg text-sm font-semibold text-red-500 hover:bg-red-50 transition-colors duration-250 flex items-center" style="font-family: 'Inter', sans-serif; cursor: pointer;">
                            <i class="fa-solid fa-arrow-right-from-bracket mr-3 text-base"></i> Log Out
                        </button>
                    </form>
                </div>
            </div>

            <!-- Mobile Account Shortcuts Grid (Mobile only) -->
            <div class="block lg:hidden w-full mb-6">
                <!-- User welcome panel -->
                <div class="bg-[#FAF6F0] border border-[#C49A6C]/20 rounded-2xl p-4 mb-4 flex items-center space-x-3.5 shadow-sm">
                    <div class="bg-[#C49A6C] text-white h-11 w-11 rounded-full flex items-center justify-center font-bold text-base font-serif shadow-sm">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <h4 class="font-serif font-bold text-gray-955 text-sm sm:text-base leading-tight">{{ Auth::user()->name }}</h4>
                        <p class="text-[10px] text-gray-500 font-sans mt-0.5">{{ Auth::user()->email }}</p>
                    </div>
                </div>

                <!-- 2x2 Grid of Actions -->
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ url('/dashboard') }}" class="flex flex-col items-center justify-center p-3.5 border border-gray-200 bg-white rounded-xl text-center transition-all shadow-sm">
                        <div class="bg-[#C49A6C]/10 text-primary h-8 w-8 rounded-full flex items-center justify-center text-xs mb-1.5" style="color: #C49A6C;">
                            <i class="fa-solid fa-chart-line"></i>
                        </div>
                        <span class="text-xs font-bold text-gray-800 font-sans">Overview</span>
                    </a>

                    <a href="{{ url('/dashboard') }}" class="flex flex-col items-center justify-center p-3.5 border border-gray-200 bg-white rounded-xl text-center transition-all shadow-sm">
                        <div class="bg-[#C49A6C]/10 text-primary h-8 w-8 rounded-full flex items-center justify-center text-xs mb-1.5" style="color: #C49A6C;">
                            <i class="fa-solid fa-box"></i>
                        </div>
                        <span class="text-xs font-bold text-gray-800 font-sans">My Orders</span>
                    </a>

                    <div class="flex flex-col items-center justify-center p-3.5 border border-[#C49A6C] ring-1 ring-[#C49A6C] bg-[#FAF6F0] rounded-xl text-center shadow-sm">
                        <div class="bg-[#C49A6C]/10 text-primary h-8 w-8 rounded-full flex items-center justify-center text-xs mb-1.5" style="color: #C49A6C;">
                            <i class="fa-solid fa-user-gear"></i>
                        </div>
                        <span class="text-xs font-bold text-[#C49A6C] font-sans">Edit Profile</span>
                    </div>

                    <form method="POST" action="{{ route('logout') }}" class="m-0 w-full flex">
                        @csrf
                        <button type="submit" class="w-full flex flex-col items-center justify-center p-3.5 border border-gray-200 bg-white rounded-xl text-center transition-all shadow-sm cursor-pointer">
                            <div class="bg-red-50 text-red-500 h-8 w-8 rounded-full flex items-center justify-center text-xs mb-1.5">
                                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                            </div>
                            <span class="text-xs font-bold text-red-500 font-sans">Log Out</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Content Area: Forms -->
            <div class="w-full lg:w-3/4 space-y-12">
                <h2 class="text-2xl font-serif font-bold text-gray-900 mb-2">Edit Account Profile</h2>
                
                <!-- Update Profile Info Form -->
                <div class="p-5 sm:p-8 bg-[#FAF6F0] border border-[#C49A6C]/30 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <!-- Update Password Form -->
                <div class="p-5 sm:p-8 bg-[#FAF6F0] border border-[#C49A6C]/30 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <!-- Delete User Form -->
                <div class="p-5 sm:p-8 bg-[#FAF6F0] border border-[#C49A6C]/30 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
