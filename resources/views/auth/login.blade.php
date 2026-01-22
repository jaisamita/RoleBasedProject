<!DOCTYPE html>
<html>
<head>
    <title>Login</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: linear-gradient(135deg, #667eea, #764ba2);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-box {
            background: #ffffff;
            padding: 30px;
            width: 350px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .login-box h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        label {
            font-weight: bold;
            color: #555;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .error {
            color: red;
            font-size: 13px;
            margin-bottom: 10px;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #667eea;
            border: none;
            color: #fff;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background: #5a67d8;
        }

        .register-link {
            text-align: center;
            margin-top: 15px;
        }

        .register-link a {
            text-decoration: none;
            color: #667eea;
            font-weight: bold;
        }
    </style>
</head>

<body>

<div class="login-box">
    <h2>Login</h2>
@if (session('success'))
    <div style="background:green;
        color:white;
        padding:10px;
        border-radius:5px;
        margin-bottom:15px;
        text-align:center;">
        {{ session('success') }}

    </div>
@endif
    <form method="POST" action="{{ url('/login') }}">
        @csrf

        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}">
        @error('email')
            <div class="error">{{ $message }}</div>
        @enderror

        <label>Password</label>
        <input type="password" name="password">
        @error('password')
            <div class="error">{{ $message }}</div>
        @enderror

        <button type="submit">Login</button>
    </form>

    <div class="register-link">
        Don’t have an account?
        <a href="{{ url('/register') }}">Register</a>
    </div>
</div>
@if ($errors->any())
<script>
    window.onload = function () {
        let msg = "";
        @foreach ($errors->all() as $error)
            msg += "- {{ $error }}\n";
        @endforeach
        //alert(msg);
    };
</script>



@endif
</body>
</html>
