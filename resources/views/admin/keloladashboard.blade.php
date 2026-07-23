@extends($layout)



@section('content')

<link rel="stylesheet" href="{{ asset('css/admin/keloladashboard.css') }}">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>



<meta name="csrf-token" content="{{ csrf_token() }}">



<div class="admin-dashboard">



    <!-- HEADER -->

    <div class="admin-header">

        <h2>Kelola Dashboard</h2>

        <p>Kelola layanan, pengumuman, dan kegiatan terbaru yang tampil di dashboard user</p>

    </div>



    <!-- ================= LAYANAN ================= -->

    <div class="section">

        <div class="section-header">

            <h3>Card Layanan</h3>

            <button class="btn-primary" id="addService">

                <i class="fa-solid fa-plus"></i> Tambah Layanan

            </button>

        </div>



      <div class="card-grid" id="layananGrid">

    @foreach($layanans as $layanan)

        <div class="service-card" data-id="{{ $layanan->id }}"

            data-nama="{{ $layanan->nama }}"

            data-icon="{{ $layanan->icon }}">

            <i class="{{ trim($layanan->icon) }}" style="font-size:36px;color:#1B3B5F"></i>

            <h4>{{ $layanan->nama }}</h4>

            <div class="card-action">

                <button class="btn edit">

                    <i class="fa-solid fa-pen"></i>

                </button>

                <button class="btn delete">

                    <i class="fa-solid fa-trash"></i>

                </button>

            </div>

        </div>

    @endforeach

</div>





    <!-- ================= PENGUMUMAN ================= -->

    <div class="section">

        <div class="section-header">

            <h3>Pengumuman</h3>

            <button class="btn-primary" id="addPengumuman">

                <i class="fa-solid fa-plus"></i> Tambah Pengumuman

            </button>

        </div>



        <div class="list-box" id="pengumumanList">

            @foreach($pengumumans as $p)
                <div class="list-item" data-id="{{ $p->id }}" data-isi="{{ $p->isi }}"  data-tanggal="{{ $p->tanggal }}">

                    <span>{{ $p->isi }} ({{ $p->tanggal }})</span>

                    <div>

                        <button class="btn edit"><i class="fa-solid fa-pen"></i></button>

                        <button class="btn delete"><i class="fa-solid fa-trash"></i></button>

                    </div>

                </div>

            @endforeach

        </div>

    </div>



    <!-- ================= KEGIATAN ================= -->

    <div class="section">

        <div class="section-header">

            <h3>Kegiatan Terbaru</h3>

            <button class="btn-primary" id="addKegiatan">

                <i class="fa-solid fa-plus"></i> Tambah Kegiatan

            </button>

        </div>



        <div class="activity-grid" id="kegiatanGrid">

            @foreach($kegiatans as $k)

                <div class="activity-card" data-id="{{ $k->id }}">

                    <img src="{{ asset('storage/'.$k->gambar) }}">

                    <h4>{{ $k->judul }}</h4>

                    <p class="deskripsi-text">{{ $k->deskripsi }}</p>

                    <div class="card-action">

                        <button class="btn edit"><i class="fa-solid fa-pen"></i></button>

                        <button class="btn delete"><i class="fa-solid fa-trash"></i></button>

                    </div>

                </div>

            @endforeach

        </div>

    </div>

</div>



<!-- ================= MODAL ================= -->

<div class="modal-overlay" id="overlay"></div>

<div class="custom-modal" id="modal">

    <h3 id="modalTitle"></h3>

    <div id="modalBody"></div>

    <div class="modal-buttons">

        <button class="btn btn-confirm" id="modalSave">Simpan</button>

        <button class="btn btn-cancel" id="modalCancel">Batal</button>

    </div>

</div>



<script>

const csrf = document.querySelector('meta[name="csrf-token"]').content;


const overlay = document.getElementById('overlay');

const modal = document.getElementById('modal');

const modalTitle = document.getElementById('modalTitle');

const modalBody = document.getElementById('modalBody');

const modalSave = document.getElementById('modalSave');

const modalCancel = document.getElementById('modalCancel');



let callback = null;



/* ================= MODAL CORE ================= */

function openModal({

    title,

    body,

    confirmText = 'Simpan',

    confirmClass = 'btn-confirm',

    onConfirm

}) {

    modalTitle.innerText = title;

    modalBody.innerHTML = body;



    modalSave.innerText = confirmText;

    modalSave.className = `btn ${confirmClass}`;



    callback = onConfirm;



    overlay.style.display = modal.style.display = 'block';

}



function closeModal(){

    overlay.style.display = modal.style.display = 'none';

    modalBody.innerHTML = '';

    callback = null;

}



modalCancel.onclick = closeModal;

modalSave.onclick = () => {

    if (callback) callback();

    closeModal();

};



/* ================= LAYANAN ================= */

document.getElementById('addService').onclick = () => {

    openModal({

        title: 'Tambah Layanan',

        body: `

            <input id="nama" placeholder="Nama Layanan">

            <input id="icon" placeholder="fa-solid fa-video">

        `,

        onConfirm: () => {

            fetch('{{ route("admin.layanan.store") }}', {

                method: 'POST',

                headers: {

                    'X-CSRF-TOKEN': csrf,

                    'Content-Type': 'application/json'

                },

                body: JSON.stringify({

                    nama: nama.value,

                    icon: icon.value

                })

            }).then(() => location.reload());

        }

    });

};



document.querySelectorAll('.service-card .edit').forEach(btn => {

    btn.onclick = () => {

        const card = btn.closest('.service-card');



        openModal({

            title: 'Edit Layanan',

            body: `

                <input id="nama" value="${card.dataset.nama}">

                <input id="icon" value="${card.dataset.icon}">

            `,

            onConfirm: () => {

                fetch(`/admin/layanan/${card.dataset.id}`, {

                    method: 'PUT',

                    headers: {

                        'X-CSRF-TOKEN': csrf,

                        'Content-Type': 'application/json'

                    },

                    body: JSON.stringify({

                        nama: nama.value,

                        icon: icon.value

                    })

                }).then(() => location.reload());

            }

        });

    };

});



document.querySelectorAll('.service-card .delete').forEach(btn => {

    btn.onclick = () => {

        const card = btn.closest('.service-card');



        openModal({

            title: 'Hapus Layanan',

            body: `<p>Yakin ingin menghapus layanan ini?</p>`,

            confirmText: 'Hapus',

            confirmClass: 'btn-cancel',

            onConfirm: () => {

                fetch(`/admin/layanan/${card.dataset.id}`, {

                    method: 'DELETE',

                    headers: { 'X-CSRF-TOKEN': csrf }

                }).then(() => location.reload());

            }

        });

    };

});



/* ================= PENGUMUMAN ================= */

document.getElementById('addPengumuman').onclick = () => {

    openModal({

        title: 'Tambah Pengumuman',

        body: `

            <input type="date" id="tanggal">

            <textarea id="isi" placeholder="Isi pengumuman"></textarea>

        `,

        onConfirm: () => {

            fetch('{{ route("admin.pengumuman.store") }}', {

                method: 'POST',

                headers: {

                    'X-CSRF-TOKEN': csrf,

                    'Content-Type': 'application/json'

                },

                body: JSON.stringify({

                    tanggal: tanggal.value,

                    isi: isi.value

                })

            }).then(() => location.reload());

        }

    });

};



document.querySelectorAll('.list-item .edit').forEach(btn => {

    btn.onclick = () => {

        const item = btn.closest('.list-item');



        openModal({

            title: 'Edit Pengumuman',

            body: `

                <input type="date" id="tanggal" value="${item.dataset.tanggal}">

                <textarea id="isi">${item.dataset.isi}</textarea>

            `,

            onConfirm: () => {

                fetch(`/admin/pengumuman/${item.dataset.id}`, {

                    method: 'PUT',

                    headers: {

                        'X-CSRF-TOKEN': csrf,

                        'Content-Type': 'application/json'

                    },

                    body: JSON.stringify({

                        tanggal: tanggal.value,

                        isi: isi.value

                    })

                }).then(() => location.reload());

            }

        });

    };

});



document.querySelectorAll('.list-item .delete').forEach(btn => {

    btn.onclick = () => {

        const item = btn.closest('.list-item');



        openModal({

            title: 'Hapus Pengumuman',

            body: `<p>Yakin ingin menghapus pengumuman ini?</p>`,

            confirmText: 'Hapus',

            confirmClass: 'btn-cancel',

            onConfirm: () => {

                fetch(`/admin/pengumuman/${item.dataset.id}`, {

                    method: 'DELETE',

                    headers: { 'X-CSRF-TOKEN': csrf }

                }).then(() => location.reload());

            }

        });

    };

});



/* ================= KEGIATAN ================= */

document.getElementById('addKegiatan').onclick = () => {

    openModal({

        title: 'Tambah Kegiatan',

        body: `

            <input type="file" id="gambar">

            <input id="judul" placeholder="Judul">

            <textarea id="deskripsi" placeholder="Deskripsi"></textarea>

        `,

        onConfirm: () => {

            const fd = new FormData();

            fd.append('gambar', gambar.files[0]);

            fd.append('judul', judul.value);

            fd.append('deskripsi', deskripsi.value);



            fetch('{{ route("admin.kegiatan.store") }}', {

                method: 'POST',

                headers: { 'X-CSRF-TOKEN': csrf },

                body: fd

            }).then(() => location.reload());

        }

    });

};



const kegiatanGrid = document.getElementById('kegiatanGrid');



/* ================= KEGIATAN CLICK HANDLER ================= */

kegiatanGrid.addEventListener('click', function(e) {



    /* ===== EDIT ===== */

    if (e.target.closest('.edit')) {

        const card = e.target.closest('.activity-card');

        const id = card.dataset.id;



        openModal({

            title: 'Edit Kegiatan',

            body: `

                <input type="file" id="gambar">

                <input id="judul" value="${card.querySelector('h4').innerText}">

                <textarea id="deskripsi">${card.querySelector('p').innerText}</textarea>

            `,

            onConfirm: () => {

                const fd = new FormData();

                if (gambar.files[0]) fd.append('gambar', gambar.files[0]);

                fd.append('judul', judul.value);

                fd.append('deskripsi', deskripsi.value);



                fetch(`/admin/kegiatan/${id}`, {

                    method: 'POST',

                    headers: {

                        'X-CSRF-TOKEN': csrf,

                        'X-HTTP-Method-Override': 'PUT'

                    },

                    body: fd

                }).then(() => location.reload());

            }

        });

    }



    /* ===== DELETE ===== */

    if (e.target.closest('.delete')) {

        const card = e.target.closest('.activity-card');

        const id = card.dataset.id;



        openModal({

            title: 'Hapus Kegiatan',

            body: `<p>Yakin ingin menghapus kegiatan ini?</p>`,

            confirmText: 'Hapus',

            confirmClass: 'btn-cancel',

            onConfirm: () => {

                fetch(`/admin/kegiatan/${id}`, {

                    method: 'DELETE',

                    headers: { 'X-CSRF-TOKEN': csrf }

                }).then(() => location.reload());

            }

        });

    }



});





</script>



<style>

/* ================= MODAL ================= */

.modal-overlay {

    position: fixed;

    inset: 0;

    background: rgba(0,0,0,.55);

    backdrop-filter: blur(4px);

    display: none;

    z-index: 999;

}



.custom-modal {

    position: fixed;

    top: 50%;

    left: 50%;

    transform: translate(-50%, -50%) scale(.95);

    background: #ffffff;

    width: 480px;

    max-width: 95%;

    padding: 30px;

    border-radius: 18px;

    box-shadow: 0 25px 60px rgba(0,0,0,.25);

    display: none;

    z-index: 1000;

    animation: modalFade .3s ease forwards;

    font-family: 'Segoe UI', sans-serif;

}



@keyframes modalFade {

    to {

        transform: translate(-50%, -50%) scale(1);

        opacity: 1;

    }

}



.custom-modal h3 {

    margin-bottom: 20px;

    font-size: 22px;

    font-weight: 700;

    color: #1f2937;

    text-align: center;

}



.custom-modal input,

.custom-modal textarea {

    width: 100%;

    padding: 12px 14px;

    margin-bottom: 14px;

    border-radius: 10px;

    border: 1px solid #d1d5db;

    font-size: 15px;

    outline: none;

}



.custom-modal input:focus,

.custom-modal textarea:focus {

    border-color: #2563eb;

    box-shadow: 0 0 0 3px rgba(37,99,235,.15);

}



.custom-modal textarea {

    resize: vertical;

    min-height: 90px;

}
#modalBody input,
#modalBody textarea {
    width: 100%;
    max-width: 100%;
    font-size: 14px;
    padding: 8px 2px;
    border-radius: 10px;
}


.modal-buttons {

    display: flex;

    justify-content: center;

    gap: 15px;

    margin-top: 20px;

}



.modal-buttons .btn {

    padding: 10px 30px;

    border-radius: 12px;

    font-weight: 600;

    font-size: 15px;

    cursor: pointer;

    border: none;

    transition: .2s;

}



.btn-confirm {

    background: #2563eb;

    color: #fff;

}



.btn-cancel {

    background: #ef4444;

    color: #fff;

}



.btn-confirm:hover { background: #1d4ed8; }

.btn-cancel:hover { background: #dc2626; }

/* ================= ACTION BUTTON ================= */

.service-card,

.activity-card {

    position: relative;

}



/* container tombol */

.service-card .card-action,

.activity-card .card-action {

    position: absolute;

    bottom: 12px;

    left: 50%;

    transform: translateX(-50%) translateY(10px);



    display: flex;

    gap: 8px;

    justify-content: center;



    opacity: 0;

    pointer-events: none;   /* ❗ penting */

    transition: .25s ease;

    z-index: 10;

}



/* saat hover card */

.service-card:hover .card-action,

.activity-card:hover .card-action {

    opacity: 1;

    transform: translateX(-50%) translateY(0);

    pointer-events: auto;   /* ❗ aktifkan klik */

}



/* tombol */

.card-action .btn {

    background: #ffffff;

    border: none;

    width: 36px;

    height: 36px;

    border-radius: 10px;

    cursor: pointer;

    box-shadow: 0 4px 10px rgba(0,0,0,.15);

    display: flex;

    align-items: center;

    justify-content: center;

}



.card-action .btn.edit i {

    color: #2563eb;

}



.card-action .btn.delete i {

    color: #ef4444;

}
/* ================= BATASI DESKRIPSI KEGIATAN ================= */

.deskripsi-text {
    display: -webkit-box;
    -webkit-line-clamp: 3; /* maksimal 3 baris */
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    line-height: 1.6;
    max-height: 4.8em; /* biar tinggi card tetap rapi */
}


</style>



@endsection

