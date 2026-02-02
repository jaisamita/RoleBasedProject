<!DOCTYPE html>
<html>
<head>
    <title>User Panel</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #f4f6f9;
        }

        /* Navbar */
        .navbar {
            background: linear-gradient(135deg, #667eea, #764ba2);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #fff;
        }

        .navbar a {
            color: #fff;
            text-decoration: none;
            margin-right: 20px;
            font-weight: 600;
        }

        .navbar a:hover {
            text-decoration: underline;
        }

        .logout-btn {
            background: #ff4d4d;
            border: none;
            color: #fff;
            padding: 8px 14px;
            border-radius: 6px;
            cursor: pointer;
        }

        .logout-btn:hover {
            background: #e63c3c;
        }

       
        .container {
            padding: 50px;
        }

        .card {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,.08);
            animation: fadeIn .4s ease-in-out;
        }

        footer {
            text-align: center;
            padding: 15px;
            color: #777;
            margin-top: 40px;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body>

<div class="navbar">
    <div>

        <a href="/user/dashboard">User Dashboard</a>
    </div>
	
	<div><span>Welcome, <?php echo e(auth()->user()->name); ?></span></div>
    
	<div>
        
        <form method="POST" action="<?php echo e(route('logout')); ?>" style="display:inline;">
            <?php echo csrf_field(); ?>
            <button class="logout-btn">Logout</button>
        </form>
    </div>
</div>

<div class="container">
    
<?php if(session('success')): ?>
<div class="alert alert-success alert-dismissible fade show">
    <?php echo e(session('success')); ?>

    <button class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>
    <div class="card">
        <?php echo $__env->yieldContent('content'); ?>
			
        <h4>Account Details</h4>
        <hr>
		  <p><strong>Name:</strong> <?php echo e(auth()->user()->name); ?></p>
        <p><strong>Email:</strong> <?php echo e(auth()->user()->email); ?></p>
    
        <p><strong>User ID:</strong> <?php echo e(auth()->user()->id); ?></p>
       
<!-- <a href="<?php echo e(route('user.profile.edit')); ?>"
   style="color:#0d6efd;font-size:14px;text-decoration:none;">
   Edit
</a> -->
<button class="btn btn-primary" data-bs-toggle="modal" 
data-bs-target="#editProfileModal" style="width:150px;">
    Edit Profile
</button>


<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:12px;">
            
            <div class="modal-body p-4">
                <h4 class="text-center mb-3">Edit Profile</h4>

                <form method="POST" action="<?php echo e(url('/user/profile/update')); ?>">
                    <?php echo csrf_field(); ?>

                    <label class="fw-semibold">Name</label>
                    <input type="text" class="form-control mb-2"
                        name="name"
                        value="<?php echo e(old('name', auth()->user()->name)); ?>">

                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="text-danger small mb-2"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    <label class="fw-semibold">Email</label>
                    <input type="email" class="form-control mb-2"
                        name="email"
                        value="<?php echo e(old('email', auth()->user()->email)); ?>">

                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="text-danger small mb-2"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    <button type="submit" class="btn btn-primary w-100 mt-2">
                        Update Profile
                    </button>
                </form>

            </div>

        </div>
    </div>
</div>


    </div>
</div>




<footer>
    © <?php echo e(date('Y')); ?> User Panel
</footer>

</body>
</html>
<?php /**PATH F:\spirehubtask\resources\views/layouts/user.blade.php ENDPATH**/ ?>