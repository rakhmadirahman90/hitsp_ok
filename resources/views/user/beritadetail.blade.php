@extends('user.layout')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<div class="dashboard-container">

    <section class="hero">
        <div class="hero-content">
            <span class="hero-badge">Portal Informasi</span>
            <h1>{{ $berita->judul }}</h1>
            <p class="hero-date">
                <i class="far fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($berita->tanggal)->translatedFormat('d F Y') }}
            </p>
        </div>
    </section>


    <div class="detail-card">

        <div class="img-wrap">
            <img src="{{ asset('storage/'.$berita->gambar) }}" alt="{{ $berita->judul }}">
            <div class="img-shadow"></div>
        </div>


        <div class="detail-body">

            <div class="info-bar">
                <div class="info-chip"><i class="fas fa-tag"></i> Berita Kampus</div>
                <div class="info-chip"><i class="far fa-clock"></i> Dibaca 2 menit</div>
            </div>


            <div class="content">
                {{-- Menggunakan nl2br agar baris baru di database terbaca --}}
                {!! nl2br(e($berita->deskripsi)) !!}
            </div>


            <div class="button-wrapper">
                <a href="{{ url()->previous() }}" class="back-btn">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>

        </div>

    </div>

</div>

<style>
/* GLOBAL BG & RESET */
html, body {
    font-family: 'Poppins', sans-serif !important;
    background: 
        radial-gradient(circle at 10% 20%, rgba(255,140,0,.1), transparent 40%),
        radial-gradient(circle at 80% 80%, rgba(59,130,246,.1), transparent 40%),
        linear-gradient(135deg,#eef2ff,#f8fafc,#fff7ed);
    margin: 0;
    padding: 0;
}

/* CONTAINER */
.dashboard-container {
    max-width: 1000px; /* Dipersempit sedikit agar lebih fokus (skala baca) */
    margin: auto;
    padding: 60px 20px 100px;
}

/* HERO */
.hero {
    border-radius: 30px;
    padding: 100px 40px 160px; /* Padding bawah diperbesar untuk float card */
    margin-bottom: 0; 
    text-align: center;
    position: relative;
    overflow: hidden;
    background: linear-gradient(120deg,#0f172a,#1e293b,#020617);
    box-shadow: 0 30px 90px rgba(0,0,0,.25);
}

.hero::after {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: url('https://www.transparenttextures.com/patterns/cubes.png'); /* Pattern halus */
    opacity: 0.1;
}

.hero h1 {
    font-size: 42px;
    font-weight: 800;
    line-height: 1.3;
    margin: 20px auto;
    max-width: 800px;
    background: linear-gradient(90deg,#fff,#fbbf24);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    position: relative;
    z-index: 2;
}

.hero-badge {
    background: linear-gradient(135deg,#f59e0b,#fb923c);
    padding: 8px 20px;
    border-radius: 999px;
    font-size: 13px;
    color: white;
    font-weight: 600;
    letter-spacing: 1px;
    text-transform: uppercase;
    position: relative;
    z-index: 2;
}

.hero-date {
    color: #cbd5e1;
    font-size: 15px;
    font-weight: 300;
    position: relative;
    z-index: 2;
}

/* DETAIL CARD */
.detail-card {
    margin: -100px auto 0; /* Menempel ke Hero */
    background: white;
    border-radius: 30px;
    overflow: hidden;
    position: relative;
    z-index: 10;
    border: 1px solid rgba(226, 232, 240, 0.8);
    box-shadow: 0 40px 100px rgba(0,0,0,.12);
    animation: fadeInUp 0.8s cubic-bezier(0.23, 1, 0.32, 1);
}

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(60px); }
    to { opacity: 1; transform: translateY(0); }
}

/* IMAGE HANDLING (Perbaikan Thumbnail Berantakan) */
.img-wrap {
    width: 100%;
    height: 480px; /* Tinggi konsisten */
    overflow: hidden;
    position: relative;
    background: #f1f5f9;
}

.img-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover; /* Gambar akan terpotong rapi di tengah, tidak gepeng */
    object-position: center;
    transition: transform 1.5s ease;
}

.img-wrap:hover img {
    transform: scale(1.05);
}

.img-shadow {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 150px;
    background: linear-gradient(to top, rgba(0,0,0,0.4), transparent);
    pointer-events: none;
}

/* BODY CONTENT */
.detail-body {
    padding: 60px;
}

.info-bar {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 35px;
    padding-bottom: 25px;
    border-bottom: 1px solid #f1f5f9;
}

.info-chip {
    padding: 8px 20px;
    border-radius: 999px;
    font-size: 13px;
    font-weight: 500;
    background: #f8fafc;
    color: #64748b;
    border: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    gap: 8px;
}

.content {
    font-size: 18px;
    line-height: 1.9;
    color: #334155;
    text-align: justify;
    word-wrap: break-word;
}

/* Tombol Kembali */
.button-wrapper {
    margin-top: 50px;
    border-top: 1px solid #f1f5f9;
    padding-top: 30px;
}

.back-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 14px 30px;
    border-radius: 12px;
    font-weight: 600;
    text-decoration: none;
    color: white;
    background: linear-gradient(135deg,#0f172a,#1e293b);
    transition: all 0.3s ease;
}

.back-btn:hover {
    transform: translateX(-5px);
    box-shadow: 0 15px 30px rgba(15, 23, 42, 0.2);
    background: linear-gradient(135deg,#1e293b,#334155);
}

/* RESPONSIVE STRATEGY */
@media (max-width: 768px) {
    .dashboard-container {
        padding: 40px 15px;
    }
    
    .hero {
        padding: 80px 20px 120px;
        border-radius: 0 0 40px 40px;
    }

    .hero h1 {
        font-size: 28px;
    }

    .detail-card {
        margin-top: -80px;
        border-radius: 20px;
    }

    .img-wrap {
        height: 280px;
    }

    .detail-body {
        padding: 30px 20px;
    }

    .content {
        font-size: 16px;
        line-height: 1.7;
    }
}
</style>

@endsection