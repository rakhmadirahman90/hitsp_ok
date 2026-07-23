<?php $__env->startSection('content'); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
/* ================= GLOBAL ================= */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{
    background:#f3f4f6;
    color:#374151;
    font-size:14px;
}

/* ================= WRAPPER ================= */
.admin-wrapper{
    max-width:1200px;
    margin:auto;
    padding:25px 15px;
}

/* ================= TITLE ================= */
.page-title{
    font-size:24px;
    font-weight:700;
    margin-bottom:25px;
    color:#1f2937;
    text-align:center;
    line-height:1.4;
}

/* ================= ALERT ================= */
.alert{
    padding:14px 16px;
    border-radius:12px;
    margin-bottom:20px;
    text-align:center;
    font-size:14px;
}

.alert-success{
    background:#ecfdf5;
    color:#065f46;
    border:1px solid #10b981;
}

.alert-error{
    background:#fef2f2;
    color:#991b1b;
    border:1px solid #ef4444;
}

/* ================= BUTTON GROUP ================= */
.button-group{
    display:flex;
    justify-content:center;
    align-items:center;
    gap:12px;
    margin-bottom:25px;
    flex-wrap:wrap;
}

/* ================= BUTTON ================= */
.btn{
    padding:12px 20px;
    border:none;
    border-radius:12px;
    font-size:14px;
    font-weight:600;
    cursor:pointer;
    transition:all .3s ease;
    min-width:180px;
}

.btn-primary{
    background:#3b82f6;
    color:#fff;
}

.btn-primary:hover{
    background:#2563eb;
    transform:translateY(-2px);
}

.btn-secondary{
    background:#e5e7eb;
    color:#374151;
}

.btn-secondary:hover{
    background:#d1d5db;
    transform:translateY(-2px);
}

/* ================= ACTIVE BUTTON ================= */
.btn-active{
    background:#1f2937 !important;
    color:#fff !important;
    box-shadow:0 4px 12px rgba(0,0,0,0.15);
    transform:translateY(-2px);
}

/* ================= TABLE WRAPPER ================= */
.table-wrapper{
    width:100%;
    overflow-x:auto;
    -webkit-overflow-scrolling:touch;
    border-radius:14px;
}

/* ================= TABLE ================= */
.table{
    width:100%;
    min-width:750px;
    border-collapse:collapse;
    background:#fff;
    border-radius:14px;
    overflow:hidden;
    box-shadow:0 4px 12px rgba(0,0,0,0.06);
}

/* ================= TABLE HEADER ================= */
.table thead{
    background:#e5e7eb;
}

.table th{
    padding:14px 12px;
    text-align:left;
    font-size:13px;
    font-weight:700;
    color:#374151;
    white-space:nowrap;
}

/* ================= TABLE BODY ================= */
.table td{
    padding:13px 12px;
    font-size:13px;
    color:#4b5563;
    border-bottom:1px solid #f1f5f9;
    vertical-align:middle;
    white-space:nowrap;
    max-width:220px;
    overflow:hidden;
    text-overflow:ellipsis;
}

/* ================= HOVER TABLE ================= */
.table tbody tr{
    transition:0.2s ease;
}

.table tbody tr:hover{
    background:#f9fafb;
}

/* ================= STATUS BADGE ================= */
.status-badge{
    padding:6px 12px;
    border-radius:999px;
    font-size:12px;
    font-weight:600;
}

.status-pending{
    background:#fef3c7;
    color:#92400e;
}

.status-approve{
    background:#dcfce7;
    color:#166534;
}

.status-reject{
    background:#fee2e2;
    color:#991b1b;
}

/* ================= ACTION BUTTON ================= */
.action-btn{
    width:38px;
    height:38px;
    border:none;
    border-radius:10px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    color:#fff;
    cursor:pointer;
    margin-right:5px;
    transition:all .25s ease;
}

.action-btn:hover{
    transform:translateY(-2px);
}

.detail-btn{
    background:#3b82f6;
}

.detail-btn:hover{
    background:#2563eb;
}

.delete-btn{
    background:#ef4444;
}

.delete-btn:hover{
    background:#dc2626;
}

/* ================= EMPTY STATE ================= */
.empty-state{
    text-align:center;
    padding:35px 20px;
    color:#6b7280;
    font-size:14px;
    background:#f9fafb;
}

/* ================= SCROLLBAR ================= */
.table-wrapper::-webkit-scrollbar{
    height:8px;
}

.table-wrapper::-webkit-scrollbar-thumb{
    background:#cbd5e1;
    border-radius:999px;
}

.table-wrapper::-webkit-scrollbar-track{
    background:#f1f5f9;
}

/* ================= MOBILE RESPONSIVE ================= */
@media (max-width:768px){

    .admin-wrapper{
        padding:12px;
    }

    .page-title{
        font-size:18px;
        margin-bottom:20px;
    }

    .button-group{
        flex-direction:column;
        gap:10px;
    }

    .btn{
        width:100%;
        min-width:100%;
        font-size:13px;
        padding:12px;
    }

    .table-wrapper{
        overflow-x:auto;
    }

    .table{
        min-width:700px;
    }

    .table th,
    .table td{
        font-size:12px;
        padding:10px;
    }

    .table td{
        max-width:160px;
    }

    .action-btn{
        width:32px;
        height:32px;
        font-size:12px;
    }

    .empty-state{
        font-size:13px;
        padding:25px 15px;
    }
}

/* ================= EXTRA SMALL DEVICE ================= */
@media (max-width:480px){

    .page-title{
        font-size:16px;
    }

    .btn{
        font-size:12px;
    }

    .table th,
    .table td{
        font-size:11px;
        padding:8px;
    }

    .action-btn{
        width:30px;
        height:30px;
    }
}
</style>

<div class="admin-wrapper">

    <h2 class="page-title">Manajemen Permohonan Email</h2>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-error"><?php echo e(session('error')); ?></div>
    <?php endif; ?>

    <div class="button-group">
        <button class="btn btn-primary btn-active" id="btnEmailPribadi">
            Email Pribadi
        </button>

        <button class="btn btn-secondary" id="btnEmailLembaga">
            Email Lembaga
        </button>
    </div>

    <!-- ================= EMAIL PRIBADI ================= -->
    <div id="emailPribadiTable" class="table-wrapper">
        <table class="table">

            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Lengkap</th>
                    <th>Jenis Pemohon</th>
                    <th>Fakultas / Jurusan</th>
                    <th>Nomor Identitas</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

                <?php $__empty_1 = true; $__currentLoopData = $emailPribadi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $email): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                <tr>

                    <td><?php echo e($i+1); ?></td>

                    <td><?php echo e($email->nama_lengkap); ?></td>

                    <td>
    <?php if($email->jenis_pemohon == 'pegawai'): ?>
        Dosen / Staf
    <?php elseif($email->jenis_pemohon == 'mahasiswa'): ?>
        Mahasiswa
    <?php else: ?>
        -
    <?php endif; ?>
</td>

                    <td><?php echo e($email->fakultas); ?> / <?php echo e($email->jurusan); ?></td>

                    <td><?php echo e($email->nomor_identitas); ?></td>

                    <td>

                        <?php
                            $status = strtolower(trim($email->status));
                        ?>

                        <?php if($status == 'pending'): ?>

                            <span class="badge-status pending">
                                <i class="fa fa-clock"></i>
                                Pending
                            </span>

                        <?php elseif($status == 'disetujui'): ?>

                            <span class="badge-status success">
                                <i class="fa fa-check-circle"></i>
                                Disetujui
                            </span>

                        <?php else: ?>

                            <span class="badge-status danger">
                                <i class="fa fa-times-circle"></i>
                                Ditolak
                            </span>

                        <?php endif; ?>

                    </td>

                    <td>

                        <a href="<?php echo e(route('admin.emailpribadi.detail', $email->id)); ?>"
                           class="action-btn detail-btn">

                            <i class="fa-solid fa-eye"></i>

                        </a>

                        <form action="<?php echo e(route('admin.emailpribadi.destroy', $email->id)); ?>"
                              method="POST"
                              style="display:inline;">

                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>

                            <button type="button"
                                    class="action-btn delete-btn btn-delete"
                                    data-name="<?php echo e($email->nama_lengkap); ?>">

                                <i class="fa-solid fa-trash"></i>

                            </button>

                        </form>

                    </td>

                </tr>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            Belum ada data email pribadi
                        </div>
                    </td>
                </tr>

                <?php endif; ?>

            </tbody>

        </table>
    </div>

    <!-- ================= EMAIL LEMBAGA ================= -->
    <div id="emailLembagaTable" style="display:none;">

        <table class="table">

            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Institusi / Kegiatan</th>
                    <th>Nama Akun</th>
                    <th>Penanggung Jawab</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

                <?php $__empty_1 = true; $__currentLoopData = $emailLembaga; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $email): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                <tr>

                    <td><?php echo e($i+1); ?></td>

                    <td>
                        <?php echo e($email->nama_institusi); ?>

                        <?php echo e($email->nama_kegiatan ? '/ '.$email->nama_kegiatan : ''); ?>

                    </td>

                    <td><?php echo e($email->nama_akun); ?></td>

                    <td><?php echo e($email->nama_teknis); ?></td>

                    <td>

                        <?php
                            $status = strtolower(trim($email->status));
                        ?>

                        <?php if($status == 'pending'): ?>

                            <span class="badge-status pending">
                                <i class="fa fa-clock"></i>
                                Pending
                            </span>

                        <?php elseif($status == 'disetujui'): ?>

                            <span class="badge-status success">
                                <i class="fa fa-check-circle"></i>
                                Disetujui
                            </span>

                        <?php else: ?>

                            <span class="badge-status danger">
                                <i class="fa fa-times-circle"></i>
                                Ditolak
                            </span>

                        <?php endif; ?>

                    </td>

                    <td>

                        <a href="<?php echo e(route('admin.email.detail', $email->id)); ?>"
                           class="action-btn detail-btn">

                            <i class="fa-solid fa-eye"></i>

                        </a>

                        <form action="<?php echo e(route('admin.email.destroy', $email->id)); ?>"
                              method="POST"
                              style="display:inline;">

                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>

                            <button type="button"
                                    class="action-btn delete-btn btn-delete"
                                    data-name="<?php echo e($email->nama_institusi); ?>">

                                <i class="fa-solid fa-trash"></i>

                            </button>

                        </form>

                    </td>

                </tr>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            Belum ada data email lembaga
                        </div>
                    </td>
                </tr>

                <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>

<script>

const btnPribadi = document.getElementById('btnEmailPribadi');
const btnLembaga = document.getElementById('btnEmailLembaga');

const pribadi = document.getElementById('emailPribadiTable');
const lembaga = document.getElementById('emailLembagaTable');

function setActiveButton(activeBtn) {

    btnPribadi.classList.remove('btn-active');
    btnLembaga.classList.remove('btn-active');

    activeBtn.classList.add('btn-active');
}

btnPribadi.onclick = () => {

    pribadi.style.display = "block";
    lembaga.style.display = "none";

    setActiveButton(btnPribadi);
};

btnLembaga.onclick = () => {

    pribadi.style.display = "none";
    lembaga.style.display = "block";

    setActiveButton(btnLembaga);
};

document.querySelectorAll('.btn-delete').forEach(button => {

    button.addEventListener('click', function () {

        let form = this.closest('form');
        let name = this.getAttribute('data-name');

        Swal.fire({

            title: 'Yakin ingin menghapus?',
            text: name + " akan dihapus permanen!",
            icon: 'warning',

            showCancelButton: true,

            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',

            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'

        }).then((result) => {

            if (result.isConfirmed) {
                form.submit();
            }

        });

    });

});

</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('operator.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/hitspbiz/public_html/HITSP/resources/views/admin/kelolaemail.blade.php ENDPATH**/ ?>