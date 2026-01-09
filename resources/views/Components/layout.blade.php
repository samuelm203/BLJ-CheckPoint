<!DOCTYPE html>
<html lang="de" class="h-full">
<head>
    <link rel="icon" type="image/png" href="{{ asset('CheckPoint_Logo.png') }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CheckPoint</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-full flex flex-col bg-[#d9d9d9]">

<header class="bg-[#b05555] w-full">
    <nav class="mx-auto max-w-7xl flex items-center justify-between p-6">
        <div>
            <img src="/CheckPoint_Logo.png" alt="Logo" class="h-8 w-auto">
        </div>

        <div class="flex font-semibold gap-x-6 items-center">
            @auth
                @if(auth()->user()->role == 1)
                    @if(!request()->routeIs('student.dashboard'))
                        <a href="{{ route('student.dashboard') }}" class="text-white hover:text-gray-300">Dashboard</a>
                    @endif
                @else
                    @if(!request()->routeIs('supervisor.dashboard'))
                        <a href="{{ route('supervisor.dashboard') }}" class="text-white hover:text-gray-300">Dashboard</a>
                    @endif
                @endif
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-white hover:text-gray-300">Logout</button>
                </form>
            @else
                @if(!request()->routeIs('home'))
                    <a href="/" class="text-white hover:text-gray-300">Login</a>
                @endif
                @if(!request()->routeIs('contact'))
                    <a href="/contact" class="text-white hover:text-gray-300">Kontakt</a>
                @endif
                @if(!request()->routeIs('about'))
                    <a href="/about" class="text-white hover:text-gray-300">Über Mich</a>
                @endif
            @endauth
        </div>

        <div>
            <a href="https://github.com/samuelm203/BLJ-CheckPoint" class="text-base font-semibold text-white">GitHub</a>
        </div>
    </nav>
</header>

<main class="flex-grow flex justify-center">
    {{ $slot }}
</main>

</body>
</html>
