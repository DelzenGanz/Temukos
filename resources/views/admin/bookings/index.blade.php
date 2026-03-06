@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800">Kelola Pemesanan</h1>
        <a href="{{ route('admin.bookings.create') }}" class="px-5 py-2.5 bg-emerald-600 text-white text-sm font-bold rounded-xl hover:bg-emerald-700 transition-all shadow-sm flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Pemesanan Manual
        </a>
    </div>

    {{-- Filters --}}
    <div class="flex flex-wrap gap-3">
        <form action="{{ route('admin.bookings.index') }}" method="GET" class="flex flex-wrap gap-3">
            <select name="status" onchange="this.form.submit()" class="px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-emerald-300 focus:border-emerald-300">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Paid</option>
                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>

            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari penyewa atau properti..."
                       class="pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-emerald-300 focus:border-emerald-300">
            </div>

            <button type="submit" class="px-4 py-2.5 bg-emerald-600 text-white text-sm font-medium rounded-xl hover:bg-emerald-700 transition-colors">Cari</button>
        </form>
    </div>

    {{-- Bookings Table --}}
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                        <th class="px-6 py-3">ID</th>
                        <th class="px-6 py-3">Penyewa</th>
                        <th class="px-6 py-3">Properti</th>
                        <th class="px-6 py-3">Tanggal Mulai</th>
                        <th class="px-6 py-3">Durasi</th>
                        <th class="px-6 py-3">Total</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($bookings as $booking)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-gray-600">#{{ $booking->id }}</td>
                        <td class="px-6 py-4">
                            @if($booking->user)
                            <div>
                                <p class="font-medium text-gray-800">{{ $booking->user->name }}</p>
                                <p class="text-xs text-gray-400">{{ $booking->user->email }}</p>
                            </div>
                            @else
                            <div>
                                <p class="font-medium text-gray-500 italic">Pemesanan Manual</p>
                                <p class="text-xs text-gray-400">Terinput oleh Admin</p>
                            </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ $booking->property->name }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $booking->start_date->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $booking->duration_months }} bulan</td>
                        <td class="px-6 py-4 font-semibold text-gray-800">{{ $booking->formattedTotalPrice() }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-lg
                                {{ $booking->isPaid() ? 'bg-emerald-100 text-emerald-700' : ($booking->isPending() ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-700') }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <form action="{{ route('admin.bookings.updateStatus', $booking) }}" method="POST" class="inline-flex items-center gap-2">
                                @csrf @method('PATCH')
                                <select name="status" class="text-xs px-2 py-1.5 rounded-lg border border-gray-200 focus:ring-1 focus:ring-emerald-300">
                                    <option value="pending" {{ $booking->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="paid" {{ $booking->status === 'paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                <button type="submit" class="text-xs px-2 py-1.5 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors">
                                    Update
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center text-gray-400">Belum ada pemesanan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $bookings->links() }}
    </div>
</div>
@endsection
