@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800">Kelola Properti</h1>
        <a href="{{ route('admin.properties.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-emerald-500 to-teal-600 text-white text-sm font-semibold rounded-xl hover:shadow-lg transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Properti
        </a>
    </div>

    {{-- Search --}}
    <form action="{{ route('admin.properties.index') }}" method="GET" class="max-w-sm">
        <div class="relative">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari properti..."
                   class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-emerald-300 focus:border-emerald-300">
        </div>
    </form>

    {{-- Properties Table --}}
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                        <th class="px-6 py-3">Foto</th>
                        <th class="px-6 py-3">Nama</th>
                        <th class="px-6 py-3">Kota</th>
                        <th class="px-6 py-3">Tipe</th>
                        <th class="px-6 py-3">Harga/Bulan</th>
                        <th class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($properties as $property)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="w-12 h-12 rounded-lg overflow-hidden bg-gray-100">
                                @if($property->primaryPhoto)
                                <img src="{{ $property->primaryPhoto->url }}" alt="{{ $property->name }}" class="w-full h-full object-cover"
                                     onerror="this.parentElement.innerHTML='<div class=\'w-full h-full bg-emerald-50 flex items-center justify-center\'><span class=\'text-xs text-emerald-300\'>No</span></div>'">
                                @else
                                <div class="w-full h-full bg-emerald-50 flex items-center justify-center">
                                    <span class="text-xs text-emerald-300">—</span>
                                </div>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $property->name }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $property->city }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-lg capitalize
                                {{ $property->property_type === 'kos' ? 'bg-emerald-100 text-emerald-700' : ($property->property_type === 'kontrakan' ? 'bg-amber-100 text-amber-700' : 'bg-indigo-100 text-indigo-700') }}">
                                {{ $property->property_type }}
                            </span>
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-800">{{ $property->formattedPrice() }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.properties.edit', $property) }}" class="text-emerald-600 hover:text-emerald-800 transition-colors" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <form action="{{ route('admin.properties.destroy', $property) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus properti ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-600 transition-colors" title="Hapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-400">Belum ada properti.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $properties->links() }}
    </div>
</div>
@endsection
