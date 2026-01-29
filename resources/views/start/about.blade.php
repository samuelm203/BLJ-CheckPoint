<x-layout>
    <div class="max-w-4xl w-full mx-auto p-8 my-12 bg-white rounded-2xl shadow-xl">
        <h1 class="text-4xl font-extrabold text-[#b05555] mb-8">Über Mich</h1>

        <div class="flex flex-col md:flex-row gap-8 items-center md:items-start">
            <div class="w-48 h-48 bg-gray-200 rounded-full flex-shrink-0 overflow-hidden shadow-inner border-4 border-[#b05555]">
                <img src="https://ui-avatars.com/api/?name=Samuel+M&background=b05555&color=fff&size=200" alt="Profile" class="w-full h-full object-cover">
            </div>

            <section class="space-y-6 text-gray-700 leading-relaxed text-lg">
                <p>
                    Hallo! Ich bin <span class="font-bold text-black">Samuel</span>, der Entwickler hinter <span class="text-[#b05555] font-bold italic underline">CheckPoint</span>.
                </p>
                <p>
                    Meine Leidenschaft gilt der Entwicklung von Tools, die den Lernprozess effizienter und transparenter gestalten. CheckPoint wurde mit dem Ziel entwickelt, Coaches und Lernenden eine einfache Plattform zur Verwaltung von Aufgaben und Modulen zu bieten.
                </p>
                <p>
                    Mit Laravel und modernen Webtechnologien wie Tailwind CSS versuche ich, Software zu bauen, die nicht nur funktional ist, sondern auch Spaß bei der Benutzung macht.
                </p>

                <div class="pt-6 border-t border-gray-100 flex gap-4">
                    <a href="https://github.com/samuelm203" target="_blank" class="bg-gray-800 text-white px-6 py-2 rounded-full font-bold hover:bg-black transition-colors shadow-md">GitHub</a>
                    <a href="{{ route('contact') }}" class="bg-[#b05555] text-white px-6 py-2 rounded-full font-bold hover:bg-[#a04444] transition-colors shadow-md">Kontaktieren</a>
                </div>
            </section>
        </div>
    </div>
</x-layout>


