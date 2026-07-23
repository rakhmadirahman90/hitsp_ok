@extends('user.layout')

@section('content')

<link rel="stylesheet" href="{{ asset('css/user/fasilitas.css') }}">

<div class="fasilitas-container">

    <h2 class="page-title">Fasilitas</h2>
    <p class="intro-text">
        UPT TIK menyediakan berbagai fasilitas dan layanan untuk mendukung kebutuhan teknologi informasi di lingkungan kampus.
    </p>

    @foreach($fasilitas as $item)
        <h3 class="section-title">{{ $item->nama }}</h3>

        <div class="lab-section">

            <div class="gallery">
                @foreach($item->gambar as $img)
                    {{-- PERBAIKAN: Mengganti 'uploads/fasilitas' menjadi 'storage/fasilitas' agar sinkron dengan Admin --}}
                    <img src="{{ asset('storage/fasilitas/' . $img->gambar) }}" 
                         alt="Foto {{ $item->nama }}" 
                         onerror="this.src='https://via.placeholder.com/400x300?text=Gambar+Tidak+Tersedia'">
                @endforeach
            </div>

        </div>
    @endforeach

</div>

<style>
/* ===================================================
   FASILITAS STYLE - MODERN 2026
=================================================== */

body{
    font-family:'Poppins',sans-serif !important;
}

/* ===================================================
   CONTAINER
=================================================== */
.fasilitas-container{
    max-width:1300px;
    margin:auto;
    padding:60px 25px;
}

/* ===================================================
   PAGE TITLE
=================================================== */
.page-title{
    font-size:32px;
    font-weight:700;
    margin-bottom:10px;
    position:relative;
}

.page-title::after{
    content:'';
    position:absolute;
    bottom:-10px;
    left:0;
    width:70px;
    height:4px;
    border-radius:6px;
    background:linear-gradient(90deg,#f59e0b,#fb923c,#0ea5e9);
    background-size:200% 200%;
    animation:gradientMove 5s ease infinite;
}

@keyframes gradientMove{
    0%{background-position:0% 50%;}
    50%{background-position:100% 50%;}
    100%{background-position:0% 50%;}
}

.intro-text{
    margin-top:20px;
    margin-bottom:50px;
    max-width:750px;
    color:#64748b;
    line-height:1.7;
}

/* ===================================================
   SECTION TITLE
=================================================== */
.section-title{
    font-size:22px;
    font-weight:600;
    margin-bottom:20px;
    margin-top:40px;
    color:#0f172a;
}

/* ===================================================
   LAB SECTION CARD
=================================================== */
.lab-section{
    background:rgba(255,255,255,0.75);
    backdrop-filter:blur(12px);
    padding:30px;
    border-radius:22px;
    border:1px solid rgba(255,255,255,0.4);
    box-shadow:0 25px 60px rgba(0,0,0,0.08);
    margin-bottom:50px;
}

/* ===================================================
   GALLERY GRID
=================================================== */
.gallery{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:20px;
}

/* IMAGE STYLE */
.gallery img{
    width:100%;
    height:230px;
    object-fit:cover;
    border-radius:18px;
    transition:all .4s ease;
    cursor:pointer;
    box-shadow:0 15px 35px rgba(0,0,0,0.1);
}

/* Hover Effect */
.gallery img:hover{
    transform:scale(1.05);
    box-shadow:0 25px 60px rgba(0,0,0,0.2);
}

/* ===================================================
   RESPONSIVE
=================================================== */

@media(max-width:1100px){
    .gallery{
        grid-template-columns:repeat(2,1fr);
    }
}

@media(max-width:700px){
    .gallery{
        grid-template-columns:1fr;
    }

    .page-title{
        font-size:24px;
    }

    .section-title{
        font-size:18px;
    }

    .gallery img{
        height:200px;
    }
}
</style>

@endsection