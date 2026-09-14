<?php

namespace App\Http\Controllers;

use App\Models\Locality;
use Illuminate\Http\Request;

class LocalityController extends Controller
{
    public function index()
    {
        $localities = Locality::latest()->paginate(10);
        return view('admin.localities.index', compact('localities'));
    }

    public function create()
    {
        $lastLocality = Locality::latest()->first();
        return view('admin.localities.create', compact('lastLocality'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'pincode' => 'required|string|max:10',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');

        Locality::create($validated);
        return redirect()->route('admin.localities.index')->with('success', 'Locality created successfully.');
    }

    public function edit(Locality $locality)
    {
        return view('admin.localities.edit', compact('locality'));
    }

    public function update(Request $request, Locality $locality)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'pincode' => 'required|string|max:10',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');

        $locality->update($validated);
        return redirect()->route('admin.localities.index')->with('success', 'Locality updated successfully.');
    }

    public function destroy(Locality $locality)
    {
        $locality->delete();
        return redirect()->route('admin.localities.index')->with('success', 'Locality deleted successfully.');
    }
}
