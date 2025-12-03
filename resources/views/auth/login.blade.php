<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - KostQu</title>
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

    <div class="w-full max-w-md mx-auto p-8 md:p-10 bg-white rounded-2xl shadow-2xl border border-gray-100">
        
        <!-- Header / Logo -->
        <div class="text-center mb-8">
            <a href="/" class="text-4xl font-extrabold text-indigo-700">KostQu</a>
            <h2 class="mt-2 text-xl font-semibold text-gray-700">Selamat Datang Kembali!</h2>
            <p class="text-sm text-gray-500">Silakan login untuk mengakses dashboard Anda.</p>
        </div>

        <!-- Form Login -->
        <form method="POST" action="{{route('login')}}">
            @csrf

            {{-- session failed --}}
            {{-- <div id="session-status" class="hidden p-3 mb-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                Email atau Password salah. Silakan coba lagi.
            </div> --}}

            <!-- Email Address -->
            <div class="mb-5">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input id="email" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 transition duration-150" 
                       type="email" name="email" required autofocus autocomplete="username" placeholder="contoh@email.com" />
                <!-- Simulasi Error Email -->
                <!-- <p class="mt-2 text-sm text-red-600">Pesan error email.</p> -->
            </div>

            <!-- Password -->
            <div class="mb-5">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input id="password" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 transition duration-150"
                       type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                <!-- Simulasi Error Password -->
                <!-- <p class="mt-2 text-sm text-red-600">Pesan error password.</p> -->
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between mt-6">
                
                <!-- Remember Me -->
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" 
                           class="rounded text-indigo-600 shadow-sm focus:ring-indigo-500 border-gray-300" name="remember">
                    <span class="ms-2 text-sm text-gray-600">Ingat Saya</span>
                </label>
            
            </div>

            <!-- Login Button -->
            <button type="submit" 
                    class="w-full mt-6 bg-indigo-600 text-white font-bold py-3 px-4 rounded-xl hover:bg-indigo-700 transition duration-300 shadow-lg focus:outline-none focus:ring-4 focus:ring-indigo-500 focus:ring-opacity-50">
                Log In
            </button>
        </form>

        <div class="mt-6 text-center text-sm text-gray-500">
            Belum punya akun? 
            {{-- <a href="#" class="text-indigo-600 hover:text-indigo-800 font-medium">Daftar Sekarang</a> --}}
        </div>
    </div>
</body>
</html>