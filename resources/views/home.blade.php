@extends('layouts.app')

@push('scripts-head')
<style>
    /* Custom Animations for Gradient Blobs */
    @keyframes blob {
        0% { transform: translate(0px, 0px) scale(1); }
        33% { transform: translate(30px, -50px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
        100% { transform: translate(0px, 0px) scale(1); }
    }
    .animate-blob {
        animation: blob 10s infinite alternate;
    }
    .animation-delay-2000 {
        animation-delay: 2s;
    }
    .animation-delay-4000 {
        animation-delay: 4s;
    }
    
    /* Premium Glassmorphism Utility */
    .glass-panel {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.9);
        box-shadow: 0 10px 40px -10px rgba(0,0,0,0.05);
    }
    .glass-input {
        background: rgba(255, 255, 255, 0.5);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.6);
    }
    
    /* Dark Mode Glassmorphism */
    .dark .glass-panel {
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.05);
        box-shadow: 0 10px 40px -10px rgba(0,0,0,0.3);
    }
    .dark .glass-input {
        background: rgba(15, 23, 42, 0.4);
        border: 1px solid rgba(255, 255, 255, 0.05);
    }
</style>
@endpush

@section('content')
{{-- 1. Premium Minimalist Hero Section --}}
<section id="hero" class="relative w-full min-h-[95vh] flex items-center justify-center bg-[#f8faf9] dark:bg-[#0b1120] overflow-hidden transition-colors duration-500">
    {{-- Aquatic / Sage Gradient Blobs --}}
    <div class="absolute top-0 right-1/4 w-[600px] h-[600px] bg-teal-200/40 dark:bg-teal-900/40 rounded-full mix-blend-multiply dark:mix-blend-screen filter blur-[100px] opacity-70 animate-blob"></div>
    <div class="absolute top-20 left-1/4 w-[500px] h-[500px] bg-emerald-200/40 dark:bg-emerald-900/30 rounded-full mix-blend-multiply dark:mix-blend-screen filter blur-[100px] opacity-70 animate-blob animation-delay-2000"></div>
    <div class="absolute -bottom-32 left-1/2 w-[700px] h-[700px] bg-cyan-200/30 dark:bg-cyan-900/40 rounded-full mix-blend-multiply dark:mix-blend-screen filter blur-[100px] opacity-70 animate-blob animation-delay-4000 translate-x-1/2"></div>
    
    {{-- Micro Grid Pattern (Optional subtle texture) --}}
    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxwYXRoIGQ9Ik0zNiAzNHYtbmgydi00aC0ydjRoLTJ2NGgtdjJoNHYyaDJ2LTRoMnogZmlsbD0iIzE0OGViOCIgZmlsbC1vcGFjaXR5PSIwLjAyNSIvPjwvZz48L3N2Zz4=')] opacity-50 dark:opacity-10 z-0"></div>

    {{-- Hero Content --}}
    <div class="relative z-10 w-full max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center">
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/60 dark:bg-slate-800/60 backdrop-blur text-teal-700 dark:text-teal-300 border border-teal-100 dark:border-teal-800 shadow-sm text-xs font-bold mb-8 uppercase tracking-[0.2em] transform transition hover:scale-105 cursor-default">
            <span class="w-2 h-2 rounded-full bg-teal-500 animate-pulse"></span>
            Revolusi Pencarian Hunian
        </div>
        
        <h1 class="text-5xl sm:text-6xl lg:text-[5rem] font-extrabold text-gray-900 dark:text-white mb-8 tracking-tighter leading-[1.1]">
            Temu kosmu <br class="hidden sm:block"/>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-teal-600 via-emerald-500 to-cyan-500 dark:from-teal-400 dark:via-emerald-300 dark:to-cyan-400">dengan elegan.</span>
        </h1>
        
        <p class="text-lg sm:text-xl text-gray-500 dark:text-slate-400 max-w-2xl mx-auto mb-14 font-medium leading-relaxed">
            Eksplorasi kos, apartemen, dan kontrakan premium di seluruh Indonesia. Booking instan yang memanjakan kenyamananmu.
        </p>

        {{-- Search Card (Minimalist Glassmorphism) --}}
        <div class="max-w-4xl mx-auto glass-panel p-3 rounded-[2rem]">
            <form action="{{ route('home') }}#properties" method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1 relative">
                    <svg class="absolute left-6 top-1/2 -translate-y-1/2 w-6 h-6 text-teal-600 dark:text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Di mana lokasi idamanmu?"
                           class="w-full pl-16 pr-6 py-5 rounded-[1.5rem] glass-input text-gray-700 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-400 focus:ring-4 focus:ring-teal-500/10 dark:focus:ring-teal-500/20 focus:border-teal-400 dark:focus:border-teal-500 transition-all font-medium text-lg outline-none"
                           id="search-input">
                </div>
                <button type="button"
                        onclick="document.getElementById('filter-modal').classList.remove('hidden')"
                        class="inline-flex items-center justify-center gap-2 lg:px-8 px-6 py-5 bg-white/80 dark:bg-slate-800/80 hover:bg-white dark:hover:bg-slate-700 text-gray-700 dark:text-slate-200 font-bold rounded-[1.5rem] border border-gray-100 dark:border-white/5 shadow-sm hover:shadow-md transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                        <circle cx="10" cy="8" r="3" />
                        <circle cx="14" cy="16" r="3" />
                        <line x1="10" y1="11" x2="10" y2="21" />
                        <line x1="10" y1="3" x2="10" y2="5" />
                        <line x1="14" y1="19" x2="14" y2="21" />
                        <line x1="14" y1="3" x2="14" y2="13" />
                    </svg>
                    Filter
                </button>
                <button type="submit"
                        class="inline-flex items-center justify-center gap-2 lg:px-10 px-8 py-5 bg-gradient-to-r from-teal-600 to-emerald-500 hover:from-teal-500 hover:to-emerald-400 text-white font-bold rounded-[1.5rem] shadow-lg shadow-teal-500/25 hover:shadow-teal-500/40 transition-all transform hover:-translate-y-0.5">
                    Temukan
                    <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </button>
            </form>
        </div>
        
        {{-- Scroll Indicator --}}
        <div class="absolute bottom-10 left-1/2 -translate-x-1/2 animate-bounce">
            <a href="#about" class="flex flex-col items-center gap-2 text-gray-400 hover:text-teal-600 transition-colors">
                <span class="text-xs font-semibold tracking-widest uppercase">Scroll</span>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
            </a>
        </div>
    </div>
</section>

{{-- 2. About Section (Minimalist White) --}}
<section id="about" class="py-32 bg-white dark:bg-slate-900 relative transition-colors duration-500">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
            {{-- Text Content --}}
            <div class="order-2 lg:order-1">
                <div class="inline-block w-12 h-1 bg-teal-500 rounded-full mb-6"></div>
                <h2 class="text-4xl sm:text-5xl font-extrabold text-gray-900 dark:text-white mb-8 tracking-tight">Lebih dari sekadar <span class="text-teal-600 dark:text-teal-400">tempat singgah</span>.</h2>
                <p class="text-gray-500 dark:text-slate-400 text-xl mb-12 font-light leading-relaxed">
                    Kami mendefinisikan ulang pengalaman mencari hunian. Temukos menggabungkan teknologi modern dengan keamanan mutlak untuk memberikan ketenangan pikiran bagi penyewa maupun pemilik properti.
                </p>
                
                <div class="space-y-8">
                    <div class="flex gap-6 items-start group">
                        <div class="shrink-0 w-14 h-14 rounded-2xl bg-teal-50 dark:bg-teal-900/30 flex items-center justify-center text-teal-600 dark:text-teal-400 group-hover:scale-110 group-hover:bg-teal-600 dark:group-hover:bg-teal-500 group-hover:text-white transition-all duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Proteksi Finansial</h3>
                            <p class="text-gray-500 dark:text-slate-400 font-medium">Pembayaran Anda ditahan dengan aman hingga Anda resmi menempati properti. Zero risiko penipuan.</p>
                        </div>
                    </div>
                    
                    <div class="flex gap-6 items-start group">
                        <div class="shrink-0 w-14 h-14 rounded-2xl bg-cyan-50 dark:bg-cyan-900/30 flex items-center justify-center text-cyan-600 dark:text-cyan-400 group-hover:scale-110 group-hover:bg-cyan-600 dark:group-hover:bg-cyan-500 group-hover:text-white transition-all duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Koleksi Terkurasi</h3>
                            <p class="text-gray-500 dark:text-slate-400 font-medium">Filter ketat kami memastikan hanya properti berkualitas tinggi yang tampil di hadapan Anda.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Floating UI Imagery --}}
            <div class="relative order-1 lg:order-2">
                {{-- Decorative Blob behind image --}}
                <div class="absolute inset-0 bg-teal-100 dark:bg-teal-900/40 rounded-[3rem] transform rotate-3 scale-105 z-0 transition-transform hover:rotate-6 duration-700"></div>
                
                {{-- Main Image --}}
                <div class="relative z-10 aspect-[4/5] rounded-[3rem] overflow-hidden shadow-2xl shadow-teal-900/10 dark:shadow-none border-4 border-white dark:border-slate-800">
                    <img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="Interior elegan" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900/40 to-transparent"></div>
                </div>
                
                {{-- Glass Floating Badge --}}
                <div class="absolute -bottom-8 -left-8 glass-panel dark:glass-panel p-6 rounded-3xl z-20 animate-[bounce_4s_infinite]">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center text-white shadow-lg">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <div>
                            <div class="text-3xl font-black text-gray-900 dark:text-white">100+</div>
                            <div class="text-sm font-bold text-teal-600 dark:text-teal-400 uppercase tracking-wider">Terverifikasi</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- 3. Properties Section (Very subtle aquatic flow) --}}
<section id="properties" class="py-32 bg-[#f8faf9] dark:bg-[#0b1120] relative transition-colors duration-500">
    {{-- Top soft divider --}}
    <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-teal-200 dark:via-teal-800 to-transparent"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        {{-- Section Header --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-8">
            <div class="max-w-2xl">
                <h2 class="text-4xl sm:text-5xl font-extrabold text-gray-900 dark:text-white mb-4 tracking-tight">Koleksi <span class="text-teal-600 dark:text-teal-400">Eksklusif</span></h2>
                <p class="text-gray-500 dark:text-slate-400 text-lg font-medium">Temukan hunian yang diciptakan untuk mendukung gaya hidup modern Anda.</p>
            </div>
            <div class="flex items-center gap-4">
                <span class="px-4 py-2 bg-white dark:bg-slate-800 rounded-full text-sm font-bold text-gray-700 dark:text-slate-300 shadow-sm border border-gray-100 dark:border-slate-700">{{ $totalResults }} Properti Tersedia</span>
                @if(request()->hasAny(['search', 'type', 'price_min', 'price_max', 'facilities', 'sort']))
                    <a href="{{ route('home') }}#properties" class="px-4 py-2 bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 text-sm font-bold rounded-full hover:bg-red-100 dark:hover:bg-red-900/50 transition-colors">
                        Reset Filter &times;
                    </a>
                @endif
            </div>
        </div>

        {{-- Property Grid --}}
        @if($properties->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
            @foreach($properties as $property)
            <a href="{{ route('property.show', $property) }}"
               class="group relative bg-white dark:bg-slate-900 rounded-[2rem] overflow-hidden shadow-sm hover:shadow-[0_20px_50px_rgba(20,184,166,0.1)] dark:hover:shadow-[0_20px_50px_rgba(20,184,166,0.05)] transition-all duration-500 border border-gray-100 dark:border-slate-800 flex flex-col h-full transform hover:-translate-y-2">
                
                {{-- Photo --}}
                <div class="aspect-[4/3] bg-gray-50 dark:bg-slate-800 overflow-hidden relative m-3 rounded-[1.5rem]">
                    @if($property->primaryPhoto)
                        <img src="{{ $property->primaryPhoto->url }}"
                             alt="{{ $property->name }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out"
                             onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($property->name) }}&size=400&background=d1fae5&color=047857&bold=true'">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-teal-50 dark:bg-teal-900/20">
                            <svg class="w-12 h-12 text-teal-200 dark:text-teal-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                        </div>
                    @endif
                    
                    {{-- Premium Type Badge --}}
                    <div class="absolute top-4 left-4">
                        <span class="px-4 py-1.5 text-xs font-black rounded-full shadow-lg uppercase tracking-wider backdrop-blur-md
                            {{ $property->property_type === 'kos' ? 'bg-teal-500/90 text-white' : ($property->property_type === 'kontrakan' ? 'bg-indigo-500/90 text-white' : 'bg-rose-500/90 text-white') }}">
                            {{ $property->property_type }}
                        </span>
                    </div>
                </div>

                {{-- Content --}}
                <div class="p-6 pt-4 flex flex-col flex-1">
                    <div class="flex items-center gap-1.5 text-gray-400 dark:text-slate-500 mb-2">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        </svg>
                        <span class="text-sm font-semibold truncate">{{ $property->city }} &middot; {{ $property->address }}</span>
                    </div>
                    
                    <h3 class="font-extrabold text-gray-900 dark:text-white text-xl mb-4 group-hover:text-teal-600 dark:group-hover:text-teal-400 transition-colors line-clamp-1">{{ $property->name }}</h3>
                    
                    {{-- Facility Tags --}}
                    <div class="flex flex-wrap gap-2 mt-auto mb-6">
                        @foreach($property->facilities->take(3) as $facility)
                        <span class="px-3 py-1 text-xs font-bold bg-gray-50 dark:bg-slate-800 text-gray-600 dark:text-slate-300 rounded-lg border border-gray-100 dark:border-slate-700">{{ $facility->name }}</span>
                        @endforeach
                        @if($property->facilities->count() > 3)
                        <span class="px-3 py-1 text-xs font-bold bg-gray-50 dark:bg-slate-800 text-teal-600 dark:text-teal-400 rounded-lg border border-teal-100 dark:border-teal-800/50">+{{ $property->facilities->count() - 3 }}</span>
                        @endif
                    </div>

                    {{-- Price --}}
                    <div class="flex items-center justify-between mt-auto">
                        <div>
                            <p class="text-[11px] tracking-widest uppercase text-gray-400 dark:text-slate-500 font-bold mb-1">Mulai Dari</p>
                            <p class="text-teal-600 dark:text-teal-400 font-black text-2xl">{{ $property->formattedPrice() }}<span class="text-sm font-medium text-gray-500 dark:text-slate-400">/bln</span></p>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-white dark:bg-slate-800 border-2 border-teal-50 dark:border-slate-700 flex items-center justify-center text-teal-600 dark:text-teal-400 group-hover:bg-teal-600 dark:group-hover:bg-teal-500 group-hover:text-white group-hover:border-teal-600 dark:group-hover:border-teal-500 transition-all shadow-sm">
                            <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-16 flex justify-center">
            {{ $properties->links() }}
        </div>
        @else
        {{-- Empty State --}}
        <div class="text-center py-32 bg-white dark:bg-slate-900 rounded-[3rem] border border-dashed border-gray-200 dark:border-slate-800 shadow-sm">
            <div class="w-24 h-24 bg-gray-50 dark:bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-teal-300 dark:text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Properti Tidak Ditemukan</h3>
            <p class="text-gray-500 dark:text-slate-400 max-w-md mx-auto mb-8 font-medium">Coba sesuaikan filter atau lokasi untuk menemukan lebih banyak pilihan hunian.</p>
            <a href="{{ route('home') }}#properties" class="inline-flex items-center gap-2 px-8 py-4 bg-teal-50 dark:bg-teal-900/30 text-teal-700 dark:text-teal-400 font-bold rounded-full hover:bg-teal-100 dark:hover:bg-teal-900/50 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                Reset Pencarian
            </a>
        </div>
        @endif
    </div>
</section>

{{-- 4. How It Works Section (Minimalist White/Sage Variant) --}}
<section id="how-to-book" class="py-32 bg-white dark:bg-slate-900 relative overflow-hidden transition-colors duration-500">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-24">
            <span class="inline-block px-4 py-2 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 rounded-full font-bold uppercase tracking-widest text-xs mb-6">Proses Mudah</span>
            <h2 class="text-4xl sm:text-5xl font-extrabold text-gray-900 dark:text-white mb-6 tracking-tight">Perjalanan ke <span class="text-emerald-500 dark:text-emerald-400">Hunian Baru</span></h2>
            <p class="text-gray-500 dark:text-slate-400 max-w-2xl mx-auto text-xl font-medium leading-relaxed">
                Empat langkah cerdas untuk memastikan proses pindah Anda lancar dan tanpa stres.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 relative">
            {{-- Connecting Dashed Line --}}
            <div class="hidden md:block absolute top-[40px] left-[15%] right-[15%] h-0 border-t-2 border-dashed border-gray-200 dark:border-slate-800 -z-10"></div>

            {{-- Step 1 --}}
            <div class="text-center group">
                <div class="w-20 h-20 mx-auto bg-white dark:bg-slate-800 border border-gray-100 dark:border-slate-700 rounded-2xl flex items-center justify-center mb-8 shadow-xl shadow-teal-900/5 dark:shadow-teal-900/10 group-hover:-translate-y-3 group-hover:border-teal-400 dark:group-hover:border-teal-500 group-hover:shadow-teal-900/10 dark:group-hover:shadow-teal-900/20 transition-all duration-300 relative">
                    <div class="absolute -top-4 -right-4 w-8 h-8 rounded-full bg-teal-500 text-white font-black flex items-center justify-center shadow-lg border-2 border-white dark:border-slate-800">1</div>
                    <svg class="w-8 h-8 text-teal-600 dark:text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <h3 class="text-2xl font-extrabold text-gray-900 dark:text-white mb-3">Eksplorasi</h3>
                <p class="text-gray-500 dark:text-slate-400 font-medium leading-relaxed">Temukan properti yang sempurna menggunakan fitur pencarian dan filter jitu kami.</p>
            </div>
            
            {{-- Step 2 --}}
            <div class="text-center group">
                <div class="w-20 h-20 mx-auto bg-white dark:bg-slate-800 border border-gray-100 dark:border-slate-700 rounded-2xl flex items-center justify-center mb-8 shadow-xl shadow-teal-900/5 dark:shadow-teal-900/10 group-hover:-translate-y-3 group-hover:border-teal-400 dark:group-hover:border-teal-500 group-hover:shadow-teal-900/10 dark:group-hover:shadow-teal-900/20 transition-all duration-300 relative">
                    <div class="absolute -top-4 -right-4 w-8 h-8 rounded-full bg-teal-500 text-white font-black flex items-center justify-center shadow-lg border-2 border-white dark:border-slate-800">2</div>
                    <svg class="w-8 h-8 text-teal-600 dark:text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <h3 class="text-2xl font-extrabold text-gray-900 dark:text-white mb-3">Jadwalkan</h3>
                <p class="text-gray-500 dark:text-slate-400 font-medium leading-relaxed">Tentukan tanggal masuk dan durasi sewa Anda. Sistem kami memastikannya instan.</p>
            </div>

            {{-- Step 3 --}}
            <div class="text-center group">
                <div class="w-20 h-20 mx-auto bg-white dark:bg-slate-800 border border-gray-100 dark:border-slate-700 rounded-2xl flex items-center justify-center mb-8 shadow-xl shadow-teal-900/5 dark:shadow-teal-900/10 group-hover:-translate-y-3 group-hover:border-teal-400 dark:group-hover:border-teal-500 group-hover:shadow-teal-900/10 dark:group-hover:shadow-teal-900/20 transition-all duration-300 relative">
                    <div class="absolute -top-4 -right-4 w-8 h-8 rounded-full bg-teal-500 text-white font-black flex items-center justify-center shadow-lg border-2 border-white dark:border-slate-800">3</div>
                    <svg class="w-8 h-8 text-teal-600 dark:text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                </div>
                <h3 class="text-2xl font-extrabold text-gray-900 dark:text-white mb-3">Transaksi</h3>
                <p class="text-gray-500 dark:text-slate-400 font-medium leading-relaxed">Selesaikan pembayaran secara aman melalui gerbang Midtrans resmi kami.</p>
            </div>

            {{-- Step 4 --}}
            <div class="text-center group">
                <div class="w-20 h-20 mx-auto bg-white dark:bg-slate-800 border border-gray-100 dark:border-slate-700 rounded-2xl flex items-center justify-center mb-8 shadow-xl shadow-teal-900/5 dark:shadow-teal-900/10 group-hover:-translate-y-3 group-hover:border-teal-400 dark:group-hover:border-teal-500 group-hover:shadow-teal-900/10 dark:group-hover:shadow-teal-900/20 transition-all duration-300 relative">
                    <div class="absolute -top-4 -right-4 w-8 h-8 rounded-full bg-teal-500 text-white font-black flex items-center justify-center shadow-lg border-2 border-white dark:border-slate-800">4</div>
                    <svg class="w-8 h-8 text-teal-600 dark:text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                </div>
                <h3 class="text-2xl font-extrabold text-gray-900 dark:text-white mb-3">Nikmati</h3>
                <p class="text-gray-500 dark:text-slate-400 font-medium leading-relaxed">Ambil kunci, masuk, dan mulailah lembaran baru di hunian yang nyaman.</p>
            </div>
        </div>
    </div>
</section>

{{-- 5. Premium CTA --}}
<section id="cta" class="py-24 bg-[#f8faf9] dark:bg-[#0b1120] relative overflow-hidden transition-colors duration-500">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="bg-gradient-to-br from-teal-600 via-emerald-600 to-cyan-700 dark:from-teal-800 dark:via-emerald-800 dark:to-cyan-900 rounded-[3rem] p-12 sm:p-20 text-center border-4 border-white dark:border-slate-800 shadow-[0_30px_60px_rgba(13,148,136,0.2)] dark:shadow-[0_30px_60px_rgba(13,148,136,0.1)] relative overflow-hidden">
            {{-- Abstract Shapes Inside CTA --}}
            <div class="absolute top-0 right-0 w-[400px] h-[400px] bg-white/10 dark:bg-white/5 rounded-full filter blur-[50px] transform translate-x-1/3 -translate-y-1/3"></div>
            <div class="absolute bottom-0 left-0 w-[300px] h-[300px] bg-emerald-300/20 dark:bg-emerald-300/10 rounded-full filter blur-[40px] transform -translate-x-1/4 translate-y-1/4"></div>
            
            <div class="relative z-10 space-y-8">
                <h2 class="text-4xl sm:text-5xl font-black text-white tracking-tight">Kini Giliran Anda Huni Impianmu.</h2>
                <p class="text-xl text-teal-50 dark:text-teal-100 font-medium max-w-2xl mx-auto">
                    Bergabung dengan komunitas cerdas kami hari ini. Jangan sampai properti idamanmu disewa oleh orang lain.
                </p>
                <div class="pt-6">
                    @guest
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-10 py-5 bg-white text-teal-700 dark:text-teal-800 font-extrabold rounded-full shadow-xl hover:shadow-2xl hover:scale-105 transition-all text-lg">
                            Daftar Sekarang Secara Gratis
                        </a>
                    @else
                        <a href="#properties" class="inline-flex items-center justify-center px-10 py-5 bg-white text-teal-700 dark:text-teal-800 font-extrabold rounded-full shadow-xl hover:shadow-2xl hover:scale-105 transition-all text-lg">
                            Mulai Pencarian
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Filter Modal (Premium Minimalist) --}}
<div id="filter-modal" class="hidden fixed inset-0 z-[60]">
    {{-- Overlay --}}
    <div class="absolute inset-0 bg-gray-900/40 dark:bg-slate-900/60 backdrop-blur-md transition-opacity" onclick="document.getElementById('filter-modal').classList.add('hidden')"></div>

    {{-- Panel --}}
    <div class="absolute right-0 top-0 h-full w-full max-w-lg bg-white dark:bg-slate-900 shadow-2xl overflow-y-auto border-l border-gray-100 dark:border-slate-800 transition-colors duration-500">
        <form action="{{ route('home') }}#properties" method="GET" class="flex flex-col h-full">
            {{-- Preserve search --}}
            @if(request('search'))
            <input type="hidden" name="search" value="{{ request('search') }}">
            @endif

            {{-- Header --}}
            <div class="sticky top-0 bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl border-b border-gray-50 dark:border-slate-800 px-8 py-6 flex items-center justify-between z-10">
                <h2 class="text-2xl font-extrabold text-gray-900 dark:text-white">Filter & Urutkan</h2>
                <button type="button" onclick="document.getElementById('filter-modal').classList.add('hidden')" class="w-12 h-12 flex items-center justify-center rounded-full bg-gray-50 dark:bg-slate-800 text-gray-400 dark:text-slate-400 hover:bg-gray-100 dark:hover:bg-slate-700 hover:text-gray-900 dark:hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            {{-- Body --}}
            <div class="px-8 py-8 space-y-12 flex-1">
                {{-- Sort --}}
                <div>
                    <h3 class="text-base font-black text-gray-900 dark:text-white uppercase tracking-widest mb-5">Urutkan</h3>
                    <div class="grid grid-cols-2 gap-4">
                        @foreach(['terbaru' => 'Terbaru', 'harga_terendah' => 'Harga Terendah', 'harga_tertinggi' => 'Harga Tertinggi', 'paling_populer' => 'Paling Populer'] as $value => $label)
                        <label class="flex items-center gap-3 px-4 py-4 rounded-2xl border-2 cursor-pointer transition-all
                            {{ request('sort', 'terbaru') === $value ? 'border-teal-500 dark:border-teal-400 bg-teal-50/50 dark:bg-teal-900/20' : 'border-gray-100 dark:border-slate-700 hover:border-teal-200 dark:hover:border-teal-500/50' }}">
                            <input type="radio" name="sort" value="{{ $value }}" {{ request('sort', 'terbaru') === $value ? 'checked' : '' }}
                                   class="w-5 h-5 text-teal-600 focus:ring-teal-500 border-gray-300 dark:border-slate-600 dark:bg-slate-800">
                            <span class="text-sm font-bold text-gray-800 dark:text-slate-200">{{ $label }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Property Type --}}
                <div>
                    <h3 class="text-base font-black text-gray-900 dark:text-white uppercase tracking-widest mb-5">Tipe Properti</h3>
                    <div class="grid grid-cols-3 gap-4">
                        @foreach(['kos' => 'Kos', 'kontrakan' => 'Kontrakan', 'apartemen' => 'Apartemen'] as $value => $label)
                        <label class="flex flex-col items-center justify-center gap-2 h-20 rounded-2xl border-2 cursor-pointer transition-all text-center relative
                            {{ in_array($value, request('type', [])) ? 'border-teal-500 dark:border-teal-400 bg-teal-50/50 dark:bg-teal-900/20 text-teal-700 dark:text-teal-400' : 'border-gray-100 dark:border-slate-700 hover:border-teal-200 dark:hover:border-teal-500/50 text-gray-500 dark:text-slate-400' }}">
                            <input type="checkbox" name="type[]" value="{{ $value }}" {{ in_array($value, request('type', [])) ? 'checked' : '' }}
                                   class="absolute opacity-0 w-0 h-0">
                            <span class="text-sm font-bold">{{ $label }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Price Range --}}
                <div>
                    <h3 class="text-base font-black text-gray-900 dark:text-white uppercase tracking-widest mb-5">Rentang Harga (Bulanan)</h3>
                    <div class="grid grid-cols-2 gap-6">
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 dark:text-slate-500 font-bold">Rp</span>
                            <input type="number" name="price_min" value="{{ request('price_min') }}" placeholder="Minimum"
                                   class="w-full pl-12 pr-4 py-4 rounded-2xl border-2 border-gray-100 dark:border-slate-700 text-base font-bold text-gray-800 dark:text-slate-200 focus:ring-0 focus:border-teal-500 dark:focus:border-teal-400 transition-colors outline-none bg-gray-50 dark:bg-slate-800 focus:bg-white dark:focus:bg-slate-900">
                        </div>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 dark:text-slate-500 font-bold">Rp</span>
                            <input type="number" name="price_max" value="{{ request('price_max') }}" placeholder="Maksimum"
                                   class="w-full pl-12 pr-4 py-4 rounded-2xl border-2 border-gray-100 dark:border-slate-700 text-base font-bold text-gray-800 dark:text-slate-200 focus:ring-0 focus:border-teal-500 dark:focus:border-teal-400 transition-colors outline-none bg-gray-50 dark:bg-slate-800 focus:bg-white dark:focus:bg-slate-900">
                        </div>
                    </div>
                </div>

                {{-- Facilities --}}
                <div>
                    <h3 class="text-base font-black text-gray-900 dark:text-white uppercase tracking-widest mb-5">Fasilitas Termasuk</h3>
                    <div class="grid grid-cols-2 gap-4">
                        @foreach($facilities as $facility)
                        <label class="flex items-center gap-3 px-4 py-3.5 rounded-2xl border-2 cursor-pointer transition-all
                            {{ in_array($facility->id, request('facilities', [])) ? 'border-teal-500 dark:border-teal-400 bg-teal-50/50 dark:bg-teal-900/20' : 'border-gray-100 dark:border-slate-700 hover:border-teal-200 dark:hover:border-teal-500/50' }}">
                            <input type="checkbox" name="facilities[]" value="{{ $facility->id }}" {{ in_array($facility->id, request('facilities', [])) ? 'checked' : '' }}
                                   class="w-5 h-5 text-teal-600 rounded focus:ring-teal-500 border-gray-300 dark:border-slate-600 dark:bg-slate-800">
                            <span class="text-sm font-bold text-gray-700 dark:text-slate-200">{{ $facility->name }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="sticky bottom-0 bg-white dark:bg-slate-900 border-t border-gray-100 dark:border-slate-800 px-8 py-6 flex gap-4 mt-auto">
                <a href="{{ route('home') }}#properties" class="flex-none px-8 flex items-center justify-center text-sm font-bold text-gray-500 dark:text-slate-400 bg-gray-100 dark:bg-slate-800 rounded-full hover:bg-gray-200 dark:hover:bg-slate-700 transition-colors">Reset</a>
                <button type="submit" class="flex-1 flex items-center justify-center text-base font-bold text-white bg-teal-600 dark:bg-teal-500 py-4 rounded-full hover:bg-teal-700 dark:hover:bg-teal-600 shadow-xl shadow-teal-600/20 dark:shadow-teal-900/20 transition-all transform hover:-translate-y-0.5">Terapkan Filter</button>
            </div>
        </form>
    </div>
</div>
@endsection
