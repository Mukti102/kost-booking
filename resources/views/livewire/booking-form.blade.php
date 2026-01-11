{{-- Kolom Form Booking (1/3 lebar) --}}
<div>
    <div class="lg:col-span-1 mt-4">
        <div class="sticky top-8 bg-white rounded-xl shadow-xl p-6 border border-indigo-200">
            <h2 class="text-2xl font-bold text-primary mb-4">Formulir Booking Kamar</h2>

            <div id="price-card" class="mb-4 p-4 bg-indigo-50 rounded-lg border border-indigo-300">
                <p class="text-sm font-semibold text-indigo-700 mb-1 capitalize">Harga Per {{ $room->duration }}</p>
                <p class="text-3xl font-extrabold text-indigo-800">
                    Rp
                    {{ number_format($room->tarif, 0, ',', '.') }}
                </p>
            </div>

            <form wire:submit.prevent="submitBooking">

                <!-- Pilihan Durasi Sewa -->
                <div class="mb-4">
                    <label for="duration" class="block text-sm font-medium text-gray-700 mb-1">Durasi Sewa
                        ({{ $room->duration }})</label>
                    <input wire:model="durationInput" type="number" id="duration" name="duration" min="1"
                        max="12" value="1" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 transition duration-150">
                </div>

                <!-- Kalkulasi Harga -->
                <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <div class="flex justify-between text-sm text-gray-700 mb-1">
                        <span>Total Sewa (<span id="calc-duration">{{ $durationInput }}</span>
                            {{ $room->duration }}):</span>
                        <span class="font-semibold text-gray-800" id="calc-total-price">
                            Rp {{ number_format($this->total, 0, ',', '.') }}
                        </span>
                    </div>

                    <div
                        class="flex justify-between text-base font-semibold text-red-600 border-t pt-2 mt-2 border-red-200">
                        <span>DP (50%) yang Harus Dibayar:</span>
                        <span id="calc-dp-price">
                            Rp {{ number_format($this->dP, 0, ',', '.') }}
                        </span>
                    </div>

                    <p class="text-xs text-gray-500 mt-2">Sisa pembayaran dilunasi saat check-in.</p>
                </div>


                <h3 class="text-lg font-semibold text-gray-700 mb-3 border-t pt-4">Data Calon Penyewa</h3>

                <!-- Nama Lengkap (Tenant: full_name) -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Nama Lengkap
                    </label>

                    <input type="text" wire:model.defer="full_name"
                        class="w-full px-4 py-2 border rounded-lg
        @error('full_name') border-red-500 @else border-gray-300 @enderror
        focus:ring-indigo-500 focus:border-indigo-500">

                    @error('full_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>


                <!-- Email (Tenant: email) -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>

                    <input type="email" wire:model.defer="email"
                        class="w-full px-4 py-2 border rounded-lg
        @error('email') border-red-500 @else border-gray-300 @enderror">

                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>


                <!-- Jenis Kelamin (Tenant: gender) -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>

                    <select wire:model.defer="gender"
                        class="w-full px-4 py-2 border rounded-lg
        @error('gender') border-red-500 @else border-gray-300 @enderror">
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="laki-laki">Laki-laki</option>
                        <option value="perempuan">Perempuan</option>
                    </select>

                    @error('gender')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>


                <!-- No. Telepon (Tenant: phone) -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>

                    <input type="tel" wire:model.defer="phone"
                        class="w-full px-4 py-2 border rounded-lg
        @error('phone') border-red-500 @else border-gray-300 @enderror">

                    @error('phone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>


                <!-- Alamat (Tenant: address) -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>

                    <textarea wire:model.defer="address" rows="3"
                        class="w-full px-4 py-2 border rounded-lg
        @error('address') border-red-500 @else border-gray-300 @enderror">
    </textarea>

                    @error('address')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>



                <!-- Submit Button -->
                <button class="px-4 py-2 rounded-lg bg-primary text-white hover:bg-indigo-700">
                    Bayar DP Sekarang
                </button>

            </form>
        </div>
    </div>


    <!-- Confirmation Modal (Pengganti alert) -->
    {{-- @if ($showModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
            <div class="bg-white rounded-xl p-6 w-full max-w-lg shadow-xl">

                <h3 class="text-xl font-bold mb-3 text-primary">Konfirmasi Booking</h3>

                <p class="text-sm text-gray-600 mb-4">Silahkan cek detail booking dan upload bukti pembayaran.</p>

                <div class="bg-gray-100 rounded-lg p-4 mb-4">
                    <p><strong>Durasi:</strong> {{ $durationInput }} {{ $room->duration }}</p>
                    <p><strong>Total:</strong> Rp {{ number_format($room->tarif * $durationInput, 0, ',', '.') }}</p>
                    <p class="text-red-600 font-bold">DP (50%) = Rp
                        {{ number_format(($room->tarif * $durationInput) / 2, 0, ',', '.') }}</p>
                </div>

                <div class="bg-indigo-50 border border-indigo-200 p-3 rounded-lg mb-4">
                    <p class="font-semibold text-indigo-700">TRANSFER DP KE REKENING {{ $bankAccount->name }}:</p>
                    <p class="text-indigo-900 font-bold">{{ $bankAccount->no_rekening }}</p>
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
                        class="px-4 py-2 rounded-lg bg-primary text-white hover:bg-indigo-700">
                        Konfirmasi & Booking
                    </button>
                </div>
            </div>
        </div>
    @endif --}}



</div>
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
</script>
<script>
    // document.addEventListener('livewire:init', () => {
    //     window.addEventListener('reload-browser', () => {
    //         window.location.reload();
    //     });
    // });

    document.addEventListener('livewire:init', () => {
        Livewire.on('open-midtrans', data => {
            snap.pay(data.token, {
                onSuccess: function(result) {
                    window.location.href = "/booking/success/" + data.bookingId;
                },
                onPending: function(result) {
                    alert('Menunggu pembayaran');
                },
                onError: function(result) {
                    alert('Pembayaran gagal');
                }
            });
        });
    });
</script>
