@extends('user.layout')

@section('content')

<link rel="stylesheet" href="{{ asset('css/user/dashboard.css') }}">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="dashboard-container">

    <section class="hero">
        <div class="hero-content">
           <h1>
                {{ auth()->check() ? 'Selamat Datang, '.auth()->user()->name.' ??' : 'UPT TIK Service Portal' }}
            </h1>

            <p class="hero-desc">
                {{ auth()->check()
                    ? 'Kami siap membantu kebutuhan layanan IT Anda hari ini.'
                    : 'Sistem layanan digital ini mendukung kebutuhan teknologi informasi civitas akademika.'
                }}
            </p>
        </div>
    </section>

    <div class="section-head">
        <h2>Layanan Tersedia</h2>
        <span>Pilih layanan sesuai kebutuhan</span>
    </div>

    <section class="services-grid">
        @forelse($layanans as $layanan)
           @php
    $namaLayanan = strtolower($layanan->nama);
    $targetRoute = '#';

   $isMahasiswa = Auth::check() && strtolower(trim(Auth::user()->role)) === 'mahasiswa';
    if (str_contains($namaLayanan, 'email')) {
        $targetRoute = Route::has('pilihemail') ? route('pilihemail') : '#';
    }

    elseif (str_contains($namaLayanan, 'zoom')) {
        $targetRoute = $isMahasiswa
            ? 'javascript:void(0)'
            : (Route::has('zoom.create') ? route('zoom.create') : '#');
    }

    elseif (str_contains($namaLayanan, 'hosting') || str_contains($namaLayanan, 'domain')) {
        $targetRoute = Route::has('requestdomain') ? route('requestdomain') : '#';
    }

    elseif (str_contains($namaLayanan, 'hotspot')) {
        $targetRoute = Route::has('hotspot.form') ? route('hotspot.form') : '#';
    }

    $isZoom = str_contains($namaLayanan, 'zoom');
@endphp

<a href="{{ $targetRoute }}"
   class="service-card {{ ($isZoom && $isMahasiswa) ? 'disabled-card' : '' }}"
   @if($isZoom && $isMahasiswa)
       onclick="return aksesZoomDitolak()"
   @endif
>
             <div class="icon-wrap">
                    <i class="{{ $layanan->icon }}"></i>
                </div>
                <h3>{{ $layanan->nama }}</h3>
            </a>
        @empty
            <p class="empty" style="grid-column: 1 / -1;">Belum ada layanan tersedia</p>
        @endforelse
    </section>

    @auth
    <section class="request-status-section" style="margin-bottom: 60px;">
        <div class="card-title">
            <div class="title-left">
                <i class="fa-solid fa-user-check" style="color: #3b82f6;"></i>
                Status Permintaan Saya
            </div>
            <a href="{{ route('permintaan.saya') }}" class="lihat-semua">
                Lihat Semua <i class="fa-solid fa-arrow-right" style="font-size: 10px;"></i>
            </a>
        </div>

        <ul class="list-permintaan">
            @forelse(($requests ?? collect()) as $r)
                @php
                    $statusStr = strtolower(trim($r->status ?? 'pending'));
                    $layananStr = strtolower($r->layanan);
$isApproved = in_array($statusStr, [
    'disetujui',
    'approved',
    'aktif',
    'active',
    'setuju'
]);

$isRejected = in_array($statusStr, [
    'ditolak',
    'rejected',
    'failed'
]);

$isDisabled = in_array($statusStr, [
    'dinonaktifkan',
    'disabled',
    'zoom_disabled',
    'domain_disabled'
]);@endphp

                <li class="item-permintaan">
                    <div class="item-header">
                        <span class="nama-layanan">
                            <i class="fa-solid {{ str_contains($layananStr, 'hotspot') ? 'fa-wifi' : 'fa-file-invoice' }}"></i>
                            {{ $r->layanan }}
                        </span>

                        <span class="status-badge
    			@if($isApproved)
       			 status-approve
    			@elseif($isRejected)
       			 status-reject
    			@elseif($isDisabled)
        		status-disabled
    			@else
       			 status-pending
    			@endif">
                            @if($isApproved)
    				<i class="fa-solid fa-check-circle"></i> Disetujui
					@elseif($isRejected)
   				 <i class="fa-solid fa-circle-xmark"></i> Ditolak
					@elseif($isDisabled)
    				<i class="fa-solid fa-ban"></i> Dinonaktifkan
					@else
    				<i class="fa-solid fa-hourglass-half"></i> Sedang Diproses
			@endif                       
			</span>
                    </div>

                   <div class="info-email
    @if($isApproved)
        info-box-approve
    @elseif($isRejected)
        info-box-reject
    @elseif($isDisabled)
        info-box-disabled
    @else
        info-box-pending
    @endif">

    @if($isApproved)

        <i class="fa-solid fa-circle-check"></i>
        <span>
            Permintaan <strong>{{ $r->layanan }}</strong> telah selesai diproses.
        </span>

    @elseif($isRejected)

        <i class="fa-solid fa-circle-exclamation"></i>
        <span>
            <strong>Permintaan ditolak.</strong>
        </span>

   @elseif($isDisabled)

    <i class="fa-solid fa-ban"></i>
    <span>

        @if($statusStr == 'zoom_disabled')
            <strong>Link Zoom sudah tidak aktif.</strong>

        @elseif($statusStr == 'domain_disabled')
            <strong>Sub Domain / Hosting telah dinonaktifkan.</strong>

        @elseif(str_contains($layananStr,'hotspot'))
            <strong>Akses Hotspot telah dinonaktifkan.</strong>

        @else
            <strong>Layanan telah dinonaktifkan.</strong>
        @endif

    </span>
    @else

        <i class="fa-solid fa-clock"></i>
        <span>Permohonan sedang diproses.</span>

    @endif

</div>
                </li>
            @empty
                <li class="empty-state">Belum ada permintaan layanan</li>
            @endforelse
        </ul>
    </section>
    @endauth

    <section class="info-grid">
        <div class="card info-card">
            <div class="card-title">
                <div class="title-left">
                    <i class="fa-solid fa-bullhorn"></i>
                    Pengumuman
                </div>
            </div>

            <ul class="list">
                @forelse($pengumumans as $p)
                <li>
                    <span class="date">
                        {{ \Carbon\Carbon::parse($p->tanggal)->translatedFormat('d M Y') }}
                    </span>
                    <span class="text">{{ $p->isi }}</span>
                </li>
                @empty
                <li class="empty-state">Belum ada pengumuman</li>
                @endforelse
            </ul>
        </div>

        <div class="card info-card">
            <div class="card-title">
                <div class="title-left">
                    <i class="fa-solid fa-newspaper"></i>
                    Berita & Kegiatan
                </div>
            </div>

            <div id="berita-container">
                <div class="news-grid">
                    @forelse($kegiatans as $k)
                    <a href="{{ Route::has('berita.show') && !empty($k->id) ? route('berita.show',$k->id) : '#' }}" class="news">
                        <div class="img-box">
                            <img src="{{ $k->gambar ? asset('storage/'.$k->gambar) : 'https://via.placeholder.com/140x110?text=No+Image' }}">
                        </div>
                        <div class="news-body">
                            <span class="date">
                                {{ \Carbon\Carbon::parse($k->tanggal)->translatedFormat('d M Y') }}
                            </span>
                            <h4 class="title">{{ Str::limit($k->judul, 45) }}</h4>
                        </div>
                    </a>
                    @empty
                    <p class="empty-state">Belum ada kegiatan</p>
                    @endforelse
                </div>

                @if($kegiatans->hasPages())
                <div class="pagination-wrapper">
                    {{ $kegiatans->links('pagination::bootstrap-4') }}
                </div>
                @endif
            </div>
        </div>
    </section>
</div>
<style>
.status-disabled{
    background:#e5e7eb !important;
    color:#374151 !important;
    border:1px solid #d1d5db;
}

.info-box-disabled{
    background:#f3f4f6;
    color:#374151;
    border-left:4px solid #6b7280;
}
/* --- STYLE DASHBOARD --- */
.card-title {
    display: flex !important;
    justify-content: space-between !important;
    align-items: center !important;
    margin-bottom: 20px;
}

.title-left {
    display: flex;
    align-items: center;
    gap: 12px;
    font-weight: 700;
    font-size: 17px;
    color: #1e293b;
}

.lihat-semua {
    font-size: 13px;
    text-decoration: none;
    color: #2563eb;
    font-weight: 600;
    transition: 0.2s;
    background: #eff6ff;
    padding: 6px 14px;
    border-radius: 10px;
}

.lihat-semua:hover { background: #dbeafe; transform: translateX(3px); }

.list-permintaan {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.item-permintaan {
    background: #ffffff;
    border: 1px solid #f1f5f9;
    padding: 20px;
    border-radius: 16px;
    transition: all .3s ease;
}

.item-permintaan:hover {
    border-color: #3b82f6;
    box-shadow: 0 10px 20px rgba(0,0,0,0.04);
}

.item-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
}

.nama-layanan {
    font-size: 16px;
    font-weight: 600;
    color: #334155;
    display: flex;
    align-items: center;
}

.status-badge {
    padding: 6px 16px;
    border-radius: 50px;
    font-size: 12px;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 5px;
}

.status-approve { background: #dcfce7 !important; color: #15803d !important; border: 1px solid #bbf7d0; }
.status-reject { background: #fee2e2 !important; color: #b91c1c !important; border: 1px solid #fecaca; }
.status-pending { background: #fef9c3 !important; color: #a16207 !important; border: 1px solid #fef08a; }

.info-email {
    margin-top: 15px;
    font-size: 13px;
    padding: 14px;
    border-radius: 10px;
    display: flex;
    align-items: flex-start;
    gap: 12px;
    line-height: 1.6;
    border-left: 4px solid;
}

.info-box-approve { background: #f0fdf4; color: #166534; border-color: #22c55e; }
.info-box-reject { background: #fef2f2; color: #991b1b; border-color: #ef4444; }
.info-box-pending { background: #fffbeb; color: #92400e; border-color: #f59e0b; }

.link-action {
    color: #2563eb;
    text-decoration: none;
    font-weight: 700;
    margin-left: 5px;
}

.link-action:hover { text-decoration: underline; }

.dashboard-container { max-width: 1400px; margin: auto; padding: 40px 20px; font-family: 'Poppins', sans-serif; }

.hero {
    background: linear-gradient(135deg, #0f172a, #1e293b);
    color: white;
    border-radius: 25px;
    padding: 50px;
    margin-bottom: 50px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
}

.services-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 25px; margin-bottom: 50px; }

.service-card {
    background: white;
    border-radius: 20px;
    padding: 35px 20px;
    text-align: center;
    text-decoration: none;
    border: 1px solid #f1f5f9;
    transition: all .3s;
    color: #1e293b;
}

.service-card:hover { transform: translateY(-8px); border-color: #3b82f6; box-shadow: 0 15px 30px rgba(59, 130, 246, 0.1); }

.icon-wrap {
    width: 60px; height: 60px; border-radius: 15px; margin: 0 auto 20px;
    display: flex; align-items: center; justify-content: center;
    background: linear-gradient(135deg, #FF7A00, #FFA94D); 
    color: white; font-size: 24px;
}
.info-grid { display: grid; grid-template-columns: 1fr 2fr; gap: 30px; }
.card { background: white; border-radius: 20px; padding: 30px; border: 1px solid #f1f5f9; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }

@media (max-width: 992px) {
    .info-grid { grid-template-columns: 1fr; }
    .services-grid { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 576px) {
    .services-grid { grid-template-columns: 1fr; }
    .hero { padding: 30px; }
}
</style>
<script>
function aksesZoomDitolak(){
    Swal.fire({
        icon: 'warning',
        title: 'Akses Ditolak',
        text: 'Zoom hanya dapat diakses oleh Dosen dan Staf',
        confirmButtonColor: '#d97706'
    });
    return false;
}
</script>
@endsection
