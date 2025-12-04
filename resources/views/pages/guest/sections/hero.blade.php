 <!-- Hero Section with Slider -->
    <section id="home" class="relative mt-10 md:mt-16">
        <div class="hero-slider overflow-hidden">
            <div class="slide-container flex transition-transform duration-500" id="slideContainer">
                <!-- Slide 1 -->
                <div class="slide min-w-full h-[600px] relative">
                    <img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=1200" alt="Kost 1"
                        class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center">
                        <div class="text-center text-white px-4">
                            <h1 class="text-5xl font-bold mb-4">Temukan Hunian Nyaman Anda</h1>
                            <p class="text-xl mb-8">Kost modern dengan fasilitas lengkap di lokasi strategis</p>
                            <a href="#rooms"
                                class="booking-btn text-white px-8 py-3 rounded-lg text-lg hover:bg-indigo-700 transition">
                                Lihat Kamar
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Slide 2 -->
                <div class="slide min-w-full h-[600px] relative">
                    <img src="https://images.unsplash.com/photo-1555854877-bab0e564b8d5?w=1200" alt="Kost 2"
                        class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center">
                        <div class="text-center text-white px-4">
                            <h1 class="text-5xl font-bold mb-4">Fasilitas Premium</h1>
                            <p class="text-xl mb-8">WiFi cepat, AC, dan keamanan 24 jam</p>
                            <a href="#about"
                                class="booking-btn text-white px-8 py-3 rounded-lg text-lg hover:bg-indigo-700 transition">
                                Pelajari Lebih Lanjut
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Slide 3 -->
                <div class="slide min-w-full h-[600px] relative">
                    <img src="https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?w=1200" alt="Kost 3"
                        class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center">
                        <div class="text-center text-white px-4">
                            <h1 class="text-5xl font-bold mb-4">Lokasi Strategis</h1>
                            <p class="text-xl mb-8">Dekat kampus, pusat bisnis, dan transportasi umum</p>
                            <a href="#contact"
                                class="booking-btn text-white px-8 py-3 rounded-lg text-lg hover:bg-indigo-700 transition">
                                Cek Lokasi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Slider Controls -->
        <button onclick="prevSlide()"
            class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-50 hover:bg-opacity-75 rounded-full p-3 transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </button>
        <button onclick="nextSlide()"
            class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-50 hover:bg-opacity-75 rounded-full p-3 transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </button>
        <!-- Slider Indicators -->
        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
            <span class="indicator w-3 h-3 bg-white rounded-full cursor-pointer" onclick="goToSlide(0)"></span>
            <span class="indicator w-3 h-3 bg-white bg-opacity-50 rounded-full cursor-pointer"
                onclick="goToSlide(1)"></span>
            <span class="indicator w-3 h-3 bg-white bg-opacity-50 rounded-full cursor-pointer"
                onclick="goToSlide(2)"></span>
        </div>
    </section>
