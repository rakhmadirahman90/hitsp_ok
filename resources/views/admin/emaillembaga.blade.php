@extends('operator.layout')

@section('content')

<link rel="stylesheet" href="{{ asset('css/admin/emaillembaga.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

{{-- Bagian Notifikasi --}}
<div class="container-fluid mt-3">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="fa fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="fa fa-exclamation-triangle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
</div>

<div class="admin-wrapper">
    <h2 class="page-title"><i class="fa fa-building me-2"></i> Detail Permohonan Email Lembaga</h2>

    {{-- 1. INFORMASI PERMOHONAN --}}
    <div class="detail-wrapper shadow-sm">
        <h3><i class="fa fa-info-circle me-2 text-primary"></i> Informasi Permohonan</h3>
        <table class="table table-bordered align-middle mt-3">
            <tr>
                <th class="bg-light">Nama Institusi / Kegiatan</th>
                <td class="fw-bold">{{ $email->nama_institusi }} {{ $email->nama_kegiatan ? '/ '.$email->nama_kegiatan : '' }}</td>
            </tr>
            <tr>
                <th class="bg-light">Email Alternatif (Pemohon)</th>
                <td><i class="fa fa-envelope me-2 text-muted"></i>{{ $email->email_alternatif }}</td>
            </tr>
            <tr>
                <th class="bg-light">Penanggung Jawab Teknis</th>
                <td>{{ $email->nama_teknis }}</td>
            </tr>
            <tr>
                <th class="bg-light">Identitas (NIP/NIK/NIM)</th>
                <td class="font-monospace">{{ $email->nip_nik_nim_teknis }}</td>
            </tr>
            <tr>
                <th class="bg-light">Jabatan & Status Teknis</th>
                <td>{{ $email->jabatan_teknis }} ({{ $email->status_teknis }})</td>
            </tr>
            <tr>
                <th class="bg-light">Telepon Teknis</th>
                <td><i class="fa fa-phone me-2 text-muted"></i>{{ $email->telp_teknis }}</td>
            </tr>
            <tr>
                <th class="bg-light">Status Permohonan Saat Ini</th>
                <td>
                    {{-- PERBAIKAN LOGIKA STATUS --}}
                    @php $currStatus = strtolower(trim($email->status)); @endphp
                    
                    @if($currStatus == 'pending')
                        <span class="badge bg-warning text-dark"><i class="fa fa-clock me-1"></i> PENDING</span>
                    @elseif($currStatus == 'disetujui')
                        <span class="badge bg-success text-white"><i class="fa fa-check-circle me-1"></i> DISETUJUI</span>
                    @else
                        <span class="badge bg-danger text-white"><i class="fa fa-times-circle me-1"></i> DITOLAK</span>
                    @endif
                </td>
            </tr>
        </table>
    </div>

    {{-- 2. LOGIKA FORM INPUT ADMIN --}}
    @if($currStatus == 'pending')
        {{-- SECTION SETUJU --}}
        <div id="sectionSetuju" class="detail-wrapper border-start border-success border-4 shadow-sm">
            <h4 class="text-success mb-4 fw-bold"><i class="fa fa-user-check me-2"></i> Aktivasi Akun Lembaga</h4>
            <form action="{{ route('admin.email.setuju', $email->id) }}" method="POST" id="formSetuju">
                @csrf
                <input type="hidden" name="id" value="{{ $email->id }}">
                <input type="hidden" name="email_pemohon" value="{{ $email->email_alternatif }}">

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Jenis Akun</label>
                        <select name="jenis_akun" class="form-control" required>
                            <option value="">-- Pilih Jenis Akun --</option>
                            <option value="Institusi">Institusi</option>
                            <option value="Lembaga Mahasiswa">Lembaga Mahasiswa</option>
                            <option value="Kegiatan">Kegiatan</option>
                            <option value="Lain-lain">Lain-lain</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Nama Akun (Username)</label>
                        <div class="input-group">
                            <input type="text" name="nama_akun" class="form-control" placeholder="contoh: bem.teknik" value="{{ $email->nama_akun }}" required>
                            <span class="input-group-text bg-white">@institut.ac.id</span>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Password Default</label>
                        <input type="text" name="password" class="form-control" placeholder="Isi password" required>
                    </div>
                </div>

                <div class="action-wrapper mt-4">
                    <button type="submit" class="btn btn-success px-4 py-2 fw-bold shadow-sm">
                        <i class="fa fa-check me-1"></i> Setujui & Buat Akun
                    </button>
                    <button type="button" class="btn btn-danger px-4 py-2 fw-bold shadow-sm" id="btnTolak">
                        <i class="fa fa-times me-1"></i> Tolak Permohonan
                    </button>
                    <a href="{{ route('admin.kelolaemail') }}" class="btn btn-outline-secondary px-4 py-2 fw-bold">
                        Kembali
                    </a>
                </div>
            </form>
        </div>

        {{-- SECTION TOLAK --}}
        <div id="sectionTolak" class="detail-wrapper border-start border-danger border-4 shadow-sm" style="display:none;">
            <h4 class="text-danger mb-4 fw-bold"><i class="fa fa-ban me-2"></i> Konfirmasi Penolakan</h4>
            <form action="{{ route('admin.email.tolak', $email->id) }}" method="POST" id="formTolak">
                @csrf
                {{-- BARU: Pastikan parameter dikirim dengan benar --}}
                <div class="form-group">
                    <label class="fw-bold">Alasan Penolakan</label>
                    <textarea name="alasan_tolak" class="form-control" rows="4" placeholder="Tulis alasan mengapa permohonan ini tidak dapat diproses..." required></textarea>
                    <small class="text-muted mt-1 d-block italic">Alasan ini akan dikirimkan ke email pemohon.</small>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-danger px-4 py-2 fw-bold shadow-sm">
                        <i class="fa fa-paper-plane me-1"></i> Kirim Penolakan
                    </button>
                    <button type="button" class="btn btn-secondary px-4 py-2 fw-bold" id="batalTolak">
                        <i class="fa fa-undo me-1"></i> Batal
                    </button>
                </div>
            </form>
        </div>
    @else
        {{-- 3. TAMPILAN SETELAH DIPROSES (FINAL) --}}
        <div class="detail-wrapper border-top border-4 shadow-sm {{ $currStatus == 'disetujui' ? 'border-success' : 'border-danger' }}">
            @if($currStatus == 'disetujui')
                <h3 class="text-success fw-bold"><i class="fa fa-id-card me-2"></i> Akun Lembaga Telah Aktif</h3>
                <div class="bg-light p-3 rounded border mt-3">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <th style="width: 250px;">Jenis Akun Resmi</th>
                            <td class="fw-bold text-dark">{{ $akunAktif->jenis_akun ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Alamat Email Baru</th>
                            <td><span class="fs-5 text-primary fw-bold font-monospace">{{ $email->nama_akun }}@ith.ac.id</span></td>
                        </tr>
                        <tr>
                            <th>Waktu Persetujuan</th>
                            <td><i class="fa fa-calendar-check me-2 text-muted"></i>{{ $email->updated_at->format('d F Y, H:i') }} WIB</td>
                        </tr>
                    </table>
                </div>
                <div class="alert alert-info border-0 mt-3 mb-0">
                    <i class="fa fa-info-circle me-2"></i> Kredensial akun sudah dikirimkan ke email alternatif penanggung jawab teknis.
                </div>
            @else
                {{-- BARU: Tampilan Box Penolakan yang Lebih Tegas --}}
                <div class="alert alert-danger shadow-sm border-0 d-flex align-items-start mb-0 p-4">
                    <div class="me-3 fs-1"><i class="fa fa-times-circle"></i></div>
                    <div>
                        <h5 class="fw-bold mb-1">Permohonan Telah Ditolak</h5>
                        <p class="text-muted small mb-2">Diproses pada: {{ $email->updated_at->format('d F Y, H:i') }} WIB</p>
                        <div class="bg-white p-3 rounded border">
                            <strong class="text-danger d-block mb-1">Alasan Penolakan:</strong>
                            <p class="mb-0 text-dark">{{ $email->alasan_tolak ?? 'Tidak ada alasan spesifik yang diberikan oleh admin.' }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="mt-4">
                <a href="{{ route('admin.kelolaemail') }}" class="btn btn-secondary px-4 py-2 fw-bold shadow-sm">
                    <i class="fa fa-arrow-left me-1"></i> Kembali ke Daftar Akun
                </a>
            </div>
        </div>
    @endif
</div>

{{-- SCRIPT INTERAKSI --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btnTolak = document.getElementById('btnTolak');
        const sectionTolak = document.getElementById('sectionTolak');
        const sectionSetuju = document.getElementById('sectionSetuju');
        const batalTolak = document.getElementById('batalTolak');

        if (btnTolak) {
            btnTolak.addEventListener('click', () => {
                sectionSetuju.style.display = 'none';
                sectionTolak.style.display = 'block';
            });
        }

        if (batalTolak) {
            batalTolak.addEventListener('click', () => {
                sectionTolak.style.display = 'none';
                sectionSetuju.style.display = 'block';
            });
        }
    });
</script>

<style>
    /* CSS Wrapper & General */
    .admin-wrapper { padding: 30px; background-color: #f8fafc; min-height: 100vh; }
    .page-title { color: #1e293b; font-weight: 700; border-left: 5px solid #1B3B5F; padding-left: 15px; }
    .detail-wrapper { background: #ffffff; border-radius: 12px; padding: 25px; margin-bottom: 30px; }
    .detail-wrapper h3 { font-size: 1.1rem; font-weight: 600; margin-bottom: 20px; }
    .table th { font-weight: 600; color: #475569; width: 280px !important; }
    
    /* Form Elements */
    .form-label, label { font-size: 12px; font-weight: 600; color: #64748b; margin-bottom: 6px; display: block; text-transform: uppercase; letter-spacing: 0.4px; }
    .form-control { border-radius: 10px !important; padding: 11px 14px; border: 1px solid #cbd5e1; font-size: 14px; transition: 0.2s; }
    .form-control:focus { border-color: #1B3B5F !important; box-shadow: 0 0 0 3px rgba(27,59,95,0.12) !important; outline: none; }
    
    /* Input Group */
    .input-group { border-radius: 10px; overflow: hidden; border: 1px solid #cbd5e1; }
    .input-group input { border: none !important; }
    .input-group-text { background: #f1f5f9; border-left: 1px solid #cbd5e1; font-size: 13px; }

    /* Buttons */
    .btn { border-radius: 10px !important; padding: 10px 18px; font-size: 13px; font-weight: 600; transition: 0.25s; }
    .btn:hover { transform: translateY(-2px); }
    .btn-success { background: #10b981; border: none; }
    .btn-danger { background: #ef4444; border: none; }
    .btn-outline-secondary, .btn-secondary { background: #f1f5f9 !important; border: 1px solid #cbd5e1 !important; color: #334155 !important; border-radius: 999px !important; }
    .btn-outline-secondary:hover, .btn-secondary:hover { background: #1B3B5F !important; color: #fff !important; }

    .action-wrapper { display: flex; gap: 12px; flex-wrap: wrap; margin-top: 25px; }

    @media (max-width: 768px) {
        .action-wrapper { flex-direction: column; }
        .action-wrapper .btn { width: 100%; }
    }
</style>

@endsection