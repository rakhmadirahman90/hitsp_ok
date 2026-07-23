<?php $__env->startSection('content'); ?>

<link rel="stylesheet" href="<?php echo e(asset('css/user/emaillembaga.css')); ?>">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
/* =========================
    GLOBAL WRAPPER
========================= */
.form-wrapper{
    max-width: 900px;
    margin: 40px auto;
    background: #fff;
    padding: 30px;
    border-radius: 14px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    font-family: 'Poppins', sans-serif;
}

/* TITLE */
.form-title{
    text-align:center;
    font-size:26px;
    font-weight:700;
    margin-bottom:5px;
    color:#111827;
}

.form-subtitle{
    text-align:center;
    font-size:14px;
    color:#6b7280;
    margin-bottom:25px;
}

/* SECTION */
.form-section{
    margin-bottom:25px;
    padding:20px;
    border:1px solid #eee;
    border-radius:12px;
    background:#fafafa;
}

.form-section h3{
    font-size:16px;
    margin-bottom:15px;
    color:#1f2937;
    border-left:4px solid #B45309;
    padding-left:10px;
}

/* FORM GROUP */
.form-group{
    margin-bottom:15px;
    display:flex;
    flex-direction:column;
}

.form-group label{
    font-size:13px;
    margin-bottom:6px;
    color:#374151;
    font-weight:600;
}

.form-group input{
    padding:10px 12px;
    border:1px solid #d1d5db;
    border-radius:8px;
    outline:none;
    transition:0.2s;
    font-size:14px;
}

.form-group input:focus{
    border-color:#B45309;
    box-shadow:0 0 0 3px rgba(180,83,9,0.15);
}

/* EMAIL INLINE */
.email-inline{
    display:flex;
    align-items:center;
    gap:10px;
}

.email-inline span{
    background:#f3f4f6;
    padding:10px;
    border-radius:8px;
    font-size:13px;
    color:#374151;
}

/* CHECKBOX */
.form-checkbox{
    display:flex;
    align-items:center;
    gap:10px;
    margin-top:10px;
}

/* NOTE */
.form-note-list{
    background:#f9f9f9;
    border-left:4px solid #B45309;
    padding:15px 20px;
    margin-top:15px;
    border-radius:8px;
    font-size:14px;
    line-height:1.6;
    color:#333;
}

.form-note-list li{
    margin-bottom:10px;
}

/* BUTTON */
.form-action{
    text-align:center;
    margin-top:20px;
}

.form-action button{
    background:#B45309;
    color:#fff;
    border:none;
    padding:12px 25px;
    border-radius:10px;
    font-size:15px;
    cursor:pointer;
    transition:0.3s;
}

.form-action button:hover{
    background:#92400e;
    transform:translateY(-1px);
}

/* ERROR */
.invalid-feedback-custom{
    color:#dc3545;
    font-size:12px;
    margin-top:5px;
}

/* MEWARNAI INPUT JIKA LOCK KONDISI READONLY/DISABLED */
input[readonly], input:disabled, checkbox:disabled {
    background-color: #f3f4f6 !important;
    color: #6b7280 !important;
    cursor: not-allowed !important;
}
.form-action button:disabled {
    background-color: #9ca3af !important;
    cursor: not-allowed !important;
    transform: none !important;
}

/* MODAL AKSES TERKUNCI CUSTOM STYLING MENGIKUTI SCREENSHOT */
.swal-lock-title {
    font-family: 'Poppins', sans-serif !important;
    font-weight: 700 !important;
    color: #4b5563 !important;
    font-size: 26px !important;
}
.swal-lock-html {
    font-family: 'Poppins', sans-serif !important;
    color: #4b5563 !important;
    font-size: 15px !important;
    line-height: 1.6 !important;
}
.swal-lock-btn {
    padding: 10px 32px !important;
    font-size: 15px !important;
    font-weight: 600 !important;
    border-radius: 6px !important;
}
</style>

<div class="form-wrapper">

    <h2 class="form-title">Formulir Permohonan</h2>
    <p class="form-subtitle">Pembuatan Akun Email Non-Pribadi</p>

    
    <?php
        $statusClean = (isset($email) && isset($email->status)) ? strtolower(trim($email->status)) : null;
        $isLocked = false;
        
        // Form otomatis terkunci jika status pending, disetujui/active, maupun ditolak/rejected
        if(in_array($statusClean, ['pending', 'disetujui', 'approved', 'active', 'ditolak', 'rejected'])) {
            $isLocked = true;
        }
    ?>

    
    <?php if($errors->any()): ?>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Data Tidak Valid',
                    html: '<?php echo implode("<br>", $errors->all()); ?>',
                });
            });
        </script>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('email-lembaga.store')); ?>" id="emailForm">
        <?php echo csrf_field(); ?>

        <div class="form-section">
            <h3>A. Data Pemohon</h3>

            <div class="form-group">
                <label>Nama Institusi *</label>
                <input 
                    type="text" 
                    name="nama_institusi" 
                    value="<?php echo e(old('nama_institusi', $email->nama_institusi ?? '')); ?>" 
                    placeholder="Masukkan nama institusi"
                    pattern="[A-Za-z\s.,'-]+"
                    oninput="this.value=this.value.replace(/[^A-Za-z\s.,'-]/g,'')"
                    <?php echo e($isLocked ? 'readonly' : ''); ?>

                    required>
            </div>

            <div class="form-group">
                <label>Nama Kegiatan</label>
                <input 
                    type="text" 
                    name="nama_kegiatan" 
                    value="<?php echo e(old('nama_kegiatan', $email->nama_kegiatan ?? '')); ?>" 
                    placeholder="Masukkan nama kegiatan"
                    pattern="[A-Za-z\s.,'-]+"
                    oninput="this.value=this.value.replace(/[^A-Za-z\s.,'-]/g,'')"
                    <?php echo e($isLocked ? 'readonly' : ''); ?>>
            </div>

            <div class="form-group email-group">
                <label>Nama Akun yang Diminta *</label>

                <div class="email-inline">
    <input
        type="text"
        name="nama_akun"
        id="nama_akun"
        value="<?php echo e(old('nama_akun', $email->nama_akun ?? '')); ?>"
        placeholder="Masukkan nama akun"
        minlength="2"
        maxlength="15"
        pattern="^[A-Za-z0-9][A-Za-z0-9._-]{0,13}[A-Za-z0-9]$"
        <?php echo e($isLocked ? 'readonly' : ''); ?>

        required>

    <span><?php echo e(auth()->user()->institution_domain ?? 'institusi'); ?>.ac.id</span>
</div>
                <small style="color: #666;"></small>
            </div>

            <div class="form-group">
                <label>Email Alternatif *</label>
                <input 
                    type="email" 
                    name="email_alternatif" 
                    id="email_alternatif" 
                    value="<?php echo e(old('email_alternatif', $email->email_alternatif ?? $teknis['email_alternatif'] ?? '')); ?>" 
                    placeholder="contoh@gmail.com"
                    <?php echo e($isLocked ? 'readonly' : ''); ?>

                    required>
            </div>
        </div>

        <div class="form-section">
            <h3>B. Penanggung Jawab Teknis</h3>

            <div class="form-group">
                <label>Nama Lengkap *</label>
                <input 
                    type="text" 
                    name="nama_teknis" 
                    value="<?php echo e(old('nama_teknis', $email->nama_teknis ?? $teknis['nama_teknis'] ?? '')); ?>"
                    placeholder="Masukkan nama lengkap"
                    pattern="[A-Za-z\s.,'-]+"
                    oninput="this.value=this.value.replace(/[^A-Za-z\s.,'-]/g,'')"
                    <?php echo e($isLocked ? 'readonly' : ''); ?>

                    required>
            </div>

            <div class="form-group">
                <label>NIP/NIK/NIM *</label>
                <input 
                    type="text" 
                    name="nip_nik_nim_teknis" 
                    value="<?php echo e(old('nip_nik_nim_teknis', $email->nip_nik_nim_teknis ?? $teknis['nip_nik_nim_teknis'] ?? '')); ?>" 
                    minlength="8"
                    maxlength="18"
                    inputmode="numeric"
                    pattern="[0-9]+"
                    placeholder="Masukkan NIP/NIK/NIM"
                    oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,18)"
                    <?php echo e($isLocked ? 'readonly' : ''); ?>

                    required>
            </div>

            <div class="form-group">
                <label>Jabatan *</label>
                <input 
                    type="text" 
                    name="jabatan_teknis" 
                    value="<?php echo e(old('jabatan_teknis', $email->jabatan_teknis ?? '')); ?>"
                    placeholder="Masukkan jabatan"
                    pattern="[A-Za-z\s.,'-]+"
                    oninput="this.value=this.value.replace(/[^A-Za-z\s.,'-]/g,'')"
                    <?php echo e($isLocked ? 'readonly' : ''); ?>

                    required>
            </div>

            <div class="form-group">
                <label>Status *</label>
                <input 
                    type="text" 
                    name="status_teknis" 
                    value="<?php echo e(old('status_teknis', $email->status_teknis ?? '')); ?>"
                    placeholder="Contoh: Dosen / Staf / Mahasiswa"
                    pattern="[A-Za-z\s.,'-]+"
                    oninput="this.value=this.value.replace(/[^A-Za-z\s.,'-]/g,'')"
                    <?php echo e($isLocked ? 'readonly' : ''); ?>

                    required>
            </div>

            <div class="form-group">
                <label>No Telepon *</label>
                <input 
                    type="text"
                    name="telp_teknis"
                    value="<?php echo e(old('telp_teknis', $email->telp_teknis ?? '')); ?>"
                    minlength="8"
                    maxlength="12"
                    inputmode="numeric"
                    pattern="^[0-9]{8,12}$"
                    placeholder="Masukkan nomor telepon"
                    oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,12); this.setCustomValidity('')"
                    oninvalid="this.setCustomValidity('Nomor telepon harus 8 sampai 12 digit angka')"
                    <?php echo e($isLocked ? 'readonly' : ''); ?>

                    required>
            </div>
        </div>

        <div class="form-section">
            <h3>C. Penanggung Jawab Administratif</h3>

            <div class="form-group">
                <label>Nama *</label>
                <input 
                    type="text" 
                    name="nama_admin" 
                    value="<?php echo e(old('nama_admin', $email->nama_admin ?? $admin['nama_admin'] ?? '')); ?>" 
                    placeholder="Masukkan nama lengkap"
                    pattern="[A-Za-z\s.,'-]+"
                    oninput="this.value=this.value.replace(/[^A-Za-z\s.,'-]/g,'')"
                    <?php echo e($isLocked ? 'readonly' : ''); ?>

                    required>
            </div>

            <div class="form-group">
                <label>NIP / NIK *</label>
                <input 
                    type="text" 
                    name="nip_admin" 
                    value="<?php echo e(old('nip_admin', $email->nip_admin ?? $admin['nip_admin'] ?? '')); ?>" 
                    minlength="8"
                    maxlength="18"
                    inputmode="numeric"
                    pattern="[0-9]+"
                    placeholder="Masukkan NIP / NIK"
                    oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,18)"
                    <?php echo e($isLocked ? 'readonly' : ''); ?>

                    required>
            </div>

            <div class="form-group">
                <label>Jabatan *</label>
                <input 
                    type="text" 
                    name="jabatan_admin" 
                    value="<?php echo e(old('jabatan_admin', $email->jabatan_admin ?? $admin['jabatan_admin'] ?? '')); ?>" 
                    placeholder="Masukkan jabatan"
                    pattern="[A-Za-z\s.,'-]+"
                    oninput="this.value=this.value.replace(/[^A-Za-z\s.,'-]/g,'')"
                    <?php echo e($isLocked ? 'readonly' : ''); ?>

                    required>
            </div>

            <div class="form-group">
                <label>No Telepon *</label>
                <input 
                    type="text"
                    name="telp_admin"
                    value="<?php echo e(old('telp_admin', $email->telp_admin ?? $admin['telp_admin'] ?? '')); ?>" 
                    minlength="8"
                    maxlength="12"
                    inputmode="numeric"
                    pattern="^[0-9]{8,12}$"
                    placeholder="Masukkan nomor telepon"
                    oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,12); this.setCustomValidity('')"
                    oninvalid="this.setCustomValidity('Nomor telepon harus 8 sampai 12 digit angka')"
                    <?php echo e($isLocked ? 'readonly' : ''); ?>

                    required>
            </div>
        </div>

        <div class="form-section">
            <h3>Persetujuan</h3>

            <p class="agreement-text">
                Dengan ini saya menyatakan data di atas benar dan menyetujui aturan layanan yang berlaku di lingkungan UPT TIK.
            </p>

            <div class="form-checkbox">
                <input type="checkbox" name="agreement" id="agreement" value="1" <?php echo e($isLocked ? 'disabled checked' : ''); ?> required>
                <label for="agreement">Saya setuju dengan ketentuan berlaku</label>
            </div>
        </div>

        <div class="form-section">
            <h3>Catatan / Panduan Pengisian</h3>

            <ol class="form-note-list">
                <li>Nama Institusi adalah nama lembaga yang mengajukan permohonan email.</li>
                <li>Nama Kegiatan harus diisi jika email yang diajukan untuk keperluan kegiatan tertentu.</li>
                <li>Nama akun minimal 2 karakter, maksimal 15 karakter. Karakter yang diperbolehkan adalah huruf, angka, underscore (_), minus (-), dan dot (.).</li>
                <li>Password awal akan dikirim ke <b>Email Alternatif</b>.</li>
                <li>Segala kendala dapat ditanyakan melalui <a href="mailto:tik@institusi.ac.id">tik@institusi.ac.id</a>.</li>
            </ol>
        </div>

        <div class="form-action">
            <button type="submit" id="btnSubmit" <?php echo e($isLocked ? 'disabled' : ''); ?>>
                Kirim Permohonan
            </button>
        </div>

    </form>
</div>

<script>
document.addEventListener("DOMContentLoaded",function(){

    <?php if(session('success')): ?>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil Terkirim!',
            text: 'Formulir permohonan email lembaga berhasil terkirim. Silakan menunggu proses verifikasi oleh admin.',
            confirmButtonColor: '#3085d6'
        });
    <?php endif; ?>

    <?php if(session('error')): ?>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '<?php echo e(session("error")); ?>',
            confirmButtonColor: '#d33'
        });
    <?php endif; ?>

    const statusClean = "<?php echo e($statusClean); ?>";
    const isFormLocked = <?php echo e($isLocked ? 'true' : 'false'); ?>;
    
    // ================= KODE BARU: MODAL NOTIFIKASI AKSES TERKUNCI (FULL MODAL ALERT) =================
    if (isFormLocked && !<?php echo e(session('success') ? 'true' : 'false'); ?>) {
        
        let msgTitle = 'Akses Terkunci';
        let msgHtml = 'Mohon maaf anda sdh tdk bisa lagi mngirim menggunakan akun anda karena sudah terdaftar/tercatat.'; // Default text bawaan system
        let alertIcon = 'info';
        let iconColor = '#38bdf8';

        if (statusClean === 'disetujui' || statusClean === 'approved' || statusClean === 'active') {
            msgHtml = 'Selamat! Akun email lembaga Anda telah berhasil dibuat. Silakan cek kotak masuk Email Alternatif Anda untuk informasi password awal.<br><br><b style="color:#dc2626;">[SISTEM DIKUNCI]</b> Anda sudah memiliki akun email lembaga aktif.';
        } else if (statusClean === 'pending') {
            msgHtml = 'Permohonan Anda sedang dalam antrean verifikasi oleh UPT TIK. Silakan tunggu informasi berikutnya.';
            alertIcon = 'warning';
            iconColor = '#f59e0b';
        } else if (statusClean === 'ditolak' || statusClean === 'rejected') {
            let alasan = "<?php echo e($email->alasan_tolak ?? 'uuguyyyyyyyyyyyyyyyyyyyy'); ?>";
            msgHtml = 'Mohon maaf anda sdh tdk bisa lagi mngirim menggunakan akun anda karena permohonan Anda <b>Ditolak</b>.<br><br><b style="color:#dc2626;">Alasan Penolakan:</b><br><span style="display:block; padding:10px; background:#fef2f2; border:1px solid #fee2e2; border-radius:6px; margin-top:5px; color:#991b1b; font-family:monospace; word-break:break-all;">' + alasan + '</span>';
            alertIcon = 'error';
            iconColor = '#ef4444';
        }

        // Memanggil SweetAlert Akses Terkunci Center Modal
        Swal.fire({
            title: msgTitle,
            html: msgHtml,
            icon: alertIcon,
            iconColor: iconColor,
            confirmButtonText: 'OK',
            confirmButtonColor: '#16a34a',
            allowOutsideClick: false,
            allowEscapeKey: false,
            customClass: {
                title: 'swal-lock-title',
                htmlContainer: 'swal-lock-html',
                confirmButton: 'swal-lock-btn'
            }
        });
    }

    if (!isFormLocked) {

        function onlyText(selector){
            const el = document.querySelector(selector);
            if(el){
                el.addEventListener('keypress',function(e){
                    if(!/[a-zA-Z\s.,'-]/.test(e.key)){
                        e.preventDefault();
                    }
                });
                el.addEventListener('input',function(){
                    this.value = this.value.replace(/[^A-Za-z\s.,'-]/g,'');
                });
            }
        }

        function onlyNumber(selector,max){
            const el = document.querySelector(selector);
            if(el){
                el.addEventListener('keypress',function(e){
                    if(!/[0-9]/.test(e.key)){
                        e.preventDefault();
                    }
                });
                el.addEventListener('input',function(){
                    this.value = this.value.replace(/[^0-9]/g,'').slice(0,max);
                });
            }
        }

        onlyText('[name="nama_institusi"]');
        onlyText('[name="nama_kegiatan"]');
        onlyText('[name="nama_teknis"]');
        onlyText('[name="nama_admin"]');
        onlyText('[name="jabatan_teknis"]');
        onlyText('[name="status_teknis"]');
        onlyText('[name="jabatan_admin"]');

        onlyNumber('[name="nip_nik_nim_teknis"]',18);
        onlyNumber('[name="nip_admin"]',18);

        onlyNumber('[name="telp_teknis"]',12);
        onlyNumber('[name="telp_admin"]',12);

        document.getElementById("nama_akun").addEventListener("input",function(){
            this.value = this.value.replace(/[^A-Za-z0-9._-]/g,'').toLowerCase();
        });

    } // END IF LOCK

    function validEmail(email){
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    document.getElementById("emailForm").addEventListener("submit", function(e){
        e.preventDefault(); 

        if(isFormLocked) {
            Swal.fire({
                icon: 'error',
                title: 'Akses Ditolak',
                text: 'Formulir terkunci karena pengajuan Anda sebelumnya masih aktif/proses.'
            });
            return false;
        }

        let alt = document.getElementById('email_alternatif').value.trim();
        let nipTeknis = document.querySelector('[name="nip_nik_nim_teknis"]').value.trim();
        let agreement = document.getElementById('agreement').checked;
        let telpTeknis = document.querySelector('[name="telp_teknis"]').value.trim();
        let telpAdmin = document.querySelector('[name="telp_admin"]').value.trim();
        let telpRegex = /^[0-9]{8,12}$/;

        if(!validEmail(alt)){
            Swal.fire({
                icon:'error',
                title:'Email Tidak Valid',
                text:'Gunakan format contoh@gmail.com'
            });
            return false;
        }

        if(nipTeknis.length < 8){
            Swal.fire({
                icon:'error',
                title:'NIP/NIK/NIM Terlalu Pendek',
                text:'Minimal terdiri dari 8 digit'
            });
            return false;
        }

        if(!telpRegex.test(telpTeknis) || !telpRegex.test(telpAdmin)){
            Swal.fire({
                icon:'error',
                title:'Nomor Telepon Tidak Valid',
                text:'Nomor telepon harus 8 sampai 12 digit angka'
            });
            return false;
        }

        if(!agreement){
            Swal.fire({
                icon:'warning',
                title:'Persetujuan',
                text:'Anda harus menyetujui syarat dan ketentuan'
            });
            return false;
        }

        Swal.fire({
            title: 'Sedang Mengirim...',
            text: 'Mohon tunggu sebentar, permohonan Anda sedang diproses.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        let formData = new FormData(this);

        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (response.redirected) {
                window.location.href = response.url;
                return;
            }
            return response.text();
        })
        .then(html => {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil Terkirim!',
                text: 'Formulir permohonan email lembaga berhasil terkirim. Silakan menunggu proses verifikasi oleh admin.',
                confirmButtonColor: '#3085d6',
                allowOutsideClick: false
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.reload();
                }
            });
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Terjadi kesalahan sistem saat mengirimkan data formulir.',
                confirmButtonColor: '#d33'
            });
        });
    });
});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('user.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/hitspbiz/public_html/HITSP/resources/views/user/akunemaillembaga.blade.php ENDPATH**/ ?>