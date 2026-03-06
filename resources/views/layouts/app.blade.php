<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Temukos — Temu kosmu dengan mudah. Cari dan sewa kos, kontrakan, dan apartemen dengan mudah dan aman.">
    <title>{{ $title ?? 'Temukos — Temu kosmu dengan mudah' }}</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Midtrans Snap JS (only loaded when needed) --}}
    @stack('scripts-head')

    {{-- Dark Mode Init (Prevents FOUC) --}}
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <style>
        * { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#FAF9F6] text-gray-800 dark:bg-slate-950 dark:text-slate-200 min-h-screen flex flex-col antialiased transition-colors duration-500">

    {{-- Navbar --}}
    <nav class="bg-white/80 dark:bg-slate-950/80 backdrop-blur-md border-b border-gray-100 dark:border-slate-800 sticky top-0 z-50 transition-colors duration-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                {{-- Brand --}}
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <img src="{{ asset('Images/logo.png') }}" alt="Temukos Logo" class="h-8 w-auto drop-shadow-sm">
                    <span class="text-xl font-bold bg-gradient-to-r from-emerald-600 to-teal-600 dark:from-emerald-400 dark:to-teal-400 bg-clip-text text-transparent">Temukos</span>
                </a>

                {{-- Nav Links --}}
                <div class="flex items-center gap-3">
                    {{-- Section Links for Homepage --}}
                    @if(request()->routeIs('home'))
                        <div class="hidden md:flex items-center gap-1 mr-4 border-r border-gray-200 dark:border-slate-700 pr-4 transition-colors">
                            <a href="#about" class="text-sm font-medium text-gray-600 dark:text-slate-300 hover:text-teal-600 dark:hover:text-teal-400 px-3 py-2 rounded-lg transition-colors">Tentang</a>
                            <a href="#properties" class="text-sm font-medium text-gray-600 dark:text-slate-300 hover:text-teal-600 dark:hover:text-teal-400 px-3 py-2 rounded-lg transition-colors">Properti</a>
                            <a href="#how-to-book" class="text-sm font-medium text-gray-600 dark:text-slate-300 hover:text-teal-600 dark:hover:text-teal-400 px-3 py-2 rounded-lg transition-colors">Cara Pesan</a>
                        </div>
                    @else
                        <div class="hidden md:flex items-center gap-1 mr-4 border-r border-gray-200 dark:border-slate-700 pr-4 transition-colors">
                            <a href="{{ route('home') }}#about" class="text-sm font-medium text-gray-600 dark:text-slate-300 hover:text-teal-600 dark:hover:text-teal-400 px-3 py-2 rounded-lg transition-colors">Tentang</a>
                            <a href="{{ route('home') }}#properties" class="text-sm font-medium text-gray-600 dark:text-slate-300 hover:text-teal-600 dark:hover:text-teal-400 px-3 py-2 rounded-lg transition-colors">Properti</a>
                            <a href="{{ route('home') }}#how-to-book" class="text-sm font-medium text-gray-600 dark:text-slate-300 hover:text-teal-600 dark:hover:text-teal-400 px-3 py-2 rounded-lg transition-colors">Cara Pesan</a>
                        </div>
                    @endif

                    {{-- Theme Toggle Button --}}
                    <button id="theme-toggle" type="button" class="text-gray-500 hover:text-teal-600 dark:text-slate-400 dark:hover:text-teal-400 focus:outline-none rounded-full text-sm p-2 transition-all relative w-10 h-10 flex items-center justify-center overflow-hidden hover:bg-gray-100 dark:hover:bg-slate-800 mr-2">
                        {{-- Sun Icon (for Dark Mode) --}}
                        <svg id="theme-toggle-light-icon" class="w-5 h-5 absolute hidden dark:block text-teal-400" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                        {{-- Moon Icon (for Light Mode) --}}
                        <svg id="theme-toggle-dark-icon" class="w-5 h-5 absolute block dark:hidden" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                    </button>

                    @auth
                        <a href="{{ route('bookings.index') }}" class="text-sm text-gray-600 dark:text-slate-300 hover:text-teal-600 dark:hover:text-teal-400 font-medium transition-colors px-3 py-2 rounded-lg hover:bg-teal-50 dark:hover:bg-teal-900/30">
                            Pemesanan Saya
                        </a>
                        <div class="flex items-center gap-2 pl-3 border-l border-gray-200 dark:border-slate-700 transition-colors">
                            <div class="w-8 h-8 bg-gradient-to-br from-teal-100 to-cyan-100 dark:from-teal-800 dark:to-cyan-800 rounded-full flex items-center justify-center">
                                <span class="text-sm font-semibold text-teal-700 dark:text-teal-200">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                            <span class="text-sm font-medium text-gray-700 dark:text-slate-200 hidden sm:block">{{ Auth::user()->name }}</span>
                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-sm text-gray-400 hover:text-red-500 transition-colors ml-1" title="Logout">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-600 dark:text-slate-300 hover:text-teal-600 dark:hover:text-teal-400 font-medium transition-colors px-4 py-2 rounded-lg hover:bg-teal-50 dark:hover:bg-teal-900/30">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="text-sm font-medium text-white bg-gradient-to-r from-teal-500 to-cyan-600 dark:from-teal-600 dark:to-cyan-700 px-4 py-2 rounded-lg hover:shadow-lg hover:shadow-teal-200 dark:hover:shadow-teal-900/50 transition-all duration-300">
                            Daftar
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- Flash Messages --}}
    @if(session('success'))
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-sm flex items-center gap-2" id="flash-success">
            <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            {{ session('success') }}
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
            <svg class="w-5 h-5 text-red-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            {{ session('error') }}
        </div>
    </div>
    @endif

    {{-- Main Content --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- Enhanced FKO-style Footer (Premium Temukos Theme) --}}
    <footer class="bg-[#0f172a] text-slate-300 relative overflow-hidden mt-16 pt-20 pb-10 border-t border-teal-900/50">
        {{-- Background Glow --}}
        <div class="absolute top-0 right-0 w-96 h-96 bg-teal-900/40 rounded-full mix-blend-screen filter blur-[100px] opacity-50 transform translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-cyan-900/30 rounded-full mix-blend-screen filter blur-[100px] opacity-50 transform -translate-x-1/2 translate-y-1/2 pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-12 lg:gap-8 mb-16">
                
                {{-- Column 1: Brand & About --}}
                <div class="md:col-span-12 lg:col-span-4 pr-0 lg:pr-8">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 mb-6 inline-block">
                        <div class="bg-white p-1.5 rounded-lg inline-block shadow-[0_0_15px_rgba(20,184,166,0.5)]">
                            <img src="{{ asset('Images/logo.png') }}" alt="Temukos Logo" class="h-8 w-auto">
                        </div>
                        <span class="text-2xl font-black text-white tracking-tight">Temukos</span>
                    </a>
                    <p class="text-slate-400 text-sm leading-relaxed mb-8">
                        Platform pencarian hunian sementara terpercaya di Indonesia. Kami mendedikasikan diri untuk memberikan pengalaman pemesanan kos, kontrakan, dan apartemen yang paling aman, mudah, dan transparan.
                    </p>
                    <div class="flex gap-4">
                        {{-- Social Links --}}
                        <a href="https://instagram.com" target="_blank" class="w-10 h-10 rounded-full bg-slate-800 hover:bg-teal-600 flex items-center justify-center text-slate-400 hover:text-white transition-all hover:-translate-y-1 shadow-lg border border-slate-700 hover:border-teal-500">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" /></svg>
                        </a>
                        <a href="https://facebook.com" target="_blank" class="w-10 h-10 rounded-full bg-slate-800 hover:bg-teal-600 flex items-center justify-center text-slate-400 hover:text-white transition-all hover:-translate-y-1 shadow-lg border border-slate-700 hover:border-teal-500">
                           <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" /></svg>
                        </a>
                    </div>
                </div>

                {{-- Column 2: Navigasi --}}
                <div class="md:col-span-4 lg:col-span-2">
                    <h4 class="text-white font-bold mb-6 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-teal-500"></span>
                        Eksplorasi
                    </h4>
                    <ul class="space-y-3">
                        <li>
                            <a href="{{ request()->routeIs('home') ? '#hero' : route('home') }}" class="text-sm text-slate-400 hover:text-teal-400 hover:translate-x-1 inline-flex transition-all">Beranda</a>
                        </li>
                        <li>
                            <a href="{{ request()->routeIs('home') ? '#about' : route('home') . '#about' }}" class="text-sm text-slate-400 hover:text-teal-400 hover:translate-x-1 inline-flex transition-all">Tentang Kami</a>
                        </li>
                        <li>
                            <a href="{{ request()->routeIs('home') ? '#properties' : route('home') . '#properties' }}" class="text-sm text-slate-400 hover:text-teal-400 hover:translate-x-1 inline-flex transition-all">Pilihan Properti</a>
                        </li>
                        <li>
                            <a href="{{ request()->routeIs('home') ? '#how-to-book' : route('home') . '#how-to-book' }}" class="text-sm text-slate-400 hover:text-teal-400 hover:translate-x-1 inline-flex transition-all">Cara Pesan</a>
                        </li>
                    </ul>
                </div>

                {{-- Column 3: Member Area --}}
                <div class="md:col-span-4 lg:col-span-2">
                    <h4 class="text-white font-bold mb-6 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-teal-500"></span>
                        Member
                    </h4>
                    <ul class="space-y-3">
                        @auth
                        <li>
                            <a href="{{ route('bookings.index') }}" class="text-sm text-slate-400 hover:text-teal-400 hover:translate-x-1 inline-flex transition-all">Pemesanan Saya</a>
                        </li>
                        <li>
                            <a href="{{ route('profile.edit') }}" class="text-sm text-slate-400 hover:text-teal-400 hover:translate-x-1 inline-flex transition-all">Pengaturan Profil</a>
                        </li>
                        @else
                        <li>
                            <a href="{{ route('login') }}" class="text-sm text-slate-400 hover:text-teal-400 hover:translate-x-1 inline-flex transition-all">Masuk Akun</a>
                        </li>
                        <li>
                            <a href="{{ route('register') }}" class="text-sm text-slate-400 hover:text-teal-400 hover:translate-x-1 inline-flex transition-all">Daftar Baru</a>
                        </li>
                        @endauth
                    </ul>
                </div>

                {{-- Column 4: Kontak Info --}}
                <div class="md:col-span-4 lg:col-span-4">
                    <h4 class="text-white font-bold mb-6 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-teal-500"></span>
                        Hubungi Kami
                    </h4>
                    
                    <div class="space-y-4">
                        <a href="https://wa.me/6282146008889" target="_blank" class="flex items-center gap-4 p-4 rounded-2xl bg-slate-800/50 hover:bg-slate-800 border border-slate-700/50 hover:border-teal-500/50 transition-all group">
                            <div class="w-12 h-12 rounded-full bg-emerald-500/10 flex items-center justify-center text-emerald-400 group-hover:scale-110 group-hover:bg-emerald-500 group-hover:text-white transition-all">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448-.003 9.883-4.436 9.884-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.347-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.876 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                            </div>
                            <div>
                                <p class="text-xs text-emerald-400 font-bold uppercase tracking-wider mb-1">WhatsApp CS</p>
                                <p class="text-slate-200 font-medium">+62 821 4600 8889</p>
                            </div>
                        </a>
                        
                        <a href="mailto:halo@temukos.com" class="flex items-center gap-4 p-4 rounded-2xl bg-slate-800/50 hover:bg-slate-800 border border-slate-700/50 hover:border-teal-500/50 transition-all group">
                            <div class="w-12 h-12 rounded-full bg-cyan-500/10 flex items-center justify-center text-cyan-400 group-hover:scale-110 group-hover:bg-cyan-500 group-hover:text-white transition-all">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <p class="text-xs text-cyan-400 font-bold uppercase tracking-wider mb-1">Email Support</p>
                                <p class="text-slate-200 font-medium">halo@temukos.com</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="pt-8 border-t border-slate-800/70 flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="text-sm text-slate-500 font-medium">
                    &copy; {{ date('Y') }} Temukos. All rights reserved. Built with <span class="text-red-500">&hearts;</span> di Indonesia.
                </p>
                <div class="flex gap-4">
                    <a href="#" class="text-xs text-slate-500 hover:text-teal-400 transition-colors">Syarat & Ketentuan</a>
                    <a href="#" class="text-xs text-slate-500 hover:text-teal-400 transition-colors">Kebijakan Privasi</a>
                </div>
            </div>
        </div>
    </footer>

    {{-- Auto-dismiss flash messages --}}
    <script>
        setTimeout(() => {
            const flash = document.getElementById('flash-success');
            if (flash) flash.style.display = 'none';
        }, 4000);
    </script>

    {{-- Dark Mode Toggle Logic --}}
    <script>
        const themeToggleBtn = document.getElementById('theme-toggle');

        themeToggleBtn.addEventListener('click', function() {
            if (localStorage.getItem('theme')) {
                if (localStorage.getItem('theme') === 'light') {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                }
            } else {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                }
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
