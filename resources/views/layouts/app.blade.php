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

    <style>
        * { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#FAF9F6] text-gray-800 min-h-screen flex flex-col antialiased">

    {{-- Navbar --}}
    <nav class="bg-white/80 backdrop-blur-md border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                {{-- Brand --}}
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <img src="{{ asset('Images/logo.png') }}" alt="Temukos Logo" class="h-8 w-auto drop-shadow-sm">
                    <span class="text-xl font-bold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">Temukos</span>
                </a>

                {{-- Nav Links --}}
                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ route('bookings.index') }}" class="text-sm text-gray-600 hover:text-emerald-600 font-medium transition-colors px-3 py-2 rounded-lg hover:bg-emerald-50">
                            Pemesanan Saya
                        </a>
                        <div class="flex items-center gap-2 pl-3 border-l border-gray-200">
                            <div class="w-8 h-8 bg-gradient-to-br from-emerald-100 to-teal-100 rounded-full flex items-center justify-center">
                                <span class="text-sm font-semibold text-emerald-700">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                            <span class="text-sm font-medium text-gray-700 hidden sm:block">{{ Auth::user()->name }}</span>
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
                        <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-emerald-600 font-medium transition-colors px-4 py-2 rounded-lg hover:bg-emerald-50">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="text-sm font-medium text-white bg-gradient-to-r from-emerald-500 to-teal-600 px-4 py-2 rounded-lg hover:shadow-lg hover:shadow-emerald-200 transition-all duration-300">
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

    {{-- Footer --}}
    <footer class="bg-white border-t border-gray-100 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <img src="{{ asset('Images/logo.png') }}" alt="Temukos Logo" class="h-7 w-auto drop-shadow-sm">
                        <span class="text-lg font-bold text-gray-800">Temukos</span>
                    </div>
                    <p class="text-sm text-gray-500 leading-relaxed">Temu kosmu dengan mudah. Platform pencarian kos, kontrakan, dan apartemen terpercaya di Indonesia.</p>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-800 mb-3">Navigasi</h4>
                    <ul class="space-y-2 text-sm text-gray-500">
                        <li><a href="{{ route('home') }}" class="hover:text-emerald-600 transition-colors">Beranda</a></li>
                        @auth
                        <li><a href="{{ route('bookings.index') }}" class="hover:text-emerald-600 transition-colors">Pemesanan Saya</a></li>
                        @endauth
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-800 mb-3">Kontak</h4>
                    <p class="text-sm text-gray-500 leading-relaxed">Hubungi kami untuk pertanyaan dan kerjasama.</p>
                    {{-- extensible: add social media links, contact form link here --}}
                </div>
            </div>
            <div class="mt-8 pt-6 border-t border-gray-100 text-center text-xs text-gray-400">
                &copy; {{ date('Y') }} Temukos. All rights reserved.
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

    @stack('scripts')
</body>
</html>
