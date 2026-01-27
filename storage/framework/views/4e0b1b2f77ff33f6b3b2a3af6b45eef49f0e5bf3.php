

			
      
<?php $__env->startSection('content'); ?>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\spirehubtask\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>