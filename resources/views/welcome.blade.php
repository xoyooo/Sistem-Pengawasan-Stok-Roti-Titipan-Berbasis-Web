<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oen Akbar Bakery</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="relative min-h-screen bg-cover bg-center" style="background-image: url('{{ asset('asset/roti.jpg') }}');">
    <div class="absolute inset-0 bg-gray-900 bg-opacity-50 flex flex-col justify-between">
        <!-- Header -->
        <div class="flex justify-between items-center p-4 sm:p-6">
            <h1 class="text-white text-base sm:text-lg font-semibold">Toko Roti Akbar</h1>
            <a href="{{ route('login') }}"
                class="bg-[#fde047] text-black-700 text-sm sm:text-base px-3 sm:px-4 py-1.5 sm:py-2 rounded-lg shadow hover:bg-[#e4b20d] transition">
                Login
            </a>
        </div>

        <!-- Hero text -->
        <div class="text-center text-white mb-10 px-4">
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-3">Selamat Datang di Oen Akbar Bakery</h2>
            <p class="text-sm sm:text-base">Tempat di mana cita rasa dan kualitas berpadu sempurna</p>
        </div>
    </div>
</body>

</html>