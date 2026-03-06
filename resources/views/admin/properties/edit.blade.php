@extends('layouts.admin')

@section('content')
<div class="space-y-6 max-w-3xl">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.properties.index') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Edit Properti</h1>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 p-6 sm:p-8">
        <form action="{{ route('admin.properties.update', $property) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div class="sm:col-span-2">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Nama Properti</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $property->name) }}" required
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-emerald-300 focus:border-emerald-300 @error('name') border-red-300 @enderror">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="city" class="block text-sm font-medium text-gray-700 mb-1.5">Kota</label>
                    <input type="text" name="city" id="city" value="{{ old('city', $property->city) }}" required
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-emerald-300 focus:border-emerald-300 @error('city') border-red-300 @enderror">
                    @error('city')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="property_type" class="block text-sm font-medium text-gray-700 mb-1.5">Tipe Properti</label>
                    <select name="property_type" id="property_type" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-emerald-300 focus:border-emerald-300">
                        <option value="kos" {{ old('property_type', $property->property_type) === 'kos' ? 'selected' : '' }}>Kos</option>
                        <option value="kontrakan" {{ old('property_type', $property->property_type) === 'kontrakan' ? 'selected' : '' }}>Kontrakan</option>
                        <option value="apartemen" {{ old('property_type', $property->property_type) === 'apartemen' ? 'selected' : '' }}>Apartemen</option>
                    </select>
                    @error('property_type')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="sm:col-span-2">
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1.5">Alamat Lengkap</label>
                    <input type="text" name="address" id="address" value="{{ old('address', $property->address) }}" required
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-emerald-300 focus:border-emerald-300 @error('address') border-red-300 @enderror">
                    @error('address')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="sm:col-span-2">
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1.5">Nomor WhatsApp Pemilik</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $property->phone) }}" placeholder="Contoh: 6282146008889"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-emerald-300 focus:border-emerald-300 @error('phone') border-red-300 @enderror">
                    <p class="text-[10px] text-gray-400 mt-1">Gunakan kode negara (62) tanpa tanda + atau spasi.</p>
                    @error('phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="price_month" class="block text-sm font-medium text-gray-700 mb-1.5">Harga per Bulan (Rp)</label>
                    <input type="number" name="price_month" id="price_month" value="{{ old('price_month', $property->price_month) }}" required min="0"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-emerald-300 focus:border-emerald-300 @error('price_month') border-red-300 @enderror">
                    @error('price_month')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="sm:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1.5">Deskripsi</label>
                    <textarea name="description" id="description" rows="5" required
                              class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-emerald-300 focus:border-emerald-300 @error('description') border-red-300 @enderror">{{ old('description', $property->description) }}</textarea>
                    @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Facilities --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">Fasilitas</label>
                <p class="text-xs text-gray-400 mb-3">Fasilitas akan menyesuaikan otomatis dengan tipe properti yang dipilih.</p>
                <div id="facility-groups">
                    @php($selectedType = old('property_type', $property->property_type))
                    @php($selectedFacilities = collect(old('facilities', $property->facilities->pluck('id')->toArray())))
                    @foreach($facilitiesByType as $type => $typeFacilities)
                    <div data-facility-group="{{ $type }}" class="grid grid-cols-2 sm:grid-cols-3 gap-2 {{ $selectedType === $type ? '' : 'hidden' }}">
                        @foreach($typeFacilities as $facility)
                        <label class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl border border-gray-100 cursor-pointer hover:border-emerald-200 transition-all
                            {{ $selectedFacilities->contains($facility->id) ? 'border-emerald-300 bg-emerald-50' : '' }}">
                            <input type="checkbox" name="facilities[]" value="{{ $facility->id }}"
                                   {{ $selectedFacilities->contains($facility->id) ? 'checked' : '' }}
                                   class="w-4 h-4 text-emerald-600 rounded focus:ring-emerald-500">
                            <span class="text-xs text-gray-700">{{ $facility->name }}</span>
                        </label>
                        @endforeach
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Existing Photos --}}
            @if($property->photos->count())
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">Foto Saat Ini</label>
                <div class="grid grid-cols-3 sm:grid-cols-4 gap-3">
                    @foreach($property->photos as $photo)
                    <div class="relative group rounded-xl overflow-hidden border {{ $photo->is_primary ? 'border-emerald-300 ring-2 ring-emerald-200' : 'border-gray-200' }}">
                        <img src="{{ $photo->url }}" alt="Photo" class="w-full aspect-square object-cover"
                             onerror="this.src='https://ui-avatars.com/api/?name=Photo&size=200&background=d1fae5&color=047857'">
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                            <label class="cursor-pointer">
                                <input type="radio" name="primary_photo_id" value="{{ $photo->id }}" {{ $photo->is_primary ? 'checked' : '' }}
                                       class="hidden">
                                <span class="px-2 py-1 text-xs bg-white rounded-lg font-medium text-gray-700 hover:bg-emerald-50 transition-colors">
                                    {{ $photo->is_primary ? '★ Utama' : 'Jadikan Utama' }}
                                </span>
                            </label>
                            <button type="button" 
                                    onclick="deletePhoto({{ $photo->id }})"
                                    class="px-2 py-1 text-xs bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
                                ×
                            </button>
                        </div>
                        @if($photo->is_primary)
                        <span class="absolute top-1 left-1 px-1.5 py-0.5 text-[10px] font-semibold bg-emerald-500 text-white rounded">Utama</span>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- New Photos --}}
            <div>
                <label for="photos" class="block text-sm font-medium text-gray-700 mb-1.5">Tambah Foto Baru</label>
                <input type="file" name="photos[]" id="photos" multiple accept="image/*"
                       class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                @error('photos.*')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="flex gap-3 pt-4">
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-semibold rounded-xl hover:shadow-lg transition-all text-sm">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.properties.index') }}" class="px-6 py-3 text-gray-500 font-medium rounded-xl border border-gray-200 hover:bg-gray-50 transition-colors text-sm">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

{{-- Hidden form for photo deletion --}}
<form id="delete-photo-form" method="POST" class="hidden">
    @csrf @method('DELETE')
</form>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const typeSelect = document.getElementById('property_type');
        const groups = document.querySelectorAll('[data-facility-group]');

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
        }

        typeSelect.addEventListener('change', syncFacilities);
        syncFacilities();
    });

    function deletePhoto(photoId) {
        if (confirm('Hapus foto ini?')) {
            const form = document.getElementById('delete-photo-form');
            form.action = `/admin/properties/photo/${photoId}`;
            form.submit();
        }
    }
</script>
@endsection
