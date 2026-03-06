@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Breadcrumb --}}
    <nav class="text-sm text-gray-400 dark:text-gray-500 mb-6">
        <a href="{{ route('home') }}" class="hover:text-emerald-600 transition-colors">Beranda</a>
        <span class="mx-2">›</span>
        <span class="text-gray-600 dark:text-gray-300">{{ $property->name }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Left Column: Photos + Details --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Photo Carousel --}}
            <div class="relative rounded-2xl overflow-hidden bg-gray-100 dark:bg-slate-800" id="photo-carousel">
                @if($photos->count() > 0)
                <div class="aspect-[16/10] relative">
                    @foreach($photos as $index => $photo)
                    <img src="{{ $photo->url }}"
                         alt="{{ $property->name }} - Foto {{ $index + 1 }}"
                         class="carousel-image absolute inset-0 w-full h-full object-cover transition-opacity duration-500 {{ $index === 0 ? 'opacity-100' : 'opacity-0' }}"
                         data-index="{{ $index }}"
                         onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($property->name) }}&size=800&background=d1fae5&color=047857&bold=true'">
                    @endforeach
                </div>

                @if($photos->count() > 1)
                {{-- Navigation Arrows --}}
                <button onclick="changeSlide(-1)" class="absolute left-3 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/80 dark:bg-slate-900/80 backdrop-blur rounded-full flex items-center justify-center shadow-lg hover:bg-white dark:hover:bg-slate-900 transition-all">
                    <svg class="w-5 h-5 text-gray-700 dark:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <button onclick="changeSlide(1)" class="absolute right-3 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/80 dark:bg-slate-900/80 backdrop-blur rounded-full flex items-center justify-center shadow-lg hover:bg-white dark:hover:bg-slate-900 transition-all">
                    <svg class="w-5 h-5 text-gray-700 dark:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>

                {{-- Dots --}}
                <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2">
                    @foreach($photos as $index => $photo)
                    <button onclick="goToSlide({{ $index }})"
                            class="carousel-dot w-2.5 h-2.5 rounded-full transition-all {{ $index === 0 ? 'bg-white w-6' : 'bg-white/50' }}"
                            data-index="{{ $index }}"></button>
                    @endforeach
                </div>
                @endif
                @else
                <div class="aspect-[16/10] flex items-center justify-center bg-gradient-to-br from-emerald-50 to-teal-50">
                    <svg class="w-16 h-16 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </div>
                @endif
            </div>

            {{-- Property Info --}}
            <div class="bg-white dark:bg-slate-900 rounded-2xl border border-gray-100 dark:border-slate-800 p-6 sm:p-8">
                <div class="flex items-start justify-between gap-4 mb-4">
                    <div>
                        <span class="inline-block px-3 py-1 text-xs font-semibold rounded-lg capitalize mb-2
                            {{ $property->property_type === 'kos' ? 'bg-emerald-100 text-emerald-700' : ($property->property_type === 'kontrakan' ? 'bg-amber-100 text-amber-700' : 'bg-indigo-100 text-indigo-700') }}">
                            {{ $property->property_type }}
                        </span>
                        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 dark:text-white">{{ $property->name }}</h1>
                    </div>
                </div>

                <div class="flex items-center gap-1.5 text-sm text-gray-500 mb-6">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    {{ $property->city }}, {{ $property->address }}
                </div>

                {{-- Facilities --}}
                <div class="mb-6">
                    <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Fasilitas</h2>
                    <div class="flex flex-wrap gap-2">
                        @foreach($property->facilities as $facility)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 rounded-lg font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            {{ $facility->name }}
                        </span>
                        @endforeach
                    </div>
                </div>

                {{-- Description --}}
                <div>
                    <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Deskripsi</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed whitespace-pre-line">{{ $property->description }}</p>
                </div>
            </div>
        </div>

        {{-- Right Column: Booking Sidebar --}}
        <div class="lg:col-span-1">
            <div class="sticky top-20 bg-white dark:bg-slate-900 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-lg p-6 space-y-5">
                {{-- Price --}}
                <div class="text-center pb-4 border-b border-gray-100 dark:border-slate-800">
                    <p class="text-3xl font-bold text-emerald-600 dark:text-emerald-400">{{ $property->formattedPrice() }}</p>
                    <p class="text-sm text-gray-400 dark:text-slate-500 mt-0.5">per bulan</p>
                </div>

                @auth
                {{-- Booking Form --}}
                <div id="booking-form-section">
                    <div class="space-y-4">
                        {{-- Booked Dates Info --}}
                        @if($bookedRanges->count() > 0)
                        <div class="p-4 bg-amber-50 dark:bg-amber-900/20 rounded-xl border border-amber-100 dark:border-amber-900/30">
                            <h3 class="text-xs font-bold text-amber-800 dark:text-amber-500 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Jadwal Terisi
                            </h3>
                            <ul class="space-y-1">
                                @foreach($bookedRanges as $range)
                                <li class="text-xs text-amber-700 dark:text-amber-600 flex items-center gap-2">
                                    <span class="w-1 h-1 rounded-full bg-amber-400"></span>
                                    {{ \Carbon\Carbon::parse($range['start'])->format('d M Y') }} - {{ \Carbon\Carbon::parse($range['end'])->format('d M Y') }}
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Tanggal Mulai</label>
                            <input type="date"
                                   id="start_date"
                                   min="{{ date('Y-m-d') }}"
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 dark:text-gray-200 text-sm focus:ring-2 focus:ring-emerald-300 focus:border-emerald-300">
                        </div>
                        <div>
                            <label for="duration_months" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Durasi Sewa</label>
                            <select id="duration_months" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 dark:text-gray-200 text-sm focus:ring-2 focus:ring-emerald-300 focus:border-emerald-300">
                                @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}">{{ $i }} bulan</option>
                                @endfor
                            </select>
                        </div>

                        {{-- Total Preview --}}
                        <div class="bg-emerald-50 dark:bg-emerald-900/20 rounded-xl p-4">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-600 dark:text-gray-400">Total Biaya</span>
                                <span id="total-price" class="text-lg font-bold text-emerald-700 dark:text-emerald-400">{{ $property->formattedPrice() }}</span>
                            </div>
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1" id="price-breakdown">{{ $property->formattedPrice() }} × 1 bulan</p>
                        </div>

                        <button onclick="submitBooking()"
                                id="booking-btn"
                                class="w-full py-3.5 bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-semibold rounded-xl hover:shadow-lg hover:shadow-emerald-200 transition-all duration-300 text-sm">
                            Pesan Sekarang
                        </button>

                        @if($property->phone)
                        <div class="relative flex items-center gap-3 py-2">
                            <div class="flex-grow h-px bg-gray-100 dark:bg-slate-800"></div>
                            <span class="text-[10px] font-bold text-gray-400 dark:text-slate-500 uppercase tracking-widest">Atau</span>
                            <div class="flex-grow h-px bg-gray-100 dark:bg-slate-800"></div>
                        </div>

                        <a href="https://wa.me/{{ $property->phone }}?text={{ urlencode('Halo, saya tertarik dengan properti ' . $property->name . ' yang saya lihat di Temukos.') }}"
                           target="_blank"
                           class="w-full py-3.5 bg-white dark:bg-slate-900 border-2 border-emerald-500 text-emerald-600 dark:text-emerald-400 font-semibold rounded-xl hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-all duration-300 text-sm text-center flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.246 2.248 3.484 5.232 3.484 8.412-.003 6.557-5.338 11.892-11.893 11.892-1.997-.001-3.951-.5-5.688-1.448l-6.309 1.656zm6.224-3.92c1.516.903 3.125 1.38 4.772 1.382 5.227 0 9.482-4.255 9.485-9.483.002-2.533-.986-4.913-2.783-6.712s-4.18-2.787-6.711-2.789c-5.23 0-9.483 4.253-9.485 9.481-.001 1.67.437 3.3 1.27 4.73l-1.027 3.748 3.843-1.007zm10.375-6.522c-.297-.15-.1.45 1.76-2.53-.1.45-1.76-2.53l-.297-.15c-.297-.15-1.758-.867-2.055-1.016-.297-.15-.513-.225-.729.15-.216.375-.838 1.05-.1.45-1.76-2.53l.297-.15c-.297-.15-.513-.225-.729.15-.216.375-.838 1.05-1.026 1.275-.189.225-.378.254-.675.105-.297-.15-1.256-.463-2.39-1.475-.883-.788-1.48-1.76-1.653-2.059-.173-.299-.018-.46.13-.609.135-.134.298-.345.447-.517.148-.172.197-.294.297-.49.098-.196.049-.368-.025-.517-.073-.148-.655-1.577-.899-2.164-.237-.57-.478-.493-.655-.502-.17-.009-.364-.01-.559-.01-.195 0-.513.073-.782.368-.269.294-1.026 1.003-1.026 2.447 0 1.444 1.05 2.84 1.197 3.037.147.197 2.067 3.155 5.008 4.426.699.302 1.246.483 1.671.618.704.223 1.345.192 1.851.117.565-.084 1.758-.72 2.008-1.416.25-.697.25-1.294.175-1.417-.075-.123-.275-.196-.572-.346z"/>
                            </svg>
                            Hubungi Pemilik
                        </a>
                        @endif
                    </div>
                </div>
                @else
                {{-- Guest CTA --}}
                <div class="text-center py-4">
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Silakan login untuk melakukan pemesanan</p>
                    <a href="{{ route('login') }}"
                       class="inline-block w-full py-3.5 bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-semibold rounded-xl hover:shadow-lg hover:shadow-emerald-200 transition-all duration-300 text-sm text-center">
                        Login untuk Memesan
                    </a>
                    <p class="text-xs text-gray-400 dark:text-slate-500 mt-3">Belum punya akun? <a href="{{ route('register') }}" class="text-emerald-600 dark:text-emerald-400 hover:underline">Daftar</a></p>
                </div>
                @endauth
            </div>
        </div>
    </div>
</div>

@push('scripts-head')
<script src="{{ config('midtrans.snap_url') }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
@endpush

@push('scripts')
<script>
    // Photo Carousel
    let currentSlide = 0;
    const totalSlides = {{ $photos->count() }};

    function changeSlide(direction) {
        currentSlide = (currentSlide + direction + totalSlides) % totalSlides;
        updateCarousel();
    }

    function goToSlide(index) {
        currentSlide = index;
        updateCarousel();
    }

    function updateCarousel() {
        document.querySelectorAll('.carousel-image').forEach((img, i) => {
            img.style.opacity = i === currentSlide ? '1' : '0';
        });
        document.querySelectorAll('.carousel-dot').forEach((dot, i) => {
            dot.classList.toggle('bg-white', i === currentSlide);
            dot.classList.toggle('w-6', i === currentSlide);
            dot.classList.toggle('bg-white/50', i !== currentSlide);
            dot.classList.toggle('w-2.5', i !== currentSlide);
        });
    }

    // Price Calculator
    const pricePerMonth = {{ $property->price_month }};

    document.getElementById('duration_months')?.addEventListener('change', function() {
        updatePrice();
    });

    function updatePrice() {
        const duration = parseInt(document.getElementById('duration_months').value);
        const total = pricePerMonth * duration;
        const formatted = 'Rp ' + total.toLocaleString('id-ID');
        const perMonth = 'Rp ' + pricePerMonth.toLocaleString('id-ID');
        document.getElementById('total-price').textContent = formatted;
        document.getElementById('price-breakdown').textContent = perMonth + ' × ' + duration + ' bulan';
    }

    // Booking Submission
    const bookedRanges = @json($bookedRanges);

    function isOverlapping(startStr, durationMonths) {
        const selectedStart = new Date(startStr);
        const selectedEnd = new Date(startStr);
        selectedEnd.setMonth(selectedEnd.getMonth() + parseInt(durationMonths));

        for (const range of bookedRanges) {
            const rangeStart = new Date(range.start);
            const rangeEnd = new Date(range.end);

            // A overlaps B if (A.start < B.end) AND (A.end > B.start)
            if (selectedStart < rangeEnd && selectedEnd > rangeStart) {
                return true;
            }
        }
        return false;
    }

    function submitBooking() {
        const startDate = document.getElementById('start_date').value;
        const duration = document.getElementById('duration_months').value;
        const btn = document.getElementById('booking-btn');

        if (!startDate) {
            alert('Silakan pilih tanggal mulai sewa.');
            return;
        }

        if (isOverlapping(startDate, duration)) {
            alert('Properti ini tidak tersedia pada rentang tanggal yang Anda pilih. Silakan periksa "Jadwal Terisi" di atas.');
            return;
        }

        btn.disabled = true;
        btn.textContent = 'Memproses...';

        fetch('{{ route("bookings.store", $property) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                start_date: startDate,
                duration_months: parseInt(duration),
            }),
        })
        .then(res => res.json())
        .then(data => {
            if (data.success && data.snap_token) {
                window.snap.pay(data.snap_token, {
                    onSuccess: function(result) {
                        window.location.href = '{{ route("bookings.index") }}';
                    },
                    onPending: function(result) {
                        window.location.href = '{{ route("bookings.index") }}';
                    },
                    onError: function(result) {
                        alert('Pembayaran gagal. Silakan coba lagi.');
                        btn.disabled = false;
                        btn.textContent = 'Pesan Sekarang';
                    },
                    onClose: function() {
                        btn.disabled = false;
                        btn.textContent = 'Pesan Sekarang';
                    }
                });
            } else {
                alert(data.message || 'Terjadi kesalahan. Silakan coba lagi.');
                btn.disabled = false;
                btn.textContent = 'Pesan Sekarang';
            }
        })
        .catch(err => {
            alert('Terjadi kesalahan jaringan. Silakan coba lagi.');
            btn.disabled = false;
            btn.textContent = 'Pesan Sekarang';
        });
    }
</script>
@endpush
@endsection
