@extends('user.layout')

@section('content')

<div class="hotspot-wrapper">
    <h2 class="form-title">Form Registrasi Pengguna Hotspot</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('hotspot.store') }}" method="POST" class="hotspot-form">
        @csrf
<style>
    .hotspot-wrapper{
    max-width:900px;
    margin:40px auto;
    background:#EDE7E7;
    padding:32px;
    border-radius:14px;
    box-shadow:0 10px 30px rgba(0,0,0,.08);
}

.form-title{
    text-align:center;
    font-weight:600;
    font-size:22px;
    margin-bottom:30px;
    color:#374151;
}

.hotspot-form .form-group{
    margin-bottom:18px;
}

.hotspot-form label{
    display:block;
    font-size:13px;
    margin-bottom:8px;
    color:#4b5563;
}

.hotspot-form input,
.hotspot-form select,
.hotspot-form textarea{
    width:100%;
    height:44px;
    padding:10px 14px;
    border-radius:10px;
    border:1px solid #e5e7eb;
    font-family:'Poppins', sans-serif;
    font-size:14px;
    background:#fff;
    box-sizing:border-box;
}

.hotspot-form textarea{
    height:auto;
    resize:vertical;
}

.hotspot-form input:focus,
.hotspot-form select:focus,
.hotspot-form textarea:focus{
    outline:none;
    border-color:#D97706;
    box-shadow:0 0 0 2px rgba(217,119,6,.15);
}

.form-checkbox-group{
    display:flex;
    gap:20px;
    flex-wrap:wrap;
    margin-bottom:18px;
}

.form-action{
    margin-top:28px;
    text-align:right;
}

.btn-submit{
    background:#D97706;
    color:#fff;
    border:none;
    padding:12px 36px;
    border-radius:999px;
    cursor:pointer;
    font-weight:500;
    font-size:14px;
}

/* Penyesuaian Font untuk SweetAlert agar serupa dengan gambar */
.swal2-title {
    font-family: 'Poppins', sans-serif !important;
    font-weight: 600 !important;
    color: #4b5563 !important;
}
.swal2-html-container {
    font-family: 'Poppins', sans-serif !important;
    color: #6b7280 !important;
}

/* Responsive */
@media (max-width:768px){
    .hotspot-wrapper{
        margin:20px 16px;
        padding:24px 20px;
    }
}
    </style>

        <h3>Akses Hotspot Sebagai</h3>
        <div class="form-checkbox-group">
            <label><input type="checkbox" name="akses[]" value="Dosen"> Dosen</label>
            <label><input type="checkbox" name="akses[]" value="Staf"> Staf</label>
            <label><input type="checkbox" name="akses[]" value="Mahasiswa"> Mahasiswa</label>
        </div>

        <h3>Pengguna / User Hotspot</h3>
        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="nama_lengkap" required>
        </div>

        <div class="form-group">
            <label>Jabatan</label>
            <input type="text" name="jabatan" required>
        </div>

        <div class="form-group">
            <label>No. Identitas (NIP)</label>
            <input type="text" name="nip" required>
        </div>

        <div class="form-group">
            <label>Akun Hotspot</label>
            <select name="akun_hotspot" required>
                <option value="">Pilih</option>
                <option value="Pengguna Baru">Pengguna Baru</option>
                <option value="Reset Password">Reset Password</option>
            </select>
        </div>

        <div class="form-group">
            <label>No. Telepon / Hp</label>
            <input type="text" name="no_telepon" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>

        <h3>Nama Hotspot yang Diminta</h3>
        <div class="form-group">
            <label>Nama Hotspot / WiFi</label>
            <input type="text" name="nama_hotspot" value="Institut Teknologi Bachruddin Jusuf Habibie" required>
        </div>

        <h3>Penanggung Jawab Teknis</h3>
        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="pj_nama" required>
        </div>

        <div class="form-group">
            <label>No. Identitas (NIP/NIM)</label>
            <input type="text" name="pj_nip" required>
        </div>

        <div class="form-group">
            <label>Jabatan</label>
            <input type="text" name="pj_jabatan" required>
        </div>

        <div class="form-group">
            <label>No. Telepon / Hp</label>
            <input type="text" name="pj_telepon" required>
        </div>

        <h3>Persetujuan</h3>
        <div class="form-group">
            <label>
                <input type="checkbox" name="persetujuan" required>
                Saya menyatakan bahwa data di atas benar dan saya bertindak atas nama institusi yang saya wakili.
            </label>
        </div>

        <div class="form-action">
            <button type="submit" class="btn-submit">KIRIM</button>
        </div>

    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
@if(session('success'))
Swal.fire({
    title: 'Berhasil!',
    text: '{{ session('success') }}',
    icon: 'success',
    iconColor: '#a5dc86', // Warna hijau centang sesuai gambar
    confirmButtonText: 'OK',
    confirmButtonColor: '#7c3aed', // Warna ungu tombol sesuai gambar
    showClass: {
        popup: 'animate__animated animate__fadeInUp animate__faster'
    },
    hideClass: {
        popup: 'animate__animated animate__fadeOutDown animate__faster'
    },
    customClass: {
        popup: 'rounded-20', // Opsional: Tambah kelas untuk border-radius besar
        confirmButton: 'px-4 py-2'
    }
});
@endif
</script>

@endsection