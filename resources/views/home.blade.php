<x-layout>
    <style>

        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #e0e0e0;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .hero-section {
            max-width: 800px;
        }

        h1 {
            font-size: 80px;
            font-weight: 800;
            margin-bottom: -30px;
            margin-left: -55px;
            color: #000;
            letter-spacing: -2px;
        }

        p {
            font-size: 28px;
            font-weight: 700;
            margin: 10px 0 40px 0;
            color: #000;
        }

        .button-group {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: -30px;
        }

        .btn {
            display: inline-block;
            background-color: #b05555;
            color: black;
            text-decoration: none;
            padding: 13px 45px;
            font-size: 20px;
            font-weight: 600;
            border-radius: 50px;
            transition: transform 0.2s, background-color 0.2s;
            min-width: 230px;
        }

        .btn:hover {
            background-color: #9a4a4a;
            transform: translateY(-3px);
        }

        .btn:active {
            transform: translateY(0);
        }
    </style>

    <div class="hero-section">
        <h1>CheckPoint</h1>
        <p>Die Plattform für deine Ausbildung</p>

        <div class="button-group">
            <a href="{{ route('student.login') }}" class="btn">Lernender</a>
            <a href="{{ route('supervisor.login') }}" class="btn">Coach</a>
        </div>
    </div>
</x-layout>
