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
    <div class="card">
        <?php echo $__env->yieldContent('content'); ?>
			
        <h4>Account Details</h4>
        <hr>
		  <p><strong>Name:</strong> <?php echo e(auth()->user()->name); ?></p>
        <p><strong>Email:</strong> <?php echo e(auth()->user()->email); ?></p>
        <p><strong>Role:</strong> <?php echo e(ucfirst(auth()->user()->role)); ?></p>
        <p><strong>User ID:</strong> <?php echo e(auth()->user()->id); ?></p>
        <p><strong>Registered On:</strong>
            <?php echo e(auth()->user()->created_at->format('d M Y')); ?>

        </p>
        <p><strong>Last Updated:</strong>
            <?php echo e(auth()->user()->updated_at->format('d M Y')); ?>

        </p>
    
    </div>
</div>




<footer>
    © <?php echo e(date('Y')); ?> User Panel
</footer>

</body>
</html>
<?php /**PATH F:\spirehubtask\resources\views/layouts/user.blade.php ENDPATH**/ ?>