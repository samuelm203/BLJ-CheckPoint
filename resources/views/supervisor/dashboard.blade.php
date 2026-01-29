<x-layout>
    <div class="w-full max-w-7xl mx-auto mb-12 p-8 self-start">
        <h1 class="text-4xl font-bold mb-12 text-black">
            Willkommen zurück {{ $user->first_name }}
        </h1>

        <div class="mb-12">
            <h2 class="text-2xl font-bold mb-6 text-black">Kurse deiner Lernenden</h2>
            <div class="flex flex-wrap gap-6 items-center">
                @foreach($aktiveModule as $module)
                    <div class="relative group">
                        <a href="{{ route('supervisor.modules.show', $module) }}" class="w-32 h-32 bg-[#b05555] rounded-xl shadow-sm flex flex-col items-center justify-center text-white p-2 text-center transition-transform hover:scale-105 cursor-pointer">
                            <span class="font-semibold text-sm">{{ $module->module_name }}</span>
                            <span class="text-[10px] mt-2 bg-white/20 px-2 py-0.5 rounded-full">
                                {{ $module->assigned_students_count }} Lernende
                            </span>
                        </a>
                        <button onclick="openAddTaskModal('{{ $module->module_id }}', '{{ $module->module_name }}')" class="absolute -top-2 -right-2 bg-white text-[#b05555] rounded-full w-8 h-8 flex items-center justify-center shadow-md border border-[#b05555] opacity-0 group-hover:opacity-100 transition-opacity hover:scale-110">
                            <span class="text-xl font-bold">+</span>
                        </button>
                    </div>
                @endforeach

                <button onclick="document.getElementById('add-module-modal').classList.remove('hidden')" class="w-32 h-32 bg-white/50 border-4 border-dashed border-[#b05555] rounded-xl shadow-sm flex items-center justify-center text-[#b05555] text-5xl font-bold transition-transform hover:scale-105 cursor-pointer group" title="Neuen Kurs erstellen"><span class="group-hover:scale-110 transition-transform">+</span>
                </button>

                @if($aktiveModule->isEmpty())
                    <p class="text-gray-600">Es sind noch keine aktiven Kurse vorhanden. Erstelle deinen ersten Kurs!</p>
                @endif
            </div>
        </div>

        <div class="mb-12">
            <h2 class="text-2xl font-bold mb-6 text-black">Abgeschlossene Kurse</h2>
            <div class="flex flex-wrap gap-6 items-center">
                @forelse($abgeschlosseneModule as $module)
                    <a href="{{ route('supervisor.modules.show', $module) }}" class="w-32 h-32 bg-gray-400 rounded-xl shadow-sm flex flex-col items-center justify-center text-white p-2 text-center transition-transform hover:scale-105 cursor-pointer grayscale hover:grayscale-0">
                        <span class="font-semibold text-sm">{{ $module->module_name }}</span>
                        <span class="text-[10px] mt-2 bg-white/20 px-2 py-0.5 rounded-full">
                            {{ $module->assigned_students_count }} Lernende
                        </span>
                    </a>
                @empty
                    <p class="text-gray-600">Momentan keine abgeschlossenen Kurse vorhanden.</p>
                @endforelse
            </div>
        </div>

        <div>
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-black">Meine Lernende</h2>
                <button onclick="document.getElementById('add-student-modal').classList.remove('hidden')" class="bg-[#b05555] text-white px-4 py-2 rounded-lg font-bold hover:bg-[#a04444] transition-colors">
                    + Lernende/r hinzufügen
                </button>
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

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($lernende as $student)
                    @php
                        $aktiveZugeordneteModule = $student->assignedModules->where('is_completed', false);
                        $totalTasks = $aktiveZugeordneteModule->flatMap->tasks->count();
                        $completedTasks = $student->tasks()
                            ->whereHas('module', function($query) {
                                $query->where('is_completed', false);
                            })
                            ->count();
                        $percentage = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;
                    @endphp
                    <div class="bg-white p-6 rounded-xl shadow-sm border-l-8 border-[#b05555] flex flex-col gap-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-xl font-bold text-black">{{ $student->first_name }} {{ $student->surname }}</p>
                                <p class="text-sm text-gray-500">{{ $student->email }}</p>
                            </div>
                            <div class="flex gap-2">
                                <button onclick="openEditStudentModal({{ json_encode($student) }})" class="text-gray-400 hover:text-[#b05555] transition-colors" title="Bearbeiten">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                </button>
                                <form action="{{ route('supervisor.students.destroy', $student) }}" method="POST" onsubmit="return confirm('Möchten Sie diesen Lernenden wirklich löschen?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-400 hover:text-red-600 transition-colors" title="Löschen">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div class="mt-2">
                            <div class="flex justify-between text-xs font-semibold mb-1 text-gray-400">
                                <span>Aktive Aufgaben</span>
                                <span title="Nur Aufgaben aus nicht abgeschlossenen Kursen">{{ $completedTasks }} / {{ $totalTasks }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-600">Du hast noch keine Lernenden zugewiesen.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Modal für neuen Kurs -->
    <div id="add-module-modal" class="{{ $errors->has('module_name') ? '' : 'hidden' }} fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-[#b05555] p-8 rounded-2xl shadow-xl w-full max-w-2xl relative">
            <button onclick="document.getElementById('add-module-modal').classList.add('hidden')" class="absolute top-4 right-4 text-white text-2xl font-bold">
                ✕
            </button>
            <h3 class="text-2xl font-bold mb-6 text-white">Kurs erstellen</h3>
            <form action="{{ route('supervisor.modules.store') }}" method="POST">
                @csrf
                <div class="space-y-6 max-h-[70vh] overflow-y-auto pr-2">
                    <div class="bg-white/20 p-4 rounded-xl">
                        <input type="text" name="module_name" placeholder="Kursname" required class="w-full bg-transparent border-b-2 border-white text-white placeholder-white/70 focus:outline-none py-2 text-xl font-semibold">
                    </div>
                    <div class="bg-white/20 p-4 rounded-xl">
                        <textarea name="description" placeholder="Beschreibung (Optional)" rows="2" class="w-full bg-transparent border-b-2 border-white text-white placeholder-white/70 focus:outline-none py-2"></textarea>
                    </div>

                    <div class="bg-white/20 p-4 rounded-xl">
                        <h4 class="text-white font-bold mb-4">Aufgaben hinzufügen</h4>
                        <div id="tasks-container" class="space-y-2">
                            <div class="flex gap-2">
                                <input type="text" name="tasks[]" placeholder="Aufgabentitel" class="w-full bg-transparent border-b border-white text-white placeholder-white/70 focus:outline-none py-1">
                                <button type="button" onclick="addTaskField()" class="text-white font-bold text-xl">+</button>
                                <button type="button" onclick="this.parentElement.querySelector('input').value = ''" class="text-white font-bold text-xl" title="Feld leeren">✕</button>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white/20 p-4 rounded-xl">
                        <h4 class="text-white font-bold mb-4">Lernende zuweisen</h4>
                        <div class="grid grid-cols-2 gap-2">
                            @foreach($lernende as $student)
                                <label class="flex items-center text-white gap-2 cursor-pointer">
                                    <input type="checkbox" name="students[]" value="{{ $student->id }}" class="rounded border-white text-[#b05555] focus:ring-white">
                                    <span class="text-sm truncate">{{ $student->first_name }} {{ $student->surname }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="mt-8 flex justify-center gap-4">
                    <button type="submit" class="bg-white text-[#b05555] px-12 py-3 rounded-xl font-bold hover:bg-white/90 transition-colors text-lg">
                        Speichern
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal für neuen Lernenden -->
    <div id="add-student-modal" class="{{ $errors->any() && !$errors->has('module_name') && !$errors->has('title') && !session('is_editing') ? '' : 'hidden' }} fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md">
            <h3 class="text-2xl font-bold mb-6">Neuen Lernenden anlegen</h3>
            <form action="{{ route('supervisor.students.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Vorname</label>
                        <input type="text" name="first_name" required value="{{ old('first_name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#b05555] focus:ring-[#b05555]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nachname</label>
                        <input type="text" name="surname" required value="{{ old('surname') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#b05555] focus:ring-[#b05555]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">E-Mail</label>
                        <input type="email" name="email" required value="{{ old('email') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#b05555] focus:ring-[#b05555]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Passwort</label>
                        <input type="password" name="password" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#b05555] focus:ring-[#b05555]">
                    </div>
                </div>
                <div class="mt-8 flex justify-end gap-4">
                    <button type="button" onclick="document.getElementById('add-student-modal').classList.add('hidden')" class="px-4 py-2 text-gray-600 hover:text-gray-800">
                        Abbrechen
                    </button>
                    <button type="submit" class="bg-[#b05555] text-white px-6 py-2 rounded-lg font-bold hover:bg-[#a04444] transition-colors">
                        Speichern
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal für Lernenden bearbeiten -->
    <div id="edit-student-modal" class="{{ session('is_editing') ? '' : 'hidden' }} fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md">
            <h3 class="text-2xl font-bold mb-6">Lernenden bearbeiten</h3>
            <form id="edit-student-form" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Vorname</label>
                        <input type="text" name="first_name" id="edit_first_name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#b05555] focus:ring-[#b05555]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nachname</label>
                        <input type="text" name="surname" id="edit_surname" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#b05555] focus:ring-[#b05555]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">E-Mail</label>
                        <input type="email" name="email" id="edit_email" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#b05555] focus:ring-[#b05555]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Passwort (leer lassen für keine Änderung)</label>
                        <input type="password" name="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#b05555] focus:ring-[#b05555]">
                    </div>
                </div>
                <div class="mt-8 flex justify-end gap-4">
                    <button type="button" onclick="document.getElementById('edit-student-modal').classList.add('hidden')" class="px-4 py-2 text-gray-600 hover:text-gray-800">
                        Abbrechen
                    </button>
                    <button type="submit" class="bg-[#b05555] text-white px-6 py-2 rounded-lg font-bold hover:bg-[#a04444] transition-colors">
                        Aktualisieren
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal für neue Aufgabe -->
    <div id="add-task-modal" class="{{ $errors->has('title') ? '' : 'hidden' }} fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md">
            <h3 class="text-2xl font-bold mb-2">Aufgabe hinzufügen</h3>
            <p id="task-modal-module-name" class="text-gray-600 mb-6 font-semibold"></p>
            <form action="{{ route('supervisor.tasks.store') }}" method="POST">
                @csrf
                <input type="hidden" name="module_id" id="task-module-id" value="{{ old('module_id') }}">
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
        function openEditStudentModal(student) {
            document.getElementById('edit-student-form').action = '/supervisor/students/' + student.id;
            document.getElementById('edit_first_name').value = student.first_name;
            document.getElementById('edit_surname').value = student.surname;
            document.getElementById('edit_email').value = student.email;
            document.getElementById('edit-student-modal').classList.remove('hidden');
        }

        function openAddTaskModal(moduleId, moduleName) {
            document.getElementById('task-module-id').value = moduleId;
            document.getElementById('task-modal-module-name').innerText = 'Kurs: ' + moduleName;
            document.getElementById('add-task-modal').classList.remove('hidden');
        }

        function addTaskField() {
            const container = document.getElementById('tasks-container');
            const div = document.createElement('div');
            div.className = 'flex gap-2';
            div.innerHTML = `
                <input type="text" name="tasks[]" placeholder="Aufgabentitel" class="w-full bg-transparent border-b border-white text-white placeholder-white/70 focus:outline-none py-1">
                <button type="button" onclick="addTaskField()" class="text-white font-bold text-xl">+</button>
                <button type="button" onclick="this.parentElement.remove()" class="text-white font-bold text-xl" title="Feld entfernen">✕</button>
            `;
            container.appendChild(div);
        }
    </script>
</x-layout>
