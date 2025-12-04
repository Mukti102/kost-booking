<?php

namespace App\Http\Controllers;

use App\Models\Testimoni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimoniController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tetstimonis = Testimoni::all();
        return view('pages.dashboard.testimoni.index', compact('tetstimonis'));
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
            'name' => 'required|min:5',
            'jabatan' => 'required',
            'rate' => 'required',
            'photo' => 'nullable',
            'comment' => 'required'
        ]);

        if ($request->photo) {
            $validated['photo'] = $request->file('photo')->store('testimoni', 'public');
        }

        Testimoni::create($validated);
        toastify()->success('Berhasil Menambahkan Testimoni');
        return redirect()->route('bookings.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Testimoni $testimoni)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Testimoni $testimoni)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Testimoni $testimoni)
    {
        $validated = $request->validate([
            'name'     => 'required|min:5',
            'jabatan'  => 'required',
            'rate'     => 'required',
            'photo'    => 'nullable',
            'comment'  => 'required'
        ]);

        // Jika upload photo baru
        if ($request->hasFile('photo')) {

            // Jika foto lama ada, hapus
            if ($testimoni->photo && Storage::disk('public')->exists($testimoni->photo)) {
                Storage::disk('public')->delete($testimoni->photo);
            }

            // Simpan foto baru
            $validated['photo'] = $request->file('photo')->store('testimoni', 'public');
        }

        $testimoni->update($validated);

        toastify()->success('Berhasil Mengubah Testimoni');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Testimoni $testimoni)
    {
        // Hapus gambar jika ada
        if ($testimoni->photo && Storage::disk('public')->exists($testimoni->photo)) {
            Storage::disk('public')->delete($testimoni->photo);
        }

        $testimoni->delete();

        toastify()->success('Berhasil Menghapus Testimoni');
        return redirect()->back();
    }
}
