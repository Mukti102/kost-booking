<?php

namespace App\Jobs;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendWhatsappToCostumer implements ShouldQueue
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
            !$this->booking->room ||
            !$this->booking->payment
        ) {
            Log::warning('WA CUSTOMER GAGAL: DATA TIDAK LENGKAP', [
                'booking_id' => $this->booking->id ?? null,
            ]);
            return;
        }

        $sisa = max(
            0,
            $this->booking->total - $this->booking->payment->amount
        );

        $message = "*PEMBAYARAN BERHASIL 🎉*\n\n"
            . "Halo *{$this->booking->tenant->full_name}*,\n\n"
            . "Pembayaran DP booking kamar Anda telah kami terima.\n\n"
            . "📌 *Detail Pembayaran*\n"
            . "Kode Booking   : {$this->booking->code}\n"
            . "Kamar          : {$this->booking->room->name}\n"
            . "Total Biaya    : Rp " . number_format($this->booking->total, 0, ',', '.') . "\n"
            . "Terbayarkan    : Rp " . number_format($this->booking->payment->amount, 0, ',', '.') . "\n"
            . "Sisa Pembayaran: Rp " . number_format($sisa, 0, ',', '.') . "\n\n"
            . "📍 Sisa pembayaran dapat dilunasi saat *check-in*.\n\n"
            . "_Terima kasih telah mempercayai kami._\n"
            . "*Manajemen Kost*";

        if (!$this->booking->tenant->phone) {
            Log::warning('WA CUSTOMER GAGAL: NOMOR TIDAK ADA', [
                'booking_code' => $this->booking->code,
            ]);
            return;
        }

        try {
            $phone = $this->normalizePhone($this->booking->tenant->phone);

            Http::withHeaders([
                'Authorization' => env('FONTE_TOKEN'),
                'Content-Type'  => 'application/json',
            ])
                ->timeout(10)
                ->post(env('FONTE_URL_ENDPOINT'), [
                    'phone'   => $phone,
                    'message' => $message,
                ]);

            Log::info('WA CUSTOMER TERKIRIM', [
                'booking_code' => $this->booking->code,
                'phone' => $phone,
            ]);
        } catch (\Throwable $e) {
            Log::error('Gagal kirim WA ke customer', [
                'booking_code' => $this->booking->code,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
