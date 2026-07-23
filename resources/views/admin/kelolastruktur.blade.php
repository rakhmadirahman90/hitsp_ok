@extends('operator.layout')



@section('title', 'Kelola Struktur Organisasi')



@section('content')



<div class="struktur-admin">



    <!-- HEADER -->

    <div class="page-header">

        <div>

            <h2>Kelola Struktur Organisasi</h2>

            <p>Kelola gambar struktur, divisi, dan anggota</p>

        </div>



        <div class="header-action">

            <button class="btn-secondary" onclick="openModal('modalGambar')">

                <i class="fa fa-image"></i> Ganti Gambar

            </button>

            <button class="btn-info" onclick="openModal('modalDivisi')">

                <i class="fa fa-layer-group"></i> Tambah Divisi

            </button>

            <button class="btn-primary" onclick="openModal('modalAnggota')">

                <i class="fa fa-user-plus"></i> Tambah Anggota

            </button>

        </div>

    </div>



    <!-- PREVIEW GAMBAR -->

    <div class="preview-box">

        <h4>Gambar Struktur Organisasi</h4>

        <img src="{{ $struktur ? asset('storage/'.$struktur->gambar) : asset('images/struktur.png') }}" class="preview-img">

    </div>



    <!-- LIST DIVISI -->

    @foreach($divisis as $divisi)

    <div class="divisi-block">

        <div class="divisi-title">

            <i class="fa fa-folder-open"></i> 

            <span>{{ $divisi->nama }}</span>



            <!-- Tombol hapus divisi -->

            <form action="{{ route('admin.divisi.delete', $divisi->id) }}" method="POST" class="delete-divisi-form" onsubmit="return confirm('Yakin ingin menghapus divisi ini?');">

                @csrf

                @method('DELETE')

                <button type="submit" class="btn-delete small"><i class="fa fa-trash"></i></button>

            </form>

        </div>



        <div class="table-wrapper">

            <table>

                <thead>

                    <tr>

                        <th>No</th>

                        <th>Foto</th>

                        <th>Nama</th>

                        <th>Peran</th>

                        <th>Status</th>

                        <th>Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($divisi->anggotas as $key => $anggota)

                    <tr>

                        <td>{{ $key + 1 }}</td>

                        <td>

                            <img src="{{ $anggota->foto ? asset('storage/'.$anggota->foto) : asset('images/default.png') }}" class="foto">

                        </td>

                        <td>{{ $anggota->nama }}</td>

                        <td>{{ $anggota->peran }}</td>

                        <td>

                            <span class="badge {{ $anggota->aktif ? 'aktif' : 'nonaktif' }}">

                                {{ $anggota->aktif ? 'Aktif' : 'Nonaktif' }}

                            </span>

                        </td>

                        <td class="aksi">

                            <form action="{{ route('admin.anggota.delete', $anggota->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus anggota ini?');">

                                @csrf @method('DELETE')

                                <button class="btn-delete"><i class="fa fa-trash"></i></button>

                            </form>

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

    @endforeach



</div>



<!-- MODAL GANTI GAMBAR -->

<div class="modal" id="modalGambar">

    <div class="modal-box">

        <h3>Ganti Gambar Struktur</h3>

        <form action="{{ route('admin.struktur.updateGambar') }}" method="POST" enctype="multipart/form-data">

            @csrf

            <input type="file" name="gambar" required>

            <div class="modal-action">

                <button class="btn-primary" type="submit">Simpan</button>

                <button class="btn-delete" type="button" onclick="closeModal('modalGambar')">Batal</button>

            </div>

        </form>

    </div>

</div>



<!-- MODAL TAMBAH DIVISI -->

<div class="modal" id="modalDivisi">

    <div class="modal-box">

        <h3>Tambah Divisi</h3>

        <form action="{{ route('admin.divisi.store') }}" method="POST">

            @csrf

            <input type="text" name="nama" placeholder="Nama Divisi" required>

            <div class="modal-action">

                <button class="btn-primary" type="submit">Simpan</button>

                <button class="btn-delete" type="button" onclick="closeModal('modalDivisi')">Batal</button>

            </div>

        </form>

    </div>

</div>



<!-- MODAL TAMBAH ANGGOTA -->

<div class="modal" id="modalAnggota">

    <div class="modal-box">

        <h3>Tambah Anggota</h3>

        <form action="{{ route('admin.anggota.store') }}" method="POST" enctype="multipart/form-data">

            @csrf

            <input type="text" name="nama" placeholder="Nama Lengkap" required>

            <input type="text" name="peran" placeholder="Peran (Koordinator / Anggota)" required>

            <select name="divisi_id" required>

                <option value="">-- Pilih Divisi --</option>

                @foreach($divisis as $divisi)

                    <option value="{{ $divisi->id }}">{{ $divisi->nama }}</option>

                @endforeach

            </select>

            <input type="file" name="foto">

            <div class="modal-action">

                <button class="btn-primary" type="submit">Simpan</button>

                <button class="btn-delete" type="button" onclick="closeModal('modalAnggota')">Batal</button>

            </div>

        </form>

    </div>

</div>



<!-- CSS -->

<style>

.struktur-admin {

    padding: 20px;

    font-family: 'Poppins', sans-serif;

}



/* HEADER */

.page-header {

    display: flex;

    justify-content: space-between;

    align-items: center;

    margin-bottom: 20px;

}

.page-header h2 { font-size: 18px; margin: 0; }

.page-header p { font-size: 13px; color: #666; }

.header-action button { margin-left: 6px; }



/* BUTTON */

.btn-primary { background: #1D3557; color: white; border: none; padding: 8px 14px; border-radius: 6px; font-size: 13px; cursor: pointer; }

.btn-secondary { background: #457B9D; color: white; border: none; padding: 8px 14px; border-radius: 6px; font-size: 13px; }

.btn-info { background: #6C757D; color: white; border: none; padding: 8px 14px; border-radius: 6px; font-size: 13px; }

.btn-delete { background: #ef4444; color: white; border: none; padding: 6px 10px; border-radius: 4px; cursor: pointer; }

.btn-delete.small { padding: 2px 6px; font-size: 11px; border-radius: 4px; }



/* PREVIEW */

.preview-box {

    background: white;

    padding: 15px;

    border-radius: 10px;

    margin-bottom: 25px;

    text-align: center;

}

.preview-img {

    max-width: 350px; /* perkecil lagi */

    width: 100%;

    display: block;

    margin: auto;

    border-radius: 8px;

}



/* DIVISI TITLE */

.divisi-title {

    font-weight: 600;

    margin: 15px 0;

    background: #1B3B5F;

    padding: 10px 14px;

    border-radius: 8px;

    color: #fff;

    display: flex;

    justify-content: space-between;

    align-items: center;

}



/* Tombol hapus divisi */

.delete-divisi-form { display: inline-block; margin-left: 10px; }



/* TABLE */

.table-wrapper {

    background: white;

    padding: 15px;

    border-radius: 10px;

    margin-bottom: 20px;

}

table { width: 100%; border-collapse: collapse; }

th, td { padding: 10px; font-size: 13px; text-align: center; }

thead { background: #f1f5f9; }

tbody tr { border-bottom: 1px solid #e5e7eb; }



/* FOTO */

.foto { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; }



/* BADGE */

.badge { padding: 4px 10px; border-radius: 12px; font-size: 11px; }

.badge.aktif { background: #22c55e; color: white; }

.badge.nonaktif { background: #ccc; color: #000; }



/* MODAL */

.modal { position: fixed; inset: 0; background: rgba(0,0,0,.45); display: none; align-items: center; justify-content: center; z-index: 999; }

.modal-box { background: #fff; width: 380px; padding: 20px; border-radius: 10px; }

.modal-box input, .modal-box select { width: 100%; padding: 8px; margin-bottom: 10px; }

.modal-action { display: flex; justify-content: flex-end; gap: 10px; }

/* ================= RESPONSIVE ================= */

/* Tablet */
@media (max-width: 992px) {
    .page-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }

    .header-action {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }

    .preview-img {
        max-width: 100%;
    }
}

/* Mobile */
@media (max-width: 600px) {

    .struktur-admin {
        padding: 12px;
    }

    /* HEADER */
    .page-header h2 {
        font-size: 16px;
    }

    .page-header p {
        font-size: 12px;
    }

    .header-action {
        width: 100%;
    }

    .header-action button {
        width: 100%;
        margin-left: 0;
    }

    /* DIVISI TITLE */
    .divisi-title {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
        font-size: 13px;
    }

    /* TABLE RESPONSIVE */
    .table-wrapper {
        overflow-x: auto;
    }

    table {
        min-width: 600px; /* biar bisa scroll horizontal */
    }

    th, td {
        font-size: 12px;
        white-space: nowrap;
    }

    /* FOTO */
    .foto {
        width: 35px;
        height: 35px;
    }

    /* PREVIEW */
    .preview-box {
        padding: 10px;
    }

    .preview-img {
        max-width: 100%;
    }

    /* MODAL */
    .modal-box {
        width: 90%;
        max-width: 350px;
        padding: 15px;
    }

    .modal-action {
        flex-direction: column;
    }

    .modal-action button {
        width: 100%;
    }
}
</style>



<!-- JS -->

<script>

function openModal(id){ document.getElementById(id).style.display='flex'; }

function closeModal(id){ document.getElementById(id).style.display='none'; }

</script>



@endsection

