<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $validatedData = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'type_payment_id' => 'required|exists:type_payments,id',
            'amount' => 'required|numeric|min:0',
            'payment_proof' => 'nullable|image|max:2048',
        ]);


        if ($request->hasFile('payment_proof')) {
            $file = $request->file('payment_proof');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('payments', $fileName, 'public');
            $validatedData['payment_proof'] = $filePath;
        }

        $validatedData['status'] = 'pending';

        Payment::updateOrCreate(
            ['booking_id' => $validatedData['booking_id']], // kondisi pencarian
            $validatedData // data yang diupdate/insert
        );

        toastify()->success('Payment recorded successfully.');
        return redirect()->back()->with('success', 'Payment recorded successfully.');
    }

    public function confirm(Payment $payment)
    {
        // 1. Update status pembayaran
        $payment->update([
            'status' => 'completed'
        ]);

        // 2. Ambil booking terkait
        $booking = $payment->booking;

        // 3. Update status booking
        $booking->update([
            'status' => 'diterima'
        ]);

        // 4. Kurangi jumlah kamar tersedia
        $room = $booking->room;

        if ($room->kamar_tersedia > 0) {
            $room->kamar_tersedia -= 1;

            // Jika sudah tidak ada kamar tersisa
            if ($room->kamar_tersedia <= 0) {
                $room->status = 'terpakai'; // atau "penuh" sesuai field yang kamu punya
            }

            $room->save();
        }

        toastify()->success('Payment confirmed successfully.');

        return redirect()->back()
            ->with('success', 'Payment confirmed successfully.');
    }



    public function reject(Payment $payment)
    {
        $payment->status = 'failed';
        $payment->save();

        $booking = $payment->booking;
        $booking->status = 'ditolak';
        $booking->room->status = 'belum terpakai';
        $booking->room->save();
        $booking->save();

        toastify()->success('Payment rejected successfully.');
        return redirect()->back()->with('success', 'Payment rejected successfully.');
    }

    public function success($id)
    {
        $id = decrypt($id);
        $booking = Booking::find($id);
        return view('pages.guest.success', compact('booking'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
