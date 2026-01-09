<x-layout>
    <div class="w-full max-w-7xl mx-auto mb-12 p-8 self-start">
        <h1 class="text-4xl font-bold mb-12 text-black">
            Willkommen zurück {{ $user->first_name }}
        </h1>

        <div class="mb-12">
            <h2 class="text-2xl font-bold mb-6 text-black">Meine Kurse</h2>
            <div class="flex flex-wrap gap-6">
                @foreach($alleModule as $module)
                    <div class="w-32 h-32 bg-[#b05555] rounded-xl shadow-sm flex items-center justify-center text-white p-4 text-center font-semibold transition-transform hover:scale-105 cursor-pointer">
                        {{ $module->module_name }}
                    </div>
                @endforeach
            </div>
        </div>

        <div>
            <h2 class="text-2xl font-bold mb-6 text-black">Abgeschlossene Kurse</h2>
            <div class="flex flex-wrap gap-6">
                @forelse($abgeschlosseneModule as $module)
                    <div class="w-32 h-32 bg-[#b05555] rounded-xl shadow-sm flex items-center justify-center text-white p-4 text-center font-semibold transition-transform hover:scale-105 cursor-pointer">
                        {{ $module->module_name }}
                    </div>
                @empty
                    <div class="flex flex-wrap gap-6">
                        <p class="text-gray-600">Du hast noch keine Kurse abgeschlossen.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-layout>
