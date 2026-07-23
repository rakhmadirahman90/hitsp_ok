<?php $__env->startSection('content'); ?>

<link rel="stylesheet" href="<?php echo e(asset('css/user/pengajuan.css')); ?>">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
/* =========================
   WRAPPER
========================= */
.form-wrapper{
max-width:950px;
margin:40px auto;
padding:40px;
border-radius:24px;
background:linear-gradient(
180deg,
#ffffff 0%,
#f8fafc 100%
);
box-shadow:
0 10px 25px rgba(15,23,42,.06),
0 20px 50px rgba(15,23,42,.08);
border:1px solid #e5e7eb;
font-family:'Poppins',sans-serif;
position:relative;
overflow:hidden;
}

/* DECORATION */
.form-wrapper::before{
content:'';
position:absolute;
top:-120px;
right:-120px;
width:260px;
height:260px;
background:rgba(217,119,6,.08);
border-radius:50%;
}

.form-wrapper::after{
content:'';
position:absolute;
bottom:-100px;
left:-100px;
width:220px;
height:220px;
background:rgba(59,130,246,.06);
border-radius:50%;
}

/* =========================
   TITLE
========================= */
.form-title{
text-align:center;
font-size:30px;
font-weight:700;
color:#0D2A54;
margin-bottom:35px;
position:relative;
z-index:2;
}

.form-title::after{
content:'';
display:block;
width:80px;
height:4px;
background:linear-gradient(
90deg,
#D97706,
#F59E0B
);
margin:12px auto 0;
border-radius:999px;
}

/* =========================
   FORM
========================= */
.laporan-form{
position:relative;
z-index:2;
}

.laporan-form label{
display:block;
font-size:13px;
font-weight:600;
color:#334155;
margin-bottom:8px;
}

/* =========================
   INPUT
========================= */
.laporan-form input,
.laporan-form select,
.laporan-form textarea{
width:100%;
padding:14px 16px;
border-radius:14px;
border:1px solid #dbe3ea;
background:#fff;
font-size:14px;
font-family:'Poppins',sans-serif;
margin-bottom:20px;
transition:all .25s ease;
box-shadow:0 2px 6px rgba(0,0,0,.03);
}

/* FOCUS EFFECT */
.laporan-form input:focus,
.laporan-form select:focus,
.laporan-form textarea:focus{
outline:none;
border-color:#D97706;
background:#fffdf9;
box-shadow:
0 0 0 4px rgba(217,119,6,.12),
0 8px 20px rgba(217,119,6,.08);
transform:translateY(-1px);
}

/* READONLY */
.laporan-form input[readonly]{
background:#f1f5f9;
cursor:not-allowed;
color:#64748b;
}

/* TEXTAREA */
.laporan-form textarea{
min-height:130px;
resize:vertical;
}

/* FILE */
.laporan-form input[type="file"]{
padding:12px;
background:#fff;
cursor:pointer;
}

/* =========================
   BUTTON
========================= */
.btn-kirim{
background:linear-gradient(
135deg,
#D97706,
#F59E0B
);
color:#fff;
border:none;
padding:14px 42px;
border-radius:999px;
font-size:14px;
font-weight:700;
cursor:pointer;
transition:all .25s ease;
display:flex;
justify-content:center;
align-items:center;
gap:8px;
margin-left:auto;
box-shadow:
0 10px 20px rgba(217,119,6,.18);
}

.btn-kirim:hover{
transform:translateY(-2px) scale(1.02);
box-shadow:
0 15px 30px rgba(217,119,6,.25);
background:linear-gradient(
135deg,
#b45309,
#d97706
);
}

/* =========================
   ERROR
========================= */
.error{
margin-top:-12px;
margin-bottom:15px;
font-size:12px;
font-weight:500;
color:#dc2626;
padding-left:4px;
}

/* =========================
   SELECT GROUP
========================= */
select optgroup{
background:#f8fafc;
color:#0D2A54;
font-weight:700;
}

select option{
color:#334155;
}

/* =========================
   SWEET ALERT
========================= */
.swal2-popup{
border-radius:22px !important;
padding:25px !important;
font-family:'Poppins',sans-serif !important;
}

.swal2-title{
font-weight:700 !important;
font-size:24px !important;
color:#0D2A54 !important;
}

/* =========================
   RESPONSIVE
========================= */
@media(max-width:768px){

.form-wrapper{
padding:24px 20px;
margin:20px 12px;
border-radius:18px;
}

.form-title{
font-size:24px;
}

.btn-kirim{
width:100%;
margin-left:0;
}

.laporan-form input,
.laporan-form select,
.laporan-form textarea{
padding:13px 14px;
}

}
</style>

<div class="form-wrapper">

    <h2 class="form-title">Pengajuan Laporan</h2>

    <form class="laporan-form" action="<?php echo e(route('laporan.store')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>

        <label>Nama Pengirim</label>
        <input type="text" name="nama_pengirim" value="<?php echo e(auth()->user()->name); ?>" readonly>

        <label>Status Pengirim</label>
        <input type="text" value="<?php echo e(auth()->user()->role ?? 'Mahasiswa'); ?>" readonly>
        <input type="hidden" name="status_pengirim" value="<?php echo e(auth()->user()->role ?? 'Mahasiswa'); ?>">

        <label>Judul Laporan</label>
        <input type="text" name="judul" value="<?php echo e(old('judul')); ?>">
        <?php $__errorArgs = ['judul'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        <label>Kategori</label>
        <select name="kategori">
            <option value="">Pilih Kategori</option>
            <option value="Wifi">Wifi & Jaringan</option>
            <option value="Sistem">Sistem</option>
            <option value="Website">Website & Hosting</option>
            <option value="Sistem Informasi">Sistem Informasi</option>
            <option value="Aplikasi">Aplikasi Conference (Zoom)</option>
            <option value="Hardware">Perangkat Keras</option>
            <option value="Keamanan">Lain-lain / Keamanan</option>
        </select>
        <?php $__errorArgs = ['kategori'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        <label>Tanggal</label>
        <input type="date" name="tanggal" value="<?php echo e(old('tanggal', date('Y-m-d'))); ?>">
        <?php $__errorArgs = ['tanggal'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        <label>Tingkat Urgensi</label>
        <select name="tingkat_urgensi">
            <option value="">Pilih Urgensi</option>
            <option value="Rendah">Rendah</option>
            <option value="Sedang">Sedang</option>
            <option value="Tinggi">Tinggi</option>
        </select>
        <?php $__errorArgs = ['tingkat_urgensi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        <!-- ? BAGIAN YANG SUDAH DIPERBAIKI -->
        <label>Area Layanan</label>
        <select name="lokasi">
            <option value="">Pilih Area Layanan</option>

            <optgroup label="Area Kampus & Gedung Utama">
                <option value="Gedung Rektorat Lantai 1">Gedung Rektorat Lantai 1</option>
                <option value="Gedung Rektorat Lantai 2">Gedung Rektorat Lantai 2</option>
                <option value="Gedung Rektorat Lantai 3">Gedung Rektorat Lantai 3</option>
                <option value="Gedung Perpustakaan">Gedung Perpustakaan</option>
                <option value="Laboratorium Terpadu">Laboratorium Terpadu</option>
                <option value="Auditorium">Auditorium</option>
                <option value="Kampus 1">Kampus 1</option>
                <option value="Kampus 2">Kampus 2</option>
            </optgroup>

            <optgroup label="Area Akademik">
                <option value="Ruang Kuliah 101">Ruang Kuliah 101</option>
                <option value="Ruang Kuliah 202">Ruang Kuliah 202</option>
                <option value="Lab Komputer A">Lab Komputer A</option>
                <option value="Lab Komputer B">Lab Komputer B</option>
                <option value="Lab Bahasa">Lab Bahasa</option>
                <option value="Ruang Seminar">Ruang Seminar</option>
            </optgroup>

            <optgroup label="Area Administrasi">
                <option value="Administrasi Umum">Administrasi Umum</option>
                <option value="Akademik">Akademik</option>
                <option value="Keuangan">Keuangan</option>
                <option value="Program Studi">Program Studi</option>
                <option value="UPT">UPT</option>
            </optgroup>

            <optgroup label="Area Publik">
                <option value="Lobby">Lobby</option>
                <option value="Gazebo">Gazebo</option>
                <option value="Kantin">Kantin</option>
                <option value="Asrama">Asrama</option>
                <option value="Parkir">Area Parkir</option>
                <option value="Taman">Taman Kampus</option>
            </optgroup>

            <optgroup label="Area Digital">
                <option value="Akses Luar Kampus">Akses Luar Kampus</option>
                <option value="Server Room">Server Room</option>
            </optgroup>
        </select>
        <?php $__errorArgs = ['lokasi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        <!-- END -->

        <label>Deskripsi Laporan</label>
        <textarea name="deskripsi" rows="4"><?php echo e(old('deskripsi')); ?></textarea>
        <?php $__errorArgs = ['deskripsi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        <label>Upload Bukti (Opsional)</label>
<input type="file" name="bukti">
<?php $__errorArgs = ['bukti'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

<div style="display:flex; justify-content:flex-end; margin-top:20px;">
    <button type="submit" class="btn-kirim">
        Kirim Laporan
    </button>
</div>

</form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {

    <?php if(session('success')): ?>
    Swal.fire({
        title: 'Berhasil!',
        text: "<?php echo e(session('success')); ?>",
        icon: 'success',
        confirmButtonColor: '#7c3aed'
    });
    <?php endif; ?>

    <?php if($errors->any()): ?>
    Swal.fire({
        title: 'Gagal!',
        text: "Silakan periksa kembali isian formulir Anda.",
        icon: 'error',
        confirmButtonColor: '#dc2626'
    });
    <?php endif; ?>

});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('user.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/hitspbiz/public_html/HITSP/resources/views/user/pengajuan.blade.php ENDPATH**/ ?>