@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Breadcrumb --}}
    <nav class="text-sm text-gray-400 mb-6">
        <a href="{{ route('home') }}" class="hover:text-emerald-600 transition-colors">Beranda</a>
        <span class="mx-2">›</span>
        <span class="text-gray-600">{{ $property->name }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Left Column: Photos + Details --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Photo Carousel --}}
            <div class="relative rounded-2xl overflow-hidden bg-gray-100" id="photo-carousel">
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
                <button onclick="changeSlide(-1)" class="absolute left-3 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/80 backdrop-blur rounded-full flex items-center justify-center shadow-lg hover:bg-white transition-all">
                    <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <button onclick="changeSlide(1)" class="absolute right-3 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/80 backdrop-blur rounded-full flex items-center justify-center shadow-lg hover:bg-white transition-all">
                    <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
            <div class="bg-white rounded-2xl border border-gray-100 p-6 sm:p-8">
                <div class="flex items-start justify-between gap-4 mb-4">
                    <div>
                        <span class="inline-block px-3 py-1 text-xs font-semibold rounded-lg capitalize mb-2
                            {{ $property->property_type === 'kos' ? 'bg-emerald-100 text-emerald-700' : ($property->property_type === 'kontrakan' ? 'bg-amber-100 text-amber-700' : 'bg-indigo-100 text-indigo-700') }}">
                            {{ $property->property_type }}
                        </span>
                        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">{{ $property->name }}</h1>
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
                    <h2 class="text-sm font-semibold text-gray-700 mb-3">Fasilitas</h2>
                    <div class="flex flex-wrap gap-2">
                        @foreach($property->facilities as $facility)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm bg-emerald-50 text-emerald-700 rounded-lg font-medium">
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
                    <h2 class="text-sm font-semibold text-gray-700 mb-3">Deskripsi</h2>
                    <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-line">{{ $property->description }}</p>
                </div>
            </div>
        </div>

        {{-- Right Column: Booking Sidebar --}}
        <div class="lg:col-span-1">
            <div class="sticky top-20 bg-white rounded-2xl border border-gray-100 shadow-lg p-6 space-y-5">
                {{-- Price --}}
                <div class="text-center pb-4 border-b border-gray-100">
                    <p class="text-3xl font-bold text-emerald-600">{{ $property->formattedPrice() }}</p>
                    <p class="text-sm text-gray-400 mt-0.5">per bulan</p>
                </div>

                @auth
                {{-- Booking Form --}}
                <div id="booking-form-section">
                    <div class="space-y-4">
                        {{-- Booked Dates Info --}}
                        @if($bookedRanges->count() > 0)
                        <div class="p-4 bg-amber-50 rounded-xl border border-amber-100">
                            <h3 class="text-xs font-bold text-amber-800 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Jadwal Terisi
                            </h3>
                            <ul class="space-y-1">
                                @foreach($bookedRanges as $range)
                                <li class="text-xs text-amber-700 flex items-center gap-2">
                                    <span class="w-1 h-1 rounded-full bg-amber-400"></span>
                                    {{ \Carbon\Carbon::parse($range['start'])->format('d M Y') }} - {{ \Carbon\Carbon::parse($range['end'])->format('d M Y') }}
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal Mulai</label>
                            <input type="date"
                                   id="start_date"
                                   min="{{ date('Y-m-d') }}"
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-emerald-300 focus:border-emerald-300">
                        </div>
                        <div>
                            <label for="duration_months" class="block text-sm font-medium text-gray-700 mb-1.5">Durasi Sewa</label>
                            <select id="duration_months" class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-emerald-300 focus:border-emerald-300">
                                @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}">{{ $i }} bulan</option>
                                @endfor
                            </select>
                        </div>

                        {{-- Total Preview --}}
                        <div class="bg-emerald-50 rounded-xl p-4">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-600">Total Biaya</span>
                                <span id="total-price" class="text-lg font-bold text-emerald-700">{{ $property->formattedPrice() }}</span>
                            </div>
                            <p class="text-xs text-gray-400 mt-1" id="price-breakdown">{{ $property->formattedPrice() }} × 1 bulan</p>
                        </div>

                        <button onclick="submitBooking()"
                                id="booking-btn"
                                class="w-full py-3.5 bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-semibold rounded-xl hover:shadow-lg hover:shadow-emerald-200 transition-all duration-300 text-sm">
                            Pesan Sekarang
                        </button>
                    </div>
                </div>
                @else
                {{-- Guest CTA --}}
                <div class="text-center py-4">
                    <p class="text-sm text-gray-500 mb-4">Silakan login untuk melakukan pemesanan</p>
                    <a href="{{ route('login') }}"
                       class="inline-block w-full py-3.5 bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-semibold rounded-xl hover:shadow-lg hover:shadow-emerald-200 transition-all duration-300 text-sm text-center">
                        Login untuk Memesan
                    </a>
                    <p class="text-xs text-gray-400 mt-3">Belum punya akun? <a href="{{ route('register') }}" class="text-emerald-600 hover:underline">Daftar</a></p>
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
