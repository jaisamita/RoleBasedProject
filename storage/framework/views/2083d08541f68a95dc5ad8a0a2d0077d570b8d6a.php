
<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg,#667eea,#764ba2);
            height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
        }

        .card {
            background:#fff;
            padding:30px;
            width:360px;
            border-radius:12px;
            box-shadow:0 10px 25px rgba(0,0,0,.15);
            animation: fadeIn .4s ease;
        }

        h3 {
            text-align:center;
            margin-bottom:20px;
            color:#333;
        }

        label {
            font-weight:600;
            color:#555;
        }

        input, button {
            width:100%;
            padding:10px;
            margin-top:6px;
            margin-bottom:10px;
            border-radius:6px;
            border:1px solid #ccc;
        }

        button {
            background:#667eea;
            color:#fff;
            border:none;
            font-size:16px;
            cursor:pointer;
        }

        button:hover {
            background:#5a67d8;
        }

        .error {
            color:red;
            font-size:13px;
            margin-bottom:8px;
        }

        .back {
            text-align:center;
            margin-top:15px;
        }

        .back a {
            text-decoration:none;
            color:#667eea;
            font-weight:600;
        }

        @keyframes fadeIn {
            from { opacity:0; transform:translateY(10px); }
            to { opacity:1; transform:translateY(0); }
        }
    </style>
</head>

<body>

<div class="card">
    <h3>Edit Profile</h3>

    <form method="POST" action="<?php echo e(url('/user/profile/update')); ?>">
        <?php echo csrf_field(); ?>

        <label>Name</label>
        <input type="text" name="name" value="<?php echo e(old('name', auth()->user()->name)); ?>">
        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        <label>Email</label>
        <input type="email" name="email" value="<?php echo e(old('email', auth()->user()->email)); ?>">
        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        <button type="submit">Update Profile</button>
    </form>

    <div class="back">
        <a href="<?php echo e(url('/user/dashboard')); ?>">← Back to Dashboard</a>
    </div>
</div>

</body>
</html>
<?php /**PATH F:\spirehubtask\resources\views/user/edit-profile.blade.php ENDPATH**/ ?>