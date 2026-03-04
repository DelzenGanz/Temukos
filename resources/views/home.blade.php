@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Hero / Search Section --}}
    <div class="relative bg-gradient-to-br from-emerald-600 via-teal-600 to-cyan-600 rounded-2xl overflow-hidden mb-10 px-6 sm:px-10 py-12 sm:py-16">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg%20width%3D%2240%22%20height%3D%2240%22%20viewBox%3D%220%200%2040%2040%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Cg%20fill%3D%22%23fff%22%20fill-opacity%3D%220.05%22%3E%3Cpath%20d%3D%22M0%2020L20%200h20v20L20%2040H0z%22%2F%3E%3C%2Fg%3E%3C%2Fsvg%3E')] opacity-50"></div>
        <div class="relative z-10">
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white mb-3 tracking-tight">Temu kosmu<br class="sm:hidden"> dengan mudah</h1>
            <p class="text-emerald-100 text-sm sm:text-base max-w-md mb-8">Cari kos, kontrakan, dan apartemen impianmu di seluruh Indonesia. Booking langsung, bayar aman.</p>

            {{-- Search Form --}}
            <form action="{{ route('home') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1 relative">
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Cari berdasarkan lokasi, nama, atau kota..."
                           class="w-full pl-12 pr-4 py-3.5 rounded-xl border-0 shadow-lg text-sm text-gray-700 placeholder-gray-400 focus:ring-2 focus:ring-emerald-300 focus:outline-none"
                           id="search-input">
                </div>
                <button type="button"
                        onclick="document.getElementById('filter-modal').classList.remove('hidden')"
                        class="inline-flex items-center gap-2 px-5 py-3.5 bg-white/20 backdrop-blur text-white text-sm font-medium rounded-xl border border-white/30 hover:bg-white/30 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    Filter
                </button>
                <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-3.5 bg-white text-emerald-700 text-sm font-semibold rounded-xl shadow-lg hover:shadow-xl hover:bg-emerald-50 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Cari
                </button>
            </form>
        </div>
    </div>

    {{-- Results Count --}}
    <div class="flex items-center justify-between mb-6">
        <p class="text-sm text-gray-500">
            <span class="font-semibold text-gray-800">{{ $totalResults }}</span> properti ditemukan
        </p>
        <div class="text-sm text-gray-400">
            @if(request()->hasAny(['search', 'type', 'price_min', 'price_max', 'facilities', 'sort']))
                <a href="{{ route('home') }}" class="text-emerald-600 hover:text-emerald-700 font-medium transition-colors">Reset filter ×</a>
            @endif
        </div>
    </div>

    {{-- Property Grid --}}
    @if($properties->count())
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($properties as $property)
        <a href="{{ route('property.show', $property) }}"
           class="group bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-xl hover:border-emerald-100 hover:-translate-y-1 transition-all duration-300">
            {{-- Photo --}}
            <div class="aspect-[4/3] bg-gray-100 overflow-hidden relative">
                @if($property->primaryPhoto)
                    <img src="{{ $property->primaryPhoto->url }}"
                         alt="{{ $property->name }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                         onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($property->name) }}&size=400&background=d1fae5&color=047857&bold=true'">
                @else
                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-emerald-50 to-teal-50">
                        <svg class="w-12 h-12 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </div>
                @endif
                {{-- Type Badge --}}
                <span class="absolute top-3 left-3 px-2.5 py-1 text-xs font-semibold rounded-lg capitalize
                    {{ $property->property_type === 'kos' ? 'bg-emerald-500 text-white' : ($property->property_type === 'kontrakan' ? 'bg-amber-500 text-white' : 'bg-indigo-500 text-white') }}">
                    {{ $property->property_type }}
                </span>
            </div>

            {{-- Content --}}
            <div class="p-4">
                <h3 class="font-semibold text-gray-800 text-sm leading-snug group-hover:text-emerald-700 transition-colors line-clamp-1">{{ $property->name }}</h3>
                <p class="text-xs text-gray-400 mt-1 flex items-center gap-1 line-clamp-1">
                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    {{ $property->city }} · {{ $property->address }}
                </p>

                {{-- Facility Tags --}}
                <div class="flex flex-wrap gap-1.5 mt-3">
                    @foreach($property->facilities->take(3) as $facility)
                    <span class="px-2 py-0.5 text-[10px] font-medium bg-emerald-50 text-emerald-700 rounded-md">{{ $facility->name }}</span>
                    @endforeach
                    @if($property->facilities->count() > 3)
                    <span class="px-2 py-0.5 text-[10px] font-medium bg-gray-50 text-gray-500 rounded-md">+{{ $property->facilities->count() - 3 }}</span>
                    @endif
                </div>

                {{-- Price --}}
                <div class="mt-3 pt-3 border-t border-gray-50">
                    <p class="text-emerald-600 font-bold text-sm">{{ $property->formattedPrice() }}<span class="text-xs font-normal text-gray-400">/bulan</span></p>
                </div>
            </div>
        </a>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="mt-10">
        {{ $properties->links() }}
    </div>
    @else
    {{-- Empty State --}}
    <div class="text-center py-20">
        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </div>
        <h3 class="text-lg font-semibold text-gray-800 mb-1">Tidak ada properti ditemukan</h3>
        <p class="text-sm text-gray-400">Coba ubah kata kunci pencarian atau filter Anda.</p>
    </div>
    @endif
</div>

{{-- Filter Modal --}}
<div id="filter-modal" class="hidden fixed inset-0 z-[60]">
    {{-- Overlay --}}
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="document.getElementById('filter-modal').classList.add('hidden')"></div>

    {{-- Panel --}}
    <div class="absolute right-0 top-0 h-full w-full max-w-md bg-white shadow-2xl overflow-y-auto">
        <form action="{{ route('home') }}" method="GET">
            {{-- Preserve search --}}
            @if(request('search'))
            <input type="hidden" name="search" value="{{ request('search') }}">
            @endif

            <div class="sticky top-0 bg-white border-b border-gray-100 px-6 py-4 flex items-center justify-between z-10">
                <h2 class="text-lg font-bold text-gray-800">Filter & Urutkan</h2>
                <button type="button" onclick="document.getElementById('filter-modal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <div class="px-6 py-6 space-y-8">
                {{-- Sort --}}
                <div>
                    <h3 class="text-sm font-semibold text-gray-700 mb-3">Urutkan</h3>
                    <div class="space-y-2">
                        @foreach(['terbaru' => 'Terbaru', 'harga_terendah' => 'Harga Terendah', 'harga_tertinggi' => 'Harga Tertinggi', 'paling_populer' => 'Paling Populer'] as $value => $label)
                        <label class="flex items-center gap-3 px-3 py-2.5 rounded-xl border cursor-pointer transition-all
                            {{ request('sort', 'terbaru') === $value ? 'border-emerald-300 bg-emerald-50' : 'border-gray-100 hover:border-emerald-200 hover:bg-emerald-50/50' }}">
                            <input type="radio" name="sort" value="{{ $value }}" {{ request('sort', 'terbaru') === $value ? 'checked' : '' }}
                                   class="w-4 h-4 text-emerald-600 focus:ring-emerald-500">
                            <span class="text-sm text-gray-700">{{ $label }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Property Type --}}
                <div>
                    <h3 class="text-sm font-semibold text-gray-700 mb-3">Tipe Properti</h3>
                    <div class="grid grid-cols-3 gap-3">
                        @foreach(['kos' => 'Kos', 'kontrakan' => 'Kontrakan', 'apartemen' => 'Apartemen'] as $value => $label)
                        <label class="flex flex-col items-center gap-1.5 px-3 py-3 rounded-xl border cursor-pointer transition-all text-center
                            {{ in_array($value, request('type', [])) ? 'border-emerald-300 bg-emerald-50' : 'border-gray-100 hover:border-emerald-200' }}">
                            <input type="checkbox" name="type[]" value="{{ $value }}" {{ in_array($value, request('type', [])) ? 'checked' : '' }}
                                   class="w-4 h-4 text-emerald-600 rounded focus:ring-emerald-500">
                            <span class="text-xs font-medium text-gray-700">{{ $label }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Price Range --}}
                <div>
                    <h3 class="text-sm font-semibold text-gray-700 mb-3">Rentang Harga (per bulan)</h3>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-xs text-gray-400 mb-1 block">Minimum</label>
                            <input type="number" name="price_min" value="{{ request('price_min') }}" placeholder="Rp 0"
                                   class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-emerald-300 focus:border-emerald-300">
                        </div>
                        <div>
                            <label class="text-xs text-gray-400 mb-1 block">Maksimum</label>
                            <input type="number" name="price_max" value="{{ request('price_max') }}" placeholder="Rp 10.000.000"
                                   class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-emerald-300 focus:border-emerald-300">
                        </div>
                    </div>
                </div>

                {{-- Facilities --}}
                <div>
                    <h3 class="text-sm font-semibold text-gray-700 mb-3">Fasilitas</h3>
                    <div class="grid grid-cols-2 gap-2">
                        @foreach($facilities as $facility)
                        <label class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl border cursor-pointer transition-all
                            {{ in_array($facility->id, request('facilities', [])) ? 'border-emerald-300 bg-emerald-50' : 'border-gray-100 hover:border-emerald-200' }}">
                            <input type="checkbox" name="facilities[]" value="{{ $facility->id }}" {{ in_array($facility->id, request('facilities', [])) ? 'checked' : '' }}
                                   class="w-4 h-4 text-emerald-600 rounded focus:ring-emerald-500">
                            <span class="text-xs text-gray-700">{{ $facility->name }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Sticky Footer --}}
            <div class="sticky bottom-0 bg-white border-t border-gray-100 px-6 py-4 flex gap-3">
                <a href="{{ route('home') }}" class="flex-1 text-center text-sm text-gray-500 font-medium py-3 rounded-xl border border-gray-200 hover:bg-gray-50 transition-colors">Reset</a>
                <button type="submit" class="flex-1 text-sm font-semibold text-white py-3 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-600 hover:shadow-lg hover:shadow-emerald-200 transition-all">Terapkan</button>
            </div>
        </form>
    </div>
</div>
@endsection
