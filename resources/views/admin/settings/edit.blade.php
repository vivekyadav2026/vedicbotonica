@extends('layouts.admin')

@section('header_title', 'Global Settings')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-2xl border border-slate-100 p-6 sm:p-8 shadow-xs">
    
    <div class="mb-6 flex items-center justify-between">
        <h3 class="font-serif font-bold text-slate-800 text-lg">System Settings</h3>
    </div>

    <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
        @csrf

        <!-- Site Identity -->
        <div class="bg-slate-50 p-5 rounded-2xl border border-slate-100 space-y-4">
            <h4 class="font-serif font-bold text-slate-800 text-sm pb-1.5 border-b border-slate-200">Shop Identity</h4>

            <!-- Site Name -->
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Shop Name</label>
                <input type="text" name="site_name" value="{{ $settings['site_name'] ?? 'Vedic Botanica' }}" placeholder="Vedic Botanica"
                       class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5 bg-white">
            </div>

            <!-- Site Email -->
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Support Email</label>
                <input type="email" name="site_email" value="{{ $settings['site_email'] ?? 'support@vedicbotanica.com' }}" placeholder="support@vedicbotanica.com"
                       class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5 bg-white">
            </div>

            <!-- Site Phone -->
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Support Phone</label>
                <input type="text" name="site_phone" value="{{ $settings['site_phone'] ?? '+91-9876543210' }}" placeholder="+91-9876543210"
                       class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5 bg-white">
            </div>

            <!-- Site Address -->
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Physical Address</label>
                <textarea name="site_address" rows="3" placeholder="Shop Address..."
                          class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5 bg-white">{{ $settings['site_address'] ?? 'Haridwar, Uttarakhand, India' }}</textarea>
            </div>
        </div>

        <!-- Payment Settings -->
        <div class="bg-slate-50 p-5 rounded-2xl border border-slate-100 space-y-4">
            <h4 class="font-serif font-bold text-slate-800 text-sm pb-1.5 border-b border-slate-200">Razorpay Integrations</h4>

            <!-- Razorpay Key -->
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Razorpay API Key</label>
                <input type="text" name="razorpay_key" value="{{ $settings['razorpay_key'] ?? config('services.razorpay.key') }}" placeholder="rzp_live_..."
                       class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5 bg-white">
            </div>

            <!-- Razorpay Secret -->
            <div class="space-y-1.5" x-data="{ showSecret: false }">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Razorpay API Secret</label>
                <div class="relative">
                    <input :type="showSecret ? 'text' : 'password'" name="razorpay_secret" value="{{ $settings['razorpay_secret'] ?? config('services.razorpay.secret') }}" placeholder="••••••••••••••••"
                           class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm pl-4 pr-10 py-2.5 bg-white">
                    <button type="button" @click="showSecret = !showSecret" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-[#C49A6C] focus:outline-none cursor-pointer" title="Toggle Secret Visibility">
                        <i class="fa-solid text-sm" :class="showSecret ? 'fa-eye-slash' : 'fa-eye'"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Shiprocket Settings -->
        <div class="bg-slate-50 p-5 rounded-2xl border border-slate-100 space-y-4">
            <h4 class="font-serif font-bold text-slate-800 text-sm pb-1.5 border-b border-slate-200">Shiprocket Logistics</h4>

            <!-- Shiprocket Email -->
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Shiprocket API Email</label>
                <input type="email" name="shiprocket_email" value="{{ $settings['shiprocket_email'] ?? '' }}" placeholder="email@shiprocket.in"
                       class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5 bg-white">
            </div>

            <!-- Shiprocket Password -->
            <div class="space-y-1.5" x-data="{ showPassword: false }">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Shiprocket API Password</label>
                <div class="relative">
                    <input :type="showPassword ? 'text' : 'password'" name="shiprocket_password" value="{{ $settings['shiprocket_password'] ?? '' }}" placeholder="••••••••••••••••"
                           class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm pl-4 pr-10 py-2.5 bg-white">
                    <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-[#C49A6C] focus:outline-none cursor-pointer" title="Toggle Password Visibility">
                        <i class="fa-solid text-sm" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                    </button>
                </div>
            </div>

            <!-- Shiprocket Pickup Location -->
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Pickup Location Name</label>
                <input type="text" name="shiprocket_pickup_location" value="{{ $settings['shiprocket_pickup_location'] ?? 'Primary' }}" placeholder="Primary"
                       class="w-full border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5 bg-white">
                <span class="text-[10px] text-slate-400 block mt-1">Must exactly match the pickup location nickname registered in your Shiprocket panel.</span>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="flex justify-end pt-4 border-t border-slate-100">
            <button type="submit" class="w-full sm:w-auto bg-[#C49A6C] hover:bg-[#b0875b] text-white font-bold text-sm px-8 py-3.5 rounded-xl shadow-md shadow-[#C49A6C]/20 transition cursor-pointer">
                Save Settings
            </button>
        </div>
    </form>

</div>
@endsection
