@extends('layouts.admin')

@section('content')
<div class="space-y-6 max-w-3xl">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.properties.index') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Tambah Properti</h1>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 p-6 sm:p-8">
        <form action="{{ route('admin.properties.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div class="sm:col-span-2">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Nama Properti</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-emerald-300 focus:border-emerald-300 @error('name') border-red-300 @enderror">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="city" class="block text-sm font-medium text-gray-700 mb-1.5">Kota</label>
                    <input type="text" name="city" id="city" value="{{ old('city') }}" required
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-emerald-300 focus:border-emerald-300 @error('city') border-red-300 @enderror">
                    @error('city')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="property_type" class="block text-sm font-medium text-gray-700 mb-1.5">Tipe Properti</label>
                    <select name="property_type" id="property_type" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-emerald-300 focus:border-emerald-300">
                        <option value="">Pilih tipe</option>
                        <option value="kos" {{ old('property_type') === 'kos' ? 'selected' : '' }}>Kos</option>
                        <option value="kontrakan" {{ old('property_type') === 'kontrakan' ? 'selected' : '' }}>Kontrakan</option>
                        <option value="apartemen" {{ old('property_type') === 'apartemen' ? 'selected' : '' }}>Apartemen</option>
                    </select>
                    @error('property_type')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="sm:col-span-2">
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1.5">Alamat Lengkap</label>
                    <input type="text" name="address" id="address" value="{{ old('address') }}" required
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-emerald-300 focus:border-emerald-300 @error('address') border-red-300 @enderror">
                    @error('address')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="price_month" class="block text-sm font-medium text-gray-700 mb-1.5">Harga per Bulan (Rp)</label>
                    <input type="number" name="price_month" id="price_month" value="{{ old('price_month') }}" required min="0"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-emerald-300 focus:border-emerald-300 @error('price_month') border-red-300 @enderror">
                    @error('price_month')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="sm:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1.5">Deskripsi</label>
                    <textarea name="description" id="description" rows="5" required
                              class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-emerald-300 focus:border-emerald-300 @error('description') border-red-300 @enderror">{{ old('description') }}</textarea>
                    @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Facilities --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">Fasilitas</label>
                <p class="text-xs text-gray-400 mb-3">Pilih tipe properti terlebih dahulu agar fasilitas yang sesuai muncul otomatis.</p>
                <div id="facility-groups">
                    @foreach($facilitiesByType as $type => $typeFacilities)
                    <div data-facility-group="{{ $type }}" class="grid grid-cols-2 sm:grid-cols-3 gap-2 {{ old('property_type') === $type ? '' : 'hidden' }}">
                        @foreach($typeFacilities as $facility)
                        <label class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl border border-gray-100 cursor-pointer hover:border-emerald-200 transition-all">
                            <input type="checkbox" name="facilities[]" value="{{ $facility->id }}"
                                   {{ in_array($facility->id, old('facilities', [])) ? 'checked' : '' }}
                                   class="w-4 h-4 text-emerald-600 rounded focus:ring-emerald-500">
                            <span class="text-xs text-gray-700">{{ $facility->name }}</span>
                        </label>
                        @endforeach
                    </div>
                    @endforeach
                    <div id="facility-placeholder" class="rounded-xl border border-dashed border-gray-200 px-4 py-5 text-sm text-gray-400 {{ old('property_type') ? 'hidden' : '' }}">
                        Belum ada tipe properti yang dipilih.
                    </div>
                </div>
            </div>

            {{-- Photos --}}
            <div>
                <label for="photos" class="block text-sm font-medium text-gray-700 mb-1.5">Foto Properti</label>
                <p class="text-xs text-gray-400 mb-2">Foto pertama akan menjadi foto utama. Maks 10 foto, masing-masing maks 2MB.</p>
                <input type="file" name="photos[]" id="photos" multiple accept="image/*"
                       class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                @error('photos.*')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="flex gap-3 pt-4">
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-semibold rounded-xl hover:shadow-lg transition-all text-sm">
                    Simpan Properti
                </button>
                <a href="{{ route('admin.properties.index') }}" class="px-6 py-3 text-gray-500 font-medium rounded-xl border border-gray-200 hover:bg-gray-50 transition-colors text-sm">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const typeSelect = document.getElementById('property_type');
        const groups = document.querySelectorAll('[data-facility-group]');
        const placeholder = document.getElementById('facility-placeholder');

        function syncFacilities() {
            const selectedType = typeSelect.value;

            groups.forEach((group) => {
                const isActive = group.dataset.facilityGroup === selectedType;
                group.classList.toggle('hidden', !isActive);

                group.querySelectorAll('input[type="checkbox"]').forEach((input) => {
                    if (!isActive) {
                        input.checked = false;
                    }
                });
            });

            placeholder.classList.toggle('hidden', Boolean(selectedType));
        }

        typeSelect.addEventListener('change', syncFacilities);
        syncFacilities();
    });
</script>
@endsection
