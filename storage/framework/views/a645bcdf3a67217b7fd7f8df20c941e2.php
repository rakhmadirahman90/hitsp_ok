<?php $__env->startSection('content'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/admin/emaillembaga.css')); ?>">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="admin-wrapper" style="padding: 20px; background: #f8fafc;">
    <h2 class="page-title" style="color: #1B3B5F; font-weight: 700; margin-bottom: 25px;">
        <i class="fa fa-envelope-open-text me-2"></i> Detail Permohonan Email Pribadi
    </h2>

    
    <?php if(session('success')): ?>
        <div class="alert alert-success border-0 shadow-sm mb-4">
            <i class="fa fa-check-circle me-2"></i> <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>
    
    <?php if(session('error')): ?>
        <div class="alert alert-danger border-0 shadow-sm mb-4">
            <i class="fa fa-exclamation-triangle me-2"></i> <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <div class="detail-wrapper" style="background: white; padding: 25px; border-radius: 15px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
        <h3 style="font-size: 18px; color: #1B3B5F; border-bottom: 2px solid #eee; padding-bottom: 10px; margin-bottom: 20px;">
            <i class="fa fa-info-circle me-2"></i> Informasi Permohonan
        </h3>
        <table class="table table-bordered align-middle">
            <tr>
                <th style="width: 30%; background: #f1f5f9; color: #475569;">Jenis Akun</th>
                <td class="fw-bold">Pribadi</td>
            </tr>
            <tr>
                <th style="background: #f1f5f9; color: #475569;">Nama Lengkap</th>
                <td><?php echo e($email->nama_lengkap); ?></td>
            </tr>
            <tr>
                <th style="background: #f1f5f9; color: #475569;">Fakultas / Lembaga</th>
                <td><?php echo e($email->fakultas); ?></td>
            </tr>
            <tr>
                <th style="background: #f1f5f9; color: #475569;">Jurusan / Program Studi</th>
                <td><?php echo e($email->jurusan); ?></td>
            </tr>
            <tr>
                <th style="background: #f1f5f9; color: #475569;">Jabatan</th>
                <td><?php echo e($email->jabatan); ?></td>
            </tr>
            <tr>
                <th style="background: #f1f5f9; color: #475569;">Nomor Identitas</th>
                <td class="font-monospace"><?php echo e($email->nomor_identitas); ?></td>
            </tr>
            <tr>
                <th style="background: #f1f5f9; color: #475569;">Nomor Telepon</th>
                <td><?php echo e($email->no_telp); ?></td>
            </tr>
            <tr>
                <th style="background: #f1f5f9; color: #475569;">Email Alternatif</th>
                <td><i class="fa fa-envelope me-1 text-muted"></i> <?php echo e($email->email_alternatif); ?></td>
            </tr>
            <tr>
                <th style="background: #f1f5f9; color: #475569;">Status Permohonan Saat Ini</th>
                <td>
                    <?php if($email->status == 'pending'): ?>
                        <span class="badge bg-warning text-dark px-3 py-2"><i class="fa fa-clock me-1"></i> PENDING</span>
                    <?php elseif($email->status == 'disetujui'): ?>
                        <span class="badge bg-success text-white px-3 py-2"><i class="fa fa-check-circle me-1"></i> DISETUJUI</span>
                    <?php else: ?>
                        <span class="badge bg-dark text-white px-3 py-2"><i class="fa fa-times-circle me-1"></i> DITOLAK</span>
                    <?php endif; ?>
                </td>
            </tr>
        </table>
    </div>

    
    <?php if($email->status == 'pending'): ?>
        
        <div id="sectionSetuju" class="mt-4 p-4" style="background: #ecfdf5; border-radius: 15px; border: 1px solid #10b981;">
            <h4 style="color: #065f46; font-size: 16px; font-weight: 700; margin-bottom: 20px;">
                <i class="fa fa-user-plus me-2"></i> Aktivasi Akun Email Institusi
            </h4>
            <form action="<?php echo e(route('admin.emailpribadi.setuju', $email->id)); ?>" method="POST" id="formSetuju">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="id" value="<?php echo e($email->id); ?>">
                <input type="hidden" name="email_pemohon" value="<?php echo e($email->email_alternatif); ?>">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold small text-uppercase text-secondary">Nama Akun (Username)</label>
                        <div class="input-group">
                            <input type="text" name="nama_akun" id="nama_akun" class="form-control" placeholder="contoh: nama.nip/nim" required>
                            <span class="input-group-text">@institusi.ac.id</span>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="fw-bold small text-uppercase text-secondary">Password Default</label>
                        <input type="text" name="password" id="password" class="form-control" placeholder="Isi password aman" required>
                    </div>
                </div>

                <div class="action-wrapper mt-3 d-flex gap-2">
                    <button type="submit" class="btn btn-success px-4 fw-bold shadow-sm">
                        <i class="fa fa-check me-1"></i> Setujui & Kirim Akun
                    </button>
                    
                    <button type="button" class="btn btn-danger px-4 fw-bold shadow-sm" id="btnTolak">
                        <i class="fa fa-times me-1"></i> Tolak Permohonan
                    </button>
                    <a href="<?php echo e(route('admin.kelolaemail')); ?>" class="btn btn-secondary px-4 fw-bold shadow-sm">
                        <i class="fa fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </form>
        </div>

        
        <div id="formTolak" class="mt-4 p-4" style="display:none; background: #fff; border-radius: 15px; border: 1px solid #ef4444;">
            <h4 style="color: #991b1b; font-size: 16px; font-weight: 700; margin-bottom: 20px;">
                <i class="fa fa-ban me-2"></i> Konfirmasi Penolakan
            </h4>
            <form action="<?php echo e(route('admin.emailpribadi.tolak', $email->id)); ?>" method="POST" id="mainFormTolak">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="id" value="<?php echo e($email->id); ?>">
                <div class="form-group mb-3">
                    <label class="fw-bold small text-secondary">Alasan Penolakan</label>
                    <textarea name="alasan_tolak" id="alasan_tolak" class="form-control" rows="3" placeholder="Berikan alasan yang jelas mengapa permohonan ditolak..." required></textarea>
                </div>
                <div class="d-flex gap-2 mt-3 block-action-tolak">
                    <button type="submit" id="submitTolakReal" class="btn btn-danger btn-kirim-tolak px-4 fw-bold shadow-sm">
                        Kirim Penolakan
                    </button>
                    <button type="button" class="btn btn-outline-secondary btn-batal-tolak px-4 fw-bold" id="batalTolak">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    <?php else: ?>
        
        <div class="detail-wrapper mt-4 p-4" style="background: white; border-radius: 15px; border: 1px solid <?php echo e($email->status == 'disetujui' ? '#10b981' : '#cbd5e1'); ?>; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
            <?php if($email->status == 'disetujui'): ?>
                <h3 style="color: #1B3B5F; font-size: 18px; font-weight: 700; margin-bottom: 20px;">
                    <i class="fa fa-id-card me-2 text-success"></i> Informasi Akun Institusi Aktif
                </h3>
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th class="small text-secondary text-uppercase py-1">Username Baru</th>
                                <td class="py-1 fw-bold text-primary fs-5"><?php echo e($akunAktif->nama_akun ?? ($email->nama_akun ?? 'belum.aktif')); ?>@institusi.ac.id</td>
                            </tr>
                            <tr>
                                <th class="small text-secondary text-uppercase py-1">Tanggal Aktivasi</th>
                                <td class="py-1"><?php echo e($email->updated_at->format('d F Y, H:i')); ?> WIB</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="alert alert-info border-0 shadow-sm mt-3 mb-3">
                    <i class="fa fa-info-circle me-2"></i> Detail akun telah dikirimkan secara otomatis ke email alternatif user.
                </div>
                <div class="mt-2">
                    <a href="<?php echo e(route('admin.kelolaemail')); ?>" class="btn btn-secondary px-4 py-2 fw-bold shadow-sm">
                        <i class="fa fa-chevron-left me-1"></i> Kembali ke Daftar Akun
                    </a>
                </div>
            <?php else: ?>
                
                <div style="background: #fff; padding: 5px 10px;">
                    <div style="color: #000; font-size: 24px; margin-bottom: 10px;">
                        <i class="fa-solid fa-circle-xmark text-danger"></i>
                    </div>
                    <h5 class="mb-1" style="font-weight: 700; color: #000; font-size: 15px;">Permohonan Telah Ditolak</h5>
                    <p class="text-muted mb-3" style="font-size: 13.5px;">
                        Diproses pada: <?php echo e($email->updated_at->format('d F Y, H:i')); ?> WIB
                    </p>
                    
                    <h5 class="mb-1" style="font-weight: 700; color: #000; font-size: 15px;">Alasan Penolakan:</h5>
                    <p class="mb-4" style="color: #000; font-size: 14px;"><?php echo e($email->alasan_tolak); ?></p>
                    
                    <div class="mt-2">
                        <a href="<?php echo e(route('admin.kelolaemail')); ?>" class="btn btn-secondary px-4 py-2 fw-bold shadow-sm" style="border-radius: 20px !important;">
                            <i class="fa fa-arrow-left me-1"></i> Kembali ke Daftar Akun
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btnTolak = document.getElementById('btnTolak');
        const sectionSetuju = document.getElementById('sectionSetuju');
        const formTolak = document.getElementById('formTolak');
        const batalTolak = document.getElementById('batalTolak');
        const mainFormTolak = document.getElementById('mainFormTolak');
        
        const namaAkunInput = document.getElementById('nama_akun');
        const passwordInput = document.getElementById('password');
        const alasanTolakInput = document.getElementById('alasan_tolak');

        if (btnTolak) {
            btnTolak.addEventListener('click', function(e) {
                e.preventDefault();
                // Matikan required pada form setuju
                if (namaAkunInput) namaAkunInput.removeAttribute('required');
                if (passwordInput) passwordInput.removeAttribute('required');
                
                // Aktifkan required pada input alasan
                if (alasanTolakInput) alasanTolakInput.setAttribute('required', 'required');

                sectionSetuju.style.display = 'none';
                formTolak.style.display = 'block';
            });
        }

        if (batalTolak) {
            batalTolak.addEventListener('click', function(e) {
                e.preventDefault();
                // Kembalikan required form setuju
                if (namaAkunInput) namaAkunInput.setAttribute('required', 'required');
                if (passwordInput) passwordInput.setAttribute('required', 'required');
                
                if (alasanTolakInput) alasanTolakInput.removeAttribute('required');

                formTolak.style.display = 'none';
                sectionSetuju.style.display = 'block';
            });
        }

        if (mainFormTolak) {
            mainFormTolak.addEventListener('submit', function(e) {
                if (alasanTolakInput && alasanTolakInput.value.trim() === "") {
                    e.preventDefault();
                    alert("Harap isi alasan penolakan terlebih dahulu.");
                    alasanTolakInput.focus();
                    return false;
                }

                const btnSubmit = document.getElementById('submitTolakReal');
                if (btnSubmit) {
                    // Gunakan setTimeout agar browser menyelesaikan inisiasi request POST ke server 
                    // sebelum element interaktifnya dikunci.
                    setTimeout(function() {
                        btnSubmit.innerHTML = '<i class="fa fa-spinner fa-spin me-1"></i> Memproses...';
                        btnSubmit.style.pointerEvents = 'none';
                        btnSubmit.style.opacity = '0.7';
                    }, 50);
                }
            });
        }
    });
</script>

<style>
/* ================= BUTTON KEMBALI ================= */
.btn-secondary {
    background: #f1f5f9 !important;
    color: #334155 !important;
    border: 1px solid #cbd5e1 !important;
    border-radius: 999px !important;
    padding: 10px 18px !important;
    font-size: 0.85rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.25s ease;
}

.btn-secondary:hover {
    background: #1B3B5F !important;
    color: #fff !important;
    border-color: #1B3B5F !important;
    transform: translateY(-2px);
    box-shadow: 0 6px 14px rgba(27,59,95,0.2);
}

.btn-secondary i {
    font-size: 0.75rem;
}

/* ================= RESPONSIVE ================= */
@media (max-width: 768px) {
    .btn-secondary {
        width: 100%;
        justify-content: center;
        padding: 12px !important;
    }
}

/* ================= OVERRIDE / CUSTOM STYLES ================= */
.form-group input,
.form-group textarea,
.input-group input {
    width: 100%;
    padding: 10px 15px;
    border-radius: 8px !important;
    border: 1px solid #cbd5e1;
    font-size: 14px;
    background-color: #fff;
    transition: all 0.2s ease;
}

.form-group input:focus, .input-group input:focus {
    border-color: #1B3B5F;
    box-shadow: 0 0 0 3px rgba(27,59,95,0.1);
    outline: none;
}

.btn {
    border-radius: 8px;
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-2px);
}

.badge {
    border-radius: 6px;
    font-weight: 600;
}

/* ================= FORM AKTIVASI EMAIL ================= */
#sectionSetuju,
#formTolak {
    box-shadow: 0 6px 18px rgba(0,0,0,0.05);
}

#sectionSetuju h4,
#formTolak h4 {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 16px;
}

#sectionSetuju label,
#formTolak label {
    font-size: 12px;
    letter-spacing: 0.5px;
    margin-bottom: 6px;
    display: block;
    color: #64748b;
}

.input-group {
    display: flex;
    align-items: center;
    border-radius: 10px;
    overflow: hidden;
    border: 1px solid #cbd5e1;
    background: #fff;
}

.input-group input {
    border: none !important;
    flex: 1;
    padding: 12px 14px;
    outline: none;
}

.input-group-text {
    background: #f1f5f9;
    padding: 12px 14px;
    font-size: 13px;
    color: #475569;
    border-left: 1px solid #cbd5e1;
}

#sectionSetuju .form-control,
#formTolak .form-control {
    border-radius: 10px;
    padding: 12px 14px;
    border: 1px solid #cbd5e1;
    transition: 0.2s;
}

#sectionSetuju .form-control:focus,
#formTolak .form-control:focus {
    border-color: #ef4444;
    box-shadow: 0 0 0 3px rgba(239,68,68,0.15);
    outline: none;
}

.action-wrapper {
    flex-wrap: wrap;
}

.action-wrapper .btn {
    border-radius: 10px;
    padding: 10px 18px;
    font-size: 13px;
}

.btn-success {
    background: #10b981;
    border: none;
}

.btn-success:hover {
    background: #059669;
}

.btn-danger {
    background: #ef4444;
    border: none;
}

.btn-danger:hover {
    background: #dc2626;
}

.btn-secondary {
    border-radius: 10px !important;
}

/* KUSTOMISASI TOMBOL PENOLAKAN */
.block-action-tolak {
    display: flex !important;
    gap: 6px !important;
    clear: both !important;
}
.btn-kirim-tolak {
    background: #ef4444 !important;
    color: #fff !important;
    padding: 6px 14px !important;
    font-size: 14px !important;
    border-radius: 6px !important;
    border: none !important;
    width: auto !important;
    font-weight: 500 !important;
}
.btn-batal-tolak {
    background: #fff !important;
    color: #000 !important;
    border: 1px solid #000 !important;
    padding: 6px 14px !important;
    font-size: 14px !important;
    border-radius: 6px !important;
    width: auto !important;
    font-weight: 500 !important;
}
.btn-kirim-tolak:hover {
    background: #dc2626 !important;
}
.btn-batal-tolak:hover {
    background: #f1f5f9 !important;
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('operator.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/hitspbiz/public_html/HITSP/resources/views/admin/EmailPribadi.blade.php ENDPATH**/ ?>