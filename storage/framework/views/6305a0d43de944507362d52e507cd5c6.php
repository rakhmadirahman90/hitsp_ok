<?php $__env->startSection('content'); ?>

<link rel="stylesheet" href="<?php echo e(asset('css/user/reqzoom.css')); ?>">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php
$user = Auth::user();
?>

<div class="zoom-wrapper">
<h2 class="form-title">Formulir Pembuatan Link Zoom</h2>

<form action="<?php echo e(route('zoom.store')); ?>" method="POST" class="zoom-form" id="zoomForm">
<?php echo csrf_field(); ?>

<div class="form-group">
<label>Nama Lengkap</label>
<input
type="text"
name="nama"
id="nama"
required
maxlength="50"
value="<?php echo e($user->name); ?>"
placeholder="Masukkan nama lengkap">
</div>

<div class="form-group">
<label>NIP</label>
<input
type="text"
name="nip"
id="nip"
required
maxlength="18"
value="<?php echo e($user->username); ?>"
placeholder="Masukkan nip">
</div>

<div class="form-group">
<label>Unit / Jurusan</label>
<input
type="text"
name="unit"
required
placeholder="Contoh: Ilmu Komputer">
</div>

<div class="form-group">
<label>Jenis Kegiatan</label>
<input
type="text"
name="jenis_kegiatan"
required
placeholder="Contoh: Webinar Web Development">
</div>

<div class="form-group">
<label>Tanggal</label>
<input
type="date"
name="tanggal"
required
min="<?php echo e(date('Y-m-d')); ?>">
</div>

<div class="form-row">
<div class="form-group">
<label>Waktu Mulai</label>
<input
type="time"
name="waktu_mulai"
required>
</div>

<div class="form-group">
<label>Waktu Selesai</label>
<input
type="time"
name="waktu_selesai"
required>
</div>
</div>

<div class="form-group">
<label>Email</label>
<input
type="email"
name="email"
id="email"
required
value="<?php echo e($user->email); ?>"
placeholder="Masukkan alamat email"
pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">
</div>

<div class="form-group">
<label>Keterangan Tambahan</label>
<textarea
name="keterangan"
rows="4"
placeholder="Contoh: Memerlukan Zoom untuk seminar nasional dengan 100 peserta">
</textarea>
</div>

<button type="submit" class="btn-submit">
KIRIM
</button>

</form>
</div>

<?php if(session('success')): ?>
<script>
Swal.fire({
icon:'success',
title:'Berhasil!',
text:'<?php echo e(session("success")); ?>'
});
</script>
<?php endif; ?>


<script>

/* NAMA HANYA HURUF */
document.getElementById('nama').addEventListener('input', function(){
this.value=this.value.replace(/[^a-zA-Z\s]/g,'');
});


/* NIP HANYA ANGKA */
document.getElementById('nip').addEventListener('input', function(){
this.value=this.value.replace(/[^0-9]/g,'');
});


/* VALIDASI SAAT SUBMIT */
document.getElementById('zoomForm').addEventListener('submit', function(e){

let nama=document.getElementById('nama').value.trim();
let nip=document.getElementById('nip').value.trim();
let email=document.getElementById('email').value.trim();

let namaRegex=/^[A-Za-z\s]+$/;
let emailRegex=/^[^\s@]+@[^\s@]+\.[^\s@]+$/;

if(!namaRegex.test(nama)){
e.preventDefault();
Swal.fire('Error','Nama hanya boleh huruf','error');
return;
}

if(!/^\d+$/.test(nip)){
e.preventDefault();
Swal.fire('Error','NIP hanya boleh angka','error');
return;
}

if(!emailRegex.test(email)){
e.preventDefault();
Swal.fire('Error','Email tidak valid','error');
return;
}

});

</script>

<style>
/* =========================
   WRAPPER
========================= */
.zoom-wrapper{
    max-width:900px;
    margin:40px auto;
    background:#f9f5f2;
    padding:35px;
    border-radius:18px;
    box-shadow:0 12px 35px rgba(0,0,0,0.08);
    border:1px solid #e5e7eb;
    font-family:'Poppins',sans-serif;
}

/* =========================
   TITLE
========================= */
.form-title{
    text-align:center;
    font-size:26px;
    font-weight:700;
    color:#0B2447;
    margin-bottom:35px;
    position:relative;
}

.form-title::after{
    content:'';
    width:90px;
    height:4px;
    background:#D97706;
    display:block;
    margin:12px auto 0;
    border-radius:999px;
}

/* =========================
   FORM
========================= */
.zoom-form{
    display:flex;
    flex-direction:column;
    gap:22px;
}

/* =========================
   FORM GROUP
========================= */
.form-group{
    display:flex;
    flex-direction:column;
}

.form-group label{
    font-size:14px;
    font-weight:600;
    color:#0B2447;
    margin-bottom:8px;
}

/* =========================
   INPUT & TEXTAREA
========================= */
.form-group input,
.form-group textarea{
    width:100%;
    border:1px solid #d1d5db;
    border-radius:12px;
    padding:14px 16px;
    font-size:14px;
    background:#ffffff;
    transition:all 0.25s ease;
    color:#111827;
}

.form-group input{
    height:50px;
}

.form-group textarea{
    resize:vertical;
    min-height:120px;
}

/* =========================
   FOCUS EFFECT
========================= */
.form-group input:focus,
.form-group textarea:focus{
    outline:none;
    border-color:#D97706;
    box-shadow:0 0 0 4px rgba(217,119,6,0.15);
}

/* =========================
   BUTTON
========================= */
.btn-submit{
    background:linear-gradient(135deg,#D97706,#b45309);
    color:#fff;
    border:none;
    padding:15px 20px;
    border-radius:999px;
    font-size:15px;
    font-weight:600;
    cursor:pointer;
    transition:0.3s ease;
}

.btn-submit:hover{
    transform:translateY(-2px);
    box-shadow:0 10px 25px rgba(180,83,9,0.25);
}

/* =========================
   RESPONSIVE
========================= */
@media(max-width:768px){
.zoom-wrapper{padding:22px;margin:20px;}
.form-title{font-size:22px;}
}
</style>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('user.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/hitspbiz/public_html/HITSP/resources/views/user/reqzoom.blade.php ENDPATH**/ ?>