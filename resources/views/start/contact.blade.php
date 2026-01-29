<x-layout>
    <div class="max-w-4xl w-full mx-auto p-8 my-12 bg-white rounded-2xl shadow-xl">
        <h1 class="text-4xl font-extrabold text-[#b05555] mb-8">Kontakt</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <section class="space-y-6">
                <p class="text-gray-700 text-lg">
                    Haben Sie Fragen zu <span class="text-[#b05555] font-bold">CheckPoint</span> oder möchten Sie Feedback geben? Ich freue mich von Ihnen zu hören!
                </p>

                <div class="space-y-4">
                    <div class="flex items-center gap-4 text-gray-700">
                        <div class="w-10 h-10 bg-[#b05555]/10 rounded-full flex items-center justify-center text-[#b05555]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <span class="text-lg">samuel@example.com</span>
                    </div>

                    <div class="flex items-center gap-4 text-gray-700">
                        <div class="w-10 h-10 bg-[#b05555]/10 rounded-full flex items-center justify-center text-[#b05555]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <span class="text-lg">Musterstadt, Deutschland</span>
                    </div>
                </div>
            </section>

            <form action="#" method="POST" class="space-y-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Name</label>
                    <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#b05555] focus:border-transparent outline-none transition-all" placeholder="Ihr Name">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">E-Mail</label>
                    <input type="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#b05555] focus:border-transparent outline-none transition-all" placeholder="ihre@email.de">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Nachricht</label>
                    <textarea rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#b05555] focus:border-transparent outline-none transition-all" placeholder="Wie kann ich Ihnen helfen?"></textarea>
                </div>
                <button type="submit" class="w-full bg-[#b05555] text-white font-bold py-3 rounded-lg hover:bg-[#a04444] transition-colors shadow-lg">
                    Nachricht senden
                </button>
            </form>
        </div>
    </div>
</x-layout>
