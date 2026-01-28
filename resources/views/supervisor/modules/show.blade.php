<x-layout>
    <div class="w-full max-w-7xl mx-auto mb-12 p-8 self-start">
        <a href="{{ route('supervisor.dashboard') }}" class="text-[#b05555] font-bold mb-8 inline-block hover:underline">
            ← Zurück zum Dashboard
        </a>

        <div class="bg-white p-8 rounded-2xl shadow-sm border-l-8 border-[#b05555] mb-12">
            <h1 class="text-4xl font-bold mb-4 text-black">{{ $module->module_name }}</h1>
            <p class="text-gray-600 text-lg">{{ $module->description ?? 'Keine Beschreibung vorhanden.' }}</p>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Aufgaben Übersicht -->
            <div>
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-black">Aufgaben</h2>
                    <button onclick="document.getElementById('add-task-modal').classList.remove('hidden')" class="bg-[#b05555] text-white px-4 py-2 rounded-lg font-bold hover:bg-[#a04444] transition-colors">
                        + Aufgabe hinzufügen
                    </button>
                </div>
                <div class="space-y-4">
                    @forelse($module->tasks as $task)
                        <div class="bg-white p-4 rounded-xl shadow-sm flex justify-between items-center border border-gray-100">
                            <span class="font-semibold text-gray-800">{{ $task->title }}</span>
                            <div class="flex gap-2">
                                <!-- Hier könnten Bearbeiten/Löschen Buttons hin -->
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 italic">Noch keine Aufgaben für diesen Kurs hinterlegt.</p>
                    @endforelse
                </div>
            </div>

            <!-- Lernende Übersicht -->
            <div>
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-black">Zugewiesene Lernende</h2>
                    <button onclick="document.getElementById('assign-student-modal').classList.remove('hidden')" class="bg-[#b05555] text-white px-4 py-2 rounded-lg font-bold hover:bg-[#a04444] transition-colors">
                        + Lernende hinzufügen
                    </button>
                </div>
                <div class="space-y-4">
                    @forelse($module->assignedStudents as $student)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                            <div class="p-4 flex justify-between items-center bg-white">
                                <div>
                                    <p class="font-bold text-black text-lg">{{ $student->first_name }} {{ $student->surname }}</p>
                                    <p class="text-xs text-gray-500">{{ $student->email }}</p>
                                </div>
                                <div class="flex items-center gap-4">
                                    @php
                                        $studentCompletedCount = $student->tasks->where('pivot.is_completed', true)->count();
                                        $totalTasksCount = $module->tasks->count();
                                        $studentPercentage = $totalTasksCount > 0 ? round(($studentCompletedCount / $totalTasksCount) * 100) : 0;
                                    @endphp
                                    <div class="text-right">
                                        <div class="text-xs font-bold text-gray-400 mb-1">{{ $studentCompletedCount }} / {{ $totalTasksCount }} Aufgaben</div>
                                        <div class="w-24 bg-gray-200 rounded-full h-1.5">
                                            <div class="bg-[#b05555] h-1.5 rounded-full" style="width: {{ $studentPercentage }}%"></div>
                                        </div>
                                    </div>
                                    <button onclick="toggleStudentTasks('{{ $student->id }}')" class="text-[#b05555] hover:bg-[#b05555]/10 p-2 rounded-lg transition-colors">
                                        <svg id="icon-{{ $student->id }}" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Detaillierte Aufgabenliste des Lernenden -->
                            <div id="tasks-{{ $student->id }}" class="hidden bg-gray-50 border-t border-gray-100 p-4">
                                <div class="grid grid-cols-1 gap-2">
                                    @foreach($module->tasks as $task)
                                        @php
                                            $taskStatus = $student->tasks->where('task_id', $task->task_id)->first();
                                            $isTaskCompleted = $taskStatus ? $taskStatus->pivot->is_completed : false;
                                        @endphp
                                        <div class="flex items-center justify-between p-2 rounded-lg {{ $isTaskCompleted ? 'bg-green-50' : 'bg-white' }} border border-gray-200">
                                            <span class="text-sm {{ $isTaskCompleted ? 'text-green-700 font-semibold' : 'text-gray-600' }}">
                                                {{ $task->title }}
                                            </span>
                                            @if($isTaskCompleted)
                                                <span class="flex items-center text-green-600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                    </svg>
                                                    <span class="text-[10px] ml-1">{{ \Carbon\Carbon::parse($taskStatus->pivot->completion_date)->format('d.m.Y') }}</span>
                                                </span>
                                            @else
                                                <span class="text-[10px] text-gray-400 font-bold uppercase">Offen</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 italic">Noch keine Lernenden für diesen Kurs zugewiesen.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Modal für Lernende zuweisen -->
    <div id="assign-student-modal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md">
            <h3 class="text-2xl font-bold mb-2">Lernende zuweisen</h3>
            <p class="text-gray-600 mb-6 font-semibold">Kurs: {{ $module->module_name }}</p>

            @if($availableStudents->isEmpty())
                <p class="text-gray-500 mb-6 italic">Alle deine Lernenden sind bereits diesem Kurs zugewiesen.</p>
                <div class="flex justify-end">
                    <button type="button" onclick="document.getElementById('assign-student-modal').classList.add('hidden')" class="bg-gray-200 text-gray-800 px-6 py-2 rounded-lg font-bold hover:bg-gray-300 transition-colors">
                        Schließen
                    </button>
                </div>
            @else
                <form action="{{ route('supervisor.modules.assign-students', $module) }}" method="POST">
                    @csrf
                    <div class="space-y-4 max-h-[40vh] overflow-y-auto pr-2 mb-6">
                        @foreach($availableStudents as $student)
                            <label class="flex items-center gap-3 p-3 rounded-xl border border-gray-100 hover:bg-gray-50 cursor-pointer transition-colors">
                                <input type="checkbox" name="students[]" value="{{ $student->id }}" class="rounded border-gray-300 text-[#b05555] focus:ring-[#b05555]">
                                <div>
                                    <p class="font-bold text-gray-800">{{ $student->first_name }} {{ $student->surname }}</p>
                                    <p class="text-xs text-gray-500">{{ $student->email }}</p>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    <div class="flex justify-end gap-4">
                        <button type="button" onclick="document.getElementById('assign-student-modal').classList.add('hidden')" class="px-4 py-2 text-gray-600 hover:text-gray-800">
                            Abbrechen
                        </button>
                        <button type="submit" class="bg-[#b05555] text-white px-6 py-2 rounded-lg font-bold hover:bg-[#a04444] transition-colors">
                            Zuweisen
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>

    <!-- Modal für neue Aufgabe (Wiederverwendet vom Dashboard, aber angepasst) -->
    <div id="add-task-modal" class="{{ $errors->has('title') ? '' : 'hidden' }} fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md">
            <h3 class="text-2xl font-bold mb-2">Aufgabe hinzufügen</h3>
            <p class="text-gray-600 mb-6 font-semibold">Kurs: {{ $module->module_name }}</p>
            <form action="{{ route('supervisor.tasks.store') }}" method="POST">
                @csrf
                <input type="hidden" name="module_id" value="{{ $module->module_id }}">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Aufgabentitel</label>
                        <input type="text" name="title" required value="{{ old('title') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#b05555] focus:ring-[#b05555]">
                    </div>
                </div>
                <div class="mt-8 flex justify-end gap-4">
                    <button type="button" onclick="document.getElementById('add-task-modal').classList.add('hidden')" class="px-4 py-2 text-gray-600 hover:text-gray-800">
                        Abbrechen
                    </button>
                    <button type="submit" class="bg-[#b05555] text-white px-6 py-2 rounded-lg font-bold hover:bg-[#a04444] transition-colors">
                        Speichern
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleStudentTasks(studentId) {
            const container = document.getElementById('tasks-' + studentId);
            const icon = document.getElementById('icon-' + studentId);

            if (container.classList.contains('hidden')) {
                container.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
            } else {
                container.classList.add('hidden');
                icon.style.transform = 'rotate(0deg)';
            }
        }
    </script>
</x-layout>
