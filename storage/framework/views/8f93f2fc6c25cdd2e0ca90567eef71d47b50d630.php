

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5>Edit User</h5>
        </div>

        <div class="card-body">
            <form method="POST" action="<?php echo e(url('/users/'.$user->id)); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control"
                           value="<?php echo e(old('name', $user->name)); ?>">
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control"
                           value="<?php echo e(old('email', $user->email)); ?>">
                </div>


                <button type="submit" class="btn btn-success">
                    Update
                </button>

                <!--a href="<?php echo e(route('admin.users')); ?>" class="btn btn-secondary">
                    Back
                </a-->
            </form>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\spirehubtask\resources\views/admin/users/edit.blade.php ENDPATH**/ ?>