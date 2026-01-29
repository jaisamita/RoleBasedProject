

<?php $__env->startSection('content'); ?>
<head>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<?php if(session('success')): ?>
    <div id="success-msg" class="alert alert-success alert-dismissible fade show">
        <?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="container-fluid">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">User List</h5>
        </div>
<div id="flash-message"></div>

        <div class="card-body">
<div id="flash-message"></div>

            <table class="table table-hover table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        
                        <th width="120" class="text-center">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr id="row-<?php echo e($user->id); ?>">
                            <td><?php echo e($index + 1); ?></td>
                            <td><?php echo e($user->name); ?></td>
                            <td><?php echo e($user->email); ?></td>
                           
                            <td class="text-center">
                                <!-- Edit -->
                                <a href="<?php echo e(url('/users/'.$user->id.'/edit')); ?>"
                                   title="Edit"
                                   style="color:#0d6efd;font-size:14px;margin-right:10px;text-decoration:none;">
                                   Edit
                                </a>

                                <!-- Delete -->
                                <a href="javascript:void(0)"
                                   onclick="deleteUser(<?php echo e($user->id); ?>)"
                                   title="Delete"
                                   style="color:red;font-size:14px;text-decoration:none;">
                                   Delete
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                No users found
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<script>
    setTimeout(() => {
        let msg = document.getElementById('success-msg');
        if (msg) msg.remove();
    }, 2000);
</script>
<script>
function showMessage(message, type = 'success') {
    let box = document.getElementById('flash-message');
    box.innerHTML = `
        <div class="alert alert-${type} alert-dismissible fade show">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;

    setTimeout(() => {
        box.innerHTML = '';
    }, 5000);
}
</script>
<script>
function showMessage(message, type = 'success') {
    let box = document.getElementById('flash-message');
    box.innerHTML = `
        <div class="alert alert-${type} alert-dismissible fade show">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    setTimeout(() => box.innerHTML = '', 5000);
}

function deleteUser(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "This user will be permanently deleted!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {

        if (result.isConfirmed) {

            fetch(`/users/${id}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]').content,
                    "Accept": "application/json"
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    document.getElementById('row-' + id).remove();

                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: data.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire('Error', data.message ?? 'Delete failed', 'error');
                }
            })
            .catch(() => {
                Swal.fire('Error', 'Server error', 'error');
            });
        }
    });
}
</script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\spirehubtask\resources\views/admin/users.blade.php ENDPATH**/ ?>