@extends('operator.layout')

@section('content')

<style>

/* ================= BASE ================= */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins', sans-serif;
}

body{
    background:#f4f7fb;
    color:#374151;
}

/* ================= PAGE ================= */
.notif-page{
    max-width:900px;
    margin:30px auto;
    padding:0 15px;
}

/* ================= HEADER ================= */
.notif-header{
    background:linear-gradient(135deg,#1B3B5F,#27496d);
    color:#fff;
    padding:18px 22px;
    border-radius:14px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 10px 25px rgba(0,0,0,0.12);
}

.notif-header h3{
    font-size:18px;
    font-weight:600;
}

/* ================= LIST ================= */
.notif-list{
    margin-top:18px;
    display:flex;
    flex-direction:column;
    gap:12px;
}

/* ================= CARD ================= */
.notif-card{
    background:#fff;
    padding:14px 16px;
    border-radius:12px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 6px 18px rgba(0,0,0,0.06);
    border-left:4px solid #F77F00;
    transition:all 0.25s ease;
}

.notif-card:hover{
    transform:translateY(-3px);
    box-shadow:0 12px 28px rgba(0,0,0,0.10);
}

/* LEFT */
.notif-left{
    display:flex;
    gap:12px;
    align-items:center;
}

.icon{
    width:42px;
    height:42px;
    background:#1B3B5F;
    color:#F77F00;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:10px;
    flex-shrink:0;
}

.title{
    font-weight:600;
    color:#1B3B5F;
    font-size:14px;
    margin-bottom:3px;
}

.desc{
    font-size:12px;
    color:#6b7280;
}

.time{
    font-size:11px;
    color:#9ca3af;
    white-space:nowrap;
}

/* ================= SEE ALL ================= */
.see-all{
    margin-top:15px;
    text-align:center;
}

.see-all a{
    display:inline-block;
    padding:10px 16px;
    background:#1B3B5F;
    color:#fff;
    border-radius:10px;
    font-size:12px;
    text-decoration:none;
    transition:0.2s;
}

.see-all a:hover{
    background:#27496d;
    transform:translateY(-2px);
}

/* ================= PAGINATION (BOOTSTRAP MATCH KELOLA PENGGUNA) ================= */

.pagination-wrapper{
    display:flex;
    justify-content:center;
    margin-top:35px;
}

.pagination{
    display:flex !important;
    gap:10px;
    list-style:none;
    padding:0;
    margin:0;
    flex-wrap:wrap;
}

/* item */
.page-item{
    list-style:none;
}

/* link */
.page-link{
    display:flex !important;
    justify-content:center;
    align-items:center;

    min-width:42px;
    height:42px;
    padding:0 15px !important;

    border-radius:12px !important;
    border:none !important;

    background:#fff !important;
    color:#455a64 !important;

    font-weight:600;
    font-size:14px;

    box-shadow:0 3px 10px rgba(0,0,0,.08);
    transition:all .25s ease;
    text-decoration:none !important;
}

/* hover */
.page-link:hover{
    background:#607d8b !important;
    color:#fff !important;
    transform:translateY(-2px);
}

/* active */
.page-item.active .page-link{
    background:linear-gradient(135deg,#607d8b,#455a64) !important;
    color:#fff !important;
    box-shadow:0 5px 15px rgba(96,125,139,.35);
}

/* disabled */
.page-item.disabled .page-link{
    background:#eceff1 !important;
    color:#90a4ae !important;
    box-shadow:none !important;
    cursor:not-allowed;
    opacity:.8;
}

/* ================= RESPONSIVE ================= */
@media(max-width:768px){

.notif-card{
    flex-direction:column;
    align-items:flex-start;
    gap:8px;
}

.time{
    align-self:flex-end;
}

.page-link{
    min-width:36px;
    height:36px;
    font-size:13px;
    padding:0 12px !important;
}

}

</style>

<div class="notif-page">

    <div class="notif-header">
        <h3>Notifikasi</h3>
        <i class="fa-solid fa-bell"></i>
    </div>

    <div class="notif-list">

        @php
            $limit = 10;
            $total = count($notifications ?? []);
        @endphp

        @forelse(($notifications ?? []) as $index => $notif)

            @if($index < $limit)

            <div class="notif-card">

                <div class="notif-left">
                    <div class="icon">
                        <i class="fa-solid fa-bell"></i>
                    </div>

                    <div>
                        <div class="title">
                            {{ $notif->title ?? 'Notifikasi Baru' }}
                        </div>

                        <div class="desc">
                            {{ $notif->message ?? 'Ada aktivitas baru di sistem' }}
                        </div>
                    </div>
                </div>

                <div class="time">
                    {{ $notif->created_at->diffForHumans() }}
                </div>

            </div>

            @endif

        @empty
            <p style="text-align:center;color:#999;">Tidak ada notifikasi</p>
        @endforelse

        @if($total > $limit)
            <div class="see-all">
                <a href="{{ url('/admin/notifikasi/all') }}">
                    Lihat semua notifikasi ({{ $total }})
                </a>
            </div>
        @endif

        {{-- PAGINATION --}}
        <div class="pagination-wrapper">
            {{ $notifications->links('pagination::bootstrap-5') }}
        </div>

    </div>

</div>

@endsection