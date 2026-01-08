<div class="max-w-7xl mx-auto p-8">
    <h1 class="text-3xl font-bold mb-8 text-gray-900">
        Willkommen zurück {{ $user->first_name }} {{ $user->surname }}
    </h1>

    <div class="mb-12">
        <h2 class="text-xl font-semibold mb-4 text-gray-800">Meine Kurse</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
            @foreach($alleModule as $module)
                <div class="flex flex-col items-center group">
                    <div class="w-full aspect-square bg-[#b05555] rounded-2xl shadow-sm flex items-center justify-center text-white p-4 text-center font-semibold transition-transform group-hover:scale-105">
                        {{ $module->name }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div>
        <h2 class="text-xl font-semibold mb-4 text-gray-800">Abgeschlossene Kurse</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
            @forelse($abgeschlosseneModule as $module)
                <div class="flex flex-col items-center opacity-60">
                    <div class="w-full aspect-square bg-[#b05555] rounded-2xl shadow-sm flex items-center justify-center text-white p-4 text-center font-semibold">
                        {{ $module->name }}
                    </div>
                </div>
            @empty
                <p class="text-gray-500 italic">Noch keine Kurse abgeschlossen.</p>
            @endforelse
        </div>
    </div>
</div>
