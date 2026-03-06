@extends('layouts.admin')

@section('content')
<div class="space-y-6 max-w-3xl">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.bookings.index') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Tambah Pemesanan Manual</h1>
    </div>

    @if(session('error'))
    <div class="p-4 bg-red-50 border border-red-100 text-red-700 rounded-xl text-sm">
        {{ session('error') }}
    </div>
    @endif

    <div class="bg-white rounded-2xl border border-gray-100 p-6 sm:p-8">
        <form action="{{ route('admin.bookings.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div class="sm:col-span-2">
                    <label for="property_id" class="block text-sm font-medium text-gray-700 mb-1.5">Pilih Properti</label>
                    <select name="property_id" id="property_id" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-emerald-300 focus:border-emerald-300">
                        <option value="">Pilih Properti</option>
                        @foreach($properties as $property)
                        <option value="{{ $property->id }}" {{ old('property_id') == $property->id ? 'selected' : '' }}>
                            {{ $property->name }} - {{ $property->formattedPrice() }}/bln
                        </option>
                        @endforeach
                    </select>
                    @error('property_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal Mulai</label>
                    <input type="date" name="start_date" id="start_date" value="{{ old('start_date', date('Y-m-d')) }}" required
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-emerald-300 focus:border-emerald-300">
                    @error('start_date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="duration_months" class="block text-sm font-medium text-gray-700 mb-1.5">Durasi (Bulan)</label>
                    <select name="duration_months" id="duration_months" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-emerald-300 focus:border-emerald-300">
                        @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ old('duration_months') == $i ? 'selected' : '' }}>{{ $i }} Bulan</option>
                        @endfor
                    </select>
                    @error('duration_months')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="sm:col-span-2">
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-1.5">Catatan (Opsional)</label>
                    <textarea name="notes" id="notes" rows="3" placeholder="Contoh: Booking via WhatsApp, pembayaran cash."
                              class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-emerald-300 focus:border-emerald-300">{{ old('notes') }}</textarea>
                    @error('notes')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="flex gap-3 pt-4">
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-semibold rounded-xl hover:shadow-lg transition-all text-sm">
                    Konfirmasi Pemesanan
                </button>
                <a href="{{ route('admin.bookings.index') }}" class="px-6 py-3 text-gray-500 font-medium rounded-xl border border-gray-200 hover:bg-gray-50 transition-colors text-sm">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
