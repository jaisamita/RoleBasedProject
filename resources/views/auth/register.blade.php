<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
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
        .register-box {
            background: #ffffff;
            padding: 30px;
            width: 380px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        h2 { text-align: center; margin-bottom: 20px; }
        label { font-weight: bold; }
        input {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .error {
            color: red;
            font-size: 13px;
            text-align: center;
        }
        .success {
            color: green;
            text-align: center;
            font-weight: bold;
            margin-bottom: 10px;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #667eea;
            border: none;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
        }
        .resend-btn {
            background: none;
            color: #667eea;
            border: none;
            margin-top: 10px;
            cursor: pointer;
            font-weight: bold;
        }
        .login-link {
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>

<body>
<div class="register-box">

@if(session('success'))
    <div class="success">{{ session('success') }}</div>
@endif


@if(session('showOtp'))

    <h2>Verify OTP</h2>

    <form method="POST" action="{{ route('otp.verify') }}">
        @csrf
        <input type="hidden" name="email"
               value="{{ session('email') ?? old('email') }}">

        <label>Enter OTP</label>
        <input type="text" name="otp" required>

        @error('otp')
            <div class="error">{{ $message }}</div>
        @enderror
      <br>
        <button type="submit">Verify OTP</button>
    </form>

    <form method="POST" action="{{ route('resend.otp') }}">
        @csrf
        <input type="hidden" name="email"
               value="{{ session('email') ?? old('email') }}">
        <button type="submit" class="resend-btn">Resend OTP</button>
    </form>


@else

    <h2>Register</h2>

    <form method="POST" action="{{ url('/register') }}">
        @csrf

        <label>Name</label>
        <input type="text" name="name" value="{{ old('name') }}">
        @error('name') <div class="error">{{ $message }}</div> @enderror

        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}">
        @error('email') <div class="error">{{ $message }}</div> @enderror

        <label>Password</label>
        <input type="password" name="password">
        @error('password') <div class="error">{{ $message }}</div> @enderror

        <label>Confirm Password</label>
        <input type="password" name="password_confirmation">

        <br><br>
        <button type="submit">Register</button>
    </form>

    <div class="login-link">
        Already have an account?
        <a href="{{ url('/login') }}">Login</a>
    </div>

@endif

</div>
</body>
</html>
