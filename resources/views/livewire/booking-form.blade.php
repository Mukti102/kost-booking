{{-- Kolom Form Booking (1/3 lebar) --}}
<div>
    <div class="lg:col-span-1 mt-4">
        <div class="sticky top-8 bg-white rounded-xl shadow-xl p-6 border border-indigo-200">
            <h2 class="text-2xl font-bold text-indigo-600 mb-4">Formulir Booking Kamar</h2>

            <div id="price-card" class="mb-4 p-4 bg-indigo-50 rounded-lg border border-indigo-300">
                <p class="text-sm font-semibold text-indigo-700 mb-1">Harga per Bulan</p>
                <p class="text-3xl font-extrabold text-indigo-800">
                    Rp
                    {{ number_format($room->tarif, 0, ',', '.') }}
                </p>
            </div>

            <form wire:submit.prevent="openConfirmModal">

                <!-- Pilihan Durasi Sewa -->
                <div class="mb-4">
                    <label for="duration" class="block text-sm font-medium text-gray-700 mb-1">Durasi Sewa
                        (Bulan)</label>
                    <input type="number" readonly id="duration" name="duration" min="1" max="12"
                        value="1" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 transition duration-150">
                </div>

                <!-- Kalkulasi Harga -->
                <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <div class="flex justify-between text-sm text-gray-700 mb-1">
                        <span>Total Sewa (<span id="calc-duration">1</span> bulan):</span>
                        <span class="font-semibold text-gray-800" id="calc-total-price">
                            Rp
                            {{ number_format($room->tarif, 0, ',', '.') }}
                        </span>
                    </div>
                    <div
                        class="flex justify-between text-base font-semibold text-red-600 border-t pt-2 mt-2 border-red-200">
                        <span>DP (50%) yang Harus Dibayar:</span>
                        <span id="calc-dp-price">
                            Rp
                            {{ number_format($room->tarif / 2, 0, ',', '.') }}
                        </span>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Sisa pembayaran dilunasi saat check-in.</p>
                </div>

                <h3 class="text-lg font-semibold text-gray-700 mb-3 border-t pt-4">Data Calon Penyewa</h3>

                <!-- Nama Lengkap (Tenant: full_name) -->
                <div class="mb-4">
                    <label for="full_name" class="block text-sm font-medium text-gray-700 mb-1">Nama
                        Lengkap</label>
                    <input type="text" wire:model="full_name" id="full_name" name="full_name" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- Email (Tenant: email) -->
                <div class="mb-4">
                    <label for="email" 
                        class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" wire:model="email" id="email" name="email" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- Jenis Kelamin (Tenant: gender) -->
                <div class="mb-4">
                    <label for="gender" class="block text-sm font-medium text-gray-700 mb-1">Jenis
                        Kelamin</label>
                    <select wire:model="gender" id="gender" name="gender" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 appearance-none">
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="laki-laki">Laki-laki</option>
                        <option value="perempuan">Perempuan</option>
                    </select>
                </div>

                <!-- No. Telepon (Tenant: phone) -->
                <div class="mb-4">
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon
                        (Opsional)</label>
                    <input wire:model="phone" type="tel" id="phone" name="phone"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- Alamat (Tenant: address) -->
                <div class="mb-6">
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap
                        (Opsional)</label>
                    <textarea wire:model="address" id="address" name="address" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                </div>

                <div class="mb-4">
                    <label for="gender" class="block text-sm font-medium text-gray-700 mb-1">Jenis
                        Pembayaran</label>
                    <select wire:model="typePayment" id="typePayment" name="typePayment" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 appearance-none">
                        <option value="">Pilih Metode Pembayaran</option>
                        @foreach ($typePayments as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full bg-indigo-600 text-white font-bold py-3 px-4 rounded-xl hover:bg-indigo-700 transition duration-300 shadow-md hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-indigo-500 focus:ring-opacity-50">
                    Booking Sekarang & Bayar DP
                </button>
            </form>
        </div>
    </div>


    <!-- Confirmation Modal (Pengganti alert) -->
    @if ($showModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
            <div class="bg-white rounded-xl p-6 w-full max-w-lg shadow-xl">

                <h3 class="text-xl font-bold mb-3 text-indigo-600">Konfirmasi Booking</h3>

                <p class="text-sm text-gray-600 mb-4">Silahkan cek detail booking dan upload bukti pembayaran.</p>

                <div class="bg-gray-100 rounded-lg p-4 mb-4">
                    <p><strong>Durasi:</strong> {{ $duration }} Bulan</p>
                    <p><strong>Harga/bulan:</strong> Rp {{ number_format($room->tarif, 0, ',', '.') }}</p>
                    <p><strong>Total:</strong> Rp {{ number_format($room->tarif * $duration, 0, ',', '.') }}</p>
                    <p class="text-red-600 font-bold">
                        DP (50%) = Rp {{ number_format(($room->tarif * $duration) / 2, 0, ',', '.') }}
                    </p>
                </div>

                <div class="bg-indigo-50 border border-indigo-200 p-3 rounded-lg mb-4">
                    <p class="font-semibold text-indigo-700">TRANSFER DP KE REKENING:</p>
                    <p class="text-indigo-900 font-bold">{{ $bankAccount }}</p>
                </div>

                <label class="block text-sm font-semibold text-gray-700 mb-2">Upload Bukti Pembayaran</label>
                <input type="file" wire:model="payment_proof" class="w-full border p-2 rounded mb-3">

                @error('payment_proof')
                    <p class="text-red-600 text-sm mb-2">{{ $message }}</p>
                @enderror

                <div class="flex justify-end gap-2">
                    <button wire:click="$set('showModal', false)"
                        class="px-4 py-2 rounded-lg bg-gray-300 hover:bg-gray-400">
                        Batal
                    </button>

                    <button wire:click="submitBooking"
                        class="px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">
                        Konfirmasi & Booking
                    </button>
                </div>
            </div>
        </div>
    @endif


</div>
