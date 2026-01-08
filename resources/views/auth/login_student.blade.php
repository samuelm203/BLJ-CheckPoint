<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Anmeldung</title>
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
            width: 450px;
            min-height: 450px;
            background: #b05555;
            border-radius: 40px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        }

        .section {
            width: 100%;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            box-sizing: border-box;
        }

        .login {
            background: #b05555;
            color: white;
        }

        h2 {
            font-size: 32px;
            margin-bottom: 25px;
            font-weight: bold;
            color: #000;
            text-align: center;
        }

        form {
            width: 100%;
        }

        input {
            width: 100%;
            padding: 14px 18px;
            margin: 10px 0;
            border: none;
            border-radius: 12px;
            box-sizing: border-box;
            font-size: 16px;
            background-color: #fff;
            outline: none;
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
            margin-top: 20px;
            font-weight: bold;
            font-size: 18px;
            transition: all 0.2s ease;
        }

        .btn-login {
            background: #fff;
            color: #333;
        }

        .btn-login:hover {
            background: #e0e0e0;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>

<div class="auth-container">
    <div class="section login">
        <h2>Login</h2>

        <form action="{{ route('student.login.post') }}" method="POST">
            @csrf
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" class="btn btn-login">Login</button>
        </form>
    </div>
</div>

</body>
</html>
