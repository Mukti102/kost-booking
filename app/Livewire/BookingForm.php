<?php

namespace App\Livewire;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Tenant;
use App\Models\TypePayment;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Throwable;

class BookingForm extends Component
{
    use WithFileUploads;

    public $room;
    public $typePayments;

    // form input values
    public $full_name, $email, $gender, $phone, $address;
    public $typePayment;
    public $duration = 1;

    public $showModal = false;
    public $payment_proof;
    public $bankAccount; // contoh no rekening


    public function mount($room)
    {
        $this->room = $room;
        $this->typePayments = TypePayment::all();
    }

    protected $rules = [
        'full_name'   => 'required|string|max:255',
        'email'       => 'required|email',
        'gender'      => 'required',
        'phone'       => 'nullable|string|max:20',
        'address'     => 'nullable|string',
        'typePayment' => 'required|exists:type_payments,id',
        'duration'    => 'required|numeric|min:1|max:12'
    ];

    public function openConfirmModal()
    {
        $bankAccount = TypePayment::find($this->typePayment);
        $this->bankAccount = $bankAccount;
        $this->validate();

        $this->showModal = true;
    }

    public function submitBooking()
    {
        $this->validate([
            'payment_proof' => 'required|image|max:2048'
        ]);



        // Hitung biaya
        $total = $this->room->tarif * $this->duration;
        $dp = $total / 2;

        // Upload file
        $proofPath = $this->payment_proof->store('payments', 'public');

        try {

            DB::beginTransaction();
            // Simpan Tenant
            $tenant = Tenant::create([
                'full_name' => $this->full_name,
                'email'     => $this->email,
                'gender'    => $this->gender,
                'phone'     => $this->phone,
                'address'   => $this->address,
            ]);

            $numberUnique = 'BK-' . str_pad((Booking::max('id') + 1), 3, '0', STR_PAD_LEFT);


            // Simpan Booking
            $booking = Booking::create([
                'code' => $numberUnique,
                'room_id'   => $this->room->id,
                'tenant_id' => $tenant->id,
                'duration'  => $this->duration,
                'total'     => $total,
                'status'    => 'pending',
            ]);

            // Simpan Payment
            Payment::create([
                'booking_id'      => $booking->id,
                'type_payment_id' => $this->typePayment,
                'amount'          => $dp,
                'payment_proof'   => $proofPath,
                'status'          => 'pending'
            ]);

            DB::commit();

            $this->reset();

            session()->flash('success', 'Booking berhasil, admin akan konfirmasi pembayaran Anda.');
            toastify()->success('Berhasil Melakukan Booking Harap Tunggu Untuk Dikonfirmasi');
            return redirect()->route('booking.success', Crypt::encrypt($booking->id));
        } catch (Throwable $e) {
            DB::rollBack();
            toastify()->success('Berhasil Melakukan Booking Harap Tunggu Untuk Dikonfirmasi');
            return redirect()->back();
        }
    }


    public function render()
    {

        return view('livewire.booking-form');
    }
}
