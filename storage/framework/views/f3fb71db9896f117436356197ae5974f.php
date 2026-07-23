<?php $__env->startSection('title', 'Detail Permohonan Sub Domain'); ?>

<?php $__env->startSection('content'); ?>

<link rel="stylesheet" href="<?php echo e(asset('css/admin/emaillembaga.css')); ?>">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<div class="admin-wrapper">

    <h2 class="page-title">Detail Permohonan Sub Domain</h2>

    
    <?php if(session('success')): ?>
        <div class="alert alert-success" style="padding:15px; background-color:#d1e7dd; color:#0f5132; border-radius:10px; margin-bottom:20px; font-weight:500; border: 1px solid #badbcc;">
            <i class="fa-solid fa-circle-check"></i> <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger" style="padding:15px; background-color:#f8d7da; color:#842029; border-radius:10px; margin-bottom:20px; font-weight:500; border: 1px solid #f5c2c7;">
            <i class="fa-solid fa-circle-xmark"></i> <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <div class="detail-wrapper mb-4">

        <h3>Informasi Pengajuan</h3>

        <table class="table table-bordered">

            <tr>
                <th>Nama Organisasi</th>
                <td><?php echo e($subdomain->nama_organisasi); ?></td>
            </tr>

            <tr>
                <th>Nama Pemohon</th>
                <td><?php echo e($subdomain->user->name ?? '-'); ?></td>
            </tr>

            <tr>
                <th>Email Pemohon</th>
                <td><?php echo e($subdomain->user->email ?? '-'); ?></td>
            </tr>

            <tr>
                <th>Jenis Domain</th>
                <td><?php echo e($subdomain->jenis_domain); ?></td>
            </tr>

            <tr>
                <th>Nama Sub Domain</th>
                <td><?php echo e($subdomain->nama_sub_domain); ?></td>
            </tr>

            <tr>
                <th>Status</th>
                <td>
                    <?php if($subdomain->status == 'pending'): ?>
                        <span class="badge bg-warning text-dark" style="background-color: #ffc107; color: #000;">
                            <i class="fa-solid fa-clock"></i> PENDING
                        </span>
                    <?php elseif($subdomain->status == 'approved' || $subdomain->status == 'active'): ?>
                        <span class="badge bg-success" style="background-color: #198754; color: #fff;">
                            <i class="fa-solid fa-check-circle"></i> APPROVED / ACTIVE
                        </span>
                    <?php elseif($subdomain->status == 'disabled'): ?>
                        <span class="badge bg-secondary" style="background-color: #6b7280; color: #fff;">
                            <i class="fa-solid fa-ban"></i> DISABLED
                        </span>
                    <?php elseif($subdomain->status == 'rejected'): ?>
                        <span class="badge bg-danger" style="background-color: #dc2626; color: #fff;">
                            <i class="fa-solid fa-times-circle"></i> REJECTED
                        </span>
                    <?php else: ?>
                        <span class="badge bg-info">
                            <?php echo e(strtoupper($subdomain->status)); ?>

                        </span>
                    <?php endif; ?>
                </td>
            </tr>

            <?php if($subdomain->status == 'rejected' && $subdomain->alasan_tolak): ?>
            <tr style="background-color: #fce8e6;">
                <th style="background-color: #ea4335; color: #fff; font-weight: 600;">Alasan Penolakan Admin</th>
                <td style="color: #c5221f; font-weight: 600; border: 1px solid #fecaca;">
                    <i class="fa-solid fa-triangle-exclamation"></i> <?php echo e($subdomain->alasan_tolak); ?>

                </td>
            </tr>
            <?php endif; ?>

        </table>

        <h5 class="mt-4">Penanggung Jawab Administratif</h5>

        <ul class="detail-list">
            <li>Nama: <?php echo e($subdomain->nama_admin); ?></li>
            <li>NIP: <?php echo e($subdomain->nip_admin); ?></li>
            <li>Alamat Kantor: <?php echo e($subdomain->alamat_kantor_admin); ?></li>
            <li>Alamat Rumah: <?php echo e($subdomain->alamat_rumah_admin); ?></li>
            <li>Telepon Kantor: <?php echo e($subdomain->telp_kantor_admin); ?></li>
            <li>Telepon Rumah: <?php echo e($subdomain->telp_rumah_admin); ?></li>
            <li>Email: <?php echo e($subdomain->email_admin); ?></li>
        </ul>

        <h5 class="mt-4">Penanggung Jawab Teknis</h5>

        <ul class="detail-list">
            <li>Nama: <?php echo e($subdomain->nama_teknis); ?></li>
            <li>NIP / NIM: <?php echo e($subdomain->nip_nim_teknis); ?></li>
            <li>Alamat Kantor: <?php echo e($subdomain->alamat_kantor_teknis); ?></li>
            <li>Alamat Rumah: <?php echo e($subdomain->alamat_rumah_teknis); ?></li>
            <li>Telepon Kantor: <?php echo e($subdomain->telp_kantor_teknis); ?></li>
            <li>Email: <?php echo e($subdomain->email_teknis); ?></li>
        </ul>

    </div>

    <?php if($subdomain->status == 'pending'): ?>
        
        <div class="detail-wrapper">

            <h3>Data Hosting (Diisi Admin)</h3>

            <form id="approveSubdomainForm" action="<?php echo e(route('admin.subdomain.approve', $subdomain->id)); ?>" method="POST">

                <?php echo csrf_field(); ?>

                <div class="form-group">
                    <label>IP Server</label>
                    <input type="text" name="ip_server" id="form_ip_server" class="form-control" value="<?php echo e($subdomain->ip_server ?? (optional($subdomain->hostingAccess)->ip_server ?? '')); ?>" required>
                </div>

                <div class="form-group mt-3">
                    <label>User SSH</label>
                    <input type="text" name="ssh_user" id="form_ssh_user" class="form-control" value="<?php echo e($subdomain->ssh_user ?? (optional($subdomain->hostingAccess)->ssh_user ?? '')); ?>" required>
                </div>

                <div class="form-group mt-3">
                    <label>Password SSH</label>
                    <div class="password-wrapper">
                        <input type="password" name="ssh_password" id="ssh_password" class="form-control password-input" value="<?php echo e($subdomain->ssh_password ?? (optional($subdomain->hostingAccess)->ssh_password ?? '')); ?>" required>
                        <span class="toggle-password" onclick="togglePassword('ssh_password', 'icon_ssh')">
                            <i class="fa-solid fa-eye" id="icon_ssh"></i>
                        </span>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label>Database Name</label>
                    <input type="text" name="db_name" id="form_db_name" class="form-control" value="<?php echo e($subdomain->db_name ?? (optional($subdomain->hostingAccess)->db_name ?? '')); ?>" required>
                </div>

                <div class="form-group mt-3">
                    <label>Database User</label>
                    <input type="text" name="db_user" id="form_db_user" class="form-control" value="<?php echo e($subdomain->db_user ?? (optional($subdomain->hostingAccess)->db_user ?? '')); ?>" required>
                </div>

                <div class="form-group mt-3">
                    <label>Database Password</label>
                    <div class="password-wrapper">
                        <input type="password" name="db_password" id="db_password" class="form-control password-input" value="<?php echo e($subdomain->db_password ?? (optional($subdomain->hostingAccess)->db_password ?? '')); ?>" required>
                        <span class="toggle-password" onclick="togglePassword('db_password', 'icon_db')">
                            <i class="fa-solid fa-eye" id="icon_db"></i>
                        </span>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label>Lokasi Aplikasi</label>
                    <input type="text" name="app_path" id="form_app_path" class="form-control" value="<?php echo e($subdomain->app_path ?? (optional($subdomain->hostingAccess)->app_path ?? '')); ?>" required>
                </div>

                <div class="action-wrapper mt-4">
                    <button type="button" class="btn btn-success" onclick="openApproveModal()">Setuju</button>
                    <button type="button" class="btn btn-danger" onclick="openRejectModal()">Tolak</button>
                    <a href="<?php echo e(route('admin.subdomain.index')); ?>" class="btn btn-secondary">Kembali</a>
                </div>

            </form>

        </div>
    <?php elseif($subdomain->status == 'approved' || $subdomain->status == 'active' || $subdomain->status == 'disabled'): ?>
        
        <div class="detail-wrapper" style="border-left: 5px solid <?php echo e($subdomain->status == 'disabled' ? '#6b7280' : '#198754'); ?>;">
            <h3 style="color: <?php echo e($subdomain->status == 'disabled' ? '#6b7280' : '#198754'); ?>;">
                <i class="fa-solid fa-server"></i> Ringkasan Hasil Persetujuan Akses Hosting (<?php echo e(strtoupper($subdomain->status)); ?>)
            </h3>
            <p style="font-size: 14px; color: #475569; margin-bottom: 15px;">Berikut adalah ringkasan parameter hosting yang telah dibuat dan dikonfigurasi untuk layanan ini:</p>
            
            <table class="table table-bordered" style="box-shadow: none; margin-bottom: 5px;">
                <tr style="background-color: #f8fafc;">
                    <th style="width: 30%; background-color: #475569;">Parameter</th>
                    <th style="background-color: #475569;">Nilai Konfigurasi</th>
                </tr>
                <tr>
                    <td><strong>IP Server</strong></td>
                    <td><code><?php echo e($subdomain->ip_server ?? (optional($subdomain->hostingAccess)->ip_server ?? '-')); ?></code></td>
                </tr>
                <tr>
                    <td><strong>User SSH</strong></td>
                    <td><code><?php echo e($subdomain->ssh_user ?? (optional($subdomain->hostingAccess)->ssh_user ?? '-')); ?></code></td>
                </tr>
                
                <tr>
                    <td><strong>Password SSH</strong></td>
                    <td>
                        <div style="display: flex; align-items: center; justify-content: space-between; max-width: 300px;">
                            <span id="text_summary_ssh" style="font-family: monospace;">******</span>
                            <span id="hidden_summary_ssh" style="display:none;"><?php echo e($subdomain->ssh_password ?? (optional($subdomain->hostingAccess)->ssh_password ?? '-')); ?></span>
                            <button type="button" class="btn-toggle-view" onclick="toggleSummaryText('text_summary_ssh', 'hidden_summary_ssh', 'icon_summary_ssh')" style="background: none; border: none; color: #64748b; cursor: pointer; padding: 0 5px;">
                                <i class="fa-solid fa-eye" id="icon_summary_ssh"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><strong>Database Name</strong></td>
                    <td><code><?php echo e($subdomain->db_name ?? (optional($subdomain->hostingAccess)->db_name ?? '-')); ?></code></td>
                </tr>
                <tr>
                    <td><strong>Database User</strong></td>
                    <td><code><?php echo e($subdomain->db_user ?? (optional($subdomain->hostingAccess)->db_user ?? '-')); ?></code></td>
                </tr>
                
                <tr>
                    <td><strong>Database Password</strong></td>
                    <td>
                        <div style="display: flex; align-items: center; justify-content: space-between; max-width: 300px;">
                            <span id="text_summary_db" style="font-family: monospace;">******</span>
                            <span id="hidden_summary_db" style="display:none;"><?php echo e($subdomain->db_password ?? (optional($subdomain->hostingAccess)->db_password ?? '-')); ?></span>
                            <button type="button" class="btn-toggle-view" onclick="toggleSummaryText('text_summary_db', 'hidden_summary_db', 'icon_summary_db')" style="background: none; border: none; color: #64748b; cursor: pointer; padding: 0 5px;">
                                <i class="fa-solid fa-eye" id="icon_summary_db"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><strong>Lokasi Aplikasi (Path)</strong></td>
                    <td><code><?php echo e($subdomain->app_path ?? (optional($subdomain->hostingAccess)->app_path ?? '-')); ?></code></td>
                </tr>
                
                <tr>
                    <th style="background-color: #64748b; color: #fff;">Notifikasi Pengguna</th>
                    <td>
                        <?php if($subdomain->status == 'disabled'): ?>
                            <i class="fa-solid fa-ban" style="color: #dc2626;"></i> Status saat ini ditangguhkan (Disabled). Akses menuju server dinonaktifkan sementara waktu.
                        <?php else: ?>
                            <i class="fa-solid fa-envelope" style="color: #198754;"></i> Surat pemberitahuan persetujuan sistem otomatis beserta akun hosting lengkap telah dikirimkan ke email penanggung jawab teknis (<code><?php echo e($subdomain->email_teknis); ?></code>).
                        <?php endif; ?>
                    </td>
                </tr>
            </table>

            <div class="action-wrapper mt-4">
                <a href="<?php echo e(route('admin.subdomain.index')); ?>" class="btn btn-secondary">Kembali ke Daftar Layanan</a>
            </div>
        </div>

        
        <div class="detail-wrapper mt-4" style="border-top: 4px solid #1B3B5F;">
            <h3><i class="fa-solid fa-gear"></i> Parameter Konfigurasi Hosting (Akses Server)</h3>
            <p style="font-size: 14px; color: #64748b; margin-bottom: 20px;">Anda dapat memperbarui konfigurasi server aktif di bawah ini jika diperlukan sewaktu-waktu.</p>

            <form action="<?php echo e(route('admin.subdomain.update-hosting', $subdomain->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="form-group">
                    <label>IP Server</label>
                    <input type="text" name="ip_server" class="form-control" value="<?php echo e($subdomain->ip_server ?? (optional($subdomain->hostingAccess)->ip_server ?? '')); ?>" required>
                </div>

                <div class="form-group mt-3">
                    <label>User SSH</label>
                    <input type="text" name="ssh_user" class="form-control" value="<?php echo e($subdomain->ssh_user ?? (optional($subdomain->hostingAccess)->ssh_user ?? '')); ?>" required>
                </div>

                <div class="form-group mt-3">
                    <label>Password SSH</label>
                    <div class="password-wrapper">
                        <input type="password" name="ssh_password" id="edit_ssh_password" class="form-control password-input" value="<?php echo e($subdomain->ssh_password ?? (optional($subdomain->hostingAccess)->ssh_password ?? '')); ?>" required>
                        <span class="toggle-password" onclick="togglePassword('edit_ssh_password', 'icon_edit_ssh')">
                            <i class="fa-solid fa-eye" id="icon_edit_ssh"></i>
                        </span>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label>Database Name</label>
                    <input type="text" name="db_name" class="form-control" value="<?php echo e($subdomain->db_name ?? (optional($subdomain->hostingAccess)->db_name ?? '')); ?>" required>
                </div>

                <div class="form-group mt-3">
                    <label>Database User</label>
                    <input type="text" name="db_user" class="form-control" value="<?php echo e($subdomain->db_user ?? (optional($subdomain->hostingAccess)->db_user ?? '')); ?>" required>
                </div>

                <div class="form-group mt-3">
                    <label>Database Password</label>
                    <div class="password-wrapper">
                        <input type="password" name="db_password" id="edit_db_password" class="form-control password-input" value="<?php echo e($subdomain->db_password ?? (optional($subdomain->hostingAccess)->db_password ?? '')); ?>" required>
                        <span class="toggle-password" onclick="togglePassword('edit_db_password', 'icon_edit_db')">
                            <i class="fa-solid fa-eye" id="icon_edit_db"></i>
                        </span>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label>Lokasi Aplikasi (Path)</label>
                    <input type="text" name="app_path" class="form-control" value="<?php echo e($subdomain->app_path ?? (optional($subdomain->hostingAccess)->app_path ?? '')); ?>" required>
                </div>

                <div class="action-wrapper mt-4">
                    <button type="submit" class="btn btn-primary" style="background-color: #2563eb; color: #fff; border: none; padding: 10px 20px; border-radius: 6px; font-weight: 600; cursor: pointer;">Simpan Perubahan</button>
                </div>
            </form>
        </div>

    <?php elseif($subdomain->status == 'rejected'): ?>
        
        <div class="detail-wrapper" style="border-left: 5px solid #dc2626;">
            <h3 style="color: #dc2626;"><i class="fa-solid fa-circle-xmark"></i> Ringkasan Hasil Penolakan Permohonan</h3>
            <p style="font-size: 14px; color: #475569; margin-bottom: 15px;">Permohonan sub domain ini telah ditolak oleh administrator. Berikut informasi penolakan:</p>
            
            <table class="table table-bordered" style="box-shadow: none; margin-bottom: 5px;">
                <tr style="background-color: #f8fafc;">
                    <th style="width: 30%; background-color: #64748b;">Status Akhir</th>
                    <td style="font-weight: bold; color: #dc2626;">REJECTED (DITOLAK)</td>
                </tr>
                <tr>
                    <th style="background-color: #64748b; color: #fff;">Alasan Penolakan Resmi</th>
                    <td style="background-color: #fff5f5; color: #b91c1c; font-weight: 500; line-height: 1.5;">
                        <?php echo e($subdomain->alasan_tolak ?? 'Tidak ada alasan spesifik yang diisi oleh admin.'); ?>

                    </td>
                </tr>
                <tr>
                    <th style="background-color: #64748b; color: #fff;">Notifikasi Pengguna</th>
                    <td><i class="fa-solid fa-envelope" style="color: #2563eb;"></i> Surat pemberitahuan penolakan sistem otomatis telah dikirimkan ke email penanggung jawab teknis (<code><?php echo e($subdomain->email_teknis); ?></code>).</td>
                </tr>
            </table>

            <div class="action-wrapper mt-4">
                <a href="<?php echo e(route('admin.subdomain.index')); ?>" class="btn btn-secondary">Kembali ke Daftar Layanan</a>
            </div>
        </div>
    <?php else: ?>
        <div class="action-wrapper mt-2">
            <a href="<?php echo e(route('admin.subdomain.index')); ?>" class="btn btn-secondary">
                Kembali ke Daftar Layanan
            </a>
        </div>
    <?php endif; ?>

</div>


<div class="reject-modal" id="approveModal">
    <div class="reject-content" style="max-width: 500px; text-align: center;">
        <div class="reject-header" style="justify-content: center; position: relative;">
            <h3 style="color: #198754;"><i class="fa-solid fa-circle-check fa-2x d-block mb-2"></i><br>Konfirmasi Persetujuan</h3>
            <span class="close-btn" onclick="closeApproveModal()" style="position: absolute; right: 0; top: -5px;">&times;</span>
        </div>
        
        <div style="margin-top: 15px; text-align: left; background: #f8fafc; padding: 15px; border-radius: 10px; font-size: 14px; border: 1px solid #e2e8f0;">
            <p style="margin-bottom: 8px; color:#1B3B5F; font-weight: bold;">Anda akan menyetujui pendaftaran subdomain dengan parameter berikut:</p>
            <div style="line-height: 1.8;">
                <strong>Subdomain:</strong> <code><?php echo e($subdomain->nama_sub_domain); ?></code><br>
                <strong>Organisasi:</strong> <?php echo e($subdomain->nama_organisasi); ?><br>
                <strong>IP Server:</strong> <span id="md_ip_server"></span><br>
                <strong>User SSH:</strong> <span id="md_ssh_user"></span><br>
                <strong>Password SSH:</strong> <span id="md_ssh_password">******</span><br>
                <strong>Database Name:</strong> <span id="md_db_name"></span><br>
                <strong>Database User:</strong> <span id="md_db_user"></span><br>
                <strong>Database Password:</strong> <span id="md_db_password">******</span><br>
                <strong>Lokasi Aplikasi (Path):</strong> <span id="md_app_path"></span><br>
                <strong>Email Tujuan:</strong> <code><?php echo e($subdomain->email_teknis); ?></code>
            </div>
        </div>

        <p class="mt-3" style="font-size: 13.5px; color: #64748b; line-height: 1.5;">
            Sistem secara otomatis akan mengubah status menjadi <strong>Active</strong> dan langsung mengirimkan rincian akun hosting di atas ke alamat email teknis pemohon.
        </p>

        <div class="action-wrapper mt-4" style="justify-content: center;">
            <button type="button" class="btn btn-success" onclick="submitApproveForm()" style="background-color: #198754; padding: 12px 25px;">Ya, Setujui & Kirim</button>
            <button type="button" class="btn btn-secondary" onclick="closeApproveModal()" style="padding: 12px 25px;">Batal</button>
        </div>
    </div>
</div>


<div class="reject-modal" id="rejectModal">
    <div class="reject-content">
        <div class="reject-header">
            <h3>Alasan Penolakan</h3>
            <span class="close-btn" onclick="closeRejectModal()">&times;</span>
        </div>

        <form action="<?php echo e(route('admin.subdomain.reject', $subdomain->id)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label>Masukkan alasan penolakan</label>
                <textarea name="alasan_tolak" class="form-control" rows="5" placeholder="Contoh: Berkas persyaratan teknis tidak valid atau nama subdomain melanggar aturan..." required></textarea>
            </div>

            <div class="action-wrapper mt-4">
                <button type="submit" class="btn btn-danger">Kirim Penolakan</button>
                <button type="button" class="btn btn-secondary" onclick="closeRejectModal()">Batal</button>
            </div>
        </form>
    </div>
</div>

<style>
/* ================= GLOBAL WRAPPER ================= */
.admin-wrapper { max-width: 1200px; margin: 20px auto; padding: 20px; background: #f9f9f9; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
.page-title { font-size: 1.8rem; margin-bottom: 25px; color: #1B3B5F; text-align: center; font-weight: 600; }
/* ================= DETAIL WRAPPER ================= */
.detail-wrapper { background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); margin-bottom: 25px; }
.detail-wrapper h3 { font-size: 18px; margin-bottom: 15px; color: #1B3B5F; font-weight: 600; }
.detail-wrapper h5 { margin-top: 25px; margin-bottom: 10px; font-size: 16px; color: #1B3B5F; font-weight: 600; }
/* ================= DETAIL LIST ================= */
.detail-list { list-style-type: none; padding-left: 20px; margin-bottom: 15px; display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 10px; }
.detail-list li { padding: 6px 0; font-size: 14px; color: #1B3B5F; }
/* ================= TABLE ================= */
.table { width: 100%; border-collapse: collapse; margin-bottom: 20px; background: #fff; border-radius: 6px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
.table th, .table td { padding: 12px 15px; text-align: left; border: 1px solid #e2e8f0; }
.table th { background-color: #2563eb; color: #fff; font-weight: 600; }
.table tr:nth-child(even) { background-color: #f4f6f8; }
.table tr:hover { background-color: #e0e7ff; }
/* ================= FORM INPUT ================= */
.form-group input, .form-group textarea { width: 100%; padding: 12px 16px; border-radius: 10px; border: 1px solid #cbd5e1; font-size: 14px; background-color: #fff; box-sizing: border-box; transition: all 0.3s ease; height: 44px; }
.form-group textarea { height: auto; min-height: 120px; resize: vertical; }
.form-group input:focus, .form-group textarea:focus { outline: none; border-color: #1B3B5F; box-shadow: 0 0 0 2px rgba(27,59,95,0.15); background-color: #fefefe; }
.form-group label { display: block; font-size: 14px; font-weight: 500; margin-bottom: 6px; color: #1B3B5F; }
/* ================= PASSWORD ================= */
.password-wrapper { position: relative; }
.password-input { padding-right: 50px !important; }
.toggle-password { position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #64748b; font-size: 16px; z-index: 5; }
.toggle-password:hover { color: #1B3B5F; }
/* ================= BUTTONS ================= */
.action-wrapper { display: flex; gap: 10px; flex-wrap: wrap; margin-top: 20px; }
.action-wrapper .btn { padding: 10px 20px; border-radius: 6px; font-weight: 600; transition: all 0.3s ease; cursor: pointer; text-decoration: none; text-align: center; display: inline-block; }
.btn-success { background-color: #1B3B5F; color: #fff; border: none; }
.btn-success:hover { background-color: #163447; }
.btn-danger { background-color: #dc2626; color: #fff; border: none; }
.btn-danger:hover { background-color: #b91c1c; }
.btn-secondary { background-color: #6b7280; color: #fff; border: none; }
.btn-secondary:hover { background-color: #4b5563; }
/* ================= BADGE ================= */
.badge { display: inline-block; padding: 5px 10px; border-radius: 10px; font-size: 12px; font-weight: 600; }
/* ================= MODAL ================= */
.reject-modal { display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); justify-content: center; align-items: center; padding: 20px; }
.reject-content { background: #fff; width: 100%; max-width: 550px; border-radius: 14px; padding: 25px; animation: modalFade 0.3s ease; }
.reject-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
.reject-header h3 { margin: 0; color: #1B3B5F; }
.close-btn { font-size: 28px; cursor: pointer; color: #64748b; }
.close-btn:hover { color: #dc2626; }
@keyframes modalFade { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
/* ================= RESPONSIVE ================= */
@media screen and (max-width: 992px) { .table th, .table td { padding: 8px 10px; font-size: 0.85rem; } }
@media screen and (max-width: 600px) { .admin-wrapper { padding: 15px; } .action-wrapper { flex-direction: column; } .action-wrapper .btn { width: 100%; } .detail-list { grid-template-columns: 1fr; } .table { font-size: 0.8rem; } }
</style>

<script>
function openRejectModal() { document.getElementById('rejectModal').style.display = 'flex'; }
function closeRejectModal() { document.getElementById('rejectModal').style.display = 'none'; }

/* JAVASCRIPT LOGIC UNTUK HANDLING POP-UP MODAL APPROVE (NEW CODE) */
function openApproveModal() {
    const form = document.getElementById('approveSubdomainForm');
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }

    // Mengambil value input secara realtime dan menampilkannya ke konfirmasi modal
    document.getElementById('md_ip_server').innerText = document.getElementById('form_ip_server').value;
    document.getElementById('md_ssh_user').innerText = document.getElementById('form_ssh_user').value;
    document.getElementById('md_db_name').innerText = document.getElementById('form_db_name').value;
    document.getElementById('md_db_user').innerText = document.getElementById('form_db_user').value;
    document.getElementById('md_app_path').innerText = document.getElementById('form_app_path').value;

    document.getElementById('approveModal').style.display = 'flex';
}

function closeApproveModal() {
    document.getElementById('approveModal').style.display = 'none';
}

function submitApproveForm() {
    document.getElementById('approveSubdomainForm').submit();
}

window.onclick = function(event) {
    const rejectModal = document.getElementById('rejectModal');
    const approveModal = document.getElementById('approveModal');
    if (event.target === rejectModal) {
        closeRejectModal();
    }
    if (event.target === approveModal) {
        closeApproveModal();
    }
}

function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    } else {
        input.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
}

/* ??? BARU TAMBAHAN: FUNGSI JAVASCRIPT UNTUK INTIP PASSWORD PADA TABEL RINGKASAN DATA */
function toggleSummaryText(textId, hiddenId, iconId) {
    const textSpan = document.getElementById(textId);
    const hiddenSpan = document.getElementById(hiddenId);
    const icon = document.getElementById(iconId);
    
    if (textSpan.innerText === "******") {
        textSpan.innerText = hiddenSpan.innerText;
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    } else {
        textSpan.innerText = "******";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('operator.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/hitspbiz/public_html/HITSP/resources/views/admin/detailhosting.blade.php ENDPATH**/ ?>