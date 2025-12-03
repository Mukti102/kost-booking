<!-- Rooms Section -->
<section id="rooms" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Pilihan Kamar</h2>
            <p class="text-gray-600 text-lg">Temukan kamar yang sesuai dengan kebutuhan dan budget Anda</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            @forelse ($rooms as $room)
                <!-- Room Card 1 -->
                <a href="{{ route('showRoom', Crypt::encrypt($room->id)) }}"
                    class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-300">
                    <div class="relative">
                        <img src="https://images.unsplash.com/photo-1540518614846-7eded433c457?w=400" alt="Room 1"
                            class="w-full h-64 object-cover">
                        <span
                            class="absolute top-4 right-4 bg-green-500 text-white px-3 py-1 rounded-full text-sm font-semibold">Tersedia</span>
                    </div>
                    <div class="p-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $room->name }}</h3>
                        <p class="text-gray-600 mb-4">Kamar nyaman dengan fasilitas lengkap</p>
                        @php
                            $facilities = $room->fasilities()->limit(3)->get();
                        @endphp
                        @foreach ($facilities as $facility)
                            <div class="mb-4">
                                <div class="flex items-center text-gray-600 mb-2">
                                   <i class="fa-regular fa-hand-point-right me-2"></i>
                                    {{ $facility->name }}
                                </div>
                            </div>
                        @endforeach
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-3xl font-bold text-indigo-600">Rp 1,2jt</span>
                                <span class="text-gray-500">/bulan</span>
                            </div>
                            <button
                                class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                                Booking
                            </button>
                        </div>
                    </div>
                </a>

            @empty
                <h1>Tidak Ada Kamar</h1>
            @endforelse

        </div>
    </div>
</section>
