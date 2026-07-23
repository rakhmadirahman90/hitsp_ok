<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>ITSP - IT Service Portal</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>

/* ===== GLOBAL ===== */

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

body{
background:#f4f6f9;
display:flex;
flex-direction:column;
min-height:100vh;
}


/* ===== NAVBAR ===== */

.navbar{
background:#111827;
color:white;
position:sticky;
top:0;
z-index:1000;
box-shadow:0 4px 20px rgba(0,0,0,.15);
}

.nav-top{
display:flex;
align-items:center;
justify-content:space-between;
padding:14px 60px;
}


/* ===== LOGO ===== */

.logo{
display:flex;
align-items:center;
gap:10px;
}

.logo img{
    height:70px;
    width:auto;
}

.logo h1{
font-size:20px;
font-weight:600;
}

.logo p{
font-size:12px;
}


/* ===== MENU ===== */

.nav-menu-bar{
display:flex;
align-items:center;
gap:28px;
}

.nav-menu-bar a{
color:white;
text-decoration:none;
font-size:14px;
font-weight:500;
display:flex;
align-items:center;
gap:6px;
}

.nav-menu-bar a:hover{
color:#D97706;
}
/* ===== MENU ACTIVE ===== */

.nav-menu-bar a.active,
.dropbtn.active{
color:#D97706;
border-bottom:3px solid #D97706;
padding-bottom:4px;
font-weight:600;
}

/* ===== LOGIN BUTTON ===== */

.login-btn{
padding:8px 18px;
border-radius:6px;
background:#D97706;
color:white;
text-decoration:none;
font-size:14px;
transition:.3s;
}

.login-btn:hover{
background:#B45309;
}


/* ===== DROPDOWN ===== */

.dropdown{
position:relative;
}

.dropbtn{
background:none;
border:none;
color:white;
font-size:14px;
cursor:pointer;
display:flex;
align-items:center;
gap:6px;
}

.dropdown-content{
display:none;
position:absolute;
top:35px;
background:white;
min-width:220px;
border-radius:10px;
box-shadow:0 10px 25px rgba(0,0,0,.15);
}

.dropdown-content a{
color:#333;
padding:10px 18px;
display:block;
}

.dropdown-content a:hover{
background:#f3f4f6;
}

.dropdown-content{
display:none;
position:absolute;
top:35px;
background:white;
min-width:220px;
border-radius:10px;
box-shadow:0 10px 25px rgba(0,0,0,.15);
}

.dropdown-content.show{
display:block;
}

/* ===== PROFILE ===== */

.profile-area{
display:flex;
align-items:center;
}

.profile-dropdown{
position:relative;
}

.profile-trigger{
display:flex;
align-items:center;
gap:8px;
cursor:pointer;
font-size:14px;
color:white;
}

.profile-icon{
background:#D97706;
padding:8px;
border-radius:50%;
font-size:14px;
}

.user-name{
font-weight:500;
}

.profile-menu{
display:none;
position:absolute;
right:0;
top:40px;
background:white;
border-radius:10px;
box-shadow:0 10px 25px rgba(0,0,0,.15);
min-width:180px;
overflow:hidden;
}

.profile-menu a,
.profile-menu button{
display:flex;
align-items:center;
gap:8px;
width:100%;
padding:10px 15px;
border:none;
background:none;
cursor:pointer;
font-size:14px;
color:#333;
text-decoration:none;
}

.profile-menu a:hover,
.profile-menu button:hover{
background:#f3f4f6;
}


/* ===== HAMBURGER ===== */

.menu-toggle{
display:none;
font-size:22px;
cursor:pointer;
}


/* ===== CONTENT ===== */

.content{
padding:40px 80px;
flex:1;
}


/* ===== FOOTER ===== */

.footer{
background:#111827;
color:white;
padding:40px 80px;
margin-top:auto;
}

.footer-container{
display:flex;
justify-content:space-between;
flex-wrap:wrap;
gap:30px;
}

.footer h3{
margin-bottom:12px;
}

.footer p,
.footer a{
font-size:14px;
color:#d1d5db;
text-decoration:none;
}

.footer a:hover{
color:#D97706;
}

.footer-bottom{
margin-top:25px;
text-align:center;
font-size:13px;
color:#9ca3af;
border-top:1px solid rgba(255,255,255,.1);
padding-top:15px;
}


/* ===== MOBILE ===== */

@media(max-width:900px){

.nav-top{
padding:14px 20px;
}

.menu-toggle{
display:block;
}

.nav-menu-bar{
position:absolute;
top:65px;
left:0;
width:100%;
background:white;
flex-direction:column;
align-items:flex-start;
padding:20px;
gap:18px;
display:none;
}

.nav-menu-bar.active{
display:flex;
}

.nav-menu-bar a{
color:#111827;
width:100%;
}

.dropbtn{
color:#111827;
width:100%;
justify-content:space-between;
}

.dropdown{
width:100%;
}

.dropdown-content{
position:relative;
top:0;
box-shadow:none;
width:100%;
}

.login-btn{
width:100%;
text-align:center;
}

.profile-trigger{
color:#111827;
}

.content{
padding:25px;
}

.footer{
padding:30px 20px;
}

.footer-container{
flex-direction:column;
}

}
.disabled-menu{
    color:#9ca3af !important;
    cursor:not-allowed;
    opacity:0.6;
}

.disabled-menu:hover{
    color:#9ca3af !important;
}
</style>
</head>

<body>


<!-- ===== NAVBAR ===== -->

<div class="navbar">

<div class="nav-top">

<div class="logo">

<img src="{{ asset('images/logo_itsp.png') }}" alt="logo">

<div>
<h1>ITSP</h1>
<p style="color:#D97706">IT Service Portal</p>
</div>

</div>


<div class="menu-toggle" id="menuToggle">
<i class="fa-solid fa-bars"></i>
</div>

<nav class="nav-menu-bar" id="navMenu">

<a href="{{ route('dashboard') }}" 
class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
<i class="fa-solid fa-house"></i> Beranda
</a>


<div class="dropdown">
<button class="dropbtn 
{{ request()->routeIs('user.visimisi','user.sejarah','struktur','masterplane') ? 'active' : '' }}">
<i class="fa-solid fa-building"></i>
Tentang Kami
<i class="fa-solid fa-chevron-down"></i>
</button>

<div class="dropdown-content">
<a href="{{ route('user.visimisi') }}">Visi Misi</a>
<a href="{{ route('user.sejarah') }}">Sejarah</a>
<a href="{{ route('struktur') }}">Struktur Organisasi</a>
<a href="{{ route('masterplane') }}">Master Plan TIK</a>
</div>
</div>


<div class="dropdown">
<button class="dropbtn
{{ request()->routeIs('pilihemail','zoom.my','requestdomain','hotspot.form') ? 'active' : '' }}">
<i class="fa-solid fa-headset"></i>
Layanan
<i class="fa-solid fa-chevron-down"></i>
</button>

<div class="dropdown-content">
<a href="{{ route('pilihemail') }}">Request Pembuatan Email</a>
<a href="{{ route('zoom.create') }}">Request Pembuatan Zoom</a>
<a href="{{ route('requestdomain') }}">Hosting Web</a>
<a href="{{ route('hotspot.form') }}">Buat Akun Hotspot</a>
</div>
</div>


<div class="dropdown">
<button class="dropbtn
{{ request()->routeIs('laporan.create','tracking','faq') ? 'active' : '' }}">
<i class="fa-solid fa-circle-question"></i>
Helpdesk IT
<i class="fa-solid fa-chevron-down"></i>
</button>

<div class="dropdown-content">
<a href="{{ route('laporan.create') }}">Pengajuan Laporan</a>
<a href="{{ route('tracking') }}">Tracking Status Ticket</a>
<a href="{{ route('faq') }}">FAQ & Panduan</a>
</div>
</div>


<a href="{{ route('fasilitas') }}"
class="{{ request()->routeIs('fasilitas') ? 'active' : '' }}">
<i class="fa-solid fa-building-columns"></i> Fasilitas
</a>
<!-- PROFILE AREA -->

<div class="profile-area">

@guest
<a href="{{ route('login') }}" class="login-btn">
<i class="fa-solid fa-right-to-bracket"></i> Login
</a>
@endguest


@auth

<div class="profile-dropdown">

<div class="profile-trigger" id="profileToggle">
<i class="fa-solid fa-user profile-icon"></i>
<span class="user-name">{{ Auth::user()->name }}</span>
<i class="fa-solid fa-chevron-down"></i>
</div>

<div class="profile-menu" id="profileMenu">

<a href="{{ route('profile') }}">
<i class="fa-solid fa-user"></i> Profil Saya
</a>

<form action="{{ route('logout') }}" method="POST">
@csrf
<button type="submit">
<i class="fa-solid fa-right-from-bracket"></i> Logout
</button>
</form>

</div>

</div>

@endauth

</div>


</nav>

</div>

</div>


<!-- ===== CONTENT ===== -->

<div class="content">

@yield('content')

</div>


<!-- ===== FOOTER ===== -->

<footer class="footer">

<div class="footer-container">

<div>
<h3>ITSP</h3>
<p>IT Service Portal</p>
<p>Layanan Teknologi Informasi.</p>
</div>

<div>
<h3>Layanan</h3>
<p><a href="{{ route('pilihemail') }}">Request Email</a></p>
@auth
    @if(Auth::user()->role == 'dosen' || Auth::user()->role == 'staf')
        <a href="{{ route('zoom.create') }}">
            Request Pembuatan Zoom
        </a>
    @else
        <a href="javascript:void(0)" class="disabled-menu" onclick="aksesZoomDitolak()">
            Request Pembuatan Zoom
        </a>
    @endif
@endauth
<p><a href="{{ route('requestdomain') }}">Hosting Website</a></p>
</div>

<div>
<h3>Helpdesk</h3>
<p><a href="{{ route('laporan.create') }}">Buat Laporan</a></p>
<p><a href="{{ route('tracking') }}">Tracking Ticket</a></p>
<p><a href="{{ route('faq') }}">FAQ</a></p>
</div>

<div>
<h3>Kontak</h3>
<p>Email: it-support@gmail.com</p>
<p>Telp: (0421) 123456</p>
</div>

</div>

<div class="footer-bottom">
� {{ date('Y') }} ITSP - IT Service Portal
</div>

</footer>


<script>

const menuToggle = document.getElementById("menuToggle");
const navMenu = document.getElementById("navMenu");

menuToggle.addEventListener("click", function(){
navMenu.classList.toggle("active");
});

const profileToggle = document.getElementById("profileToggle");
const profileMenu = document.getElementById("profileMenu");

if(profileToggle){
profileToggle.addEventListener("click", function(){
profileMenu.style.display =
profileMenu.style.display === "block" ? "none" : "block";
});
}

window.addEventListener("click", function(e){
if(!e.target.closest(".profile-dropdown")){
if(profileMenu){
profileMenu.style.display="none";
}
}
});
const dropdownButtons = document.querySelectorAll(".dropbtn");

dropdownButtons.forEach(button => {

button.addEventListener("click", function(e){

e.stopPropagation();

let dropdown = this.nextElementSibling;

/* tutup dropdown lain */
document.querySelectorAll(".dropdown-content").forEach(menu=>{
if(menu !== dropdown){
menu.classList.remove("show");
}
});

/* toggle dropdown */
dropdown.classList.toggle("show");

});

});

/* klik di luar dropdown -> tutup */
window.addEventListener("click", function(){

document.querySelectorAll(".dropdown-content").forEach(menu=>{
menu.classList.remove("show");
});

});

</script>
@if(session('error'))
<script>
Swal.fire({
    icon:'warning',
    title:'Akses Ditolak',
    text:'{{ session("error") }}',
    confirmButtonColor:'#d97706'
});
</script>
<script>
function aksesZoomDitolak(){
    Swal.fire({
        icon: 'warning',
        title: 'Akses Ditolak',
        text: 'Zoom hanya dapat diakses oleh Dosen dan Staf',
        confirmButtonColor: '#d97706'
    });
}
</script>
@endif
</body>
</html>