<x-guest-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-16">
        <div class="grid my-10 grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Kolom Slide Photo Room dan Deskripsi Detail (2/3 lebar) --}}
            <div class="lg:col-span-2">

                <!-- Photo Slider -->
                <div class="bg-white rounded-xl  shadow-lg p-4 mb-8" >
                    <div id="image-slider"  class="relative overflow-hidden rounded-lg">
                        @foreach ($room->images as $item)
                            <!-- Images -->
                            <div class="slider-item" >
                                <img src="{{ asset('storage/' . $item->path) }}" alt="Kamar Utama"
                                    class="w-full rounded-lg slider-image" data-index="{{ $loop->iteration }}">
                            </div>
                        @endforeach


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
                        {{$room->description}}
                    </p>

                    <h3 class="text-xl font-medium text-gray-700 mb-3">Fasilitas</h3>
                    <ul class="list-disc list-inside text-gray-600 space-y-2 ml-4 mb-6">
                        @foreach ($room->fasilities as $fasilitas)
                            <li>{{ $fasilitas->name }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>

            @livewire('booking-form', ['room' => $room])
        </div>

    </div>

    <script>
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
    </script>
</x-guest-layout>
