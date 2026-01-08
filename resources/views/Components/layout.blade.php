<!DOCTYPE html>
<html lang="de" class="h-full">
<head>
    <link rel="icon" type="image/png" href="{{ asset('CheckPoint_Logo.png') }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CheckPoint</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-full flex flex-col bg-gray-100">

<header class="bg-[#b05555] w-full">
    <nav class="mx-auto max-w-7xl flex items-center justify-between p-6">
        <div>
            <img src="/CheckPoint_Logo.png" alt="Logo" class="h-8 w-auto">
        </div>

        <div class="flex font-semibold gap-x-6 items-center">
            <a href="/" class="text-white hover:text-gray-300">Login</a>
            <a href="/contact" class="text-white hover:text-gray-300">Kontakt</a>
            <a href="/about" class="text-white hover:text-gray-300">Über Mich</a>
        </div>

        <div>
            <a href="https://github.com/samuelm203/BLJ-CheckPoint" class="text-base font-semibold text-white">GitHub</a>
        </div>
    </nav>
</header>

<main class="flex-grow flex justify-center items-center">
    {{ $slot }}
</main>

</body>
</html>
