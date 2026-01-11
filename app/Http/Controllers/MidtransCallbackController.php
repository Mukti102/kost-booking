<?php

namespace App\Http\Controllers;

use App\Jobs\SendWhatsappToAdmin;
use App\Jobs\SendWhatsappToCostumer;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MidtransCallbackController extends Controller
{
    public function handle(Request $request)
    {
        // ===============================
        // 1. LOG PAYLOAD (DEBUG)
        // ===============================
        Log::info('MIDTRANS CALLBACK HIT', [
            'payload' => $request->all(),
        ]);

        // ===============================
        // 2. VALIDASI SIGNATURE KEY
        // ===============================
        $serverKey = env('MIDTRANS_SERVER_KEY');

        $expectedSignature = hash(
            'sha512',
            $request->order_id .
                $request->status_code .
                $request->gross_amount .
                $serverKey
        );

        if ($expectedSignature !== $request->signature_key) {
            Log::warning('MIDTRANS INVALID SIGNATURE', [
                'order_id' => $request->order_id,
            ]);

            return response()->json([
                'message' => 'Invalid signature'
            ], 403);
        }

        // ===============================
        // 3. CARI PAYMENT BERDASARKAN ORDER ID
        // ===============================
        $payment = Payment::with(['booking.tenant', 'booking.room'])
            ->whereHas('booking', function ($q) use ($request) {
                $q->where('code', $request->order_id);
            })
            ->first();

        if (!$payment) {
            Log::warning('MIDTRANS PAYMENT NOT FOUND', [
                'order_id' => $request->order_id,
            ]);

            return response()->json([
                'message' => 'Payment not found'
            ], 404);
        }

        // ===============================
        // 4. UPDATE DATA DASAR PAYMENT
        // ===============================
        $payment->update([
            'transaction_id'     => $request->transaction_id ?? null,
            'transaction_status' => $request->transaction_status,
            'payment_type'       => $request->payment_type ?? null,
            'gross_amount'       => $request->gross_amount,
        ]);

        // ===============================
        // 5. HANDLE STATUS MIDTRANS
        // ===============================
        switch ($request->transaction_status) {

            // ===== SUKSES =====
            case 'settlement':
            case 'capture':

                // Hindari double process
                if ($payment->status !== 'completed') {
                    $payment->update([
                        'status' => 'completed',
                    ]);

                    $payment->booking->update([
                        'status' => 'diterima',
                    ]);

                    // Kirim notifikasi
                    SendWhatsappToAdmin::dispatch($payment->booking);
                    SendWhatsappToCostumer::dispatch($payment->booking);

                    Log::info('MIDTRANS PAYMENT COMPLETED', [
                        'booking_code' => $payment->booking->code,
                    ]);
                }

                break;

            // ===== MENUNGGU =====
            case 'pending':
                $payment->update([
                    'status' => 'pending',
                ]);

                Log::info('MIDTRANS PAYMENT PENDING', [
                    'booking_code' => $payment->booking->code,
                ]);
                break;

            // ===== GAGAL =====
            case 'deny':
            case 'cancel':
            case 'expire':

                $payment->update([
                    'status' => 'failed',
                ]);

                $payment->booking->update([
                    'status' => 'ditolak',
                ]);

                Log::warning('MIDTRANS PAYMENT FAILED', [
                    'booking_code' => $payment->booking->code,
                    'status' => $request->transaction_status,
                ]);
                break;
        }

        // ===============================
        // 6. RESPONSE KE MIDTRANS
        // ===============================
        return response()->json([
            'success' => true
        ]);
    }
}
