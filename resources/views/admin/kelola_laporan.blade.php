@extends('operator.layout')

@section('title', 'Kelola Laporan')

@section('content')

<!-- FONT AWESOME -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<!-- CUSTOM CSS -->
<link rel="stylesheet" href="{{ asset('css/admin/laporan.css') }}">
<style>
/* ================= BODY ================= */
body {
    background: #f4f6f9;
    font-family: 'Poppins', sans-serif;
}

/* ================= WRAPPER ================= */
.admin-laporan-wrapper {
    max-width: 1050px;
    margin: 30px auto;
    padding: 20px;
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.05);
}

/* ================= TITLE ================= */
.page-title {
    font-size: 22px;
    color: #1e293b;
    margin-bottom: 20px;
    font-weight: 700;
    text-align: center;
}

/* ================= TABLE DESKTOP ================= */
.table-responsive {
    overflow-x: auto;
    border-radius: 12px;
}

.table {
    width: 100%;
    border-collapse: collapse;
    font-size: 12px;
    min-width: 820px;
    table-layout: fixed;
}

.table th {
    background: #1e293b;
    color: #fff;
    padding: 8px 6px;
    font-weight: 600;
    font-size: 11.5px;
    text-align: center;
}

.table td {
    padding: 8px 6px;
    font-size: 12px;
    background: #fff;
    border-bottom: 1px solid #eef2f7;
    text-align: center;
    white-space: nowrap;
}

.table tr:nth-child(even) td {
    background: #f8fafc;
}

.table tbody tr:hover td {
    background: #f1f5f9;
}

/* ================= BADGE ================= */
.badge {
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
}

.bg-warning { background: #facc15; color:#000; }
.bg-primary { background: #3b82f6; color:#fff; }
.bg-success { background: #10b981; color:#fff; }

/* ================= BUTTON ================= */
.action-buttons {
    display: flex;
    justify-content: center;
    gap: 5px;
}

.btn {
    padding: 5px 7px;
    font-size: 12px;
    border-radius: 6px;
    border: none;
    cursor: pointer;
}

.btn-info { background: #3b82f6; color:#fff; }
.btn-success { background: #10b981; color:#fff; }
.btn-danger { background: #ef4444; color:#fff; }

/* ================= MODAL ================= */
.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.55);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
    opacity: 0;
    pointer-events: none;
}

.modal-overlay.active {
    opacity: 1;
    pointer-events: auto;
}

.modal-content {
    background: #fff;
    padding: 22px;
    border-radius: 14px;
    text-align: center;
    max-width: 380px;
    width: 90%;
}

/* ================= ?? MOBILE FIX (INI PERBAIKAN UTAMA) ================= */
@media (max-width: 768px) {

    .admin-laporan-wrapper {
        padding: 12px;
    }

    /* HILANGKAN TABLE HEADER */
    .table thead {
        display: none;
    }

    /* JADI CARD BENERAN */
    .table,
    .table tbody,
    .table tr {
        display: block;
        width: 100%;
    }

    .table tr {
        background: #fff;
        margin-bottom: 12px;
        border-radius: 14px;
        padding: 12px;
        box-shadow: 0 4px 14px rgba(0,0,0,0.08);
        border: 1px solid #eef2f7;
    }

    /* TIAP FIELD JADI ROW RAPI */
    .table td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 6px 0;
        border: none;
        font-size: 13px;
        white-space: normal;
        text-align: left;
    }

    /* LABEL KIRI */
    .table td::before {
        content: attr(data-label);
        font-weight: 600;
        font-size: 12px;
        color: #64748b;
    }

    /* VALUE KANAN */
    .table td {
        color: #1e293b;
    }

    /* ACTION BUTTON RAPI */
    .action-buttons {
        justify-content: flex-end;
        gap: 6px;
    }

    .btn {
        padding: 6px 8px;
        font-size: 12px;
    }
}
}</style>

<!-- ================= CONTENT ================= -->
<div class="admin-laporan-wrapper">

    <h2 class="page-title">Daftar Laporan</h2>

   <div class="table-responsive">
    <table class="table table-bordered table-striped">
       <thead>
    <tr>
        <th>Ticket No</th>
        <th>Nama Pengirim</th>
        <th>Status Pengirim</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>
</thead>
        <tbody>
@forelse($laporans as $laporan)
<tr>

    <td data-label="Ticket No">
        {{ $laporan->ticket_no ?? $laporan->id }}
    </td>

    <td data-label="Nama Pengirim">
        {{ $laporan->nama_pengirim }}
    </td>

    <td data-label="Status Pengirim">
        {{ $laporan->status_pengirim }}
    </td>

    <td data-label="Status">
        @if($laporan->status == 'Menunggu')
            <span class="badge bg-warning text-dark">Pending</span>
        @elseif($laporan->status == 'Proses')
            <span class="badge bg-primary">Proses</span>
        @else
            <span class="badge bg-success">Selesai</span>
        @endif
    </td>

    <td data-label="Aksi">
        <div class="action-buttons">

            <a href="{{ route('admin.laporan.show', $laporan->id) }}" 
               class="btn btn-info btn-sm">
               <i class="fa-solid fa-eye"></i>
            </a>

            @if($laporan->status == 'Pending')
            <form action="{{ route('admin.laporan.terima', $laporan->id) }}" 
                  method="POST" style="display:inline-block;">
                @csrf
                @method('PATCH')
                <button class="btn btn-success btn-sm"
                        onclick="return confirm('Yakin ingin menerima laporan ini?')">
                    <i class="fa-solid fa-check"></i>
                </button>
            </form>
            @endif

            <button type="button" 
                    class="btn btn-danger btn-sm"
                    onclick="openDeleteModal('{{ route('admin.laporan.destroy', $laporan->id) }}')">
                <i class="fa-solid fa-trash"></i>
            </button>

        </div>
    </td>

</tr>
@empty
<tr>
    <td colspan="5" style="text-align:center">
        Belum ada laporan masuk.
    </td>
</tr>
@endforelse
</tbody>
    </table>
</div>
</div>

<!-- ================= MODAL HAPUS ================= -->
<div id="deleteModal" class="modal-overlay">
    <div class="modal-content">
        <h3>Konfirmasi Hapus</h3>
        <p>Apakah Anda yakin ingin menghapus laporan ini?</p>
        <div class="modal-buttons">
            <button id="cancelBtn" class="btn btn-secondary">Batal</button>
            <form id="deleteForm" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Hapus</button>
            </form>
        </div>
    </div>
</div>

<!-- ================= SCRIPT ================= -->
<script>
const deleteModal = document.getElementById('deleteModal');
const cancelBtn = document.getElementById('cancelBtn');
const deleteForm = document.getElementById('deleteForm');

// Fungsi buka modal hapus
function openDeleteModal(actionUrl) {
    deleteForm.action = actionUrl;
    deleteModal.classList.add('active');
}

// Tutup modal
cancelBtn.addEventListener('click', () => {
    deleteModal.classList.remove('active');
});

// Tutup modal kalau klik luar modal
window.addEventListener('click', (e) => {
    if(e.target === deleteModal) {
        deleteModal.classList.remove('active');
    }
});
</script>

@endsection