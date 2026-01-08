<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Modul Übersicht</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f7f6; padding: 40px; }
        .container { max-width: 800px; margin: auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        h1 { color: #2d3748; }
        .module-card { border-left: 5px solid #3490dc; background: #fff; margin-bottom: 20px; padding: 15px; border: 1px solid #e2e8f0; border-radius: 8px; }
        .task-list { list-style: none; padding: 0; }
        .task-item { background: #edf2f7; margin: 5px 0; padding: 8px; border-radius: 4px; }
    </style>
</head>
<body>
<div class="container">
    <h1>📚 Deine Lernmodule</h1>
    <p>Hier sind deine aktuellen Fortschritte aus der Datenbank:</p>
    <hr>

    @foreach($modules as $module)
        <div class="module-card">
            <h2>{{ $module->module_name }}</h2>
            <p>{{ $module->description }}</p>

            <strong>Aufgaben:</strong>
            <ul class="task-list">
                @foreach($module->tasks as $task)
                    <li class="task-item">✅ {{ $task->title }}</li>
                @endforeach
            </ul>
        </div>
    @endforeach

    <a href="{{ url('/') }}">Zurück zur Startseite</a>
</div>
</body>
</html>
