<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use App\Models\Tenant;
use App\Models\TypePayment;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tenants = Tenant::all();
        $rooms = Room::where('status', 'belum terpakai')->get();
        $numberUnique = 'BK-' . str_pad((Booking::max('id') + 1), 3, '0', STR_PAD_LEFT);
        $bookings = Booking::with('tenant', 'room', 'payment')->get();
        $typePayments = TypePayment::all();
        return view('pages.dashboard.bookings.index', compact('tenants', 'rooms', 'numberUnique', 'bookings', 'typePayments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rooms = Room::where('status', 'belum terpakai')->get();
        $tenants = Tenant::all();
        return view('pages.dashboard.bookings.create', compact('rooms', 'tenants'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'gender' => 'required|in:laki-laki,perempuan',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'room_id' => 'required|exists:rooms,id',
        ]);

        $numberUnique = 'BK-' . str_pad((Booking::max('id') + 1), 3, '0', STR_PAD_LEFT);

        $tenant = Tenant::create([
            'full_name' => $validatedData['full_name'],
            'email' => $validatedData['email'],
            'gender' => $validatedData['gender'],
            'phone' => $validatedData['phone'] ?? null,
            'address' => $validatedData['address'] ?? null,
        ]);

        $tenant->booking()->create([
            'code' => $numberUnique,
            'room_id' => $validatedData['room_id'],
            'status' => 'pending',
        ]);


        // Update room status to 'terpakai'
        $room = Room::find($request->room_id);
        $room->status = 'terpakai';
        $room->save();

        toastify()->success('Penyewaan Kost berhasil ditambahkan.');

        return redirect()->route('bookings.index')->with('success', 'Penyewaan Kost berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        $booking = $booking->load('tenant', 'room', 'payment.typePayment');
        $payment = $booking->payment;
        return view('pages.dashboard.bookings.detailPayment', compact('booking', 'payment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        $booking = $booking->load('tenant', 'room');
        $rooms = Room::where('status', 'belum terpakai')->orWhere('id', $booking->room_id)->get();
        return view('pages.dashboard.bookings.edit', compact('booking', 'rooms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'gender' => 'required|in:laki-laki,perempuan',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'room_id' => 'required|exists:rooms,id',
            'status' => 'nullable|string'
        ]);

        // Update tenant data
        $booking->tenant->update([
            'full_name' => $validatedData['full_name'],
            'email' => $validatedData['email'],
            'gender' => $validatedData['gender'],
            'phone' => $validatedData['phone'],
            'address' => $validatedData['address']
        ]);

        // Jika room berubah
        if ($booking->room_id != $validatedData['room_id']) {

            // Ubah status kamar lama menjadi belum terpakai
            Room::where('id', $booking->room_id)->update([
                'status' => 'belum terpakai'
            ]);

            // Kamar baru jadi terpakai
            Room::where('id', $validatedData['room_id'])->update([
                'status' => 'terpakai'
            ]);
        }

        // Update booking data
        $booking->update([
            'room_id' => $validatedData['room_id'],
            'status' => $validatedData['status'] ?? $booking->status,
        ]);

        toastify()->success('Booking berhasil diperbarui');

        return redirect()
            ->route('bookings.index')
            ->with('success', 'Booking berhasil diperbarui');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        // kembalikan kamar menjadi belum terpakai
        Room::where('id', $booking->room_id)->update([
            'status' => 'belum terpakai'
        ]);

        $booking->tenant()->delete();

        // hapus booking
        $booking->delete();

        toastify()->success('Booking berhasil dihapus');

        return redirect()->route('bookings.index')
            ->with('success', 'Booking berhasil dihapus');
    }
}
