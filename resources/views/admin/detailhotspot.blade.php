@extends('operator.layout')

@section('title', 'Detail Permohonan Hotspot')

@section('content')
<link rel="stylesheet" href="{{ asset('css/admin/hotspot.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

{{-- ================= NOTIFIKASI ================= --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius: 10px;">
        <i class="fa fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius: 10px;">
        <i class="fa fa-exclamation-triangle me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius: 10px;">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="hotspot-detail">
    <div class="detail-wrapper bg-white p-4 shadow-sm" style="border-radius: 15px;">
        <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
            <h2 class="mb-0 fw-bold text-navy"><i class="fa fa-wifi text-primary me-2"></i> Detail Permohonan Hotspot</h2>
            <a href="{{ route('admin.hotspot.index') }}" class="btn btn-sm btn-outline-secondary px-3 py-2 fw-bold">
                <i class="fa fa-arrow-left me-1"></i> Kembali ke Daftar
            </a>
        </div>

        {{-- ================= DATA PEMOHON ================= --}}
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <tr class="bg-light">
                    <th width="30%" class="p-3 text-secondary text-uppercase small fw-bold">Nama Lengkap</th>
                    <td class="p-3 fw-bold text-dark fs-6">{{ $hotspot->nama_lengkap }}</td>
                </tr>
                <tr>
                    <th class="p-3 text-secondary text-uppercase small fw-bold">Jabatan / NIM</th>
                    <td class="p-3 text-dark">{{ $hotspot->jabatan }} ({{ $hotspot->nip }})</td>
                </tr>
                <tr class="bg-light">
                    <th class="p-3 text-secondary text-uppercase small fw-bold">Kontak Pemohon</th>
                    <td class="p-3 text-dark">
                        <div class="mb-1"><i class="fa fa-envelope me-2 text-muted"></i> {{ $hotspot->email }}</div>
                        <div><i class="fa fa-phone me-2 text-muted"></i> {{ $hotspot->no_telepon }}</div>
                    </td>
                </tr>
                <tr>
                    <th class="p-3 text-secondary text-uppercase small fw-bold">Akses & Nama Hotspot</th>
                    <td class="p-3">
                        <span class="text-dark fw-semibold">{{ $hotspot->akses }}</span> - 
                        <span class="badge bg-light text-primary border border-primary-subtle px-2">{{ $hotspot->nama_hotspot }}</span>
                    </td>
                </tr>
                <tr class="bg-light">
                    <th class="p-3 text-secondary text-uppercase small fw-bold">Jenis Permohonan</th>
                    <td class="p-3">
                        <span class="badge bg-info text-dark px-3 py-2 fw-bold" style="font-size: 0.75rem;">
                            {{ strtoupper($hotspot->akun_hotspot) }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th class="p-3 text-secondary text-uppercase small fw-bold">Penanggung Jawab Teknis</th>
                    <td class="p-3">
                        <div class="p-2 bg-light rounded border-start border-4 border-primary">
                            <strong class="text-dark">{{ $hotspot->pj_nama }}</strong> <span class="text-muted small">({{ $hotspot->pj_jabatan }})</span> <br>
                            <small class="text-secondary">NIP: {{ $hotspot->pj_nip }} | Telp: {{ $hotspot->pj_telepon }}</small>
                        </div>
                    </td>
                </tr>
                <tr class="bg-light">
                    <th class="p-3 text-secondary text-uppercase small fw-bold">Status Saat Ini</th>
                    <td class="p-3">
                        @php $status = (int)$hotspot->persetujuan; @endphp
                        @if($status === 0)
                            <span class="badge bg-warning text-dark py-2 px-3 fw-bold"><i class="fa fa-clock me-1"></i> PENDING</span>
                        @elseif($status === 1)
                            <span class="badge bg-success text-white py-2 px-3 fw-bold"><i class="fa fa-check-circle me-1"></i> DISETUJUI</span>
                        @elseif($status === 2)
                            <span class="badge bg-danger text-white py-2 px-3 fw-bold"><i class="fa fa-times-circle me-1"></i> DITOLAK</span>
                        @endif
                    </td>
                </tr>
            </table>
        </div>

        <hr class="my-5 border-2">

        {{-- ================= LOGIKA ACTION ================= --}}
        
        {{-- 1. JIKA STATUS PENDING (0) --}}
        @if((int)$hotspot->persetujuan === 0)
            
            <div id="wrapperSetuju" class="p-4 border rounded shadow-sm bg-light">
                <h4 class="mb-4 text-dark fw-bold"><i class="fa fa-user-plus text-success me-2"></i> Aktivasi Akun Hotspot</h4>
                <form method="POST" action="{{ route('admin.hotspot.storeCredentials', $hotspot->id) }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-secondary small text-uppercase">Username Akun</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i class="fa fa-user text-muted"></i></span>
                                <input type="text" name="username_hotspot" class="form-control border-start-0 ps-0" 
                                       value="{{ $hotspot->nip }}" placeholder="Username pemohon..." required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-secondary small text-uppercase">Password Akun</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i class="fa fa-key text-muted"></i></span>
                                <input type="text" name="password_hotspot" class="form-control border-start-0 ps-0" 
                                       placeholder="Masukkan password akun..." required>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-success px-4 py-2 shadow-sm fw-bold">
                            <i class="fa fa-check-circle me-1"></i> Setujui & Kirim Email
                        </button>
                        <button type="button" class="btn btn-outline-danger px-4 py-2 fw-bold" id="btnTolak">
                            <i class="fa fa-times-circle me-1"></i> Tolak Permohonan
                        </button>
                    </div>
                </form>
            </div>

            <div id="wrapperTolak" class="p-4 border rounded shadow-sm bg-light" style="display: none;">
                <h4 class="mb-4 text-danger fw-bold"><i class="fa fa-ban me-2"></i> Konfirmasi Penolakan</h4>
                <form method="POST" action="{{ route('admin.hotspot.tolak', $hotspot->id) }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark">Alasan Penolakan</label>
                        <textarea name="alasan_tolak" class="form-control" rows="4" 
                                  placeholder="Berikan alasan jelas mengapa permohonan ini ditolak..." required></textarea>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-danger px-4 py-2 shadow-sm fw-bold">
                            <i class="fa fa-paper-plane me-1"></i> Kirim Penolakan
                        </button>
                        <button type="button" class="btn btn-secondary px-4 py-2 fw-bold" id="btnBatal">
                            <i class="fa fa-undo me-1"></i> Batalkan
                        </button>
                    </div>
                </form>
            </div>

        {{-- 2. JIKA SUDAH DISETUJUI (1) --}}
        @elseif((int)$hotspot->persetujuan === 1)
            <div class="card border-0 shadow-sm" style="border-radius: 12px; background-color: #f0f7ff; border-left: 5px solid #0d6efd !important;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                            <i class="fa fa-id-card fa-lg"></i>
                        </div>
                        <div>
                            <h5 class="text-dark fw-bold mb-0">Akun Hotspot Telah Aktif</h5>
                            <p class="text-muted mb-0 small uppercase fw-bold">Diproses pada: {{ $hotspot->updated_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                    
                    <div class="row g-3 bg-white p-3 rounded border mx-0">
                        <div class="col-md-4 border-end">
                            <label class="small text-secondary fw-bold d-block mb-1">USERNAME</label>
                            <span class="fs-5 fw-bold text-primary font-monospace">{{ $hotspot->username_hotspot }}</span>
                        </div>
                        <div class="col-md-4 border-end">
                            <label class="small text-secondary fw-bold d-block mb-1">METODE AKTIVASI</label>
                            <span class="fw-semibold text-dark">Email Notifikasi Otomatis</span>
                        </div>
                        <div class="col-md-4">
                            <label class="small text-secondary fw-bold d-block mb-1">STATUS JARINGAN</label>
                            <span class="badge bg-success rounded-pill px-3"><i class="fa fa-check me-1"></i> AKTIF</span>
                        </div>
                    </div>
                    <div class="mt-3 p-2 text-center small text-secondary italic">
                        <i class="fa fa-info-circle text-primary me-1"></i> Detail login telah dikirimkan secara otomatis ke email <strong>{{ $hotspot->email }}</strong>.
                    </div>
                </div>
            </div>

        {{-- 3. JIKA SUDAH DITOLAK (2) --}}
        @elseif((int)$hotspot->persetujuan === 2)
            <div class="card border-0 shadow-sm" style="border-radius: 12px; background-color: #fff5f5; border-left: 5px solid #dc3545 !important;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                            <i class="fa fa-times-circle fa-lg"></i>
                        </div>
                        <div>
                            <h5 class="text-danger fw-bold mb-0">Permohonan Ditolak</h5>
                            <p class="text-muted mb-0 small uppercase fw-bold">Sistem memproses penolakan pada {{ $hotspot->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    
                    <div class="row g-3 bg-white p-3 rounded border mx-0">
                        <div class="col-md-4 border-end text-center">
                            <label class="small text-secondary fw-bold d-block mb-1">STATUS AKHIR</label>
                            <span class="badge bg-danger text-white px-3"><i class="fa fa-ban me-1"></i> DITOLAK</span>
                        </div>
                        <div class="col-md-8 text-start ps-4">
                            <label class="small text-secondary fw-bold d-block mb-1 text-uppercase">Catatan / Alasan Admin:</label>
                            <p class="mb-0 text-dark fw-semibold italic">"{{ $hotspot->alasan_tolak ?? 'Tidak ada catatan tambahan.' }}"</p>
                        </div>
                    </div>

                    <div class="mt-3 p-2 text-center small text-secondary italic">
                        <i class="fa fa-info-circle text-danger me-1"></i> Detail informasi penolakan telah dikirimkan secara otomatis ke email <strong>{{ $hotspot->email }}</strong>.
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btnTolak = document.getElementById('btnTolak');
        const btnBatal = document.getElementById('btnBatal');
        const wrapperSetuju = document.getElementById('wrapperSetuju');
        const wrapperTolak = document.getElementById('wrapperTolak');

        if(btnTolak && btnBatal) {
            btnTolak.addEventListener('click', () => {
                wrapperSetuju.classList.add('fade-out');
                setTimeout(() => {
                    wrapperSetuju.style.display = 'none';
                    wrapperTolak.style.display = 'block';
                    wrapperTolak.classList.add('fade-in');
                }, 200);
            });

            btnBatal.addEventListener('click', () => {
                wrapperTolak.style.display = 'none';
                wrapperSetuju.style.display = 'block';
            });
        }
    });
</script>

<style>
/* ================= BASE RESET ================= */
.hotspot-detail,
.hotspot-detail * {
    box-sizing: border-box;
}

.hotspot-detail {
    font-family: 'Inter', sans-serif;
    background: #f4f6f9;
    color: #111827;
    padding-bottom: 40px;
}

/* ================= CONTAINER ================= */
.hotspot-detail .detail-wrapper {
    max-width: 920px;
    margin: auto;
    background: #fff;
    border-radius: 14px;
    padding: 20px;
    border: 1px solid #e5e7eb;
}

/* ================= HEADER ================= */
.hotspot-detail h2 {
    font-size: 1.3rem;
    font-weight: 700;
    margin: 0;
}

.hotspot-detail .btn-outline-secondary {
    border-radius: 8px;
    font-size: 0.85rem;
    padding: 6px 12px;
}

/* ================= ALERT ================= */
.alert {
    border-radius: 10px !important;
}

/* ================= TABLE (STABIL & CLEAN) ================= */
.hotspot-detail .table {
    width: 100%;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    overflow: hidden;
    margin-top: 10px;
}

.hotspot-detail .table th {
    width: 30%;
    font-size: 0.75rem;
    text-transform: uppercase;
    color: #6b7280;
    background: #f9fafb;
    padding: 12px;
}

.hotspot-detail .table td {
    padding: 12px;
    font-size: 0.9rem;
}

/* ================= BADGE ================= */
.badge {
    border-radius: 6px;
    font-weight: 600;
}

/* ================= CARD ================= */
.hotspot-detail .card {
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    box-shadow: none;
}

.hotspot-detail .card-body {
    padding: 16px;
}

/* ================= STATUS HEADER ================= */
.hotspot-detail .d-flex.align-items-center {
    gap: 12px;
}

/* ICON */
.hotspot-detail .rounded-circle {
    width: 44px;
    height: 44px;
}

/* ================= GRID INFO (FIXED, NO OVERFLOW) ================= */
.hotspot-detail .row.g-3 {
    display: flex;
    flex-wrap: wrap;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    overflow: hidden;
    margin-top: 12px;
}

.hotspot-detail .row.g-3 > div {
    flex: 1;
    min-width: 180px;
    padding: 12px;
    text-align: center;
    border-right: 1px solid #e5e7eb;
    background: #fff;
}

.hotspot-detail .row.g-3 > div:last-child {
    border-right: none;
}

/* ================= TEXT ================= */
.hotspot-detail label {
    font-size: 0.7rem;
    color: #6b7280;
    display: block;
    margin-bottom: 4px;
}

.hotspot-detail span {
    font-size: 0.9rem;
    font-weight: 600;
}

/* ================= INPUT ================= */
.hotspot-detail input,
.hotspot-detail textarea {
    border-radius: 8px !important;
    border: 1px solid #d1d5db;
    padding: 10px;
    font-size: 0.9rem;
}

.hotspot-detail input:focus,
.hotspot-detail textarea:focus {
    outline: none;
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37,99,235,0.15);
}

/* ================= BUTTON ================= */
.hotspot-detail .btn {
    border-radius: 8px;
    transition: 0.2s;
}

.hotspot-detail .btn:hover {
    transform: translateY(-1px);
}

/* ================= ACTION AREA ================= */
.hotspot-detail .d-flex.gap-2 {
    gap: 10px;
}

/* ================= MOBILE FIX TOTAL ================= */
@media (max-width: 768px) {

    .hotspot-detail .detail-wrapper {
        padding: 14px;
    }

    /* HEADER STACK */
    .hotspot-detail .detail-wrapper > div:first-child {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }

    .hotspot-detail .btn-outline-secondary {
        width: 100%;
        text-align: center;
    }

    /* TABLE FIX MOBILE */
    .hotspot-detail .table,
    .hotspot-detail .table tbody,
    .hotspot-detail .table tr,
    .hotspot-detail .table th,
    .hotspot-detail .table td {
        display: block;
        width: 100%;
    }

    .hotspot-detail .table tr {
        margin-bottom: 10px;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        overflow: hidden;
    }

    .hotspot-detail .table th {
        background: #f3f4f6;
    }

    /* GRID STACK */
    .hotspot-detail .row.g-3 {
        flex-direction: column;
    }

    .hotspot-detail .row.g-3 > div {
        border-right: none;
        border-bottom: 1px solid #e5e7eb;
    }

    .hotspot-detail .row.g-3 > div:last-child {
        border-bottom: none;
    }

    /* BUTTON FULL WIDTH */
    .hotspot-detail .d-flex.gap-2 {
        flex-direction: column;
    }

    .hotspot-detail .d-flex.gap-2 .btn {
        width: 100%;
    }
}
</style>
@endsection