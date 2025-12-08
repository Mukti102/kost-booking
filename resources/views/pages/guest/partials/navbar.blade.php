 
 <div id="overlay" class="overlay"></div>

 <nav class="navbar-glass   fixed w-full top-0 z-50">
     <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
         <div class="flex justify-between items-center h-20">
             <!-- Logo Section -->
             <a href="/" class="logo-wrapper flex items-center space-x-3">
                 <div class="relative">

                     <img class="relative w-10 h-10 md:w-16 md:h-16 rounded-xl" src="{{ asset('storage/' . setting('site_logo')) }}"
                         alt="KostQu Logo">
                 </div>
                 <span
                     class="text-2xl font-bold bg-primary bg-clip-text text-transparent">
                     {{ setting('site_name') }}
                 </span>
             </a>

             <!-- Desktop Navigation -->
             <div class="hidden md:flex items-center space-x-1">
                 <a href="#home" class="nav-link px-4 py-2 text-gray-700 hover:text-primary font-medium">
                     Beranda
                 </a>
                 <a href="#about" class="nav-link px-4 py-2 text-gray-700 hover:text-primary font-medium">
                     Tentang
                 </a>
                 <a href="#rooms" class="nav-link px-4 py-2 text-gray-700 hover:text-primary font-medium">
                     Kamar
                 </a>
                 <a href="#facilities" class="nav-link px-4 py-2 text-gray-700 hover:text-primary font-medium">
                     Fasilitas
                 </a>
                 <a href="#contact" class="nav-link px-4 py-2 text-gray-700 hover:text-primary font-medium">
                     Kontak
                 </a>
                 <a href="#rooms" class="booking-btn ml-4 px-6 py-2.5 text-white rounded-xl font-semibold">
                     <span class="flex items-center space-x-2">
                         <span>Booking Sekarang</span>
                         <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                 d="M13 7l5 5m0 0l-5 5m5-5H6" />
                         </svg>
                     </span>
                 </a>
             </div>

             <!-- Mobile Menu Button -->
             <button id="mobile-menu-button"
                 class="menu-icon md:hidden p-2.5 rounded-xl text-gray-600 hover:text-primary">
                 <svg id="menu-icon-closed" class="w-6 h-6 block" fill="none" stroke="currentColor"
                     viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                         d="M4 6h16M4 12h16M4 18h16" />
                 </svg>
                 <svg id="menu-icon-open" class="w-6 h-6 hidden" fill="none" stroke="currentColor"
                     viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                 </svg>
             </button>
         </div>
     </div>

     <!-- Mobile Menu -->
     <div id="mobile-menu" class="mobile-menu">
         <div class="p-6">
             <!-- Header Mobile Menu -->
             <div class="flex justify-between items-center mb-8">
                 <span
                     class="text-xl font-bold bg-primary bg-clip-text text-transparent">
                     Menu
                 </span>
                 <button id="close-menu" class="p-2 rounded-xl text-gray-600 hover:bg-gray-100 transition">
                     <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                             d="M6 18L18 6M6 6l12 12" />
                     </svg>
                 </button>
             </div>

             <!-- Menu Items -->
             <div class="space-y-2">
                 <a href="#home"
                     class="mobile-link block px-4 py-3 rounded-xl text-gray-700 hover:bg-indigo-50 hover:text-primary font-medium transition">
                     Beranda
                 </a>
                 <a href="#about"
                     class="mobile-link block px-4 py-3 rounded-xl text-gray-700 hover:bg-indigo-50 hover:text-primary font-medium transition">
                     Tentang
                 </a>
                 <a href="#rooms"
                     class="mobile-link block px-4 py-3 rounded-xl text-gray-700 hover:bg-indigo-50 hover:text-primary font-medium transition">
                     Kamar
                 </a>
                 <a href="#facilities"
                     class="mobile-link block px-4 py-3 rounded-xl text-gray-700 hover:bg-indigo-50 hover:text-primary font-medium transition">
                     Fasilitas
                 </a>
                 <a href="#contact"
                     class="mobile-link block px-4 py-3 rounded-xl text-gray-700 hover:bg-indigo-50 hover:text-primary font-medium transition">
                     Kontak
                 </a>
                 <a href="#rooms"
                     class="booking-btn block text-center py-3.5 text-white rounded-xl font-semibold mt-6">
                     Booking Sekarang
                 </a>
             </div>
         </div>
     </div>
 </nav>


 <script>
     const button = document.getElementById('mobile-menu-button');
     const menu = document.getElementById('mobile-menu');
     const overlay = document.getElementById('overlay');
     const closeBtn = document.getElementById('close-menu');
     const iconClosed = document.getElementById('menu-icon-closed');
     const iconOpen = document.getElementById('menu-icon-open');

     // Toggle mobile menu
     function toggleMenu() {
         menu.classList.toggle('active');
         overlay.classList.toggle('active');
         iconClosed.classList.toggle('hidden');
         iconOpen.classList.toggle('hidden');

         // Prevent body scroll when menu is open
         if (menu.classList.contains('active')) {
             document.body.style.overflow = 'hidden';
         } else {
             document.body.style.overflow = '';
         }
     }

     // Open menu
     button.addEventListener('click', toggleMenu);

     // Close menu
     closeBtn.addEventListener('click', toggleMenu);
     overlay.addEventListener('click', toggleMenu);

     // Close mobile menu when clicking on a link
     const mobileLinks = document.querySelectorAll('.mobile-link');
     mobileLinks.forEach(link => {
         link.addEventListener('click', () => {
             menu.classList.remove('active');
             overlay.classList.remove('active');
             iconClosed.classList.remove('hidden');
             iconOpen.classList.add('hidden');
             document.body.style.overflow = '';
         });
     });

     // Add scroll effect
     let lastScroll = 0;
     window.addEventListener('scroll', () => {
         const nav = document.querySelector('nav');
         const currentScroll = window.pageYOffset;

         if (currentScroll > 50) {
             nav.style.boxShadow = '0 4px 20px rgba(0, 0, 0, 0.08)';
         } else {
             nav.style.boxShadow = 'none';
         }

         lastScroll = currentScroll;
     });
 </script>
