<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use App\Models\Property;
use App\Models\PropertyPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $query = Property::with('primaryPhoto');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%");
            });
        }

        $properties = $query->latest()->paginate(15)->withQueryString();

        return view('admin.properties.index', compact('properties'));
    }

    public function create()
    {
        $facilitiesByType = Facility::orderBy('name')->get()->groupBy('property_type');
        return view('admin.properties.create', compact('facilitiesByType'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'phone' => 'nullable|string|max:20',
            'price_month' => 'required|integer|min:0',
            'description' => 'required|string',
            'property_type' => 'required|in:kos,kontrakan,apartemen',
            'facilities' => 'array',
            'facilities.*' => 'exists:facilities,id',
            'photos' => 'array|max:10',
            'photos.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $property = Property::create($validated);

        $facilityIds = Facility::query()
            ->forPropertyType($validated['property_type'])
            ->whereIn('id', $request->input('facilities', []))
            ->pluck('id');

        if ($facilityIds->isNotEmpty()) {
            $property->facilities()->attach($facilityIds);
        }

        // Upload photos
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $index => $photo) {
                $filename = 'property-' . $property->id . '-' . time() . '-' . $index . '.' . $photo->getClientOriginalExtension();
                $photo->storeAs('uploads', $filename, 'public');

                PropertyPhoto::create([
                    'property_id' => $property->id,
                    'filename' => $filename,
                    'is_primary' => $index === 0, // First photo is primary
                ]);
            }
        }

        return redirect()->route('admin.properties.index')->with('success', 'Properti berhasil ditambahkan.');
    }

    public function edit(Property $property)
    {
        $property->load(['photos', 'facilities']);
        $facilitiesByType = Facility::orderBy('name')->get()->groupBy('property_type');
        return view('admin.properties.edit', compact('property', 'facilitiesByType'));
    }

    public function update(Request $request, Property $property)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'phone' => 'nullable|string|max:20',
            'price_month' => 'required|integer|min:0',
            'description' => 'required|string',
            'property_type' => 'required|in:kos,kontrakan,apartemen',
            'facilities' => 'array',
            'facilities.*' => 'exists:facilities,id',
            'photos' => 'array|max:10',
            'photos.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'primary_photo_id' => 'nullable|exists:property_photos,id',
        ]);

        $property->update($validated);

        $facilityIds = Facility::query()
            ->forPropertyType($validated['property_type'])
            ->whereIn('id', $request->input('facilities', []))
            ->pluck('id');

        $property->facilities()->sync($facilityIds);

        // Upload new photos
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $index => $photo) {
                $filename = 'property-' . $property->id . '-' . time() . '-' . $index . '.' . $photo->getClientOriginalExtension();
                $photo->storeAs('uploads', $filename, 'public');

                PropertyPhoto::create([
                    'property_id' => $property->id,
                    'filename' => $filename,
                    'is_primary' => false,
                ]);
            }
        }

        // Update primary photo
        if ($request->filled('primary_photo_id')) {
            $property->photos()->update(['is_primary' => false]);
            $property->photos()->where('id', $request->input('primary_photo_id'))->update(['is_primary' => true]);
        }

        return redirect()->route('admin.properties.index')->with('success', 'Properti berhasil diperbarui.');
    }

    public function destroy(Property $property)
    {
        // Delete photo files
        foreach ($property->photos as $photo) {
            Storage::disk('public')->delete('uploads/' . $photo->filename);
        }

        $property->delete();

        return redirect()->route('admin.properties.index')->with('success', 'Properti berhasil dihapus.');
    }

    public function deletePhoto(PropertyPhoto $photo)
    {
        Storage::disk('public')->delete('uploads/' . $photo->filename);
        $photo->delete();

        return back()->with('success', 'Foto berhasil dihapus.');
    }
}
