@extends('operator.layout')



@section('title', 'Kelola Sejarah UPT TIK')



@section('content')

<link rel="stylesheet" href="{{ asset('css/admin/sejarah.css') }}">



<style>

/* ================= MODAL ALERT ================= */

.modal {

    position: fixed;

    inset: 0;

    background: rgba(0,0,0,0.5);

    display: none;

    align-items: center;

    justify-content: center;

    z-index: 999;

}



.modal.show {

    display: flex;

}



.modal-content {

    background: #fff;

    padding: 25px;

    border-radius: 12px;

    width: 320px;

    text-align: center;

    animation: scaleIn .2s ease;

}



.modal-content h4 {

    margin-bottom: 10px;

}



.modal-content p {

    font-size: 14px;

    color: #555;

}



.modal-actions {

    display: flex;

    justify-content: center;

    gap: 10px;

    margin-top: 20px;

}



.btn-cancel {

    padding: 8px 16px;

    border: none;

    border-radius: 6px;

    background: #ccc;

    cursor: pointer;

}



.btn-danger {

    padding: 8px 16px;

    border: none;

    border-radius: 6px;

    background: #e74c3c;

    color: white;

    cursor: pointer;

}



.btn-danger:hover {

    background: #c0392b;

}



@keyframes scaleIn {

    from {

        transform: scale(0.9);

        opacity: 0;

    }

    to {

        transform: scale(1);

        opacity: 1;

    }

}
/* ================= RESPONSIVE MOBILE ================= */
@media (max-width: 768px) {

    .admin-sejarah {
        padding: 10px;
    }

    .admin-header h2 {
        font-size: 20px;
    }

    .admin-header p {
        font-size: 13px;
    }

    /* SECTION */
    .section {
        padding: 10px;
    }

    .section-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }

    .section-header h3 {
        font-size: 16px;
    }

    /* FORM UPLOAD */
    .section-header form {
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .section-header input[type="file"] {
        width: 100%;
        font-size: 13px;
    }

    .btn-primary {
        width: 100%;
        font-size: 14px;
    }

    /* GRID GAMBAR */
    .image-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
    }

    .image-card img {
        height: 120px;
        object-fit: cover;
    }

    /* TEXTAREA */
    .sejarah-text {
        font-size: 14px;
    }

    /* SAVE BUTTON */
    .save-area {
        text-align: center;
    }

    .btn-save {
        width: 100%;
        font-size: 14px;
    }

    /* MODAL */
    .modal-content {
        width: 90%;
        padding: 20px;
    }
}

@media (max-width: 480px) {

    .image-grid {
        grid-template-columns: 1fr;
    }

    .image-card img {
        height: 160px;
    }
}
</style>



<div class="admin-sejarah">



    <div class="admin-header">

        <h2>Kelola Sejarah UPT TIK</h2>

        <p>Admin dapat mengubah teks sejarah dan mengelola galeri gambar</p>

    </div>



    {{-- ================= GALERI GAMBAR ================= --}}

    <div class="section">

        <div class="section-header">

            <h3>Galeri Gambar</h3>



            <form action="{{ route('sejarah.upload') }}"

                  method="POST"

                  enctype="multipart/form-data">

                @csrf

                <input type="file" name="gambar" required>



                <button type="submit" class="btn-primary">

                    <i class="fa-solid fa-plus"></i> Upload Gambar

                </button>

            </form>

        </div>



        <div class="image-grid">

            @forelse($gambar as $img)

                <div class="image-card">

                    <img src="{{ asset('uploads/sejarah/'.$img->gambar) }}" alt="Gambar Sejarah">



                    <button class="icon-btn delete"

                            onclick="openDeleteModal({{ $img->id }})">

                        <i class="fa-solid fa-trash"></i>

                    </button>



                    <form id="delete-form-{{ $img->id }}"

                          action="{{ route('sejarah.delete', $img->id) }}"

                          method="POST">

                        @csrf

                        @method('DELETE')

                    </form>

                </div>

            @empty

                <p style="opacity:0.7">Belum ada gambar</p>

            @endforelse

        </div>

    </div>



    {{-- ================= TEKS SEJARAH ================= --}}

    <form action="{{ route('sejarah.simpan') }}" method="POST">

        @csrf



        <div class="section">

            <div class="section-header">

                <h3>Teks Sejarah</h3>

            </div>



            <textarea name="isi_sejarah"

                      rows="8"

                      class="sejarah-text"

                      placeholder="Masukkan teks sejarah...">{{ $sejarah->isi_sejarah ?? '' }}</textarea>

        </div>



        <div class="save-area">

            <button type="submit" class="btn-save">

                <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan

            </button>

        </div>

    </form>



</div>



{{-- ================= MODAL ALERT HAPUS ================= --}}

<div id="deleteModal" class="modal">

    <div class="modal-content">

        <h4>Konfirmasi</h4>

        <p>Apakah Anda yakin ingin menghapus gambar ini?</p>



        <div class="modal-actions">

            <button class="btn-cancel" onclick="closeDeleteModal()">Batal</button>

            <button class="btn-danger" id="confirmDelete">Hapus</button>

        </div>

    </div>

</div>



<script>

    let deleteId = null;



    function openDeleteModal(id) {

        deleteId = id;

        document.getElementById('deleteModal').classList.add('show');

    }



    function closeDeleteModal() {

        deleteId = null;

        document.getElementById('deleteModal').classList.remove('show');

    }



    document.getElementById('confirmDelete').addEventListener('click', function () {

        if (deleteId) {

            document.getElementById('delete-form-' + deleteId).submit();

        }

    });

</script>



@endsection

