<?php $__env->startSection('content'); ?>

<div class="tracking-container">

<h2 class="tracking-title">Tracking Ticket Status</h2>

<div class="table-wrapper">

<table class="tracking-table">

<thead>
<tr>
<th>No Ticket</th>
<th>Judul Laporan</th>
<th>Tanggal</th>
<th>Status</th>
<th>Aksi</th>
</tr>
</thead>

<tbody>

<?php $__empty_1 = true; $__currentLoopData = $laporan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

<tr>

<td data-label="No Ticket">
<?php echo e($item->ticket_no); ?>

</td>

<td data-label="Judul Laporan">
<?php echo e($item->judul); ?>

</td>

<td data-label="Tanggal">
<?php echo e(\Carbon\Carbon::parse($item->tanggal)->format('d/m/Y')); ?>

</td>

<td data-label="Status"
class="status
<?php echo e($item->status == 'Selesai' ? 'selesai' :
($item->status == 'Di Terima' ? 'di-terima' :
($item->status == 'Di proses' ? 'proses' : 'menunggu'))); ?>">
<?php echo e($item->status); ?>

</td>

<td data-label="Aksi">

<a href="<?php echo e(route('laporan.show_user', $item->id)); ?>">
<i class="fa-solid fa-eye eye-icon"></i>
</a>

</td>

</tr>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

<tr>
<td colspan="5" class="empty">
Belum ada laporan yang diajukan
</td>
</tr>

<?php endif; ?>

</tbody>

</table>

</div>

</div>

<style>

/* ===== CONTAINER ===== */

.tracking-container{
max-width:1100px;
margin:auto;
padding:40px 20px;
}


/* ===== TITLE ===== */

.tracking-title{
font-size:26px;
font-weight:700;
margin-bottom:25px;
}


/* ===== TABLE ===== */

.table-wrapper{
overflow-x:auto;
}

.tracking-table{
width:100%;
border-collapse:collapse;
background:white;
border-radius:12px;
overflow:hidden;
box-shadow:0 5px 25px rgba(0,0,0,.08);
}

.tracking-table thead{
background:#111827;
color:white;
}

.tracking-table th{
padding:15px;
font-size:14px;
text-align:left;
}

.tracking-table td{
padding:15px;
font-size:14px;
border-bottom:1px solid #f1f5f9;
}


/* ===== STATUS ===== */

.status{
padding:6px 14px;
border-radius:20px;
font-size:12px;
font-weight:600;
display:inline-block;
}

.status.menunggu{
background:#FEF3C7;
color:#92400E;
}

.status.proses{
background:#DBEAFE;
color:#1D4ED8;
}

.status.di-terima{
background:#DCFCE7;
color:#15803D;
}

.status.selesai{
background:#E0F2FE;
color:#0284C7;
}


/* ===== ICON ===== */

.eye-icon{
font-size:18px;
color:#0284C7;
}


/* ===== EMPTY ===== */

.empty{
text-align:center;
padding:30px;
color:gray;
}


/* =========================
MOBILE RESPONSIVE
========================= */

@media (max-width:768px){

.tracking-table thead{
display:none;
}

.tracking-table,
.tracking-table tbody,
.tracking-table tr,
.tracking-table td{
display:block;
width:100%;
}

.tracking-table tr{
background:white;
border-radius:12px;
margin-bottom:15px;
padding:15px;
box-shadow:0 5px 20px rgba(0,0,0,.05);
}

.tracking-table td{
border:none;
padding:8px 0;
}

.tracking-table td::before{
content:attr(data-label);
font-weight:600;
display:block;
font-size:12px;
color:#64748b;
margin-bottom:2px;
}

}

</style>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('user.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/hitspbiz/public_html/HITSP/resources/views/user/tracking.blade.php ENDPATH**/ ?>