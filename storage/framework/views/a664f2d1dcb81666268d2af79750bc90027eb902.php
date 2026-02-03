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
    <?php if(session('success')): ?>
    <div style="
        background:#d4edda;
        color:#155724;
        padding:8px;
        border-radius:5px;
        margin-bottom:10px;
        text-align:center;">
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>

    <h2>Reset Password</h2>

    <form method="POST" action="<?php echo e(route('forgot.reset.password')); ?>">
        <?php echo csrf_field(); ?>

        <label>New Password</label>
        <input type="password" name="password">
        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="error"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        <label>Confirm Password</label>
        <input type="password" name="password_confirmation">

        <button type="submit">Reset Password</button>
    </form>
</div>

</body>
</html>
<?php /**PATH F:\spirehubtask\resources\views/auth/reset-password.blade.php ENDPATH**/ ?>