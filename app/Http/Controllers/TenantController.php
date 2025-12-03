<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tenants = Tenant::all();
        return view('pages.dashboard.tenants.index', compact('tenants'));
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
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:tenants,email',
            'gender' => 'required|in:laki-laki,perempuan',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        Tenant::create($validated);
        toastify()->success('Tenant Berhasil Ditambahkan');
        return redirect()->route('tenants.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tenant $tenant)
    {
        return view('pages.dashboard.tenants.show', compact('tenant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tenant $tenant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tenant $tenant)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:tenants,email,'.$tenant->id,
            'gender' => 'required|in:laki-laki,perempuan',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $tenant->update($validated);
        toastify()->success('Tenant Berhasil Diperbarui');
        return redirect()->route('tenants.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tenant $tenant)
    {
        $tenant->delete();
        toastify()->success('Tenant Berhasil Dihapus');
        return redirect()->route('tenants.index');
    }
}
