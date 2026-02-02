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

   
 <?php if(session('success')): ?>
        <p style="
            background:#d4edda;color:#155724;padding:8px;  border-radius:5px; font-size:14px; margin-bottom:10px;
            text-align:center;">
            <?php echo e(session('success')); ?>

        </p>
    <?php endif; ?>
    <form method="POST" action="<?php echo e(url('/login')); ?>">
        <?php echo csrf_field(); ?>

        <label>Email</label>
        <input type="email" name="email" value="<?php echo e(old('email')); ?>">
        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        <label>Password</label>
        <input type="password" name="password">
        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        <button type="submit">Login</button>
        <p style="text-align:center; margin-top:10px;">
    Don't have an account?
    <a href="<?php echo e(url('/register')); ?>" style="color:#667eea; font-weight:bold;">
        Register
    </a>
</p>
    </form>
</div>


<?php if(session('showOtp')): ?>
<div class="modal">
    <div class="modal-box">
        <h3>Verify OTP</h3>
         <?php if(session('success')): ?>
            <p style="background:#d4edda;color:#155724;padding:8px;border-radius:5px;font-size:14px;margin-bottom:10px;
                text-align:center;">
                <?php echo e(session('success')); ?>

            </p>
        <?php endif; ?>
        <form method="POST" action="<?php echo e(url('/login')); ?>">
            <?php echo csrf_field(); ?>

            <input type="hidden" name="email" value="<?php echo e(old('email')); ?>">
            <input type="hidden" name="password" value="<?php echo e(old('password')); ?>">

            <input type="text" name="otp" placeholder="Enter OTP" required>
            <?php $__errorArgs = ['otp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

            <button type="submit">Verify</button>
            
        </form>

        <form method="POST" action="<?php echo e(route('resend.otp')); ?>">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="email" value="<?php echo e(old('email')); ?>">
            <button type="submit" style="background:none;color:#667eea;border:none">
                Resend OTP
            </button>
        </form>
    </div>
</div>
<?php endif; ?>

</body>
</html>
<?php /**PATH F:\spirehubtask\resources\views/auth/login.blade.php ENDPATH**/ ?>