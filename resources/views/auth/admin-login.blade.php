<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — Temukos</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>* { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-900 min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-sm">
        <div class="text-center mb-8">
            <img src="{{ asset('Images/logo.png') }}" alt="Temukos Logo" class="h-12 w-auto mx-auto mb-4 drop-shadow-lg">
            <h1 class="text-xl font-bold text-white">Temukos Admin</h1>
            <p class="text-sm text-gray-400 mt-1">Masuk ke panel administrasi</p>
        </div>

        @if(session('error'))
        <div class="bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-xl text-sm mb-6">
            {{ session('error') }}
        </div>
        @endif

        <div class="bg-gray-800 rounded-2xl border border-gray-700 p-8">
            <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-5">
                @csrf
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-300 mb-1.5">Username</label>
                    <input type="text" name="username" id="username" value="{{ old('username') }}" required autofocus
                           class="w-full px-4 py-3 rounded-xl bg-gray-700 border border-gray-600 text-white text-sm placeholder-gray-400 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('username') border-red-500 @enderror"
                           placeholder="admin">
                    @error('username')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-300 mb-1.5">Password</label>
                    <input type="password" name="password" id="password" required
                           class="w-full px-4 py-3 rounded-xl bg-gray-700 border border-gray-600 text-white text-sm placeholder-gray-400 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                           placeholder="••••••••">
                </div>

                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="remember" class="w-4 h-4 text-emerald-600 rounded bg-gray-700 border-gray-600 focus:ring-emerald-500">
                    <span class="text-sm text-gray-400">Ingat saya</span>
                </label>

                <button type="submit"
                        class="w-full py-3.5 bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-semibold rounded-xl hover:shadow-lg hover:shadow-emerald-500/30 transition-all duration-300 text-sm">
                    Masuk
                </button>
            </form>
        </div>

        <p class="text-center text-xs text-gray-500 mt-6">
            <a href="{{ route('home') }}" class="hover:text-gray-300 transition-colors">← Kembali ke Temukos</a>
        </p>
    </div>
</body>
</html>
