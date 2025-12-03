<?php

namespace App\Http\Controllers;

use App\Models\TypePayment;
use Illuminate\Http\Request;

class TypePaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $typePayments = TypePayment::all();
        return view('pages.dashboard.typePayment.index',compact('typePayments'));
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
            'name' => 'required|unique:type_payments,name',
            'description' => 'nullable|string',
            'no_rekening' => 'nullable|string',
            'logo' => 'nullable|mimes:png,jpg',
            'qris_url' => 'nullable',
        ]);

        if($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('type-payments','public');
        }

        if($request->hasFile('qris_url')) {
            $validated['qris_url'] = $request->file('qris_url')->store('type-payments','public');
        }

       

        TypePayment::create($validated);

        toastify()->success('Tipe Pembayaran Berhasil Ditambahkan');
        return redirect()->route('type-payments.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(TypePayment $typePayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TypePayment $typePayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TypePayment $typePayment)
    {
        $validated = $request->validate([
            'name' => 'required|unique:type_payments,name,'.$typePayment->id,
            'description' => 'nullable|string',
            'no_rekening' => 'nullable|string',
            'logo' => 'nullable|mimes:png,jpg',
            'qris_url' => 'nullable',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('type-payments','public');
        }

        if ($request->hasFile('qris_url')) {
            $validated['qris_url'] = $request->file('qris_url')->store('type-payments','public');
        }

        $typePayment->update($validated);

        toastify()->success('Tipe Pembayaran Berhasil Diperbarui');
        return redirect()->route('type-payments.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TypePayment $typePayment)
    {
        $typePayment->delete();
        toastify()->success('Tipe Pembayaran Berhasil Dihapus');
        return redirect()->route('type-payments.index');
    }
}
