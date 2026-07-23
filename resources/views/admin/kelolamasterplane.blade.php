@extends('operator.layout')

@section('title', 'Kelola Master Plan TIK')

@section('content')

<!-- FONT AWESOME -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<!-- SWEETALERT -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>

/* ================= CONTAINER ================= */
.admin-masterplan-container{
    max-width:1200px;
    margin:40px auto;
    padding:25px;
}

/* ================= TITLE ================= */
.page-title{
    font-size:26px;
    font-weight:600;
    margin-bottom:25px;
    color:#1B3B5F;
    text-align:center;
}

/* ================= SUCCESS ALERT ================= */
.alert-success{
    background:#16a34a;
    color:white;
    padding:12px 16px;
    border-radius:8px;
    margin-bottom:20px;
    font-size:14px;
    text-align:center;
}

/* ================= BUTTON TAMBAH ================= */
.top-action{
    display:flex;
    justify-content:flex-end;
    margin-bottom:20px;
}

.btn-add{
    background:#1B3B5F;
    color:white;
    border:none;
    padding:10px 18px;
    border-radius:8px;
    cursor:pointer;
    font-size:14px;
}

.btn-add:hover{
    background:#16324d;
}

/* ================= TABLE ================= */
.table-wrapper{
    background:#ffffff;
    border-radius:12px;
    padding:15px;
    box-shadow:0 8px 25px rgba(0,0,0,.05);
}

.masterplan-table{
    width:100%;
    border-collapse:collapse;
}

.masterplan-table th{
    background:#f1f5f9;
    padding:12px;
    text-align:left;
    font-size:13px;
    font-weight:600;
}

.masterplan-table td{
    padding:12px;
    border-top:1px solid #e2e8f0;
    font-size:14px;
}

.masterplan-table tr:hover{
    background:#f8fafc;
}

/* ================= ICON BUTTON ================= */
.aksi-icon{
    display:flex;
    gap:8px;
}

.icon-btn{
    width:34px;
    height:34px;
    border:none;
    border-radius:6px;
    display:flex;
    align-items:center;
    justify-content:center;
    cursor:pointer;
    text-decoration:none;
}

.icon-btn.view{
    background:#dbeafe;
    color:#1d4ed8;
}

.icon-btn.view:hover{
    background:#1d4ed8;
    color:white;
}

.icon-btn.delete{
    background:#fee2e2;
    color:#dc2626;
}

.icon-btn.delete:hover{
    background:#dc2626;
    color:white;
}

/* ================= MODAL ================= */
.modal{
    position:fixed;
    inset:0;
    background:rgba(0,0,0,.4);
    display:none;
    align-items:center;
    justify-content:center;
}

.modal-content{
    background:#fff;
    width:420px;
    padding:25px;
    border-radius:12px;
}

.modal-content h3{
    margin-bottom:20px;
    font-size:18px;
}

.modal-content label{
    font-size:13px;
    display:block;
    margin-bottom:6px;
}

.modal-content input{
    width:100%;
    padding:8px;
    margin-bottom:15px;
    border:1px solid #cbd5e1;
    border-radius:6px;
}

.modal-action{
    text-align:right;
}

.btn-upload{
    background:#1B3B5F;
    color:white;
    border:none;
    padding:8px 14px;
    border-radius:6px;
}

.btn-cancel{
    background:#e5e7eb;
    border:none;
    padding:8px 14px;
    border-radius:6px;
}

</style>

<div class="admin-masterplan-container">

    <h2 class="page-title">MASTER PLAN TIK-ITH 2025</h2>

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="top-action">
        <button class="btn-add" onclick="openModal()">
            + Tambah Dokumen
        </button>
    </div>

    <div class="table-wrapper">
        <table class="masterplan-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul Dokumen</th>
                    <th>Nama File</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($masterplans as $index => $mp)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $mp->judul }}</td>
                    <td>{{ $mp->file }}</td>

                    <td class="aksi-icon">

                        <!-- VIEW -->
                        <a href="{{ asset('storage/masterplan/'.$mp->file) }}"
                           target="_blank"
                           class="icon-btn view"
                           title="Lihat Dokumen">
                            <i class="fa-solid fa-eye"></i>
                        </a>

                        <!-- DELETE -->
                        <form class="delete-form"
                              action="{{ route('admin.masterplan.delete', $mp->id) }}"
                              method="POST">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="icon-btn delete delete-btn"
                                    title="Hapus Dokumen">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>

                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align:center">
                        Belum ada dokumen
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

<!-- ================= MODAL ================= -->
<div class="modal" id="modalForm">
    <div class="modal-content">

        <h3>Tambah Master Plan</h3>

        <form action="{{ route('admin.masterplan.store') }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf

            <label>Judul Dokumen</label>
            <input type="text" name="judul" required>

            <label>Upload File PDF</label>
            <input type="file" name="file" accept="application/pdf" required>

            <div class="modal-action">
                <button type="button" class="btn-cancel" onclick="closeModal()">Batal</button>
                <button type="submit" class="btn-upload">Simpan</button>
            </div>

        </form>

    </div>
</div>

<script>

/* MODAL */
function openModal(){
    document.getElementById('modalForm').style.display='flex';
}

function closeModal(){
    document.getElementById('modalForm').style.display='none';
}

/* AUTO REMOVE ALERT */
setTimeout(()=>{
    let alert=document.querySelector('.alert-success');
    if(alert) alert.remove();
},3000);

/* SWEETALERT DELETE */
document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', function(e){
        e.preventDefault();

        let form = this.closest('form');
        let title = this.closest('tr').children[1].innerText;

        Swal.fire({
            title: 'Hapus dokumen?',
            text: `"${title}" akan dihapus permanen!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if(result.isConfirmed){
                form.submit();
            }
        });
    });
});

</script>

@endsection