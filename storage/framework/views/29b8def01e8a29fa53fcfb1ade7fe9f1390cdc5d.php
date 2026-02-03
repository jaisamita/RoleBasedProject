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

<?php if(session('success')): ?>
    <div style=" background:#d4edda; color:#155724; padding:8px; border-radius:5px; margin-bottom:10px; text-align:center; font-size:14px;">
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>

    <form method="POST" action="<?php echo e(route('forgot.send.otp')); ?>">
        <?php echo csrf_field(); ?>
        <label>Email</label>
        <input type="email" name="email" required>
        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        <button type="submit">Send OTP</button>
    </form>
</div>

<?php if(session('showOtp')): ?>
<div class="modal">
    <div class="modal-box">
        <h3>Verify OTP</h3>

        <form method="POST" action="<?php echo e(route('forgot.verify.otp')); ?>">
            <?php echo csrf_field(); ?>
            <input type="text" name="otp" placeholder="Enter OTP" required>
            <?php $__errorArgs = ['otp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            <button type="submit">Verify OTP</button>


        </form>
        <form method="POST" action="<?php echo e(route('resend.otp')); ?>">
            <?php echo csrf_field(); ?>
            <button type="submit"
                style="margin-top:10px;background:none;border:none;color:#667eea;">
                Resend OTP
            </button>
        </form>
    </div>
</div>
<?php endif; ?>

</body>
</html>
<?php /**PATH F:\spirehubtask\resources\views/auth/forget.blade.php ENDPATH**/ ?>