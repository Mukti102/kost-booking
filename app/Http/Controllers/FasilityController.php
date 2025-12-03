<?php

namespace App\Http\Controllers;

use App\Models\Fasility;
use Illuminate\Http\Request;

class FasilityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fasilities = Fasility::all();
        return view('pages.dashboard.fasilities.index', compact('fasilities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
        ]);


        Fasility::create($validated);
        toastify()->success('Fasilitas Berhasil Ditambahkan');
        return redirect()->route('fasilities.index')->with('success', 'Fasility created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Fasility $fasility)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fasility $fasility)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fasility $fasility)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
        ]);

        $fasility->update($validated);
        toastify()->success('Fasilitas Berhasil Diperbarui');
        return redirect()->route('fasilities.index')->with('success', 'Fasility updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fasility $fasility)
    {
        $fasility->delete();
        toastify()->success('Fasilitas Berhasil Dihapus');
        return redirect()->route('fasilities.index')->with('success', 'Fasility deleted successfully.');
    }
}
