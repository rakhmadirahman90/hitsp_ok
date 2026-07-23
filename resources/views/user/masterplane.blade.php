@extends('user.layout')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

<div class="masterplan-container">

    <h2 class="page-title">MASTER PLAN TIK-ITH 2025</h2>

    <div class="main-grid">

        <!-- Sidebar -->
        <div class="sidebar-box">

            <div class="sidebar-title">
                <i class="fa-solid fa-bars"></i> KEBIJAKAN
            </div>

            <div class="sidebar-menu">
                @forelse($masterplans as $mp)
                <a href="#"
                   class="menu-item"
                   onclick="showPDF('{{ asset('storage/masterplan/'.$mp->file) }}', this)">
                    {{ $mp->judul }}
                </a>
                @empty
                <p class="no-doc">Belum ada dokumen tersedia</p>
                @endforelse
            </div>

        </div>

        <!-- Konten -->
        <div class="content-box">
            @if($masterplans->count() > 0)
            <iframe id="pdfViewer"
                src="{{ asset('storage/masterplan/'.$masterplans->first()->file) }}"
                class="pdf-viewer">
            </iframe>
            @else
            <p>Tidak ada dokumen untuk ditampilkan</p>
            @endif
        </div>

    </div>

</div>

<script>
function showPDF(fileUrl, element) {
    const viewer = document.getElementById('pdfViewer');
    if(viewer){
        viewer.src = fileUrl;
    }

    document.querySelectorAll(".menu-item").forEach(item=>{
        item.classList.remove("active");
    });

    element.classList.add("active");
}
</script>

<style>
/* ================= RESET ================= */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Poppins',sans-serif;
    background:
        radial-gradient(circle at 15% 25%, #fde68a55, transparent 40%),
        radial-gradient(circle at 85% 85%, #fdba7455, transparent 40%),
        linear-gradient(135deg,#fff7ed,#ffffff,#ffedd5);
    color:#1e293b;
}


/* ================= CONTAINER ================= */
.masterplan-container{
    max-width:1300px;
    margin:70px auto;
    padding:25px;
    animation:fadePage .6s ease;
}

@keyframes fadePage{
    from{opacity:0; transform:translateY(25px)}
    to{opacity:1; transform:translateY(0)}
}


/* ================= TITLE ================= */
.page-title{
    text-align:center;
    font-size:36px;
    font-weight:700;
    margin-bottom:55px;
    color:#1B3B5F;
    letter-spacing:.5px;
    position:relative;
}

.page-title::after{
    content:"";
    width:110px;
    height:5px;
    background:#1B3B5F;
    display:block;
    margin:18px auto 0;
    border-radius:50px;
}


/* ================= GRID ================= */
.main-grid{
    display:grid;
    grid-template-columns:300px 1fr;
    gap:28px;
}


/* ================= SIDEBAR ================= */
.sidebar-box{
    background:rgba(255,255,255,.9);
    backdrop-filter:blur(12px);
    border-radius:22px;
    padding:26px;
    border:1px solid #e2e8f0;
    box-shadow:0 20px 55px rgba(27,59,95,.12);
    transition:.35s;
}

.sidebar-box:hover{
    transform:translateY(-5px);
    box-shadow:0 30px 80px rgba(27,59,95,.18);
}

.sidebar-title{
    font-size:20px;
    font-weight:600;
    margin-bottom:24px;
    color:#1B3B5F;
    display:flex;
    align-items:center;
    gap:12px;
    padding-bottom:12px;
    border-bottom:2px solid #e2e8f0;
}

.sidebar-title i{
    background:#1B3B5F;
    color:white;
    padding:8px;
    border-radius:8px;
    font-size:14px;
}


/* ================= MENU ================= */
.sidebar-menu{
    display:flex;
    flex-direction:column;
    gap:12px;
}

.menu-item{
    text-decoration:none;
    padding:14px 18px;
    border-radius:14px;
    background:#f8fafc;
    color:#334155;
    font-weight:500;
    transition:.3s;
    position:relative;
    overflow:hidden;
}

/* shimmer hover effect */
.menu-item::before{
    content:"";
    position:absolute;
    top:0;
    left:-100%;
    width:100%;
    height:100%;
    background:linear-gradient(120deg,transparent,rgba(255,255,255,.7),transparent);
    transition:.5s;
}

.menu-item:hover::before{
    left:100%;
}

.menu-item:hover{
    background:#1B3B5F;
    color:white;
    transform:translateX(6px);
}

.menu-item.active{
    background:#1B3B5F;
    color:white;
    box-shadow:0 10px 25px rgba(27,59,95,.35);
}

.no-doc{
    font-size:14px;
    color:#94a3b8;
}


/* ================= CONTENT ================= */
.content-box{
    background:rgba(255,255,255,.95);
    backdrop-filter:blur(12px);
    border-radius:22px;
    padding:20px;
    border:1px solid #e2e8f0;
    box-shadow:0 25px 70px rgba(27,59,95,.15);
    min-height:650px;
    display:flex;
    align-items:center;
    justify-content:center;
    transition:.35s;
}

.content-box:hover{
    transform:translateY(-4px);
}


/* ================= PDF ================= */
.pdf-viewer{
    width:100%;
    height:720px;
    border:none;
    border-radius:14px;
    box-shadow:0 15px 45px rgba(0,0,0,.1);
    transition:.4s;
}

.pdf-viewer:hover{
    transform:scale(1.01);
}


/* ================= SCROLLBAR ================= */
::-webkit-scrollbar{
    width:9px;
}
::-webkit-scrollbar-track{
    background:#f1f5f9;
}
::-webkit-scrollbar-thumb{
    background:#1B3B5F;
    border-radius:20px;
}


/* ================= RESPONSIVE ================= */
@media(max-width:992px){

.main-grid{
    grid-template-columns:1fr;
}

.sidebar-box{
    order:2;
}

.content-box{
    order:1;
}

.pdf-viewer{
    height:550px;
}

}

@media(max-width:500px){

.page-title{
    font-size:26px;
}

.masterplan-container{
    margin:50px auto;
}

}
</style>

@endsection