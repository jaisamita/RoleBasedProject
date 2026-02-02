

<?php $__env->startSection('content'); ?>


<?php if(session('success')): ?>
<div class="alert alert-success alert-dismissible fade show">
    <?php echo e(session('success')); ?>

    <button class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<h4>Admin Profile</h4>


<!-- <button  style=" width:150px;"class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#viewAccountModal">
    Edit Profile
</button> -->

 
        <hr>
		  <p><strong>Name:</strong> <?php echo e(auth()->user()->name); ?></p>
        <p><strong>Email:</strong> <?php echo e(auth()->user()->email); ?></p>
    
        <p><strong>User ID:</strong> <?php echo e(auth()->user()->id); ?></p>
<button style="width:150px;"
        class="btn btn-primary mb-3"
        data-bs-toggle="modal"
        data-bs-target="#editAccountModal">
    Edit Profile
</button>


<div class="modal fade" id="viewAccountModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Account Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p><strong>Name:</strong> <?php echo e(auth()->user()->name); ?></p>
                <p><strong>Email:</strong> <?php echo e(auth()->user()->email); ?></p>
                <p><strong>User ID:</strong> <?php echo e(auth()->user()->id); ?></p>
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary"
                        data-bs-dismiss="modal"
                        data-bs-toggle="modal"
                        data-bs-target="#editAccountModal">
                    Edit
                </button>

                <button class="btn btn-secondary" data-bs-dismiss="modal">
                    Close
                </button>
            </div>

        </div>
    </div>
</div>


<div class="modal fade" id="editAccountModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Edit Account</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form method="POST" action="<?php echo e(url('/admin/profile/update')); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="modal-body">

                    <label class="fw-semibold">Name</label>
                    <input type="text"
                           name="name"
                           class="form-control mb-2"
                           value="<?php echo e(auth()->user()->name); ?>"
                           required>

                    <label class="fw-semibold">Email</label>
                    <input type="email"
                           name="email"
                           class="form-control"
                           value="<?php echo e(auth()->user()->email); ?>"
                           required>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button class="btn btn-primary">
                        Update
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\spirehubtask\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>