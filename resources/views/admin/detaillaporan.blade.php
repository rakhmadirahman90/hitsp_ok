@extends('operator.layout')



@section('title', 'Detail Laporan')



@section('content')

<link rel="stylesheet" href="{{ asset('css/admin/detaillaporan.css') }}">

<!-- Tambahkan SweetAlert2 CSS -->

<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">



<div class="admin-laporan-wrapper">

    <h2 class="page-title">Detail Laporan</h2>



    <table class="table table-bordered" style="width:100%; max-width:800px;">

        <tr>

            <th>Ticket No</th>

            <td>{{ $laporan->ticket_no ?? $laporan->id }}</td>

        </tr>

        <tr>

            <th>Nama Pengirim</th>

            <td>{{ $laporan->nama_pengirim }}</td>

        </tr>

        <tr>

            <th>Status Pengirim</th>

            <td>{{ $laporan->status_pengirim }}</td>

        </tr>

        <tr>

            <th>Judul</th>

            <td>{{ $laporan->judul }}</td>

        </tr>

        <tr>

            <th>Kategori</th>

            <td>{{ $laporan->kategori }}</td>

        </tr>

        <tr>

            <th>Urgensi</th>

            <td>{{ $laporan->tingkat_urgensi }}</td>

        </tr>

        <tr>

            <th>AreaLayanan</th>

            <td>{{ $laporan->lokasi }}</td>

        </tr>

        <tr>

            <th>Tanggal</th>

            <td>{{ \Carbon\Carbon::parse($laporan->tanggal)->format('d-m-Y') }}</td>

        </tr>

        <tr>

            <th>Status</th>

            <td>

                @if($laporan->status == 'Menunggu' || $laporan->status == 'Pending')

                    <span class="badge bg-warning text-dark">Pending</span>

                @else

                    <span class="badge bg-success">Selesai</span>

                @endif

            </td>

        </tr>

        <tr>

            <th>Bukti</th>

            <td>

                @if($laporan->bukti)

                    <a href="{{ asset('storage/' . $laporan->bukti) }}" target="_blank">Lihat Bukti</a>

                @else

                    -

                @endif

            </td>

        </tr>

    </table>



    <div style="margin-top:20px;">

        <a href="{{ route('admin.laporan.index') }}" class="btn btn-info">Kembali</a>



        @if($laporan->status == 'Pending' || $laporan->status == 'Menunggu')

        <form id="terimaForm" action="{{ route('admin.laporan.terima', $laporan->id) }}" method="POST" style="display:inline-block;">

            @csrf

            @method('PATCH')

            <button type="button" class="btn btn-success" onclick="confirmTerima()">Terima</button>

        </form>

        @endif

    </div>

</div>



<!-- SweetAlert2 JS -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

    function confirmTerima() {

        Swal.fire({

            title: 'Apakah Anda yakin?',

            text: "Anda akan menerima laporan ini!",

            icon: 'warning',

            showCancelButton: true,

            confirmButtonColor: '#00b894',

            cancelButtonColor: '#d33',

            confirmButtonText: 'Ya, Terima!',

            cancelButtonText: 'Batal'

        }).then((result) => {

            if (result.isConfirmed) {

                // Submit form jika user klik "Ya, Terima!"

                document.getElementById('terimaForm').submit();

            }

        });

    }

</script>
<style>
/* ================= WRAPPER ================= */
.admin-laporan-wrapper {
    background: #f8fafc;
    padding: 30px;
    border-radius: 16px;
}

/* ================= TITLE ================= */
.page-title {
    font-size: 22px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 25px;
}

/* ================= TABLE CARD ================= */
.table {
    background: #ffffff;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 8px 20px rgba(0,0,0,0.05);
    border: none;
}

/* header kiri */
.table th {
    width: 30%;
    background: #f1f5f9;
    color: #475569;
    font-weight: 600;
    padding: 14px;
    border: none;
}

/* isi kanan */
.table td {
    padding: 14px;
    color: #334155;
    border: none;
    background: #ffffff;
}

/* garis halus antar baris */
.table tr:not(:last-child) td,
.table tr:not(:last-child) th {
    border-bottom: 1px solid #f1f5f9;
}

/* ================= LINK ================= */
.table a {
    color: #0ea5e9;
    font-weight: 500;
    text-decoration: none;
}

.table a:hover {
    text-decoration: underline;
}

/* ================= BADGE ================= */
.badge {
    padding: 6px 12px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
}

/* pending */
.bg-warning {
    background: #fef3c7 !important;
    color: #92400e !important;
}

/* selesai */
.bg-success {
    background: #dcfce7 !important;
    color: #166534 !important;
}

/* ================= BUTTON ================= */
.btn {
    border-radius: 10px;
    padding: 8px 18px;
    font-size: 14px;
    font-weight: 600;
    transition: 0.3s;
    border: none;
}

/* tombol kembali */
.btn-info {
    background: #e2e8f0;
    color: #334155;
}

.btn-info:hover {
    background: #cbd5e1;
    transform: translateY(-2px);
}

/* tombol terima */
.btn-success {
    background: #10b981;
    color: white;
}

.btn-success:hover {
    background: #059669;
    transform: translateY(-2px);
    box-shadow: 0 6px 14px rgba(16,185,129,0.25);
}

/* ================= SPACING BUTTON ================= */
.admin-laporan-wrapper .btn {
    margin-right: 8px;
}

/* ================= RESPONSIVE ================= */
@media (max-width: 768px) {
    .table {
        font-size: 13px;
    }

    .btn {
        width: 100%;
        margin-top: 10px;
    }
}
</style>

@endsection

