<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Anmeldung & Registrierung</title>
    <style>

        body {
            background-color: #ccc;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }


        .auth-container {
            display: flex;
            width: 800px;
            height: 500px;
            background: #e0e0e0;
            border-radius: 40px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        }

        .section {
            width: 50%;
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            box-sizing: border-box;
        }

        .sign-up {
            background: #e0e0e0;
        }

        .login {
            background: #b05555;
            color: white;
            border-bottom-left-radius: 70px;
            padding-left: 80px;
        }

        h2 {
            font-size: 32px;
            margin-bottom: 25px;
            font-weight: bold;
        }

        .sign-up h2 { color: #000; }
        .login h2 { color: #000000; }


        input {
            width: 100%;
            padding: 14px 18px;
            margin: 10px 0;
            border: 1px solid #bbb;
            border-radius: 12px;
            box-sizing: border-box;
            font-size: 16px;
            background-color: #fff;
            outline: none;
        }

        .login input {
            border: none;
        }

        input::placeholder {
            color: #999;
        }


        .btn {
            width: 100%;
            padding: 14px;
            border-radius: 50px;
            border: none;
            cursor: pointer;
            margin-top: 15px;
            font-weight: bold;
            font-size: 18px;
            transition: all 0.2s ease;
        }

        .btn-signup {
            background: #fff;
            color: #000;
        }

        .btn-signup:hover {
            background: #f0f0f0;
        }

        .btn-login {
            background: #fff;
            color: #333;
        }

        .btn-login:hover {
            background: #d0d0d0;
        }
    </style>
</head>
<body>

<div class="auth-container">
    <div class="section sign-up">
        <h2>Sign in</h2>
        <form action="{{ route('register') }}" method="POST">
            @csrf
            <input type="text" name="first_name" placeholder="First Name" required>
            <input type="text" name="surname" placeholder="Surname" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" class="btn btn-signup">Sign up</button>
        </form>
    </div>

    <div class="section login">
        <h2>Login</h2>
        <form action="{{ url('/login') }}" method="POST">
            @csrf
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" class="btn btn-login">Login</button>
        </form>
    </div>
</div>

</body>
</html>
