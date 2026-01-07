<!DOCTYPE html>
<html lang="de" class="h-full">
<head>
    <meta charset="utf-8">
    <title>CheckPoint</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<header class="bg-gray-900">
    <nav class="mx-auto max-w-7xl flex items-center justify-between p-6">

        <!-- Logo -->
        <div>
            <img src="/CheckPoint_Logo.png" alt="Logo" class="h-8 w-auto">
        </div>

        <!-- Desktop Navigation -->
        <div class="flex gap-x-6 items-center">
            <x-nav-link href="/" :active="request()->is('/')">Home</x-nav-link>
            <x-nav-link href="/contact" :active="request()->is('contact')">Kontakt</x-nav-link>
            <x-nav-link href="/about" :active="request()->is('about')">Über Mich</x-nav-link>
        </div>

        <!-- Login -->
        <div>
            <a href="#" class="text-base font-semibold text-white">
                Login
            </a>
        </div>
    </nav>
</header>

</body>
</html>
