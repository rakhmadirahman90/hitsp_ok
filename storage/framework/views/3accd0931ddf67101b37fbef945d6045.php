<?php $__env->startSection('content'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/user/reqdomain.css')); ?>">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php
$user = Auth::user();

/* =========================
    DEFAULT ADMIN (AUTO FILL)
========================= */
$adminDefault = [
    'nama' => 'Budi Santoso',
    'nip' => '199008172014041001',
    'alamat_kantor' => 'Jl. Bau Massepe',
    'alamat_rumah' => 'Andi Makassau',
    'telp_kantor' => '042127899', // PERBAIKAN: Menghilangkan karakter () dan spasi agar lolos validasi regex angka murni di client-side
    'telp_rumah' => '089876789898',
    'email' => 'budisantoso@gmail.com'
];
?>

<div class="domain-wrapper">

<h2 class="form-title">Formulir Permohonan (WEB FORM)</h2>

<form id="domainForm" class="domain-form" action="<?php echo e(route('requestdomain.store')); ?>" method="POST">
<?php echo csrf_field(); ?>

<div class="section">
<h3>A. Data Sub Domain</h3>

<div class="form-group">
<label>Jenis Domain</label>
<select name="jenis_domain" required>
<option value="">-- Pilih Jenis Domain --</option>
<option value="Lembaga/Fakultas/Jurusan">Lembaga/Fakultas/Jurusan</option>
<option value="Unit Mahasiswa">Unit Mahasiswa</option>
<option value="Organisasi Mahasiswa">Organisasi Mahasiswa</option>
<option value="Lain-lain">Lain-lain</option>
</select>
</div>

<div class="form-group">
<label>Nama Organisasi</label>
<input type="text" name="nama_organisasi" required
placeholder="Masukkan nama organisasi"
pattern="[A-Za-z\s.,'-]+"
oninput="this.value=this.value.replace(/[^A-Za-z\s.,'-]/g,'')">
</div>

</div>

<div class="section">
<h3>B. Penanggung Jawab Administratif</h3>

<div class="form-group">
<label>Nama Lengkap</label>
<input type="text" name="nama_admin" required
value="<?php echo e($adminDefault['nama']); ?>"
pattern="[A-Za-z\s.,'-]+"
oninput="this.value=this.value.replace(/[^A-Za-z\s.,'-]/g,'')">
</div>

<div class="form-group">
<label>NIP</label>
<input type="text" name="nip_admin" required maxlength="18"
value="<?php echo e($adminDefault['nip']); ?>"
inputmode="numeric"
oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,18)">
</div>

<div class="form-group">
<label>Alamat Kantor</label>
<input type="text" name="alamat_kantor_admin" required
value="<?php echo e($adminDefault['alamat_kantor']); ?>">
</div>

<div class="form-group">
<label>Alamat Rumah</label>
<input type="text" name="alamat_rumah_admin" required
value="<?php echo e($adminDefault['alamat_rumah']); ?>">
</div>

<div class="form-row">

<div class="form-group">
<label>Telepon Kantor</label>
<input type="text" name="telp_kantor_admin" required maxlength="12"
value="<?php echo e($adminDefault['telp_kantor']); ?>"
inputmode="numeric"
oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,12)">
</div>

<div class="form-group">
<label>Telepon Rumah</label>
<input type="text" name="telp_rumah_admin" required maxlength="12"
value="<?php echo e($adminDefault['telp_rumah']); ?>"
inputmode="numeric"
oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,12)">
</div>

</div>

<div class="form-group">
<label>Email</label>
<input type="email" name="email_admin" id="email_admin" required
value="<?php echo e($adminDefault['email']); ?>">
</div>

</div>

<div class="section">
<h3>C. Penanggung Jawab Teknis</h3>

<div class="form-group">
<label>Nama Lengkap</label>
<input type="text" name="nama_teknis"
value="<?php echo e($user->name); ?>"
pattern="[A-Za-z\s.,'-]+">
</div>

<div class="form-group">
<label>NIP / NIM</label>
<input type="text" name="nip_nim_teknis" maxlength="18"
value="<?php echo e($user->username); ?>"
inputmode="numeric"
oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,18)">
</div>

<div class="form-group">
<label>Email</label>
<input type="email" name="email_teknis"
value="<?php echo e($user->email); ?>">
</div>

<div class="form-group">
<label>Alamat Kantor</label>
<input type="text" name="alamat_kantor_teknis">
</div>

<div class="form-group">
<label>Alamat Rumah</label>
<input type="text" name="alamat_rumah_teknis">
</div>

<div class="form-group">
<label>No Telepon</label>
<input type="text" name="telp_kantor_teknis" maxlength="12"
inputmode="numeric"
oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,12)">
</div>

</div>

<div class="section">
<h3>D. Nama Sub Domain yang Diminta</h3>

<div class="form-group">
<label>Sub Domain</label>
<input type="text" name="nama_sub_domain" required>
</div>

<div class="form-check">
<input type="checkbox" required>
<span>
Dengan ini saya menyatakan data diatas benar dan menyetujui seluruh aturan layanan hosting institusi.
</span>
</div>

</div>

<div class="form-action">
<button type="submit" class="btn-submit">KIRIM</button>
</div>

</form>
</div>




<?php if(session('success')): ?>
<script>
Swal.fire({
icon:'success',
title:'Berhasil!',
text:'<?php echo e(session("success")); ?>',
confirmButtonText:'OK'
});
</script>
<?php endif; ?>

<?php if(session('error')): ?>
<script>
Swal.fire({
icon:'error',
title:'Pengajuan Gagal',
text:'<?php echo e(session("error")); ?>',
confirmButtonText:'Saya Mengerti'
});
</script>
<?php endif; ?>

<?php if($errors->any()): ?>
<script>
Swal.fire({
icon:'error',
title:'Validasi Gagal',
text:'<?php echo e($errors->first()); ?>',
confirmButtonText:'Perbaiki Input'
});
</script>
<?php endif; ?>

<script>
document.addEventListener("DOMContentLoaded",function(){

// validasi huruf
document.querySelectorAll(
'input[name="nama_admin"],input[name="nama_teknis"],input[name="nama_organisasi"]'
).forEach(function(el){
el.addEventListener('keypress',function(e){
if(!/[a-zA-Z\s.,'-]/.test(e.key)){
e.preventDefault();
}
});
});

// validasi angka
document.querySelectorAll(
'input[name="nip_admin"],input[name="nip_nim_teknis"],input[name="telp_kantor_admin"],input[name="telp_rumah_admin"],input[name="telp_kantor_teknis"]'
).forEach(function(el){
el.addEventListener('keypress',function(e){
if(!/[0-9]/.test(e.key)){
e.preventDefault();
}
});
});

// validasi email
document.getElementById('domainForm').addEventListener('submit',function(e){

let emailAdmin=document.getElementById('email_admin').value.trim();
let emailTeknis=document.querySelector('input[name="email_teknis"]').value.trim();

let emailPattern=/^[^\s@]+@[^\s@]+\.[^\s@]+$/;

if(!emailPattern.test(emailAdmin)){
e.preventDefault();
Swal.fire({icon:'error',title:'Email Tidak Valid',text:'Email admin tidak valid'});
return false;
}

if(emailTeknis !== '' && !emailPattern.test(emailTeknis)){
e.preventDefault();
Swal.fire({icon:'error',title:'Email Tidak Valid',text:'Email teknis tidak valid'});
return false;
}

});

});
</script>

<style>
.domain-wrapper{
    max-width:950px;
    margin:40px auto;
    background:#f9fafb;
    padding:35px;
    border-radius:18px;
    box-shadow:0 10px 35px rgba(0,0,0,0.08);
    font-family:'Poppins',sans-serif;
}

.form-title{
    text-align:center;
    font-size:26px;
    font-weight:700;
    color:#0B2447;
    margin-bottom:35px;
}

.section{
    background:#fff;
    border:1px solid #e5e7eb;
    border-radius:16px;
    padding:28px;
    margin-bottom:28px;
}

.form-group{margin-bottom:18px;}
.form-group label{font-weight:600;}

.form-group input,
.form-group select{
    width:100%;
    height:50px;
    border:1px solid #d1d5db;
    border-radius:12px;
    padding:0 15px;
}

.form-row{display:flex;gap:20px;}

.form-check{
    display:flex;
    gap:12px;
    padding:15px;
    background:#fff7ed;
    border-radius:12px;
}

.form-action{text-align:right;}

.btn-submit{
    background:#D97706;
    color:#fff;
    border:none;
    padding:14px 40px;
    border-radius:999px;
    font-weight:700;
    cursor:pointer;
}
</style>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('user.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/hitspbiz/public_html/HITSP/resources/views/user/reqdomain.blade.php ENDPATH**/ ?>