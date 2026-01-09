<x-layout>
    <div class="flex flex-col items-center justify-center text-center flex-grow px-4">
        <div class="max-w-3xl">
            <h1 class="text-7xl md:text-8xl font-extrabold tracking-tighter text-black mb-2">
                CheckPoint
            </h1>
            <p class="text-2xl md:text-3xl font-bold text-black mb-6">
                Die Plattform für deine Ausbildung
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('student.login') }}" class="inline-block bg-[#b05555] hover:bg-[#9a4a4a] text-black font-semibold py-3 px-12 rounded-full text-xl transition transform hover:-translate-y-1 active:translate-y-0 min-w-[230px] text-center">
                    Lernender
                </a>
                <a href="{{ route('supervisor.login') }}" class="inline-block bg-[#b05555] hover:bg-[#9a4a4a] text-black font-semibold py-3 px-12 rounded-full text-xl transition transform hover:-translate-y-1 active:translate-y-0 min-w-[230px] text-center">
                    Coach
                </a>
            </div>
        </div>
    </div>
</x-layout>
