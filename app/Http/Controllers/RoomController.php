<?php

namespace App\Http\Controllers;

use App\Models\Fasility;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::all();
        return view('pages.dashboard.rooms.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $numberUnique = 'KMR-' . str_pad((Room::max('id') + 1), 3, '0', STR_PAD_LEFT);
        $fasilities = Fasility::all();
        return view('pages.dashboard.rooms.create', compact('numberUnique', 'fasilities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'number' => 'required|string|unique:rooms,number',
            'name' => 'required',
            'kamar_tersedia' => 'required',
            'tarif' => 'required|numeric',
            'status' => 'required|in:belum terpakai,terpakai',
            'description' => 'nullable|string',
            'duration' => 'required|in:bulan,tahun',

            // tambahan facilities
            'fasilities' => 'required|array',
            'fasilities.*' => 'exists:fasilities,id',

        ], [
            'number.required' => 'Nomor kamar wajib diisi.',
            'number.unique' => 'Nomor kamar sudah digunakan.',
            'tarif.required' => 'Tarif kamar wajib diisi.',
            'tarif.numeric' => 'Tarif kamar harus berupa angka.',
            'status.required' => 'Status kamar wajib diisi.',
            'status.in' => 'Status kamar tidak valid.',

            'fasilities.required' => 'Minimal pilih 1 fasilitas.',
            'fasilities.array' => 'Format fasilitas tidak valid.',
            'fasilities.*.exists' => 'Fasilitas tidak valid.',
        ]);

        // Simpan room
        $room = Room::create($validated);

        $room->fasilities()->sync($validated['fasilities']);

        return redirect()->route('rooms.index')->with('success', 'Kamar berhasil ditambahkan');
    }


    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        $fasilities = Fasility::all();
        $room->load('fasilities');
        return view('pages.dashboard.rooms.edit', compact('room', 'fasilities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'name' => 'required',
            'kamar_tersedia' => 'required',
            'number' => 'required|string|unique:rooms,number,' . $room->id,
            'tarif' => 'required|numeric',
            'status' => 'required|in:belum terpakai,terpakai',
            'description' => 'nullable|string',
            'duration' => 'required|in:bulan,tahun',


            // fasilities
            'fasilities' => 'required|array',
            'fasilities.*' => 'exists:fasilities,id',

        ], [
            'number.required' => 'Nomor kamar wajib diisi.',
            'number.unique' => 'Nomor kamar sudah digunakan.',
            'tarif.required' => 'Tarif kamar wajib diisi.',
            'tarif.numeric' => 'Tarif kamar harus berupa angka.',
            'status.required' => 'Status kamar wajib diisi.',
            'status.in' => 'Status kamar tidak valid.',

            'fasilities.required' => 'Minimal pilih 1 fasilitas.',
            'fasilities.array' => 'Format fasilitas tidak valid.',
            'fasilities.*.exists' => 'Fasilitas tidak valid.',
        ]);

        $room->update($validated);
        $room->fasilities()->sync($validated['fasilities']);
        toastify()->success('Kamar Berhasil Diperbarui');
        return redirect()->route('rooms.index')->with('success', 'Room updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        $room->delete();
        toastify()->success('Kamar Berhasil Dihapus');
        return redirect()->route('rooms.index')->with('success', 'Room deleted successfully.');
    }
}
