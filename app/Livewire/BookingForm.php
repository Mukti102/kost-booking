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

    // durasi default 1 bulan/tahun
    public $durationInput = 1; // dipakai user
    public $duration = 1; // sinkron database

    public $showModal = false;
    public $payment_proof;
    public $bankAccount;


    public function mount($room)
    {
        $this->room = $room;
        $this->typePayments = TypePayment::all();
    }

    /** Sinkronkan durationInput → duration (database + modal) */
    public function updatedDurationInput($value)
    {
        $this->duration = $value;
    }

    /** VALIDASI */
    protected $rules = [
        'full_name'   => 'required|string|max:255',
        'email'       => 'required|email|unique:tenants,email',
        'gender'      => 'required',
        'phone'       => 'required|string|max:20',
        'address'     => 'nullable|string',
        'durationInput' => 'required|numeric|min:1|max:12'
    ];

    /** Modal Konfirmasi */
    public function openConfirmModal()
    {
        try {
            $this->validate();

            $this->bankAccount = TypePayment::first();
            $this->showModal = true;
        } catch (\Illuminate\Validation\ValidationException $e) {

            foreach ($e->validator->errors()->all() as $error) {
                toastify()->error($error);
            }

            // Trigger browser reload via JS
            $this->dispatch('reload-browser');

            return; // stop execution
        }
    }



    /** Computed: Total Harga */
    public function getTotalProperty()
    {
        return $this->room->tarif * $this->durationInput;
    }

    /** Computed: DP (50%) */
    public function getDPProperty()
    {
        return $this->total / 2;
    }

    /** Submit Booking */
    public function submitBooking()
    {
        $this->validate([
            'payment_proof' => 'required|image|max:2048'
        ]);

        // Hitung biaya pakai durationInput
        $total = $this->room->tarif * $this->durationInput;
        $dp = $total / 2;

        // Upload Bukti pembayaran
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
                'code'      => $numberUnique,
                'room_id'   => $this->room->id,
                'tenant_id' => $tenant->id,
                'duration'  => $this->durationInput, // ← sudah benar
                'total'     => $total,
                'status'    => 'pending',
            ]);


            // Simpan Payment
            Payment::create([
                'booking_id'      => $booking->id,
                'type_payment_id' => $this->bankAccount->id,
                'amount'          => $dp,
                'payment_proof'   => $proofPath,
                'status'          => 'pending'
            ]);

            DB::commit();

            $this->reset();

            session()->flash('success', 'Booking berhasil, admin akan konfirmasi pembayaran Anda.');
            return redirect()->route('booking.success', Crypt::encrypt($booking->id));
        } catch (Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat pemrosesan booking.');
        }
    }

    public function render()
    {
        return view('livewire.booking-form');
    }
}
