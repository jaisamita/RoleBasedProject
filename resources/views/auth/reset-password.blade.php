<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
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
    </style>
</head>
<body>

<div class="box">
    @if(session('success'))
    <div style="
        background:#d4edda;
        color:#155724;
        padding:8px;
        border-radius:5px;
        margin-bottom:10px;
        text-align:center;">
        {{ session('success') }}
    </div>
@endif

    <h2>Reset Password</h2>

    <form method="POST" action="{{ route('forgot.reset.password') }}">
        @csrf

        <label>New Password</label>
        <input type="password" name="password">
        @error('password')
            <div class="error">{{ $message }}</div>
        @enderror

        <label>Confirm Password</label>
        <input type="password" name="password_confirmation">

        <button type="submit">Reset Password</button>
    </form>
</div>

</body>
</html>
