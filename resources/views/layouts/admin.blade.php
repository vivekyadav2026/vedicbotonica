<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Dashboard - {{ config('app.name', 'Vedic Botanica') }}</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=2" type="image/x-icon">
    <link rel="icon" href="{{ asset('favicon.ico') }}?v=2" type="image/x-icon">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans bg-slate-50 text-slate-800 antialiased" x-data="{ sidebarOpen: false, sidebarCollapsed: false }">

    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar (Desktop & Mobile drawer) -->
        <aside class="fixed inset-y-0 left-0 z-50 flex flex-col bg-slate-900 text-slate-300 border-r border-slate-800 transition-all duration-300 transform lg:translate-x-0 lg:static lg:inset-auto lg:z-auto"
               :class="[sidebarOpen ? 'translate-x-0 w-64' : '-translate-x-full w-64', sidebarCollapsed ? 'lg:w-20' : 'lg:w-64']">
            
            <!-- Logo Header -->
            <div class="flex items-center justify-between px-6 py-5 bg-slate-950 border-b border-slate-800/70"
                 :class="sidebarCollapsed ? 'lg:justify-center lg:px-4' : 'px-6 py-5'">
                <div class="flex items-center space-x-3" :class="sidebarCollapsed ? 'lg:space-x-0' : 'space-x-3'">
                    <img src="{{ asset('images/logo.png') }}" alt="Vedic Botanica Logo" class="h-10 w-auto object-contain bg-white rounded-md p-1 shadow-sm flex-shrink-0">
                    <div x-show="!sidebarCollapsed" class="hidden lg:block overflow-hidden transition-all duration-300">
                        <h1 class="text-sm font-bold font-serif text-white uppercase tracking-wider leading-none">Vedic Botanica</h1>
                        <span class="text-[9px] text-[#C49A6C] uppercase font-bold tracking-widest block mt-1">Admin Portal</span>
                    </div>
                    <!-- Mobile drawer title (always visible on mobile) -->
                    <div class="lg:hidden">
                        <h1 class="text-sm font-bold font-serif text-white uppercase tracking-wider leading-none">Vedic Botanica</h1>
                        <span class="text-[9px] text-[#C49A6C] uppercase font-bold tracking-widest block mt-1">Admin Portal</span>
                    </div>
                </div>
                <button @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-white">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-[#C49A6C] text-white shadow-lg shadow-[#C49A6C]/25' : 'hover:bg-slate-800 hover:text-white' }}"
                   :class="sidebarCollapsed ? 'lg:justify-center lg:space-x-0' : 'space-x-3.5'">
                    <i class="fa-solid fa-chart-pie w-5 text-center flex-shrink-0"></i>
                    <span :class="sidebarCollapsed ? 'lg:hidden' : 'inline'">Dashboard</span>
                </a>

                <a href="{{ route('admin.products.index') }}" 
                   class="flex items-center px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.products.*') ? 'bg-[#C49A6C] text-white shadow-lg shadow-[#C49A6C]/25' : 'hover:bg-slate-800 hover:text-white' }}"
                   :class="sidebarCollapsed ? 'lg:justify-center lg:space-x-0' : 'space-x-3.5'">
                    <i class="fa-solid fa-box w-5 text-center flex-shrink-0"></i>
                    <span :class="sidebarCollapsed ? 'lg:hidden' : 'inline'">Products</span>
                </a>

                <a href="{{ route('admin.combos.index') }}" 
                   class="flex items-center px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.combos.*') ? 'bg-[#C49A6C] text-white shadow-lg shadow-[#C49A6C]/25' : 'hover:bg-slate-800 hover:text-white' }}"
                   :class="sidebarCollapsed ? 'lg:justify-center lg:space-x-0' : 'space-x-3.5'">
                    <i class="fa-solid fa-cubes w-5 text-center flex-shrink-0"></i>
                    <span :class="sidebarCollapsed ? 'lg:hidden' : 'inline'">Combo Packs</span>
                </a>

                <a href="{{ route('admin.returns.index') }}" 
                   class="flex items-center px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.returns.*') ? 'bg-[#C49A6C] text-white shadow-lg shadow-[#C49A6C]/25' : 'hover:bg-slate-800 hover:text-white' }}"
                   :class="sidebarCollapsed ? 'lg:justify-center lg:space-x-0' : 'space-x-3.5'">
                    <i class="fa-solid fa-rotate-left w-5 text-center flex-shrink-0"></i>
                    <span :class="sidebarCollapsed ? 'lg:hidden' : 'inline'">Return Requests</span>
                </a>

                <a href="{{ route('admin.reviews.index') }}" 
                   class="flex items-center px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.reviews.*') ? 'bg-[#C49A6C] text-white shadow-lg shadow-[#C49A6C]/25' : 'hover:bg-slate-800 hover:text-white' }}"
                   :class="sidebarCollapsed ? 'lg:justify-center lg:space-x-0' : 'space-x-3.5'">
                    <i class="fa-solid fa-star w-5 text-center flex-shrink-0"></i>
                    <span :class="sidebarCollapsed ? 'lg:hidden' : 'inline'">Product Reviews</span>
                </a>

                <a href="{{ route('admin.categories.index') }}" 
                   class="flex items-center px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.categories.*') ? 'bg-[#C49A6C] text-white shadow-lg shadow-[#C49A6C]/25' : 'hover:bg-slate-800 hover:text-white' }}"
                   :class="sidebarCollapsed ? 'lg:justify-center lg:space-x-0' : 'space-x-3.5'">
                    <i class="fa-solid fa-folder w-5 text-center flex-shrink-0"></i>
                    <span :class="sidebarCollapsed ? 'lg:hidden' : 'inline'">Categories</span>
                </a>

                <a href="{{ route('admin.orders.index') }}" 
                   class="flex items-center px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.orders.*') ? 'bg-[#C49A6C] text-white shadow-lg shadow-[#C49A6C]/25' : 'hover:bg-slate-800 hover:text-white' }}"
                   :class="sidebarCollapsed ? 'lg:justify-center lg:space-x-0' : 'space-x-3.5'">
                    <i class="fa-solid fa-truck w-5 text-center flex-shrink-0"></i>
                    <span :class="sidebarCollapsed ? 'lg:hidden' : 'inline'">Orders</span>
                    @php
                        $pendingOrdersCount = \App\Models\Order::where('status', 'pending')->count();
                    @endphp
                    @if($pendingOrdersCount > 0)
                        <span x-show="!sidebarCollapsed" class="ml-auto bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full lg:inline">{{ $pendingOrdersCount }}</span>
                        <!-- Mobile/Sidebar badge fallback -->
                        <span class="lg:hidden ml-auto bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $pendingOrdersCount }}</span>
                    @endif
                </a>

                <a href="{{ route('admin.banners.index') }}" 
                   class="flex items-center px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.banners.*') ? 'bg-[#C49A6C] text-white shadow-lg shadow-[#C49A6C]/25' : 'hover:bg-slate-800 hover:text-white' }}"
                   :class="sidebarCollapsed ? 'lg:justify-center lg:space-x-0' : 'space-x-3.5'">
                    <i class="fa-solid fa-image w-5 text-center flex-shrink-0"></i>
                    <span :class="sidebarCollapsed ? 'lg:hidden' : 'inline'">Banners</span>
                </a>

                <a href="{{ route('admin.testimonials.index') }}" 
                   class="flex items-center px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.testimonials.*') ? 'bg-[#C49A6C] text-white shadow-lg shadow-[#C49A6C]/25' : 'hover:bg-slate-800 hover:text-white' }}"
                   :class="sidebarCollapsed ? 'lg:justify-center lg:space-x-0' : 'space-x-3.5'">
                    <i class="fa-solid fa-comment-dots w-5 text-center flex-shrink-0"></i>
                    <span :class="sidebarCollapsed ? 'lg:hidden' : 'inline'">Testimonials</span>
                </a>

                {{-- 
                <a href="{{ route('admin.coupons.index') }}" 
                   class="flex items-center px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.coupons.*') ? 'bg-[#C49A6C] text-white shadow-lg shadow-[#C49A6C]/25' : 'hover:bg-slate-800 hover:text-white' }}"
                   :class="sidebarCollapsed ? 'lg:justify-center lg:space-x-0' : 'space-x-3.5'">
                    <i class="fa-solid fa-tag w-5 text-center flex-shrink-0"></i>
                    <span :class="sidebarCollapsed ? 'lg:hidden' : 'inline'">Coupons</span>
                </a>
                --}}

                <a href="{{ route('admin.settings.edit') }}" 
                   class="flex items-center px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.settings.*') ? 'bg-[#C49A6C] text-white shadow-lg shadow-[#C49A6C]/25' : 'hover:bg-slate-800 hover:text-white' }}"
                   :class="sidebarCollapsed ? 'lg:justify-center lg:space-x-0' : 'space-x-3.5'">
                    <i class="fa-solid fa-sliders w-5 text-center flex-shrink-0"></i>
                    <span :class="sidebarCollapsed ? 'lg:hidden' : 'inline'">Settings</span>
                </a>

                <div class="pt-6 mt-6 border-t border-slate-800/80">
                    <a href="/" 
                       class="flex items-center px-4 py-3 rounded-xl text-sm font-semibold hover:bg-slate-800 hover:text-white transition-all text-slate-400"
                       :class="sidebarCollapsed ? 'lg:justify-center lg:space-x-0' : 'space-x-3.5'">
                        <i class="fa-solid fa-arrow-left-long w-5 text-center flex-shrink-0"></i>
                        <span :class="sidebarCollapsed ? 'lg:hidden' : 'inline'">Back to Storefront</span>
                    </a>
                </div>
            </nav>

            <!-- Bottom Profile / Logout -->
            <div class="p-4 bg-slate-950 border-t border-slate-800/70" :class="sidebarCollapsed ? 'lg:p-3' : 'p-4'">
                <div class="flex items-center justify-between w-full" :class="sidebarCollapsed ? 'lg:flex-col lg:space-y-4 lg:items-center' : 'flex-row'">
                    <div class="flex items-center space-x-3" :class="sidebarCollapsed ? 'lg:space-x-0' : 'space-x-3'">
                        <div class="bg-[#C49A6C]/20 text-[#C49A6C] h-9 w-9 rounded-full flex items-center justify-center font-bold flex-shrink-0 shadow-sm border border-[#C49A6C]/10">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div x-show="!sidebarCollapsed" class="hidden lg:block overflow-hidden transition-all duration-300">
                            <span class="block text-xs font-semibold text-white truncate max-w-[120px]">{{ auth()->user()->name }}</span>
                            <span class="block text-[10px] text-slate-500 truncate max-w-[120px]">{{ auth()->user()->email }}</span>
                        </div>
                        <!-- Mobile profile info -->
                        <div class="overflow-hidden lg:hidden">
                            <span class="block text-xs font-semibold text-white truncate max-w-[120px]">{{ auth()->user()->name }}</span>
                            <span class="block text-[10px] text-slate-500 truncate max-w-[120px]">{{ auth()->user()->email }}</span>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" :class="sidebarCollapsed ? 'lg:w-auto' : 'w-auto'">
                        @csrf
                        <button type="submit" class="text-slate-400 hover:text-red-400 p-2 transition cursor-pointer" title="Log Out">
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Overlay for mobile drawer -->
        <div x-show="sidebarOpen" 
             @click="sidebarOpen = false" 
             class="fixed inset-0 z-40 bg-black/50 lg:hidden"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"></div>

        <!-- Main Content Area -->
        <div class="flex flex-col flex-1 overflow-hidden">
            
            <!-- Top Header -->
            <header class="flex items-center justify-between px-6 py-4 bg-white border-b border-slate-100">
                <div class="flex items-center space-x-3">
                    <!-- Mobile Hamburger -->
                    <button @click="sidebarOpen = true" class="lg:hidden text-slate-500 hover:text-slate-700 mr-2">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                    
                    <!-- Desktop Collapse Toggle -->
                    <button @click="sidebarCollapsed = !sidebarCollapsed" class="hidden lg:flex text-slate-400 hover:text-slate-600 transition p-1.5 hover:bg-slate-50 rounded-lg focus:outline-none cursor-pointer" title="Toggle Sidebar">
                        <i class="fa-solid text-base" :class="sidebarCollapsed ? 'fa-indent' : 'fa-outdent'"></i>
                    </button>
                    
                    <h2 class="text-lg font-bold text-slate-800">
                        @yield('header_title', 'Overview')
                    </h2>
                </div>

                <div class="flex items-center space-x-4">
                    <span class="text-xs text-slate-400 hidden sm:inline">{{ date('l, d M Y') }}</span>
                    <div class="h-6 w-[1px] bg-slate-200 hidden sm:block"></div>
                    <a href="/" target="_blank" class="text-xs font-semibold text-[#C49A6C] hover:text-[#b0875b] transition flex items-center space-x-1.5">
                        <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                        <span>Live Site</span>
                    </a>
                </div>
            </header>

            <!-- Main Scrollable Section -->
            <main class="flex-1 overflow-y-auto px-6 py-8">
                
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center space-x-3 text-emerald-800 shadow-sm animate-fade-in" x-data="{ show: true }" x-show="show">
                        <i class="fa-solid fa-circle-check text-emerald-500 text-lg"></i>
                        <span class="text-sm font-semibold">{{ session('success') }}</span>
                        <button @click="show = false" class="ml-auto text-emerald-400 hover:text-emerald-600"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 bg-rose-50 border border-rose-100 rounded-2xl flex items-center space-x-3 text-rose-800 shadow-sm animate-fade-in" x-data="{ show: true }" x-show="show">
                        <i class="fa-solid fa-circle-exclamation text-rose-500 text-lg"></i>
                        <span class="text-sm font-semibold">{{ session('error') }}</span>
                        <button @click="show = false" class="ml-auto text-rose-400 hover:text-rose-600"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>

    </div>
    @stack('scripts')
</body>
</html>
