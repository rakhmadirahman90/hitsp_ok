@extends('operator.layout')

@section('content')

<h2>Daftar Request Zoom</h2>

@if(session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert-danger">
        {{ session('error') }}
    </div>
@endif

@if(session('info'))
    <div class="alert-info">
        {{ session('info') }}
    </div>
@endif

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>

/* ================= GLOBAL ================= */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    background: #f3f4f6;
    color: #374151;
}

/* ================= TITLE ================= */
h2 {
    text-align: center;
    margin-bottom: 20px;
}

/* ================= ALERT ================= */
.alert-success {
    margin-bottom:15px;
    padding:10px;
    background:#d1fae5;
    color:#065f46;
    border-radius:8px;
    text-align:center;
}

.alert-danger {
    margin-bottom:15px;
    padding:10px;
    background:#fee2e2;
    color:#991b1b;
    border-radius:8px;
    text-align:center;
}

.alert-info {
    margin-bottom:15px;
    padding:10px;
    background:#e0f2fe;
    color:#0369a1;
    border-radius:8px;
    text-align:center;
}

/* ================= TABLE ================= */
.table-wrapper {
    overflow-x: auto;
}

.zoom-table {
    width: 100%;
    min-width: 650px;
    border-collapse: collapse;
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
}

.zoom-table th,
.zoom-table td {
    padding: 14px;
}

.zoom-table thead {
    background: #e5e7eb;
}

/* ================= BADGE ================= */
.badge {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
}

.pending {
    background: #fefce8;
    color: #78350f;
}

.active {
    background: #ecfdf5;
    color: #166534;
}

.approved {
    background: #ecfdf5;
    color: #166534;
}

.rejected {
    background: #fef2f2;
    color: #991b1b;
}

.disabled {
    background: #e5e7eb;
    color: #374151;
}

/* ================= BUTTON ================= */
.action-btn {
    width: 34px;
    height: 34px;
    border-radius: 8px;
    border: none;
    color: #fff;
    cursor: pointer;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    text-decoration:none;
}

.detail-btn {
    background: #3b82f6;
}

.delete-btn {
    background: #ef4444;
}

.disable-btn {
    background: #f59e0b;
}

.disable-btn:hover {
    background: #d97706;
}

/* ================= CARD (MOBILE) ================= */
.card-container {
    display: none;
}

.zoom-card {
    background: #fff;
    border-radius: 12px;
    padding: 15px;
    margin-bottom: 12px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
}

.zoom-card h4 {
    margin-bottom: 8px;
}

.zoom-card p {
    font-size: 13px;
    margin-bottom: 5px;
}

.card-actions {
    margin-top: 10px;
    display: flex;
    gap: 5px;
    align-items: center;
}

/* ================= EMPTY STATE ================= */
.empty-state {
    text-align: center;
    padding: 40px;
    color: #6b7280;
}

.empty-state i {
    font-size: 40px;
    margin-bottom: 10px;
    color: #9ca3af;
}

/* ================= RESPONSIVE ================= */
@media (max-width: 768px) {

    .table-wrapper {
        display: none;
    }

    .card-container {
        display: block;
    }

    h2 {
        font-size: 18px;
    }
}

/* ================= PAGINATION ================= */
.pagination-wrap{
display:flex;
justify-content:center;
margin-top:30px;
}

.pagination{
display:flex;
gap:8px;
list-style:none;
flex-wrap:wrap;
padding:0;
}

.pagination li a,
.pagination li span{
display:flex;
align-items:center;
justify-content:center;
min-width:40px;
height:40px;
padding:0 14px;
border-radius:10px;
text-decoration:none;
background:#fff;
color:#374151;
border:1px solid #d1d5db;
font-weight:600;
transition:.3s;
}

.pagination li a:hover{
background:#3b82f6;
color:#fff;
border-color:#3b82f6;
}

.pagination .active span{
background:#3b82f6;
color:#fff;
border-color:#3b82f6;
}

.pagination .disabled span{
opacity:.45;
cursor:not-allowed;
}

@media(max-width:768px){

.pagination li a,
.pagination li span{
min-width:35px;
height:35px;
font-size:13px;
padding:0 10px;
}

}
</style>

@php
    $isEmpty = count($requests) == 0;
@endphp

<div class="table-wrapper">

@if(!$isEmpty)

<table class="zoom-table">

<thead>
<tr>
<th>No</th>
<th>Nama</th>
<th>Kegiatan</th>
<th>Tanggal</th>
<th>Status</th>
<th>Aksi</th>
</tr>
</thead>

<tbody>

@foreach($requests as $i => $req)

<tr>

<td>{{ $requests->firstItem() + $i }}</td>

<td>{{ $req->nama }}</td>

<td>{{ $req->jenis_kegiatan }}</td>

<td>
    {{ date('d/m/Y', strtotime($req->tanggal)) }}
</td>

<td>

    <span class="badge {{ $req->status }}">

        {{ ucfirst($req->status) }}

    </span>

</td>

<td>

    {{-- DETAIL --}}
    <a href="{{ route('admin.zoom.show',$req->id) }}"
       class="action-btn detail-btn">

        <i class="fa-solid fa-eye"></i>

    </a>

    {{-- DISABLE (MENU NONAKTIFKAN - SINKRON DENGAN POLA HOSTING) --}}
    @if($req->status == 'active' || $req->status == 'approved')

    <form action="{{ route('admin.zoom.disable',$req->id) }}"
          method="POST"
          style="display:inline;">

        @csrf

        <button type="submit"
                class="action-btn disable-btn"
                title="Nonaktifkan Layanan">

            <i class="fa-solid fa-ban"></i>

        </button>

    </form>

    @endif

    {{-- DELETE --}}
    <form action="{{ route('admin.zoom.delete',$req->id) }}"
          method="POST"
          style="display:inline;">

        @csrf
        @method('DELETE')

        <button type="submit"
                class="action-btn delete-btn">

            <i class="fa-solid fa-trash"></i>

        </button>

    </form>

</td>

</tr>

@endforeach

</tbody>
</table>

@if($requests->hasPages())

<div class="pagination-wrap">

    {{ $requests->links('pagination::bootstrap-5') }}

</div>

@endif

@else

<div class="empty-state">

    <i class="fa-solid fa-calendar-xmark"></i>

    <p>
        <b>Belum ada pengajuan request Zoom masuk</b>
    </p>

</div>

@endif

</div>

<div class="card-container">

@if(!$isEmpty)

@foreach($requests as $req)

<div class="zoom-card">

    <h4>{{ $req->nama }}</h4>

    <p>
        <b>Kegiatan:</b>
        {{ $req->jenis_kegiatan }}
    </p>

    <p>
        <b>Tanggal:</b>
        {{ date('d/m/Y', strtotime($req->tanggal)) }}
    </p>

    <p>

        <span class="badge {{ $req->status }}">

            {{ ucfirst($req->status) }}

        </span>

    </p>

    <div class="card-actions">

        {{-- DETAIL --}}
        <a href="{{ route('admin.zoom.show',$req->id) }}"
           class="action-btn detail-btn">

            <i class="fa-solid fa-eye"></i>

        </a>

        {{-- DISABLE MOBILE --}}
        @if($req->status == 'active' || $req->status == 'approved')

        <form action="{{ route('admin.zoom.disable',$req->id) }}"
              method="POST"
              style="display:inline;">

            @csrf

            <button type="submit"
                    class="action-btn disable-btn"
                    title="Nonaktifkan Layanan">

                <i class="fa-solid fa-ban"></i>

            </button>

        </form>

        @endif

        {{-- DELETE --}}
        <form action="{{ route('admin.zoom.delete',$req->id) }}"
              method="POST"
              style="display:inline;">

            @csrf
            @method('DELETE')

            <button type="submit"
                    class="action-btn delete-btn">

                <i class="fa-solid fa-trash"></i>

            </button>

        </form>

    </div>

</div>

@endforeach

@if($requests->hasPages())

<div class="pagination-wrap">

    {{ $requests->links('pagination::bootstrap-5') }}

</div>

@endif

@else

<div class="empty-state">

    <i class="fa-solid fa-calendar-xmark"></i>

    <p>
        <b>Belum ada pengajuan request Zoom masuk</b>
    </p>

</div>

@endif

</div>

<script>

// JS UNTUK TOMBOL HAPUS LAMA (TIDAK BERUBAH)
document.querySelectorAll('.delete-btn').forEach(button => {

    button.addEventListener('click', function (e) {

        e.preventDefault();

        let form = this.closest('form');

        let name =
            this.closest('tr')?.children[1]?.innerText
            ||
            this.closest('.zoom-card')?.querySelector('h4')?.innerText;

        Swal.fire({

            title: 'Yakin mau hapus?',

            text: name + " akan dihapus permanen!",

            icon: 'warning',

            showCancelButton: true,

            confirmButtonColor: '#ef4444',

            cancelButtonColor: '#6b7280',

            confirmButtonText: 'Ya, hapus!',

            cancelButtonText: 'Batal'

        }).then((result) => {

            if (result.isConfirmed) {

                form.submit();

            }

        });

    });

});

</script>

@endsection