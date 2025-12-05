<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Berhasil - KostQu</title>
    <!-- Load Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f7f9fb;
        }
    </style>
</head>

<body class="antialiased flex items-center justify-center min-h-screen">

    <div class="w-full max-w-2xl mx-auto p-6 sm:p-10">

        <div class="bg-white rounded-2xl shadow-2xl border border-green-100 p-8 md:p-10 text-center">

            <!-- Success Icon -->
            <svg class="w-20 h-20 mx-auto text-green-500 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>

            <h1 class="text-3xl font-extrabold text-green-700 mb-2">Booking Berhasil Dibuat!</h1>
            <p class="text-gray-600 mb-8">
                Bukti pembayaran DP Anda telah kami terima. Admin sedang memproses konfirmasi booking Anda.
            </p>

            <!-- Detail Booking Card -->
            <div class="bg-green-50 border-t-4 border-green-400 rounded-xl p-6 mb-8 text-left">
                <h2 class="text-xl font-bold text-green-800 mb-4">Detail Pemesanan (<span
                        id="booking-code">{{ $booking->code }}</span>)</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-3 gap-x-6 text-gray-700">

                    <!-- Kolom 1: Informasi Dasar -->
                    <div>
                        <p class="font-medium text-sm text-gray-500">Nama Penyewa:</p>
                        <p class="font-semibold" id="tenant-name">{{ $booking->tenant->full_name }}</p>
                    </div>
                    <div>
                        <p class="font-medium text-sm text-gray-500">Kamar Dipesan:</p>
                        <p class="font-semibold" id="room-name">Kamar {{ $booking->room->name }}</p>
                    </div>
                    <div>
                        <p class="font-medium text-sm text-gray-500">Durasi Sewa:</p>
                        <p class="font-semibold capitalize" id="duration">{{ $booking->duration }}{{$booking->room->duration}}</p>
                    </div>
                    <div>
                        <p class="font-medium text-sm text-gray-500">Status Booking:</p>
                        <span class="font-bold text-yellow-600 capitalize bg-yellow-100 px-3 py-1 rounded-full text-xs"
                            id="status">{{ $booking->payment->status }}</span>
                    </div>
                </div>

                <hr class="my-5 border-green-200">

                <!-- Kolom 2: Informasi Pembayaran -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-3 gap-x-6">
                    <div>
                        <p class="font-medium text-sm text-gray-500">Total Harga Sewa:</p>
                        <p class="font-bold text-lg text-gray-800" id="total-price">
                            Rp {{ number_format($booking->total, 0, ',', '.') }}
                        </p>
                    </div>

                    <div>
                        <p class="font-medium text-sm text-gray-500">DP (Uang Muka) Dibayar:</p>
                        <p class="font-bold text-lg text-green-600" id="dp-paid">
                            Rp {{ number_format($booking->total / 2, 0, ',', '.') }}
                        </p>
                    </div>

                    <div class="sm:col-span-2">
                        <p class="font-medium text-sm text-gray-500">Sisa Pembayaran (Pelunasan saat Check-in):</p>
                        <p class="font-bold text-xl text-red-600" id="remaining-balance">
                            Rp {{ number_format($booking->total / 2, 0, ',', '.') }}
                        </p>
                    </div>
                </div>

            </div>

            <!-- Next Steps & CTA -->
            <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-3">Langkah Selanjutnya silakan konfirmasi ke owner
                    kost bahwa anda sudah melakukan booking</h3>
                {{-- <ol class="list-decimal list-inside text-sm text-gray-600 space-y-2 px-4">
                    <li>Mohon tunggu notifikasi konfirmasi dari Admin dalam waktu maksimal 1x24 jam.</li>
                    <li>Kami akan menghubungi Anda melalui Email (<span
                            id="tenant-email">{{ $booking->tenant->phone }}</span>)</li>
                    <li>Setelah dikonfirmasi, Anda dapat melanjutkan ke proses pelunasan sisa pembayaran saat check-in.
                    </li>
                </ol> --}}
            </div>

            <div class="d-flex">
                <a href="/"
                    class="inline-block mt-8 bg-indigo-600 text-white font-bold py-3 px-8 rounded-xl hover:bg-indigo-700 transition duration-300 shadow-md">
                    Kembali ke Beranda
                </a>
                @php
                    $waNumber = setting('whatsapp'); // format 628xxxx
                    $message = urlencode(
                        "Halo Admin, saya ingin mengkonfirmasi booking saya dengan kode *{$booking->code}*. Mohon bantuannya ya.",
                    );
                @endphp

                {{-- <a href="https://wa.me/{{ $waNumber }}?text={{ $message }}"
                    class="inline-block mt-8 bg-green-600 text-white font-bold py-3 px-8 rounded-xl hover:bg-green-700 transition duration-300 shadow-md">
                    Konfirmasi WhatsApp
                </a> --}}
            </div>


        </div>
    </div>
</body>

</html>
