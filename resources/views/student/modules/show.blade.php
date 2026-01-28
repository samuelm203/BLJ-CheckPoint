<x-layout>
    <div class="w-full max-w-7xl mx-auto mb-12 p-8 self-start">
        <a href="{{ route('student.dashboard') }}" class="text-[#b05555] font-bold mb-8 inline-block hover:underline">
            ← Zurück zu meinen Kursen
        </a>

        <div class="bg-[#b05555] p-8 rounded-2xl shadow-sm border-l-8 border-white/30 mb-12">
            <h1 class="text-4xl font-bold mb-4 text-white">{{ $module->module_name }}</h1>
            <p class="text-white/80 text-lg">{{ $module->description ?? 'Keine Beschreibung vorhanden.' }}</p>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-[#b05555] p-6 rounded-2xl shadow-sm">
            <h2 class="text-2xl font-bold mb-6 text-white">Aufgaben</h2>

            @if($module->tasks->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($module->tasks as $task)
                        @php
                            $isCompleted = $task->users->first()?->pivot->is_completed ?? false;
                        @endphp
                        <form action="{{ route('student.tasks.toggle', $task) }}" method="POST" class="flex items-center p-3 rounded-xl border border-white/20 hover:bg-white/10 transition-colors">
                            @csrf
                            <button type="submit" class="flex items-center gap-3 w-full text-left">
                                <div class="w-6 h-6 rounded border-2 border-white flex items-center justify-center {{ $isCompleted ? 'bg-white' : 'bg-transparent' }}">
                                    @if($isCompleted)
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#b05555]" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    @endif
                                </div>
                                <span class="{{ $isCompleted ? 'line-through text-white/50' : 'text-white font-semibold' }}">
                                    {{ $task->title }}
                                </span>
                            </button>
                        </form>
                    @endforeach
                </div>
            @else
                <p class="text-white/70 italic">Noch keine Aufgaben für diesen Kurs hinterlegt.</p>
            @endif
        </div>
    </div>
</x-layout>
