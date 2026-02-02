<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Admin Panel</title>

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

        /* Layout */
        .container {
            padding: 30px;
        }

        .card {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,.08);
        }

        footer {
            text-align: center;
            padding: 15px;
            color: #777;
            margin-top: 40px;
        }
    </style>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<body>

<div class="navbar">
    <div>
        
        <a href="/admin/dashboard" style="text-decoration:none">Admin Dashboard</a>
        <a href="<?php echo e(route('admin.users')); ?>" style="text-decoration:none">Users</a>
    </div>


      <div>
        <span>Welcome, <?php echo e(auth()->user()->name); ?></span>
    </div>
	
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
			
       
    
    </div>
</div>

<footer>
    © <?php echo e(date('Y')); ?> Admin Panel
</footer>

</body>
</html>
<?php /**PATH F:\spirehubtask\resources\views/layouts/admin.blade.php ENDPATH**/ ?>