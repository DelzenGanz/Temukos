@extends('layouts.app')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 mb-4">
                <img src="{{ asset('Images/logo.png') }}" alt="Temukos Logo" class="h-10 w-auto drop-shadow-md">
            </a>
            <h1 class="text-2xl font-bold text-gray-800">Masuk ke Temukos</h1>
            <p class="text-sm text-gray-400 mt-1">Selamat datang kembali! Silakan masuk ke akunmu.</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-xl p-8">
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-emerald-300 focus:border-emerald-300 @error('email') border-red-300 @enderror"
                           placeholder="contoh@email.com">
                    @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                    <input type="password" name="password" id="password" required
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-emerald-300 focus:border-emerald-300"
                           placeholder="Masukkan password">
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 text-emerald-600 rounded focus:ring-emerald-500">
                        <span class="text-sm text-gray-500">Ingat saya</span>
                    </label>
                </div>

                <button type="submit"
                        class="w-full py-3.5 bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-semibold rounded-xl hover:shadow-lg hover:shadow-emerald-200 transition-all duration-300 text-sm">
                    Masuk
                </button>
            </form>
        </div>

        <p class="text-center text-sm text-gray-400 mt-6">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-emerald-600 font-medium hover:underline">Daftar sekarang</a>
        </p>
    </div>
</div>
@endsection
