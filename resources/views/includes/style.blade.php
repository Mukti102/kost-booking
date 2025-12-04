<style>
     @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

     body {
         font-family: 'Inter', sans-serif;
     }

     .nav-link {
         position: relative;
         transition: all 0.3s ease;
     }

  

     .nav-link::after {
         content: '';
         position: absolute;
         width: 0;
         height: 2px;
         bottom: -4px;
         left: 50%;
         background: linear-gradient(90deg, #6366f1, #8b5cf6);
         transition: all 0.3s ease;
         transform: translateX(-50%);
     }

     .nav-link:hover::after {
         width: 100%;
     }

     .navbar-glass {
         backdrop-filter: blur(12px);
         background: rgba(255, 255, 255, 0.9);
         border-bottom: 1px solid rgba(99, 102, 241, 0.1);
     }

     .booking-btn {
         background:oklch(62.3% 0.214 259.815);
         box-shadow: 0 4px 15px rgba(59, 59, 59, 0.345);
         transition: all 0.3s ease;
     }

     .booking-btn:hover {
         transform: translateY(-2px);
     }

     .logo-wrapper {
         transition: transform 0.3s ease;
     }

     .logo-wrapper:hover {
         transform: scale(1.05);
     }

     .mobile-menu {
         position: fixed;
         top: 0;
         right: -100%;
         height: 100vh;
         width: 80%;
         max-width: 320px;
         background: rgba(255, 255, 255, 0.98);
         backdrop-filter: blur(12px);
         box-shadow: -4px 0 20px rgba(0, 0, 0, 0.1);
         transition: right 0.3s ease-out;
         overflow-y: auto;
     }

     .mobile-menu.active {
         right: 0;
     }

     .overlay {
         position: fixed;
         top: 0;
         left: 0;
         width: 100%;
         height: 100vh;
         background: rgba(0, 0, 0, 0.5);
         opacity: 0;
         visibility: hidden;
         transition: all 0.3s ease;
         z-index: 40;
     }

     .overlay.active {
         opacity: 1;
         visibility: visible;
     }

     .menu-icon {
         transition: all 0.3s ease;
     }

     .menu-icon:hover {
         background: rgba(99, 102, 241, 0.1);
     }
 </style>