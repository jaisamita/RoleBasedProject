<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <style>
        body{
            font-family: Arial;
            background: linear-gradient(135deg,#667eea,#764ba2);
            height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
        }
        .box{
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
        .error{color:red;font-size:13px;}
        .success{color:green;font-size:14px;}
        .modal{
            position:fixed; inset:0;
            background:rgba(0,0,0,.6);
            display:flex; align-items:center; justify-content:center;
        }
        .modal-box{
            background:#fff; padding:25px; width:300px; border-radius:8px;
        }
    </style>
</head>
<body>

<div class="box">
    
    <h2>Forgot Password</h2>

@if(session('success'))
    <div style=" background:#d4edda; color:#155724; padding:8px; border-radius:5px; margin-bottom:10px; text-align:center; font-size:14px;">
        {{ session('success') }}
    </div>
@endif

    <form method="POST" action="{{ route('forgot.send.otp') }}">
        @csrf
        <label>Email</label>
        <input type="email" name="email" required>
        @error('email') <div class="error">{{ $message }}</div> @enderror

        <button type="submit">Send OTP</button>
    </form>
</div>

@if(session('showOtp'))
<div class="modal">
    <div class="modal-box">
        <h3>Verify OTP</h3>

        <form method="POST" action="{{ route('forgot.verify.otp') }}">
            @csrf
            <input type="text" name="otp" placeholder="Enter OTP" required>
            @error('otp') <div class="error">{{ $message }}</div> @enderror
            <button type="submit">Verify OTP</button>


        </form>
        
    </div>
</div>
@endif

</body>
</html>
