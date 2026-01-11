<?php

namespace App\Livewire;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Tenant;
use App\Models\TypePayment;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Midtrans\Snap;
use Midtrans\Config;
use Throwable;

class BookingForm extends Component
{
    public $room;

    // form input
    public $full_name, $email, $gender, $phone, $address;

    public $durationInput = 1;
    public $duration = 1;

    public $showModal = false;

    public function mount($room)
    {
        $this->room = $room;
    }

    public function updatedDurationInput($value)
    {
        $this->duration = $value;
    }

    protected $rules = [
        'full_name' => 'required|string|max:255',
        'email' => 'required|email|unique:tenants,email',
        'gender' => 'required',
        'phone' => 'required|string|max:20',
        'address' => 'nullable|string',
        'durationInput' => 'required|numeric|min:1|max:12',
    ];

    public function openConfirmModal()
    {
        $this->validate();
        $this->showModal = true;
    }

    public function getTotalProperty()
    {
        return $this->room->tarif * $this->durationInput;
    }

    public function getDPProperty()
    {
        return $this->total / 2;
    }

    public function submitBooking()
    {
        $this->validate(
            [
                'full_name'     => 'required|string|max:255',
                'email'         => 'required|email|unique:tenants,email',
                'gender'        => 'required|in:laki-laki,perempuan',
                'phone'         => 'required|string|max:20',
                'address'       => 'nullable|string',
                'durationInput' => 'required|numeric|min:1|max:12',
            ],
            [
                // full_name
                'full_name.required' => 'Nama lengkap wajib diisi.',
                'full_name.string'   => 'Nama lengkap harus berupa teks.',
                'full_name.max'      => 'Nama lengkap maksimal 255 karakter.',

                // email
                'email.required' => 'Email wajib diisi.',
                'email.email'    => 'Format email tidak valid.',
                'email.unique'   => 'Email sudah terdaftar.',

                // gender
                'gender.required' => 'Jenis kelamin wajib dipilih.',
                'gender.in'       => 'Jenis kelamin tidak valid.',

                // phone
                'phone.required' => 'Nomor telepon wajib diisi.',
                'phone.string'   => 'Nomor telepon harus berupa teks.',
                'phone.max'      => 'Nomor telepon maksimal 20 karakter.',

                // address
                'address.string' => 'Alamat harus berupa teks.',

                // duration
                'durationInput.required' => 'Durasi sewa wajib diisi.',
                'durationInput.numeric'  => 'Durasi harus berupa angka.',
                'durationInput.min'      => 'Durasi minimal 1 bulan.',
                'durationInput.max'      => 'Durasi maksimal 12 bulan.',
            ]
        );


        DB::beginTransaction();

        try {
            $total = $this->total;
            $dp = $this->dP;

            // Tenant
            $tenant = Tenant::create([
                'full_name' => $this->full_name,
                'email' => $this->email,
                'gender' => $this->gender,
                'phone' => $this->phone,
                'address' => $this->address,
            ]);

            $orderId = 'KOST-' . time();

            // Booking
            $booking = Booking::create([
                'code' => $orderId,
                'room_id' => $this->room->id,
                'tenant_id' => $tenant->id,
                'duration' => $this->durationInput,
                'total' => $total,
                'status' => 'pending',
            ]);

            // Payment
            $payment = Payment::create([
                'booking_id' => $booking->id,
                'amount' => $dp,
                'type_payment_id' => TypePayment::first()->id,
                'payment_proof' => '0',
                'status' => 'pending',
                'transaction_status' => 'pending',
            ]);

            // MIDTRANS CONFIG
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized = true;
            Config::$is3ds = true;

            $params = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => (int) $dp,
                ],
                'customer_details' => [
                    'first_name' => $this->full_name,
                    'email' => $this->email,
                    'phone' => $this->phone,
                ],
            ];

            $snapToken = Snap::getSnapToken($params);

            DB::commit();

            $this->dispatch('open-midtrans', token: $snapToken,  bookingId: Crypt::encrypt($booking->id));
        } catch (Throwable $e) {
            DB::rollBack();
            toastify()->error('Gagal memproses booking');
        }
    }

    public function render()
    {
        return view('livewire.booking-form');
    }
}
