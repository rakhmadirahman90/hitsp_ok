<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>{{ $title ?? 'HITSP' }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body>

<div class="wrapper">

<!-- SIDEBAR -->
<aside class="sidebar">
    <div class="sidebar-header">
        <img src="{{ asset('images/logo_itsp.png') }}" alt="Logo ITSP">
        <div class="brand-text">
            <h4>ITSP</h4>
            <small>IT Service Portal</small>
        </div>
    </div>

<ul class="menu">

    <li class="menu-title">Manajemen</li>

    @if(Auth::check() && strtolower(Auth::user()->role) === 'operator')
 <li>
        <a href="{{ route('admin.keloladashboard') }}" class="{{ request()->routeIs('admin.keloladashboard') ? 'active' : '' }}">
            <i class="fa-solid fa-gauge-high"></i>
            <span>Kelola Dashboard</span>
        </a>
    </li>

       @endif

    @if(Auth::check() && strtolower(Auth::user()->role) === 'operator')

    <li class="menu-title">Layanan</li>

    <li>
        <a href="{{ route('admin.zoom.index') }}" class="{{ request()->routeIs('admin.zoom.index') ? 'active' : '' }}">
            <i class="fa-solid fa-video"></i>
            <span>Request Zoom</span>
        </a>
    </li>

    <li>
        <a href="{{ route('admin.subdomain.index') }}" class="{{ request()->routeIs('admin.subdomain.index') ? 'active' : '' }}">
            <i class="fa-solid fa-server"></i>
            <span>Request Hosting</span>
        </a>
    </li>

    <li>
        <a href="{{ route('admin.kelolaemail') }}" class="{{ request()->routeIs('admin.kelolaemail') ? 'active' : '' }}">
            <i class="fa-solid fa-envelope"></i>
            <span>Email</span>
        </a>
    </li>

    <li>
        <a href="{{ route('admin.hotspot.index') }}" class="{{ request()->routeIs('admin.hotspot.index') ? 'active' : '' }}">
            <i class="fa-solid fa-wifi"></i>
            <span>Kelola Hotspot</span>
        </a>
    </li>
    @endif


    <li class="menu-title">Tentang Kami</li>

    <li>
        <a href="{{ route('admin.visimisi.index') }}" class="{{ request()->routeIs('admin.visimisi.index') ? 'active' : '' }}">
            <i class="fa-solid fa-bullseye"></i>
            <span>Visi & Misi</span>
        </a>
    </li>

    <li>
        <a href="{{ route('kelolasejarah') }}" class="{{ request()->routeIs('kelolasejarah') ? 'active' : '' }}">
            <i class="fa-solid fa-clock-rotate-left"></i>
            <span>Sejarah UPT TIK</span>
        </a>
    </li>

    <li>
        <a href="{{ route('admin.struktur') }}" class="{{ request()->routeIs('admin.struktur') ? 'active' : '' }}">
            <i class="fa-solid fa-sitemap"></i>
            <span>Struktur Organisasi</span>
        </a>
    </li>

    <li>
        <a href="{{ route('admin.kelolamasterplane') }}" class="{{ request()->routeIs('admin.kelolamasterplane') ? 'active' : '' }}">
            <i class="fa-solid fa-building"></i>
            <span>Master Plan UPT TIK</span>
        </a>
    </li>


    <li class="menu-title">Helpdesk</li>

    <li>
        <a href="{{ route('admin.laporan.index') }}" class="{{ request()->routeIs('admin.laporan.index') ? 'active' : '' }}">
            <i class="fa-solid fa-file-lines"></i>
            <span>Laporan</span>
        </a>
    </li>

    <li>
        <a href="{{ route('kelolafaq') }}" class="{{ request()->routeIs('kelolafaq') ? 'active' : '' }}">
            <i class="fa-solid fa-circle-question"></i>
            <span>FAQ & Panduan</span>
        </a>
    </li>


    <li class="menu-title">Fasilitas</li>

    <li>
        <a href="{{ route('kelolafasilitas') }}" class="{{ request()->routeIs('kelolafasilitas') ? 'active' : '' }}">
            <i class="fa-solid fa-building"></i>
            <span>Fasilitas</span>
        </a>
    </li>

</ul></aside>

<!-- MAIN -->
<main class="main">
<header class="topbar">

    <!-- HAMBURGER -->
    <div class="menu-toggle" id="menuToggle">
        <i class="fa-solid fa-bars"></i>
    </div>

    <!-- KANAN (NOTIF + PROFILE) -->
    <div class="topbar-right">

        <!-- NOTIFIKASI ICON -->
        <div class="notif-wrapper">
           <a href="{{ route('admin.notifikasi') }}" class="notif-icon">
    <i class="fa-solid fa-bell"></i>

    <span id="notifBadge" class="notif-badge">
        {{ $notifTotal ?? 0 }}
    </span>
</a>

                @if(isset($notifTotal) && $notifTotal > 0)
                    <span class="notif-badge">{{ $notifTotal }}</span>
                @endif
            </a>
        </div>

        <!-- PROFILE -->
        <div class="profile-dropdown" style="position: relative;">
            <div class="profile-trigger" id="adminProfileToggle">
                <i class="fa-solid fa-user-circle"></i>
                <div style="display:flex; flex-direction:column;">
                    <span>{{ Auth::user()->name }}</span>
                    <small style="font-size:10px;">{{ Auth::user()->role }}</small>
                </div>
            </div>

            <div class="profile-menu" id="adminProfileMenu">
                <a href="{{ route('operator.profile') }}">
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

    </div>

</header>

<section class="content">
    @yield('content')
</section>

</main>

</div>
<script>
function updateNotif() {
    fetch("{{ route('admin.notif.count') }}")
        .then(res => res.json())
        .then(data => {
            let badge = document.getElementById("notifBadge");

            if (data.count > 0) {
                badge.style.display = "flex";
                badge.innerText = data.count;
            } else {
                badge.style.display = "none";
            }
        });
}

// cek tiap 5 detik
setInterval(updateNotif, 5000);

// pertama kali load
updateNotif();
</script>
<script>
// SIDEBAR
const menuToggle = document.getElementById("menuToggle");
const sidebar = document.querySelector(".sidebar");

menuToggle.addEventListener("click", function(e){
    e.stopPropagation();
    sidebar.classList.toggle("active");
});

document.addEventListener("click", function(e){
    if(!sidebar.contains(e.target) && !menuToggle.contains(e.target)){
        sidebar.classList.remove("active");
    }
});

// PROFILE FIX
const toggle = document.getElementById("adminProfileToggle");
const menu = document.getElementById("adminProfileMenu");

toggle.addEventListener("click", function(e){
    e.stopPropagation();
    menu.classList.toggle("show");
});

document.addEventListener("click", function(e){
    if (!menu.contains(e.target) && !toggle.contains(e.target)) {
        menu.classList.remove("show");
    }
});</script>

</body>
<style>
.topbar{
    justify-content: flex-start;
    gap: 20px;
}

.topbar-right{
    margin-left: auto;  /* tetap di kanan tapi bisa diatur jaraknya */
    margin-right: 40px; /* geser dari ujung kanan */
    display: flex;
    align-items: center;
    gap: 12px;
}/* ================= NOTIFIKASI ICON ================= */

.notif-wrapper{
    position: relative;
}

.notif-icon{
    color: #fff;
    font-size: 20px;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 10px;
    text-decoration: none;
    transition: 0.3s;
}

.notif-icon:hover{
    background: rgba(255,255,255,0.1);
}

.notif-icon i{
    font-size: 22px;
    color: #F77F00;
}

/* badge angka */
.notif-badge{
    position: absolute;
    top: 2px;
    right: 2px;
    background: red;
    color: white;
    font-size: 11px;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    animation: pulse 1.5s infinite;
}

/* animasi kecil */
@keyframes pulse{
    0%{transform:scale(1);}
    50%{transform:scale(1.2);}
    100%{transform:scale(1);}
}
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

/* PENTING BIAR SCROLL NORMAL */
html, body {
    height: 100%;
    overflow-x: hidden;
    overflow-y: auto;
}

body {
    background: #D9D9D9;
}

/* WRAPPER */
.wrapper {
    display: flex;
    min-height: 100vh;
}

/* SIDEBAR */
.sidebar {
    width: 270px;
    background: #1B3B5F;
    color: #fff;
    transition: 0.3s;
    flex-shrink: 0;
}

/* HEADER SIDEBAR */
.sidebar-header {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 25px 15px;
    text-align: center;
}

.sidebar-header img {
    width: 150px;
    margin-bottom: 10px;
}

.brand-text h4 {
    font-size: 18px;
    font-weight: 600;
}

.brand-text small {
    font-size: 12px;
    color: #F77F00;
}

/* MENU */
.menu {
    list-style: none;
    padding: 15px;
}

.menu-title {
    margin: 18px 0 8px;
    font-size: 11px;
    text-transform: uppercase;
    color: #F77F00;
}

.menu li a {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 15px;
    margin-bottom: 6px;
    color: #fff;
    text-decoration: none;
    border-radius: 8px;
    transition: 0.3s;
    font-size: 14px;
}

.menu li a:hover,
.menu li a.active {
    background: #F77F00;
    color: #1B3B5F;
    transform: translateX(6px);
}

/* MAIN */
.main {
    flex: 1;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    background: #fff;
}

/* TOPBAR */
.topbar {
    height: 60px;
    background: #1B3B5F;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 20px;
}

/* HAMBURGER */
.menu-toggle {
    display: none;
    font-size: 22px;
    color: #fff;
    cursor: pointer;
}

/* PROFILE */
.profile-trigger {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    color: #fff;
}

/* CONTENT (INI YANG BIKIN BISA SCROLL) */
.content {
    padding: 25px;
    flex: 1;
    overflow-y: auto;
    -webkit-overflow-scrolling: touch;
}

/* DROPDOWN */
.profile-menu {
    position: absolute;
    right: 0;
    top: 45px;
    width: 170px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 12px 25px rgba(0,0,0,0.15);
    display: none;
    z-index: 999;
}

.profile-menu a,
.profile-menu button {
    width: 100%;
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 16px;
    background: none;
    border: none;
    font-size: 14px;
    color: #0E243A;
    cursor: pointer;
}

.profile-menu a:hover,
.profile-menu button:hover {
    background: #f3f4f6;
}

/* RESPONSIVE MOBILE FIX */
@media (max-width: 768px) {

    .sidebar {
        position: fixed;
        top: 0;
        left: -270px;
        height: 100vh;
        overflow-y: auto;
        z-index: 1000;
    }

    .sidebar.active {
        left: 0;
    }

    .menu-toggle {
        display: block;
    }

    body {
        overflow-y: auto !important;
    }
}
/* === TAMBAHAN PROFILE MODERN === */

/* trigger hover */
.profile-trigger {
    padding: 6px 10px;
    border-radius: 10px;
    transition: 0.3s;
}

.profile-trigger:hover {
    background: rgba(255,255,255,0.1);
}

/* icon lebih keren */
.profile-trigger i {
    font-size: 26px;
    color: #F77F00;
}

/* dropdown animasi */
.profile-menu {
    opacity: 0;
    transform: translateY(10px);
    transition: all 0.25s ease;
}

/* aktif */
.profile-menu.show {
    display: block;
    opacity: 1;
    transform: translateY(0);
}

/* item hover lebih hidup */
.profile-menu a:hover,
.profile-menu button:hover {
    background: #f3f4f6;
    color: #F77F00;
}

/* divider */
.profile-menu a:not(:last-child),
.profile-menu button:not(:last-child) {
    border-bottom: 1px solid #eee;
}

/* ================= FIX RESPONSIVE UTAMA ================= */

@media (max-width: 768px) {

    /* ubah layout jadi vertikal */
    .wrapper {
        flex-direction: column;
    }

    /* content full width */
    .main {
        width: 100%;
        min-height: auto;
    }

    .content {
        padding: 15px !important;
        width: 100%;
    }

    /* sidebar jadi overlay (sudah benar, tapi dipertegas) */
    .sidebar {
        position: fixed;
        top: 0;
        left: -270px;
        height: 100vh;
        z-index: 1000;
        transition: 0.3s;
    }

    .sidebar.active {
        left: 0;
    }

    /* tabel supaya tidak rusak */
    table {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }

    /* tombol header jangan sejajar */
    .header-action {
        display: flex;
        flex-direction: column;
        gap: 8px;
        width: 100%;
    }

    .header-action button {
        width: 100%;
    }
}
</style>

</html>