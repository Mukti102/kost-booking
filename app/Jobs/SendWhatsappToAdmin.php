<?php

namespace App\Jobs;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendWhatsappToAdmin implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Booking $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    private function normalizePhone(string $phone): string
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);

        if (str_starts_with($phone, '0')) {
            return '62' . substr($phone, 1);
        }

        if (str_starts_with($phone, '62')) {
            return $phone;
        }

        return '62' . $phone;
    }

    public function handle(): void
    {
        // ==== VALIDASI RELASI ====
        if (
            !$this->booking ||
            !$this->booking->tenant ||
            !$this->booking->room
        ) {
            Log::warning('WA ADMIN GAGAL: DATA BOOKING TIDAK LENGKAP', [
                'booking_id' => $this->booking->id ?? null,
            ]);
            return;
        }

        $message = "*PEMBAYARAN BERHASIL*\n\n"
            . "Kode Booking: {$this->booking->code}\n"
            . "Nama: {$this->booking->tenant->full_name}\n"
            . "Kamar: {$this->booking->room->name}\n"
            . "Total: Rp " . number_format($this->booking->total, 0, ',', '.') . "\n\n"
            . "Silakan cek dashboard admin.";

        // 👉 Kalau mau hanya admin saja
        $admins = User::all();

        foreach ($admins as $admin) {
            if (!$admin->phone) {
                continue;
            }

            try {
                $phone = $this->normalizePhone($admin->phone);

                Http::withHeaders([
                    'Authorization' => env('FONTE_TOKEN'),
                    'Content-Type'  => 'application/json',
                ])
                    ->timeout(10)
                    ->post(env('FONTE_URL_ENDPOINT'), [
                        'phone'   => $phone,
                        'message' => $message,
                    ]);


                $response = Http::withHeaders([
                    'Authorization' => env('FONNTE_TOKEN'),
                ])->post('https://api.fonnte.com/send', [
                    'target'  => $phone,
                    'message' => $message,
                ]);

                Log::info('WA ADMIN TERKIRIM', [
                    'admin_id' => $admin->id,
                    'phone' => $phone,
                ]);
            } catch (\Throwable $e) {
                Log::error('Gagal kirim WA ke admin', [
                    'admin_id' => $admin->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }
}
