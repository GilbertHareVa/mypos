<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SeashellKitchen</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#fdf8f0] h-screen flex items-center justify-center p-4">
    
    <div class="flex w-full max-w-4xl bg-white shadow-xl rounded-2xl overflow-hidden">
        <!-- Panel Kiri (Dekoratif) -->
        <div class="hidden md:flex flex-col justify-center items-center w-1/2 bg-[#5c3d1e] text-[#f5deb3] p-10">
            <h2 class="text-4xl font-bold mb-4">SeashellKitchen</h2>
            <p class="text-center mb-6 text-sm">Sistem Kasir & Inventaris Cerdas untuk Cafe Anda.</p>
            <div class="text-8xl">☕</div>
        </div>

        <!-- Panel Kanan (Form) -->
        <div class="w-full md:w-1/2 p-10 flex flex-col justify-center">
            <h3 class="text-2xl font-semibold mb-6 text-gray-800">Masuk ke Akun</h3>
            
            @if($errors->any())
                <div class="bg-red-100 text-red-600 p-3 rounded mb-4 text-sm font-medium">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('auth.authenticate') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" id="email" name="email" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-[#5c3d1e] focus:ring-1 focus:ring-[#5c3d1e]" required value="{{ old('email') }}">
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" id="password" name="password" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-[#5c3d1e] focus:ring-1 focus:ring-[#5c3d1e]" required>
                </div>
                
                <button type="submit" class="w-full bg-[#5c3d1e] text-white font-semibold py-2.5 rounded hover:bg-[#4a3118] transition duration-200">Login</button>
            </form>

            <!-- Quick Login -->
            <div class="mt-8 border-t border-gray-200 pt-6">
                <p class="text-xs text-gray-500 mb-3 text-center">Quick Login (Testing)</p>
                <div class="flex gap-2">
                    <button onclick="fillAndSubmit('admin@SeashellKitchen.com', 'password')" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm py-2 rounded font-medium transition">👑 Admin</button>
                    <button onclick="fillAndSubmit('kasir@SeashellKitchen.com', 'password')" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm py-2 rounded font-medium transition">🧑‍💼 Kasir</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function fillAndSubmit(email, password) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;
        }
    </script>
</body>
</html>