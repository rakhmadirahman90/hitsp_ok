@extends('user.layout')

@section('content')

<link rel="stylesheet" href="{{ asset('css/user/dashboard.css') }}">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="dashboard-container">

    <section class="hero">
        <div class="hero-content">
            <h1>Riwayat Permintaan Layanan</h1>
            <p class="hero-desc">
                Berikut semua permintaan layanan yang pernah Anda ajukan dan status pemrosesannya.
            </p>
        </div>
    </section>

    <div class="card">

        <div class="card-title">
            <i class="fa-solid fa-clock-rotate-left"></i>
            Riwayat Permintaan Saya
        </div>

        <ul class="list-permintaan">

            @forelse($requests as $r)
            @php
                // --- 1. DETEKSI LAYANAN ---
                $layananLower = strtolower($r->layanan);
                $isHotspot = str_contains($layananLower, 'hotspot');

                // --- 2. LOGIKA SINKRONISASI DATABASE (Sangat Penting) ---
                // Jika status di riwayat 'pending', kita cek manual ke tabel hotspot_users
                // untuk melihat apakah admin sudah memberikan username/password.
                $currentStatus = $r->status;

                if ($isHotspot && (strtolower($currentStatus) == 'pending' || $currentStatus == '0')) {
                    // Cek ke tabel hotspot_users berdasarkan email user yang sedang login
                    $checkHotspot = \DB::table('hotspot_users')
                                    ->where('email', Auth::user()->email)
                                    ->first();

                    if ($checkHotspot && (!empty($checkHotspot->username_hotspot) || $checkHotspot->status == 'disetujui')) {
                        $currentStatus = 'disetujui'; // Paksa status jadi disetujui jika data di DB hotspot sudah ada
                    }
                }

                // --- 3. CLEANING STATUS ---
                $statusClean = strtolower(trim($currentStatus));

                // Cek Status Disetujui
              // Cek Status Disetujui
$isApproved = in_array($statusClean, [
    'approved',
    'setuju',
    'disetujui',
    '1',
    'success',
    'aktif',
    'active'
]);

$isRejected = in_array($statusClean, [
    'rejected',
    'tolak',
    'ditolak',
    '2',
    'failed'
]);

$isDisabled = in_array($statusClean, [
    'disabled',
    'dinonaktifkan',
    'nonaktif',
    'zoom_disabled',
    'domain_disabled'
]);

$isPending = in_array($statusClean, [
    'pending',
    'tunggu',
    'menunggu verifikasi',
    '0',
    '',
    'proses'
]);         
@endphp

            <li class="item-permintaan">

                <div class="permintaan-header">

                    <span class="nama-layanan">
                        <i class="fa-solid {{ $isHotspot ? 'fa-wifi' : 'fa-file-invoice' }}" style="margin-right: 5px; color: #64748b;"></i>
                        {{ $r->layanan }}
                    </span>

              <span class="status-badge 
    @if($isApproved) 
        status-approved
    @elseif($isRejected) 
        status-rejected
    @elseif($isDisabled)
        status-disabled
    @else 
        status-pending
    @endif
">
    @if($isApproved)
        <i class="fa-solid fa-check-circle"></i> Disetujui

    @elseif($isRejected)
        <i class="fa-solid fa-times-circle"></i> Ditolak

    @elseif($isDisabled)
        <i class="fa-solid fa-ban"></i> Dinonaktifkan

    @else
        <i class="fa-solid fa-hourglass-half"></i> Pending
    @endif
</span>
   </div>

       <div class="info-email 
    @if($isApproved) 
        info-approved
    @elseif($isRejected) 
        info-rejected
    @elseif($isDisabled)
        info-disabled
    @else 
        info-pending
    @endif
">

    @if($isApproved)

        <i class="fa-solid fa-circle-check"></i>
        <span>
            Permintaan <strong>{{ $r->layanan }}</strong> telah selesai diproses.
        </span>

    @elseif($isRejected)

        <i class="fa-solid fa-circle-xmark"></i>
        <span>
            Permintaan ditolak.
        </span>

    @elseif($isDisabled)

        <i class="fa-solid fa-ban"></i>
        <span>

            @if(str_contains($layananLower,'zoom'))
                Link Zoom sudah tidak aktif.

            @elseif(str_contains($layananLower,'domain'))
                Sub Domain telah dinonaktifkan.

            @elseif(str_contains($layananLower,'hosting'))
                Hosting telah dinonaktifkan.

            @elseif(str_contains($layananLower,'hotspot'))
                Akses Hotspot telah dinonaktifkan.

            @else
                Layanan telah dinonaktifkan.
            @endif

        </span>

    @else

        <i class="fa-solid fa-clock"></i>
        <span>
            Permohonan sedang dalam antrean verifikasi oleh administrator.
        </span>

    @endif

</div>
                {{-- Action Area khusus Hotspot --}}
                @if($isHotspot)
                    <div class="action-footer">
                        @if($isApproved)
                            <a href="{{ route('hotspot.my') }}" class="btn-detail-link success"></a>
                        @else
                            <a href="{{ route('hotspot.my') }}" class="btn-detail-link">
                                                           </a>
                        @endif
                    </div>
                @endif

            </li>

            @empty

            <li class="empty-state">
                <div style="padding: 40px 0;">
                    <i class="fa-solid fa-folder-open" style="font-size: 40px; color: #cbd5e1; margin-bottom: 10px;"></i>
                    <p>Belum ada riwayat permintaan layanan saat ini.</p>
                </div>
            </li>

            @endforelse

        </ul>

    </div>

</div>

<style>
.status-pending { background: #fef9c3 !important; color: #a16207 !important; }
.status-disabled {
    background: #e5e7eb !important;
    color: #374151 !important;
}
.info-pending { background: #f8fafc; color: #475569; border-color: #3b82f6; }
.info-disabled {
    background: #f3f4f6;
    color: #374151;
    border-color: #6b7280;
}
/* --- Dashboard Base Styles --- */
.dashboard-container {
    font-family: 'Poppins', sans-serif;
    padding: 20px;
    max-width: 1000px;
    margin: 0 auto;
}

.hero {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    padding: 40px 30px;
    border-radius: 15px;
    margin-bottom: 25px;
    box-shadow: 0 10px 20px rgba(37, 99, 235, 0.2);
}

.hero h1 { font-size: 24px; font-weight: 700; margin-bottom: 8px; }
.hero-desc { font-size: 14px; opacity: 0.9; }

.card {
    background: white;
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
}

.card-title {
    font-size: 17px; font-weight: 600; margin-bottom: 20px;
    display: flex; align-items: center; gap: 10px; color: #1e293b;
}

.card-title i { color: #3b82f6; }

/* --- List Styles --- */
.list-permintaan {
    list-style: none; padding: 0; margin: 0;
    display: flex; flex-direction: column; gap: 15px;
}

.item-permintaan {
    background: #ffffff; border: 1px solid #f1f5f9;
    padding: 18px; border-radius: 12px; transition: all 0.3s ease;
}

.item-permintaan:hover {
    box-shadow: 0 10px 15px rgba(0,0,0,0.05);
    transform: translateY(-2px); border-color: #3b82f6;
}

.permintaan-header {
    display: flex; justify-content: space-between;
    align-items: center; flex-wrap: wrap; gap: 12px;
}

.nama-layanan { font-size: 15px; font-weight: 600; color: #334155; }

/* --- Badges --- */
.status-badge {
    padding: 6px 16px; border-radius: 50px; font-size: 12px;
    font-weight: 600; display: flex; align-items: center; gap: 5px;
}

.status-approved { background: #dcfce7 !important; color: #15803d !important; }
.status-rejected { background: #fee2e2 !important; color: #b91c1c !important; }
.status-pending { background: #fef9c3 !important; color: #a16207 !important; }

/* --- Info Boxes --- */
.info-email {
    margin-top: 15px; font-size: 12.5px; padding: 12px 16px;
    border-radius: 8px; display: flex; align-items: flex-start; gap: 10px;
    line-height: 1.6; border-left: 4px solid;
}

.info-approved { background: #f0fdf4; color: #166534; border-color: #22c55e; }
.info-rejected { background: #fef2f2; color: #991b1b; border-color: #ef4444; }
.info-pending { background: #f8fafc; color: #475569; border-color: #3b82f6; }

/* --- Footer Actions --- */
.action-footer { margin-top: 15px; text-align: right; border-top: 1px solid #f1f5f9; padding-top: 12px; }

.btn-detail-link {
    font-size: 12px; text-decoration: none; color: #3b82f6;
    font-weight: 600; transition: 0.2s;
}

.btn-detail-link.success { color: #15803d; background: #f0fdf4; padding: 5px 12px; border-radius: 6px; }

.btn-detail-link:hover { text-decoration: underline; opacity: 0.8; }

.empty-state {
    text-align: center; padding: 40px; color: #94a3b8;
    background: #f8fafc; border-radius: 12px; border: 2px dashed #e2e8f0;
}

@media(max-width:768px) {
    .permintaan-header { flex-direction: column; align-items: flex-start; }
}
</style>

@endsection