<?php $__env->startSection('title', 'Form Registrasi Pengguna Hotspot'); ?>

<?php $__env->startSection('content'); ?>

<link rel="stylesheet" href="<?php echo e(asset('css/user/hotspot_form.css')); ?>">

<div class="form-wrapper">

    <h2 class="form-title">Form Registrasi Pengguna Hotspot</h2>

    
    <?php if($errors->any()): ?>
        <div style="background: #fee2e2; border: 1px solid #ef4444; color: #b91c1c; padding: 15px; border-radius: 10px; margin-bottom: 20px; font-size: 14px;">
            <ul style="margin: 0; padding-left: 20px;">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('hotspot.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>

        <div class="form-section">
            <h3>Data Pemohon</h3>
            <div class="form-group">
                <label>* Jenis Akun</label>
                <select name="akses" required>
                    <option value="">-- Pilih Jenis Akun --</option>
                    <option value="Lembaga" <?php echo e(old('akses') == 'Lembaga' ? 'selected' : ''); ?>>Lembaga/Fakultas/Jurusan</option>
                    <option value="Dosen" <?php echo e(old('akses') == 'Dosen' ? 'selected' : ''); ?>>Dosen</option>
                    <option value="Staf" <?php echo e(old('akses') == 'Staf' ? 'selected' : ''); ?>>Staf</option>
                    <option value="Mahasiswa" <?php echo e(old('akses') == 'Mahasiswa' ? 'selected' : ''); ?>>Mahasiswa</option>
                    <option value="Lain-lain" <?php echo e(old('akses') == 'Lain-lain' ? 'selected' : ''); ?>>Lain-lain</option>
                </select>
            </div>
        </div>

        <div class="form-section">
            <h3>* Pengguna / User Hotspot</h3>

            <div class="form-group">
                <label>* Nama Lengkap</label>
                <input 
                    type="text" 
                    name="nama_lengkap" 
                    value="<?php echo e(old('nama_lengkap', Auth::user()->name)); ?>"                    placeholder="Masukkan nama lengkap" 
                    pattern="[A-Za-z\s.,'-]+"
                    oninput="this.value=this.value.replace(/[^A-Za-z\s.,'-]/g,'')"
                    required>
            </div>

            <div class="form-row">

                <div class="form-group">
                    <label>* Jabatan</label>
                    <input 
                        type="text" 
                        name="jabatan" 
                        value="<?php echo e(old('jabatan')); ?>" 
                        placeholder="Masukkan jabatan"
                        pattern="[A-Za-z\s.,'-]+"
                        oninput="this.value=this.value.replace(/[^A-Za-z\s.,'-]/g,'')"
                        required>
                </div>

                <div class="form-group">
                    <label>* No Identitas (NIP/NIM)</label>
                    <input 
                        type="text" 
                        name="nip" 
                        value="<?php echo e(old('nip', Auth::user()->username)); ?>"
                        placeholder="Masukkan nip/nim"
                        maxlength="18"
                        inputmode="numeric"
                        pattern="[0-9]+"
                        oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,18)"
                        required>
                </div>

            </div>

            <div class="form-group">
                <label>* Jenis Permohonan Akun Hotspot</label>
                <select name="akun_hotspot" required>
                    <option value="">-- Pilih Jenis Permohonan --</option>
                    <option value="Pengguna Baru" <?php echo e(old('akun_hotspot') == 'Pengguna Baru' ? 'selected' : ''); ?>>Pengguna Baru</option>
                    <option value="Reset Password" <?php echo e(old('akun_hotspot') == 'Reset Password' ? 'selected' : ''); ?>>Reset Password</option>
                </select>
            </div>

            <div class="form-group">
                <label>* No Telepon / HP</label>
                <input 
                    type="text" 
                    name="no_telepon" 
                    value="<?php echo e(old('no_telepon')); ?>" 
                    placeholder="Masukkan no tlp"
                    maxlength="12"
                    inputmode="numeric"
                    pattern="[0-9]{8,12}"
                    oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,12); this.setCustomValidity('')"
                    oninvalid="this.setCustomValidity('Nomor telepon harus 8 sampai 12 digit angka')"
                    required>
            </div>

            <div class="form-group">
                <label>* Email</label>
                <input 
                    type="email" 
                    name="email" 
                    value="<?php echo e(old('email', Auth::user()->email)); ?>"
                    placeholder="Masukkan alamat email" 
                    required>
            </div>

        </div>

        <div class="form-section">
            <h3>* NAMA HOTSPOT YANG DIMINTA</h3>

            <div class="form-group">
                <label>* Nama Hotspot / WiFi</label>
                <input 
                    type="text" 
                    name="nama_hotspot" 
                    value="<?php echo e(old('nama_hotspot', 'Nama institusi/kampus')); ?>" 
                    placeholder="Masukkan nama institusi/kampus" 
                    required>
            </div>
        </div>

     <h3>* PENANGGUNG JAWAB Administratif</h3>

<div class="form-group">
    <label>* Nama</label>
    <input 
        type="text" 
        name="pj_nama" 
        value="<?php echo e(old('pj_nama', $adminDefault['pj_nama'])); ?>" 
        placeholder="Masukkan nama lengkap"
        pattern="[A-Za-z\s.,'-]+"
        oninput="this.value=this.value.replace(/[^A-Za-z\s.,'-]/g,'')"
        required>
</div>

<div class="form-row">

    <div class="form-group">
        <label>* NIP</label>
        <input 
            type="text" 
            name="pj_nip" 
            value="<?php echo e(old('pj_nip', $adminDefault['pj_nip'])); ?>" 
            placeholder="Masukkan nip"
            maxlength="18"
            inputmode="numeric"
            pattern="[0-9]+"
            oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,18)"
            required>
    </div>

    <div class="form-group">
        <label>* Jabatan</label>
        <input 
            type="text" 
            name="pj_jabatan" 
            value="<?php echo e(old('pj_jabatan', $adminDefault['pj_jabatan'])); ?>" 
            placeholder="Masukkan jabatan"
            pattern="[A-Za-z\s.,'-]+"
            oninput="this.value=this.value.replace(/[^A-Za-z\s.,'-]/g,'')"
            required>
    </div>

</div>

<div class="form-group">
    <label>* No Telepon / HP</label>
    <input 
        type="text" 
        name="pj_telepon" 
        value="<?php echo e(old('pj_telepon', $adminDefault['pj_telepon'])); ?>" 
        placeholder="Masukkan no tlp"
        maxlength="12"
        inputmode="numeric"
        pattern="[0-9]{8,12}"
        oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,12); this.setCustomValidity('')"
        oninvalid="this.setCustomValidity('Nomor telepon harus 8 sampai 12 digit angka')"
        required>
</div>
        </div>

        <div class="form-section">
            <h3>* PERSETUJUAN</h3>

            <p class="agreement-text">
                Dengan ini saya menyatakan bahwa data di atas benar dan
                bersedia mematuhi seluruh aturan layanan Hotspot institusi.
            </p>

            <div class="form-checkbox">
                <input type="checkbox" name="persetujuan" id="agree_check" required>
                <label for="agree_check">
                    Saya menyetujui pernyataan di atas
                </label>
            </div>

        </div>

        <div class="form-action">
            <button type="submit" id="btn_submit">
                KIRIM PERMOHONAN
            </button>
        </div>

    </form>
</div>
<style>

*{
    box-sizing:border-box;
}

body{
    background:#f3f4f6;
    font-family:'Poppins',sans-serif;
}

.form-wrapper{
    max-width:950px;
    margin:40px auto;
    background:#ffffff;
    padding:40px;
    border-radius:20px;
    box-shadow:0 10px 35px rgba(0,0,0,0.08);
}

.form-title{
    text-align:center;
    font-size:28px;
    font-weight:700;
    color:#1e3a8a;
    margin-bottom:35px;
}

.form-section{
    background:#f9fafb;
    padding:28px;
    border-radius:16px;
    margin-bottom:28px;
    border:1px solid #e5e7eb;
    transition:0.3s ease;
}

.form-section:hover{
    box-shadow:0 6px 18px rgba(0,0,0,0.05);
}

.form-section h3{
    font-size:16px;
    font-weight:700;
    color:#1e40af;
    margin-bottom:22px;
    padding-bottom:10px;
    border-bottom:2px solid #e5e7eb;
}

.form-group{
    margin-bottom:20px;
}

.form-group label{
    display:block;
    margin-bottom:8px;
    font-size:14px;
    font-weight:600;
    color:#374151;
}

.form-group input,
.form-group select{
    width:100%;
    height:52px;
    padding:0 16px;
    border:1px solid #d1d5db;
    border-radius:12px;
    font-size:14px;
    background:#fff;
    transition:all 0.3s ease;
}

.form-group input:focus,
.form-group select:focus{
    outline:none;
    border-color:#D97706;
    box-shadow:0 0 0 4px rgba(217,119,6,0.15);
    background:#fff;
}

.form-group input::placeholder{
    color:#9ca3af;
}

.form-row{
    display:flex;
    gap:20px;
}

.form-row .form-group{
    flex:1;
}

.agreement-text{
    font-size:14px;
    line-height:1.7;
    color:#4b5563;
    margin-bottom:18px;
}

.form-checkbox{
    display:flex;
    align-items:flex-start;
    gap:12px;
    margin-top:10px;
}

.form-checkbox input[type="checkbox"]{
    width:18px;
    height:18px;
    margin-top:2px;
    accent-color:#D97706;
    cursor:pointer;
}

.form-checkbox label{
    font-size:14px;
    color:#374151;
    line-height:1.5;
    cursor:pointer;
}

.form-action{
    text-align:right;
    margin-top:35px;
}

.form-action button{
    background:linear-gradient(135deg,#D97706,#b45309);
    color:#fff;
    border:none;
    padding:14px 40px;
    border-radius:999px;
    font-size:15px;
    font-weight:600;
    cursor:pointer;
    transition:all 0.3s ease;
    box-shadow:0 8px 20px rgba(217,119,6,0.25);
}

.form-action button:hover{
    transform:translateY(-2px);
    box-shadow:0 12px 24px rgba(217,119,6,0.35);
}

.form-action button:active{
    transform:scale(0.98);
}

@media(max-width:768px){

    .form-wrapper{
        padding:22px;
        margin:20px;
        border-radius:16px;
    }

    .form-title{
        font-size:22px;
        line-height:1.4;
    }

    .form-section{
        padding:20px;
    }

    .form-row{
        flex-direction:column;
        gap:0;
    }

    .form-action{
        text-align:center;
    }

    .form-action button{
        width:100%;
    }

}

</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function(){

    <?php if(session('success')): ?>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "<?php echo e(session('success')); ?>",
            showConfirmButton: true
        });
    <?php endif; ?>

    <?php if(session('error')): ?>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "<?php echo e(session('error')); ?>",
        });
    <?php endif; ?>

    function onlyLetters(selector){
        document.querySelectorAll(selector).forEach(function(input){

            input.addEventListener('keypress', function(e){
                let key = e.key;

                if(!/^[a-zA-Z\s.,'-]$/.test(key) && key !== "Backspace"){
                    e.preventDefault();
                }
            });

            input.addEventListener('input', function(){
                this.value=this.value.replace(/[^A-Za-z\s.,'-]/g,'');
            });

        });
    }

    onlyLetters(`
        input[name="nama_lengkap"],
        input[name="jabatan"],
        input[name="pj_nama"],
        input[name="pj_jabatan"]
    `);

    function onlyNumber(selector,maxLength){
        document.querySelectorAll(selector).forEach(function(input){

            input.addEventListener('keypress',function(e){

                let key=e.key;

                if(!/^[0-9]$/.test(key) && key!=="Backspace"){
                    e.preventDefault();
                }
            });

            input.addEventListener('input',function(){
                this.value=this.value.replace(/[^0-9]/g,'').slice(0,maxLength);
            });

        });
    }

    onlyNumber('input[name="nip"], input[name="pj_nip"]', 18);
    onlyNumber('input[name="no_telepon"], input[name="pj_telepon"]', 12);

    const emailInput = document.querySelector('input[name="email"]');

    emailInput.addEventListener('blur',function(){

        let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if(this.value.trim()!=='' && !emailRegex.test(this.value)){

            Swal.fire({
                icon:'error',
                title:'Email Tidak Valid',
                text:'Contoh format benar: nama@gmail.com'
            });

        }

    });

    document.querySelector('form').addEventListener('submit',function(e){

        let formData = new FormData(this);

        let nama = formData.get('nama_lengkap').trim();
        let jabatan = formData.get('jabatan').trim();
        let nip = formData.get('nip').trim();
        let telp = formData.get('no_telepon').trim();
        let pjNama = formData.get('pj_nama').trim();
        let pjNip = formData.get('pj_nip').trim();
        let pjTelp = formData.get('pj_telepon').trim();
        let email = formData.get('email').trim();
        let checkbox = document.getElementById('agree_check').checked;

        let huruf = /^[A-Za-z\s.,'-]+$/;
        let angka = /^[0-9]+$/;
        let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if(!nama || !jabatan || !nip || !telp || !pjNama || !pjNip || !pjTelp || !email){

            e.preventDefault();

            Swal.fire(
                'Error',
                'Semua kolom bertanda bintang (*) wajib diisi',
                'error'
            );

            return;
        }

        if(!huruf.test(nama)){
            e.preventDefault();
            Swal.fire('Error', 'Nama hanya boleh huruf', 'error');
            return;
        }

        if(!huruf.test(jabatan)){
            e.preventDefault();
            Swal.fire('Error', 'Jabatan hanya boleh huruf', 'error');
            return;
        }

        if(!huruf.test(pjNama)){
            e.preventDefault();
            Swal.fire('Error', 'Nama penanggung jawab hanya huruf', 'error');
            return;
        }

        if(!angka.test(nip)){
            e.preventDefault();
            Swal.fire('Error', 'NIP hanya boleh angka', 'error');
            return;
        }

        if(!angka.test(pjNip)){
            e.preventDefault();
            Swal.fire('Error', 'NIP penanggung jawab hanya angka', 'error');
            return;
        }

        if(!angka.test(telp)){
            e.preventDefault();
            Swal.fire('Error', 'Nomor telepon hanya angka', 'error');
            return;
        }

        if(telp.length < 8 || telp.length > 12){
            e.preventDefault();
            Swal.fire('Error', 'Nomor telepon harus 8 sampai 12 digit', 'error');
            return;
        }

        if(!angka.test(pjTelp)){
            e.preventDefault();
            Swal.fire('Error', 'Telepon penanggung jawab hanya angka', 'error');
            return;
        }

        if(pjTelp.length < 8 || pjTelp.length > 12){
            e.preventDefault();
            Swal.fire('Error', 'Telepon penanggung jawab harus 8 sampai 12 digit', 'error');
            return;
        }

        if(!emailRegex.test(email)){
            e.preventDefault();
            Swal.fire('Error', 'Format email tidak valid', 'error');
            return;
        }

        if(!checkbox){
            e.preventDefault();

            Swal.fire(
                'Persetujuan',
                'Anda harus menyetujui syarat dan ketentuan',
                'warning'
            );

            return;
        }

        Swal.fire({
            title: 'Sedang Memproses...',
            text: 'Mohon tunggu sebentar',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

    });

});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('user.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/hitspbiz/public_html/HITSP/resources/views/user/hotspot_saya.blade.php ENDPATH**/ ?>