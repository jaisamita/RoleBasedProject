<!DOCTYPE html>
<html>
<head>
    <title>Login</title>

    <style>
        body{
            font-family: Arial;
            background: linear-gradient(135deg,#667eea,#764ba2);
            height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
        }

        .login-box{
            background:#fff;
            padding:30px;
            width:350px;
            border-radius:10px;
        }

        input,button{
            width:100%;
            padding:10px;
            margin-top:8px;
        }

        .error{ color:red;font-size:13px; }

        /* MODAL */
        .modal{
            position:fixed;
            top:0;left:0;
            width:100%;height:100%;
            background:rgba(0,0,0,.6);
            display:flex;
            align-items:center;
            justify-content:center;
        }

        .modal-box{
            background:#fff;
            padding:25px;
            width:300px;
            border-radius:8px;
        }
    </style>
</head>

<body>

<div class="login-box">
    <h2>Login</h2>

   
 @if(session('success'))
        <p style="
            background:#d4edda;color:#155724;padding:8px;  border-radius:5px; font-size:14px; margin-bottom:10px;
            text-align:center;">
            {{ session('success') }}
        </p>
    @endif
    <form method="POST" action="{{ url('/login') }}">
        @csrf

        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}">
        @error('email') <div class="error">{{ $message }}</div> @enderror

        <label>Password</label>
        <input type="password" name="password">
        @error('password') <div class="error">{{ $message }}</div> @enderror

        <button type="submit">Login</button>
        <p style="text-align:center; margin-top:10px;">
    Don't have an account?
    <a href="{{ url('/register') }}" style="color:#667eea; font-weight:bold;">
        Register
    </a>
</p>
    </form>
</div>


@if(session('showOtp'))
<div class="modal">
    <div class="modal-box">
        <h3>Verify OTP</h3>
         @if(session('success'))
            <p style="background:#d4edda;color:#155724;padding:8px;border-radius:5px;font-size:14px;margin-bottom:10px;
                text-align:center;">
                {{ session('success') }}
            </p>
        @endif
        <form method="POST" action="{{ url('/login') }}">
            @csrf

            <input type="hidden" name="email" value="{{ old('email') }}">
            <input type="hidden" name="password" value="{{ old('password') }}">

            <input type="text" name="otp" placeholder="Enter OTP" required>
            @error('otp') <div class="error">{{ $message }}</div> @enderror

            <button type="submit">Verify</button>
            
        </form>

        <form method="POST" action="{{ route('resend.otp') }}">
            @csrf
            <input type="hidden" name="email" value="{{ old('email') }}">
            <button type="submit" style="background:none;color:#667eea;border:none">
                Resend OTP
            </button>
        </form>
    </div>
</div>
@endif

</body>
</html>
