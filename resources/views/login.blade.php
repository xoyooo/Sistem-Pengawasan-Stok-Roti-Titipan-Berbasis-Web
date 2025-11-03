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
<div class="bg-white w-full max-w-2xl rounded-2xl shadow-lg flex flex-col md:flex-row overflow-hidden">
    <!-- Left Side -->
    <div class="bg-gradient-to-r from-green-700 to-green-500 md:w-1/2 w-full flex flex-col justify-center items-center text-white p-6">
        <h2 class="text-2xl font-bold mb-2 text-center">Selamat datang!</h2>
        <p class="text-sm text-center">
            Bersama kita, pengelolaan toko di Oen Akbar Bakery semakin mudah dan profesional
        </p>
    </div>

    <!-- Right Side -->
    <div class="w-full md:w-1/2 flex flex-col justify-center px-6 py-8">
        <h2 class="text-green-700 text-xl font-bold mb-6 text-center">LOGIN</h2>

        <!-- Pesan error -->
        @if ($errors->has('loginError'))
            <div class="bg-red-100 text-red-700 p-2 rounded mb-3 text-center">
                {{ $errors->first('loginError') }}
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
            @csrf
            <input type="text" name="username" placeholder="Username" 
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-400" required>
            
            <input type="password" name="password" placeholder="Password" 
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-400" required>
            
            <button type="submit" 
                class="bg-green-600 text-white w-full py-2 rounded-lg hover:bg-green-700 transition">
                Login
            </button>
        </form>
    </div>
</div>

</body>
</html>
