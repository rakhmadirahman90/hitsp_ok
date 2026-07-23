<?php $__env->startSection('content'); ?>



<link rel="stylesheet" href="<?php echo e(asset('css/admin/kelolazoom.css')); ?>">



<div class="zoom-detail-wrapper">

    <h2 class="page-title">Detail Request Zoom</h2>



    <?php if(session('success')): ?>

        <div class="alert-success"><?php echo e(session('success')); ?></div>

    <?php endif; ?>



    <ul class="detail-list">

        <li><strong>Nama:</strong> <?php echo e($request->nama); ?></li>

        <li><strong>Email:</strong> <?php echo e($request->email); ?></li>

        <li><strong>Kegiatan:</strong> <?php echo e($request->jenis_kegiatan); ?></li>

        <li><strong>Tanggal:</strong> <?php echo e($request->tanggal); ?></li>

        <li><strong>Waktu:</strong> <?php echo e($request->waktu_mulai); ?> - <?php echo e($request->waktu_selesai); ?></li>

    </ul>



    <?php if($request->status == 'pending'): ?>

    <form method="POST" action="<?php echo e(route('admin.zoom.approve', $request->id)); ?>" class="approve-form">

        <?php echo csrf_field(); ?>

        <div class="form-group">

            <label>Link Zoom</label>

            <input type="url" name="link_zoom" placeholder="Masukkan link Zoom" required>

        </div>

        <button class="btn-approve" type="submit">Approve & Kirim Email</button>

    </form>

    <?php else: ?>

    <p><strong>Link Zoom:</strong>

        <a href="<?php echo e($request->link_zoom); ?>" target="_blank"><?php echo e($request->link_zoom); ?></a>

    </p>

    <p>Status: <span class="badge-approved">Approved</span></p>

    <?php endif; ?>

</div>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('operator.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/hitspbiz/public_html/HITSP/resources/views/admin/showzoom.blade.php ENDPATH**/ ?>