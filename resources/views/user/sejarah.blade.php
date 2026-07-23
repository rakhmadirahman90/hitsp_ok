@extends('user.layout')



@section('content')




<div class="sejarah-container">



    <h2 class="sejarah-title">

        {{ $sejarah->judul ?? 'Sejarah UPT TIK' }}

    </h2>



    <div class="sejarah-box">



        <!-- SLIDER GAMBAR -->

        <div class="slider-container">

            <button class="slider-btn left" onclick="prevSlide()">❮</button>



            <div class="slider-wrapper">

                @foreach($gambar as $index => $img)

                    <img 

                        class="slide {{ $index == 0 ? 'active' : '' }}" 

                        src="{{ asset('uploads/sejarah/' . $img->gambar) }}"

                        alt="Gambar Sejarah {{ $index + 1 }}">

                @endforeach

            </div>



            <button class="slider-btn right" onclick="nextSlide()">❯</button>

        </div>



        <p class="sejarah-text">

            {{ $sejarah->isi_sejarah ?? 'Data sejarah belum tersedia.' }}

        </p>



    </div>

</div>



<script>

let currentIndex = 0;



function showSlide(index) {

    const slides = document.querySelectorAll(".slide");

    slides.forEach((slide, i) => {

        slide.classList.toggle("active", i === index);

    });

}



function nextSlide() {

    const slides = document.querySelectorAll(".slide");

    if (slides.length === 0) return;

    currentIndex = (currentIndex + 1) % slides.length;

    showSlide(currentIndex);

}



function prevSlide() {

    const slides = document.querySelectorAll(".slide");

    if (slides.length === 0) return;

    currentIndex = (currentIndex - 1 + slides.length) % slides.length;

    showSlide(currentIndex);

}

</script>
<style>

/* =========================
   GLOBAL
========================= */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Poppins',sans-serif;
    background: linear-gradient(135deg,#eef4fb 0%, #ffffff 50%, #e3edf9 100%);
}

/* =========================
   CONTAINER
========================= */
.sejarah-container{
    max-width:1200px;
    margin:90px auto;
    padding:25px;
}

/* =========================
   TITLE
========================= */
.sejarah-title{
    text-align:center;
    font-size:40px;
    font-weight:700;
    margin-bottom:55px;
    color:#1B3B5F;
    letter-spacing:1px;
    position:relative;
}

.sejarah-title::after{
    content:"";
    width:120px;
    height:5px;
    background:#1B3B5F;
    display:block;
    margin:18px auto 0;
    border-radius:50px;
}

/* =========================
   CARD BOX
========================= */
.sejarah-box{
    background:#ffffff;
    border-radius:28px;
    padding:40px;
    border:1px solid #e2e8f0;
    box-shadow:0 25px 70px rgba(27,59,95,.15);
    transition:.4s;
}

.sejarah-box:hover{
    transform:translateY(-8px);
    box-shadow:0 35px 90px rgba(27,59,95,.22);
}

/* =========================
   SLIDER
========================= */
.slider-container{
    position:relative;
    overflow:hidden;
    border-radius:22px;
}

.slider-wrapper{
    position:relative;
    height:470px;
}

/* IMAGE EFFECT */
.slide{
    position:absolute;
    width:100%;
    height:100%;
    object-fit:cover;
    opacity:0;
    transition:opacity .8s ease, transform 4s ease;
    transform:scale(1.05);
}

.slide.active{
    opacity:1;
    transform:scale(1);
}

/* =========================
   NAV BUTTON
========================= */
.slider-btn{
    position:absolute;
    top:50%;
    transform:translateY(-50%);
    width:55px;
    height:55px;
    border-radius:50%;
    border:none;
    cursor:pointer;
    font-size:22px;
    color:white;
    background:#1B3B5F;
    box-shadow:0 10px 30px rgba(27,59,95,.4);
    transition:.3s;
    z-index:10;
}

.slider-btn:hover{
    background:#2e5b89;
    transform:translateY(-50%) scale(1.1);
}

.left{ left:20px; }
.right{ right:20px; }

/* =========================
   TEXT
========================= */
.sejarah-text{
    margin-top:40px;
    font-size:18px;
    line-height:2;
    color:#334155;
    text-align:justify;
}

/* =========================
   RESPONSIVE
========================= */
@media(max-width:768px){

    .sejarah-container{
        margin:60px auto;
        padding:18px;
    }

    .sejarah-title{
        font-size:28px;
    }

    .slider-wrapper{
        height:300px;
    }

    .sejarah-box{
        padding:28px;
    }

}

</style>
@endsection

