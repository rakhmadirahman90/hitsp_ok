@extends('user.layout')



@section('content')





<div class="struktur-container">



    <h3 class="judul-section">STRUKTUR ORGANISASI UPT TIK ITH</h3>



    <!-- Bagian Struktur Organisasi -->

    <div class="struktur-box">

      <img src="{{ $struktur ? asset('storage/'.$struktur->gambar) : asset('images/struktur.png') }}" alt="Struktur Organisasi" class="struktur-img">
    </div>



    <!-- Daftar Divisi dan Anggota -->

    @foreach($divisis as $divisi)

        <div class="card-title">{{ $divisi->nama }}</div>

        @foreach($divisi->anggotas as $anggota)

        <div class="card-box">

            <img src="{{ $anggota->foto ? asset('storage/'.$anggota->foto) : asset('images/default.png') }}" class="foto-profil">

            <div class="info">

                <p><b>Nama Lengkap :</b> {{ $anggota->nama }}</p>

                <p><b>Jabatan :</b> {{ $anggota->peran }}</p>

            </div>

        </div>

        @endforeach

    @endforeach



</div>

<style>

/* ===============================
   GLOBAL STYLE
=================================*/
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Segoe UI', Tahoma, sans-serif;
    background:#f8fafc;
}

/* ===============================
   CONTAINER
=================================*/
.struktur-container{
    padding:60px 25px;
    min-height:100vh;
    background: linear-gradient(135deg,#eef4fb 0%, #ffffff 50%, #e6eef8 100%);
}

/* ===============================
   JUDUL SECTION
=================================*/
.judul-section{
    text-align:center;
    font-size:30px;
    font-weight:700;
    margin-bottom:50px;
    color:#1B3B5F;
    letter-spacing:.7px;
    position:relative;
}

/* garis bawah elegan */
.judul-section::after{
    content:"";
    width:80px;
    height:4px;
    background:#1B3B5F;
    display:block;
    margin:14px auto 0;
    border-radius:10px;
}

/* ===============================
   STRUKTUR IMAGE BOX
=================================*/
.struktur-box{
    display:flex;
    justify-content:center;
    margin-bottom:70px;
}

.struktur-img{
    width:100%;
    max-width:900px;
    border-radius:22px;
    box-shadow:0 20px 45px rgba(27,59,95,.15);
    transition:all .4s ease;
}

.struktur-img:hover{
    transform:scale(1.02);
    box-shadow:0 25px 55px rgba(27,59,95,.25);
}

/* ===============================
   TITLE DIVISI
=================================*/
.card-title{
    font-size:20px;
    font-weight:600;
    margin:55px 0 22px;
    padding:18px;
    border-radius:16px;
    background: linear-gradient(135deg,#1B3B5F,#2e5b89);
    color:#ffffff;
    text-align:center;
    letter-spacing:.6px;
    box-shadow:0 10px 25px rgba(27,59,95,.25);
    position:relative;
    overflow:hidden;
}

/* efek glow halus */
.card-title::before{
    content:"";
    position:absolute;
    width:150%;
    height:100%;
    background:rgba(255,255,255,.1);
    top:0;
    left:-120%;
    transform:skewX(-25deg);
    transition:.6s;
}

.card-title:hover::before{
    left:120%;
}

/* ===============================
   CARD ANGGOTA
=================================*/
.card-box{
    display:flex;
    align-items:center;
    gap:25px;
    background:#ffffff;
    padding:26px 30px;
    border-radius:22px;
    margin-bottom:25px;
    box-shadow:0 15px 35px rgba(0,0,0,.06);
    transition:all .35s ease;
    border:1px solid #e2e8f0;
}

.card-box:hover{
    transform:translateY(-6px);
    box-shadow:0 25px 55px rgba(27,59,95,.18);
    border:1px solid #1B3B5F;
}

/* ===============================
   FOTO PROFIL
=================================*/
.foto-profil{
    width:95px;
    height:95px;
    border-radius:50%;
    object-fit:cover;
    border:4px solid #1B3B5F;
    flex-shrink:0;
    transition:all .3s ease;
}

.card-box:hover .foto-profil{
    transform:scale(1.08);
}

/* ===============================
   INFO TEXT
=================================*/
.info{
    display:flex;
    flex-direction:column;
    justify-content:center;
}

.info p{
    margin:6px 0;
    font-size:16px;
    color:#475569;
}

.info b{
    color:#0f172a;
}

/* ===============================
   RESPONSIVE
=================================*/
@media(max-width:768px){

    .struktur-container{
        padding:40px 18px;
    }

    .judul-section{
        font-size:24px;
    }

    .card-box{
        flex-direction:column;
        text-align:center;
        padding:24px;
    }

    .foto-profil{
        margin-bottom:12px;
    }
}

</style>
@endsection

