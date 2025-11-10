<!DOCTYPE html>

<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Oen Akbar Bakery</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex justify-center items-center min-h-screen bg-gray-100 p-4">

    <!-- Card Container -->
    <div class="bg-white w-full max-w-5xl rounded-3xl shadow-2x1 flex flex-col md:flex-row overflow-hidden">
        <!-- Left Side -->
        <div
            class="bg-gradient-to-r from-[#ca9e0e] to-[#fde047] md:w-1/2 w-full flex flex-col justify-center items-center text-white p-10">
            <h2 class="text-4xl font-bold mb-2 text-center">Selamat datang!</h2>
            <p class="text-sm text-center">
                Bersama kita, pengelolaan toko di Oen Akbar Bakery semakin mudah dan profesional
            </p>
        </div>

        <!-- Right Side -->
        <div class="w-full md:w-1/2 flex flex-col justify-center px-12 py-16">
            <h2 class="text-black text-3xl font-bold mb-10 text-center">LOGIN</h2>

            <!-- Pesan error -->
            @if ($errors->has('loginError'))
                <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-center">
                    {{ $errors->first('loginError') }}
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                @csrf
                <input type="text" name="username" placeholder="Username"
                    class="w-full border border-[#fde047] rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#fde047]"
                    required>

                <input type="password" name="password" placeholder="Password"
                    class="w-full border border-[#fde047] rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#fde047]"
                    required>

                <div class="pt-2"> <!-- tambahan jarak di atas tombol -->
                    <button type="submit"
                        class="bg-[#fde047] text-white w-full py-3 rounded-lg hover:bg-[#facc15] font-semibold text-sm sm:text-base shadow-md hover:shadow-lg transition-all duration-300">
                        Login
                    </button>
            </form>
        </div>
    </div>

</body>

</html>