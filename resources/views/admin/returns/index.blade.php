@extends('layouts.admin')

@section('header_title', 'Manage Return Requests')

@section('content')
<div class="space-y-6">

    <!-- Actions Panel -->
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4 bg-white p-5 rounded-2xl border border-slate-100 shadow-xs">
        <!-- Search & Filter Form -->
        <form method="GET" action="{{ route('admin.returns.index') }}" class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
            <select name="status" class="w-full sm:w-48 border border-slate-200 focus:ring-1 focus:ring-[#C49A6C] focus:border-[#C49A6C] rounded-xl text-sm px-4 py-2.5 bg-slate-50">
                <option value="">All Statuses</option>
                <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                <option value="approved" @selected(request('status') === 'approved')>Approved</option>
                <option value="rejected" @selected(request('status') === 'rejected')>Rejected</option>
            </select>

            <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white font-semibold text-sm px-5 py-2.5 rounded-xl transition cursor-pointer">
                Filter
            </button>
            
            @if(request()->filled('status'))
                <a href="{{ route('admin.returns.index') }}" class="text-xs font-semibold text-slate-400 hover:text-slate-600">Clear</a>
            @endif
        </form>
    </div>

    <!-- Returns Table -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-55 border-b border-slate-100 text-slate-400 text-[11px] font-bold uppercase tracking-wider">
                        <th class="px-6 py-4">Request ID</th>
                        <th class="px-6 py-4">Date</th>
                        <th class="px-6 py-4">Customer</th>
                        <th class="px-6 py-4">Order Number</th>
                        <th class="px-6 py-4">Reason</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-650">
                    @forelse($returns as $return)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-6 py-4 font-mono font-bold text-slate-800">#{{ $return->id }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $return->created_at->format('M d, Y H:i') }}</td>
                            <td class="px-6 py-4">
                                <div class="font-semibold text-slate-800">{{ $return->user->name }}</div>
                                <div class="text-xs text-slate-400 font-sans">{{ $return->user->email }}</div>
                            </td>
                            <td class="px-6 py-4 font-mono font-semibold text-slate-700">
                                @if($return->order)
                                    {{ $return->order->order_number }}
                                @else
                                    <span class="text-red-500">N/A (Deleted)</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 max-w-xs truncate" title="{{ $return->reason }}">
                                {{ $return->reason }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold 
                                    {{ $return->status === 'pending' ? 'bg-blue-50 text-blue-700 border border-blue-200' : '' }}
                                    {{ $return->status === 'approved' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : '' }}
                                    {{ $return->status === 'rejected' ? 'bg-rose-50 text-rose-700 border border-rose-200' : '' }}
                                ">
                                    {{ ucfirst($return->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end items-center">
                                    <a href="{{ route('admin.returns.show', $return->id) }}" class="p-2 bg-slate-100 hover:bg-[#C49A6C] hover:text-white rounded-lg text-slate-650 transition font-semibold text-xs flex items-center space-x-1" title="View Request Details">
                                        <i class="fa-solid fa-eye mr-1"></i> View Details
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-slate-400 font-medium">No return requests found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($returns->hasPages())
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100">
                {{ $returns->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
