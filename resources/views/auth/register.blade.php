@extends('layouts.app')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 mb-4">
                <img src="{{ asset('Images/logo.png') }}" alt="Temukos Logo" class="h-10 w-auto drop-shadow-md">
            </a>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Daftar di Temukos</h1>
            <p class="text-sm text-gray-400 dark:text-gray-400 mt-1">Buat akun untuk mulai menyewa properti impianmu.</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-xl p-8">
            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1.5">Nama Lengkap</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 text-sm focus:ring-2 focus:ring-emerald-300 focus:border-emerald-300 @error('name') border-red-300 @enderror"
                           placeholder="John Doe">
                    @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1.5">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 text-sm focus:ring-2 focus:ring-emerald-300 focus:border-emerald-300 @error('email') border-red-300 @enderror"
                           placeholder="contoh@email.com">
                    @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1.5">Nomor Telepon</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}" required
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 text-sm focus:ring-2 focus:ring-emerald-300 focus:border-emerald-300 @error('phone') border-red-300 @enderror"
                           placeholder="08xxxxxxxxxx">
                    @error('phone')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1.5">Password</label>
                    <input type="password" name="password" id="password" required
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 text-sm focus:ring-2 focus:ring-emerald-300 focus:border-emerald-300 @error('password') border-red-300 @enderror"
                           placeholder="Minimal 8 karakter">
                    @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1.5">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 text-sm focus:ring-2 focus:ring-emerald-300 focus:border-emerald-300"
                           placeholder="Ulangi password">
                </div>

                <button type="submit"
                        class="w-full py-3.5 bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-semibold rounded-xl hover:shadow-lg hover:shadow-emerald-200 dark:hover:shadow-emerald-900/30 transition-all duration-300 text-sm">
                    Daftar
                </button>
            </form>
        </div>

        <p class="text-center text-sm text-gray-400 dark:text-gray-400 mt-6">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-emerald-600 font-medium hover:underline">Masuk sekarang</a>
        </p>
    </div>
</div>
@endsection
