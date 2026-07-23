@extends('user.layout')

@section('content')

<link rel="stylesheet" href="{{ asset('css/user/emailpribadi.css') }}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
.form-note-list{
background-color:#fff4e5;
border-left:5px solid #ff9800;
padding:15px 20px;
margin-top:15px;
margin-bottom:25px;
border-radius:8px;
font-size:14px;
line-height:1.6;
color:#333;
}

.form-note-list li{
margin-bottom:10px;
}

.form-note-list li::marker{
color:#ff9800;
font-weight:bold;
}

.form-note-list h4{
font-size:16px;
font-weight:600;
margin-bottom:10px;
color:#ff9800;
}

.form-note-list li a{
color:#ff9800;
text-decoration:underline;
}

.form-note-list li a:hover{
text-decoration:none;
color:#e65100;
}

/* INPUT READONLY */
input[readonly]{
background:#f5f5f5;
cursor:not-allowed;
}

/* STYLING NOTIFIKASI BLOCKED FORM */
.alert-blocked-container {
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 30px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
}
.alert-blocked-title {
    margin-top: 0;
    font-weight: 700;
    font-size: 18px;
    margin-bottom: 8px;
}
.alert-blocked-desc {
    font-size: 14px;
    line-height: 1.6;
    margin-bottom: 0;
}
</style>

<div class="form-wrapper">

<h2 class="form-title">Formulir Permohonan</h2>
<p class="form-subtitle">Pembuatan Akun E-Mail Pribadi</p>

{{-- ERROR VALIDASI --}}
@if ($errors->any())
<div style="background:#ffe5e5;padding:12px;border-radius:8px;margin-bottom:15px;">
    <ul style="margin:0;padding-left:18px;">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@if($statusCheck === 'pending')

    <div class="alert-blocked-container" style="background: #fff3cd; border-left: 6px solid #ffc107;">
        <h4 class="alert-blocked-title" style="color: #664d03;"><i class="fas fa-clock"></i> Permohonan Sedang Diproses</h4>
        <p class="alert-blocked-desc" style="color: #664d03;">
            Mohon maaf, Anda tidak dapat mengirimkan formulir baru. Masih ada formulir permohonan email pribadi Anda yang <strong>belum diproses atau dalam status pending</strong> oleh administrator. Silakan cek riwayat pengajuan Anda secara berkala.
        </p>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: 'warning',
                title: 'Permohonan Masih Pending!',
                text: 'Permohonan email Anda menunggu verifikasi oleh admin.',
                confirmButtonColor: '#ff9800'
            });
        });
    </script>

@elseif($statusCheck === 'approved' || $statusCheck === 'active' || $statusCheck === 'disetujui')

    <div class="alert-blocked-container" style="background: #d1e7dd; border-left: 6px solid #198754;">
        <h4 class="alert-blocked-title" style="color: #0f5132;"><i class="fas fa-check-circle"></i> Akun Email Sudah Aktif</h4>
        <p class="alert-blocked-desc" style="color: #0f5132;">
            Mohon maaf anda sdh tdk bisa lagi mngirim menggunakan akun anda karena sudah terdaftar/tercatat di dalam sistem. Setiap pengguna hanya diperbolehkan memiliki satu alamat email institusi utama.
        </p>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: 'info',
                title: 'Akses Terkunci',
                text: 'Mohon maaf anda sdh tdk bisa lagi mngirim menggunakan akun anda karena sudah terdaftar/tercatat.',
                confirmButtonColor: '#198754'
            });
        });
    </script>

@else
   
    <form method="POST" action="{{ route('email-pribadi.store') }}" enctype="multipart/form-data" id="mainFormPribadi">
    @csrf

    <div class="form-section">

    <h3>Data Pemohon</h3>

    <div class="form-row">

    <div class="form-group">
    <label>Nama Lengkap *</label>
    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $user->name) }}" readonly required>
    </div>

    <div class="form-group">
    <label>Jenis Pemohon *</label>
    <select name="jenis_pemohon" id="jenisPemohon" required>
    <option value="">-- Pilih Jenis Pemohon --</option>
    <option value="pegawai">Dosen / Staf</option>
    <option value="mahasiswa">Mahasiswa</option>
    </select>
    </div>
    </div>

    <div class="form-row">
    <div class="form-group">
    <label>Fakultas / Lembaga *</label>
    <input type="text" name="fakultas" required>
    </div>

    <div class="form-group">
    <label>Jurusan *</label>
    <input type="text" name="jurusan" required>
    </div>
    </div>

    <div class="form-row">
    <div class="form-group">
    <label>Status/Jabatan</label>
    <input type="text" name="jabatan">
    </div>

    <div class="form-group">
    <label>Nomor Identitas *</label>
    <input type="text" name="nomor_identitas" value="{{ old('nomor_identitas', $user->username ?? '') }}" readonly required>
    </div>
    </div>

    <div class="form-row">
    <div class="form-group">
    <label>Nomor Telepon *</label>
    <input type="text" name="no_telp" maxlength="12" required oninput="this.value=this.value.replace(/[^0-9]/g,'')">
    </div>

    <div class="form-group">
    <label>Email Alternatif *</label>
    <input type="email" name="email_alternatif" value="{{ old('email_alternatif', $user->email) }}" readonly required>
    </div>
    </div>

    <div class="form-group">
    <label>Upload SK / Identitas *</label>
    <input type="file" name="file_identitas" accept=".pdf,.jpg,.jpeg,.png" required>
    </div>

    <div class="form-group">
    <label>Nama Akun Email *</label>
    <div class="email-inline">
    <input type="text" name="email_name" required>
   <span id="emailDomain">
    {{ $user->institution_domain }}.ac.id
</span>
    </div>
    <input
    type="hidden"
    name="email_domain"
    id="emailDomainInput"
    value="{{ $user->institution_domain }}.ac.id">
    </div>
    </div>

    <div class="form-section">
    <h3>Persetujuan</h3>
    <div class="form-checkbox">
    <input type="checkbox" name="agreement" required>
    <label>Saya setuju dan bertanggung jawab</label>
    </div>
    </div>

    <div class="form-section">
    <h3>Rekomendasi</h3>
    <div class="form-row">
    <div class="form-group">
    <label>Nama</label>
    <input type="text" name="rek_nama">
    </div>

    <div class="form-group">
    <label>Nomor Identitas</label>
    <input type="text" name="rek_identitas" oninput="this.value=this.value.replace(/[^0-9]/g,'')">
    </div>
    </div>

    <div class="form-row">
    <div class="form-group">
    <label>Fakultas</label>
    <input type="text" name="rek_fakultas">
    </div>

    <div class="form-group">
    <label>Email ITH</label>
    <input type="email" name="rek_email">
    </div>
    </div>
    </div>

    <div class="form-section">
    <h3>Pernyataan</h3>
    <div class="form-checkbox">
    <input type="checkbox" name="penanggung_jawab" required>
    <label>Saya bertanggung jawab penuh</label>
    </div>
    </div>

    <div class="form-section">
    <h3>Catatan</h3>
    <ol class="form-note-list">
    <li>Nomor identitas harus valid</li>
    <li>Email harus sesuai format</li>
    <li>Password dikirim ke email alternatif</li>
    </ol>
    </div>

    <div class="form-action">
    <button type="submit" class="btn btn-primary">
    Kirim Permohonan
    </button>
    </div>

    </form>
@endif

</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const mainForm = document.getElementById('mainFormPribadi');
    if(mainForm) {
        mainForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Menghentikan submit bawaan browser agar tidak redirect penuh

            // Tampilkan Alert Loading "Sedang Mengirim..."
            Swal.fire({
                title: 'Sedang Mengirim...',
                text: 'Mohon tunggu sebentar, permohonan Anda sedang diproses.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Mengumpulkan data form termasuk file upload
            let formData = new FormData(this);

            // Pengiriman data menggunakan AJAX Fetch API
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json().then(data => ({ status: response.status, body: data })))
            .then(res => {
                if (res.status === 200 && res.body.status === 'success') {
                    // Tutup loading, tampilkan SweetAlert BERHASIL TERKIRIM
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil Terkirim!',
                        text: res.body.message,
                        confirmButtonColor: '#198754',
                        allowOutsideClick: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Setelah user klik OK, barulah halaman dimuat ulang untuk mengunci form menjadi pending
                            window.location.reload();
                        }
                    });
                } else {
                    // Tampilkan alert error jika validasi backend gagal
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: res.body.message || 'Terjadi kesalahan saat memproses permohonan.',
                        confirmButtonColor: '#d33'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan!',
                    text: 'Gagal terhubung ke server, silakan coba beberapa saat lagi.',
                    confirmButtonColor: '#d33'
                });
            });
        });
    }
});

// ================= SWITCH DOMAIN =================
const jenisPemohon = document.getElementById('jenisPemohon');
const emailDomain = document.getElementById('emailDomain');
const emailDomainInput = document.getElementById('emailDomainInput');

const domain = "{{ $user->institution_domain ?? 'institusi' }}";

if (jenisPemohon) {
    jenisPemohon.addEventListener('change', function () {

        if (this.value === 'mahasiswa') {
            emailDomain.textContent = '@mahasiswa.' + domain + '.ac.id';
            emailDomainInput.value = '@mahasiswa.' + domain + '.ac.id';
        } else {
            emailDomain.textContent = '@' + domain + '.ac.id';
            emailDomainInput.value = '@' + domain + '.ac.id';
        }

    });
}
</script>

@endsection