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

<?php if(session('success')): ?>
    <div id="logout-success" style="
        background:green;
        color:white;
        padding:10px;
        border-radius:5px;
        margin-bottom:15px;
        text-align:center;">
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>

    <form method="POST" action="<?php echo e(url('/login')); ?>">
        <?php echo csrf_field(); ?>

        <label>Email</label>
        <input type="email" name="email" value="<?php echo e(old('email')); ?>">
        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="error"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        <label>Password</label>
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

        <button type="submit">Login</button>
    </form>

    <div class="register-link">
        Don’t have an account?
        <a href="<?php echo e(url('/register')); ?>">Register</a>
    </div>
</div>
<?php if($errors->any()): ?>
<script>
    window.onload = function () {
        let msg = "";
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            msg += "- <?php echo e($error); ?>\n";
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    };
</script>

<?php endif; ?>

<script>
    setTimeout(function () {
        let msg = document.getElementById('logout-success');
        if (msg) {
            msg.style.transition = "opacity 0.5s ease";
            msg.style.opacity = "0";
            setTimeout(() => msg.remove(), 500); 
        }
    }, 500);
</script>
</body>
</html>
<?php /**PATH F:\spirehubtask\resources\views/auth/login.blade.php ENDPATH**/ ?>