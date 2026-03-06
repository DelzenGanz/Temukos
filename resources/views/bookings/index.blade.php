@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Pemesanan Saya</h1>
    </div>

    @if($bookings->count())
    <div class="space-y-4">
        @foreach($bookings as $booking)
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-gray-100 dark:border-slate-800 p-5 sm:p-6 hover:shadow-md transition-shadow">
            <div class="flex flex-col sm:flex-row gap-4">
                {{-- Property Photo --}}
                <div class="w-full sm:w-32 h-24 sm:h-24 rounded-xl overflow-hidden bg-gray-100 dark:bg-slate-800 shrink-0">
                    @if($booking->property->primaryPhoto)
                        <img src="{{ $booking->property->primaryPhoto->url }}"
                             alt="{{ $booking->property->name }}"
                             class="w-full h-full object-cover"
                             onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($booking->property->name) }}&size=200&background=d1fae5&color=047857&bold=true'">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-emerald-50 to-teal-50">
                            <svg class="w-8 h-8 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                        </div>
                    @endif
                </div>

                {{-- Booking Details --}}
                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <h3 class="font-semibold text-gray-800 dark:text-gray-200 truncate">
                                <a href="{{ route('property.show', $booking->property) }}" class="hover:text-emerald-600 transition-colors">
                                    {{ $booking->property->name }}
                                </a>
                            </h3>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $booking->property->city }}</p>
                        </div>
                        {{-- Status Badge --}}
                        <span class="shrink-0 px-3 py-1 text-xs font-semibold rounded-lg
                            {{ $booking->isPaid() ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400' : ($booking->isPending() ? 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400' : 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400') }}">
                            {{ $booking->isPaid() ? 'Dibayar' : ($booking->isPending() ? 'Menunggu' : 'Dibatalkan') }}
                        </span>
                    </div>

                    <div class="flex flex-wrap gap-x-4 gap-y-1 mt-3 text-xs text-gray-500 dark:text-gray-400">
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            {{ $booking->start_date->format('d M Y') }}
                        </span>
                        <span>{{ $booking->duration_months }} bulan</span>
                        <span class="font-semibold text-gray-700 dark:text-gray-300">{{ $booking->formattedTotalPrice() }}</span>
                    </div>

                    {{-- Pay Now Button --}}
                    @if($booking->isPending() && $booking->snap_token)
                    <button onclick="payNow({{ $booking->id }})"
                            class="mt-3 inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-white bg-gradient-to-r from-amber-500 to-orange-500 rounded-lg hover:shadow-md transition-all"
                            id="pay-btn-{{ $booking->id }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                        Bayar Sekarang
                    </button>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $bookings->links() }}
    </div>
    @else
    {{-- Empty State --}}
    <div class="text-center py-20">
        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
        </div>
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-1">Belum ada pemesanan</h3>
        <p class="text-sm text-gray-400 dark:text-gray-500 mb-4">Anda belum melakukan pemesanan. Mulai cari properti impian Anda!</p>
        <a href="{{ route('home') }}" class="inline-block px-6 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-semibold rounded-xl hover:shadow-lg transition-all text-sm">
            Cari Properti
        </a>
    </div>
    @endif
</div>

@push('scripts-head')
<script src="{{ config('midtrans.snap_url') }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
@endpush

@push('scripts')
<script>
    function payNow(bookingId) {
        const btn = document.getElementById('pay-btn-' + bookingId);
        btn.disabled = true;
        btn.textContent = 'Memproses...';

        fetch('/bookings/' + bookingId + '/pay', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
        })
        .then(res => res.json())
        .then(data => {
            if (data.success && data.snap_token) {
                window.snap.pay(data.snap_token, {
                    onSuccess: function(result) {
                        window.location.reload();
                    },
                    onPending: function(result) {
                        window.location.reload();
                    },
                    onError: function(result) {
                        alert('Pembayaran gagal.');
                        btn.disabled = false;
                        btn.textContent = 'Bayar Sekarang';
                    },
                    onClose: function() {
                        btn.disabled = false;
                        btn.textContent = 'Bayar Sekarang';
                    }
                });
            } else {
                alert(data.message || 'Gagal memuat pembayaran.');
                btn.disabled = false;
                btn.textContent = 'Bayar Sekarang';
            }
        })
        .catch(err => {
            alert('Terjadi kesalahan.');
            btn.disabled = false;
            btn.textContent = 'Bayar Sekarang';
        });
    }
</script>
@endpush
@endsection
