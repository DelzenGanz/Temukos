@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-50 dark:bg-slate-900 min-h-screen pt-32">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white dark:bg-slate-800 shadow sm:rounded-lg">
            <div class="max-w-xl">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            Informasi Profil
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            Perbarui informasi profil dan nomor telepon akun Anda.
                        </p>
                    </header>

                    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
                        @csrf
                        @method('put')

                        <div>
                            <label for="name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Nama Lengkap</label>
                            <input id="name" name="name" type="text" class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
                            @error('name')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Email</label>
                            <input id="email" name="email" type="email" class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 dark:bg-slate-700/50 dark:text-gray-400 shadow-sm opacity-70 cursor-not-allowed" value="{{ old('email', $user->email) }}" disabled autocomplete="username" />
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Email tidak dapat diubah.</p>
                        </div>
                        
                        <div>
                            <label for="phone" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Nomor Telepon</label>
                            <input id="phone" name="phone" type="text" class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('phone', $user->phone) }}" required autocomplete="tel" />
                            @error('phone')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Simpan
                            </button>

                            @if (session('status') === 'profile-updated')
                                <p
                                    class="text-sm text-gray-600 dark:text-gray-400"
                                >Tersimpan.</p>
                            @endif
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection
