<x-guest-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-16">
        <div class="grid my-10 grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Kolom Slide Photo Room dan Deskripsi Detail (2/3 lebar) --}}
            <div class="lg:col-span-2">

                <!-- Photo Slider -->
                <div class="bg-white rounded-xl shadow-lg p-4 mb-8">
                    <div id="image-slider" class="relative overflow-hidden rounded-lg">

                        <!-- Images -->
                        <div class="slider-item">
                            <img src="https://placehold.co/1000x400/805ad5/ffffff?text=Kamar+Utama+1" alt="Kamar Utama"
                                class="w-full rounded-lg slider-image" data-index="0">
                        </div>
                        <div class="slider-item hidden">
                            <img src="https://placehold.co/1000x400/667eea/ffffff?text=Kamar+Mandi+Dalam"
                                alt="Kamar Mandi" class="w-full rounded-lg slider-image" data-index="1">
                        </div>
                        <div class="slider-item hidden">
                            <img src="https://placehold.co/1000x400/4299e1/ffffff?text=Fasilitas+Umum"
                                alt="Fasilitas Umum" class="w-full rounded-lg slider-image" data-index="2">
                        </div>

                        <!-- Navigation Buttons -->
                        <button onclick="changeSlide(-1)"
                            class="absolute top-1/2 left-4 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-3 rounded-full hover:bg-opacity-75 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>
                        <button onclick="changeSlide(1)"
                            class="absolute top-1/2 right-4 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-3 rounded-full hover:bg-opacity-75 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Deskripsi Detail -->
                <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                    <h2 class="text-2xl font-semibold text-gray-700 mb-4 border-b pb-2">Deskripsi Kamar</h2>
                    <p class="text-gray-600 mb-6">
                        Kamar Tipe A adalah pilihan ideal bagi mahasiswa atau profesional yang mencari kenyamanan dan
                        privasi. Dilengkapi dengan AC, kamar mandi dalam, dan perabotan lengkap (kasur, lemari, meja
                        belajar). Lokasi strategis dekat kampus dan pusat perbelanjaan.
                    </p>

                    <h3 class="text-xl font-medium text-gray-700 mb-3">Fasilitas</h3>
                    <ul class="list-disc list-inside text-gray-600 space-y-2 ml-4 mb-6">
                        @foreach ($room->fasilities as $fasilitas)
                            <li>{{ $fasilitas->name }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>

            @livewire('booking-form', ['room' => $room]);
        </div>

        {{-- <!-- Confirmation Modal (Pengganti alert) -->
        <div id="confirmation-modal"
            class="fixed inset-0 bg-gray-600 bg-opacity-50 z-50 flex justify-center items-center hidden">
            <div class="bg-white rounded-xl shadow-2xl p-6 w-11/12 max-w-lg transform transition-all">
                <h3 class="text-xl font-bold text-green-600 mb-3">Booking Berhasil!</h3>
                <p class="text-gray-700 mb-4">Permintaan booking Anda telah kami terima. Detail pemesanan:</p>
                <ul class="space-y-1 text-sm text-gray-600 p-3 bg-green-50 rounded-lg border border-green-200"
                    id="booking-summary">
                    <!-- Summary will be inserted here -->
                </ul>
                <button onclick="closeModal()"
                    class="mt-4 w-full bg-green-500 text-white font-semibold py-2 rounded-lg hover:bg-green-600 transition">
                    Tutup
                </button>
            </div>
        </div> --}}
    </div>
    {{-- 
    <script>
        // Data Harga Kamar (Rp 1.500.000 per bulan)
        const PRICE_PER_MONTH = @json($room->tarif);
        const DP_PERCENTAGE = @json(50);
        const typePayments = @json($typePayments);

        // Utility function to format number to IDR currency
        const formatRupiah = (number) => {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(number);
        };

        // --- Price Calculation Logic ---
        function calculatePrice() {
            const durationInput = document.getElementById('duration');
            const duration = parseInt(durationInput.value) || 1;

            // Limit duration to 1-12 months
            if (duration < 1) {
                durationInput.value = 1;
            } else if (duration > 12) {
                durationInput.value = 12;
            }

            const finalDuration = parseInt(durationInput.value);

            const totalPrice = PRICE_PER_MONTH * finalDuration;
            const dpPrice = totalPrice * (DP_PERCENTAGE / 100);

            document.getElementById('calc-duration').textContent = finalDuration;
            document.getElementById('calc-total-price').textContent = formatRupiah(totalPrice);
            document.getElementById('calc-dp-price').textContent = formatRupiah(dpPrice);

            return {
                finalDuration,
                totalPrice,
                dpPrice
            };
        }

        // Attach event listener to duration input
        document.getElementById('duration').addEventListener('input', calculatePrice);

        // Initial calculation on load
        calculatePrice();

        // --- Booking Form Submission ---
        function handleBooking(event) {
            event.preventDefault();

            const form = event.target;
            const formData = new FormData(form);
            const {
                finalDuration,
                totalPrice,
                dpPrice
            } = calculatePrice();

            // 1. Collect Tenant Data (sesuai skema tenants)
            const tenantData = {
                full_name: formData.get('full_name'),
                email: formData.get('email'),
                gender: formData.get('gender'),
                phone: formData.get('phone') || null,
                address: formData.get('address') || null,
                typePayment: formData.get('typePayment')
            };

            // 2. Generate Booking Data (simulasi sesuai skema bookings)
            const bookingData = {
                // 'code' would be generated on the backend (e.g., BK-202512001)
                code: 'BK-' + Date.now().toString().slice(-6),
                // 'tenant_id' would be foreign key ID after tenant is saved
                // 'room_id' is fixed for this page (e.g., 1)
                room_id: 1,
                status: 'pending',
                total_price: totalPrice.toFixed(2), // 10, 2
                dp_percentage: DP_PERCENTAGE,
                duration_months: finalDuration, // Additional field for context
            };

            // 3. Simulation of API Call (Replace with actual fetch/axios call)
            // console.log("Data Tenant:", tenantData);
            // console.log("Data Booking:", bookingData);
            // Simulate success after a delay

            setTimeout(() => {
                showModal(tenantData, bookingData);
                form.reset();
                calculatePrice(); // Recalculate after reset
            }, 500);
        }

        // --- Confirmation Modal Logic ---
        function showModal(tenant, booking) {
            const summaryList = document.getElementById('booking-summary');
            const jenisPembayaran = typePayments.find(tp => tp.id === parseInt(tenant.typePayment));
            summaryList.innerHTML = `
                <li><strong>Kode Booking:</strong> ${booking.code}</li>
                <li><strong>Kamar:</strong> Tipe A (AC + KM Dalam)</li>
                <li><strong>Durasi Sewa:</strong> ${booking.duration_months} bulan</li>
                <li><strong>Nama Penyewa:</strong> ${tenant.full_name}</li>
                <li><strong>Email:</strong> ${tenant.email}</li>
                <li><strong>Total Harga:</strong> ${formatRupiah(parseFloat(booking.total_price))}</li>
                <li><strong>DP (${booking.dp_percentage}%):</strong> ${formatRupiah(booking.dp_percentage / 100 * parseFloat(booking.total_price))}</li>
                <li><strong>Jenis Pembayaran:</strong> ${jenisPembayaran.name}</li>
                <li><strong>No Rekening / Nomor Tujuan:</strong> ${jenisPembayaran.no_rekening}</li>
                <li class="font-bold text-red-600">Status: ${booking.status.toUpperCase()} (Menunggu Verifikasi)</li>
            `;
            document.getElementById('confirmation-modal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('confirmation-modal').classList.add('hidden');
        }

        // --- Image Slider Logic ---
        let currentSlide = 0;
        const slides = document.querySelectorAll('.slider-item');
        const totalSlides = slides.length;

        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.classList.add('hidden');
                slide.style.opacity = '0';
                if (i === index) {
                    slide.classList.remove('hidden');
                    // Force reflow for transition to work
                    slide.offsetWidth;
                    slide.style.opacity = '1';
                }
            });
        }

        function changeSlide(direction) {
            currentSlide = (currentSlide + direction + totalSlides) % totalSlides;
            showSlide(currentSlide);
        }

        // Initialize slider
        showSlide(currentSlide);
    </script> --}}
</x-guest-layout>
