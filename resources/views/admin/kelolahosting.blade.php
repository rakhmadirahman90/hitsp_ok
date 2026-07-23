@extends('operator.layout')

@section('title', 'Permohonan Sub Domain & Hosting')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
.pagination-wrapper{
    display:flex;
    justify-content:center;
    margin-top:30px;
}

/* container pagination */
.pagination{
    display:flex !important;
    gap:10px;
    list-style:none;
    padding:0;
    margin:0;
    flex-wrap:wrap;
}

/* item */
.page-item{
    list-style:none;
}

/* link */
.page-link{
    display:flex !important;
    justify-content:center;
    align-items:center;

    min-width:42px;
    height:42px;
    padding:0 15px !important;

    border-radius:12px !important;
    border:none !important;

    background:#fff !important;
    color:#455a64 !important;

    font-weight:600;
    font-size:14px;

    box-shadow:0 3px 10px rgba(0,0,0,.08);
    transition:all .25s ease;
    text-decoration:none !important;
}

/* hover */
.page-link:hover{
    background:#607d8b !important;
    color:#fff !important;
    transform:translateY(-2px);
}

/* active */
.page-item.active .page-link{
    background:linear-gradient(135deg,#607d8b,#455a64) !important;
    color:#fff !important;
    box-shadow:0 5px 15px rgba(96,125,139,.35);
}

/* disabled */
.page-item.disabled .page-link{
    background:#eceff1 !important;
    color:#90a4ae !important;
    box-shadow:none !important;
    cursor:not-allowed;
    opacity:.8;
}

/* mobile */
@media(max-width:768px){
    .page-link{
        min-width:36px;
        height:36px;
        font-size:13px;
        padding:0 12px !important;
    }
}
 {
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
.page-title {
    font-size: 24px;
    font-weight: 600;
    margin-bottom: 20px;
    text-align: center;
}

/* ================= ALERT ================= */
.alert {
    padding: 12px 16px;
    border-radius: 8px;
    margin-bottom: 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.alert-success {
    background:#d1fae5;
    color:#065f46;
}

.alert-info {
    background:#dbeafe;
    color:#1e40af;
}

.alert-danger {
    background:#fee2e2;
    color:#991b1b;
}

.btn-close {
    background: none;
    border: none;
    font-size: 16px;
    cursor: pointer;
}

/* ================= CARD ================= */
.card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.08);
    max-width: 1400px;
    margin: auto;
    overflow: hidden;
}

.card-body {
    padding: 20px;
}

/* ================= TABLE ================= */
.table-wrapper {
    overflow-x: auto;
}

.table {
    width: 100%;
    min-width: 850px;
    border-collapse: collapse;
}

.table th {
    background: #f3f4f6;
    padding: 12px;
    text-align: left;
}

.table td {
    padding: 12px;
    border-bottom: 1px solid #e5e7eb;
}

.table tbody tr:hover {
    background: #f9fafb;
}

/* ================= BADGE ================= */
.badge {
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
}

.bg-warning {
    background:#fef3c7;
    color:#78350f;
}

.bg-success {
    background:#dcfce7;
    color:#166534;
}

.bg-danger {
    background:#fee2e2;
    color:#991b1b;
}

.bg-secondary {
    background:#e5e7eb;
    color:#374151;
}

/* ================= BUTTON ================= */
.action-btn {
    width: 35px;
    height: 35px;
    border-radius: 8px;
    border: none;
    color: #fff;
    cursor: pointer;
    margin-right: 5px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    text-decoration:none;
}

.detail-btn {
    background:#2563eb;
}

.delete-btn {
    background:#ef4444;
}

.disable-btn {
    background:#f59e0b;
}

.disable-btn:hover {
    background:#d97706;
}

/* ================= NEW CODE: EDIT STYLES & MODAL ================= */
.edit-btn {
    background: #d97706;
}
.edit-btn:hover {
    background: #b45309;
}
.custom-modal {
    display: none;
    position: fixed;
    z-index: 9999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5);
    align-items: center;
    justify-content: center;
}
.custom-modal.show {
    display: flex;
}
.modal-content {
    background-color: #fff;
    padding: 25px;
    border-radius: 12px;
    width: 100%;
    max-width: 650px; /* Diperlebar sedikit agar nyaman scroll data server */
    max-height: 90vh; /* Memastikan modal memiliki scrollbar jika data penuh */
    overflow-y: auto;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    animation: slideDown 0.3s ease;
}
@keyframes slideDown {
    from { transform: translateY(-20px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}
.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #e5e7eb;
    padding-bottom: 15px;
    margin-bottom: 20px;
}
.modal-header h3 {
    margin: 0;
    font-size: 18px;
    font-weight: 600;
}
.modal-close {
    background: none;
    border: none;
    font-size: 24px;
    cursor: pointer;
    color: #9ca3af;
}
.form-group {
    margin-bottom: 15px;
}
.form-group label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 6px;
    color: #4b5563;
}
.form-control {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-family: inherit;
    font-size: 14px;
    outline: none;
    box-sizing: border-box;
}
.form-control:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
}
/* Style tambahan untuk input readonly agar visualnya terlihat jelas terkunci */
.form-control:read-only {
    background-color: #f3f4f6;
    color: #6b7280;
    cursor: not-allowed;
    border-color: #e5e7eb;
}
.modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    border-top: 1px solid #e5e7eb;
    padding-top: 15px;
    margin-top: 20px;
}
.btn-submit {
    background: #2563eb;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
}
.btn-submit:hover {
    background: #1d4ed8;
}
.btn-cancel {
    background: #e5e7eb;
    color: #374151;
    border: none;
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
}

/* TAMBAHAN STYLE BARU: Untuk judul Parameter Hosting di dalam Modal */
.parameter-section-title {
    font-size: 14px;
    font-weight: 700;
    color: #059669;
    margin-top: 25px;
    margin-bottom: 15px;
    padding-bottom: 5px;
    border-bottom: 2px dashed #e5e7eb;
    display: flex;
    align-items: center;
    gap: 8px;
}
/* ================================================================= */

/* ================= MOBILE CARD ================= */
.mobile-cards {
    display: none;
}

.sub-card {
    background: #fff;
    padding: 15px;
    margin-bottom: 12px;
    border-radius: 12px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.05);
}

/* ================= RESPONSIVE ================= */
@media (max-width: 768px) {

    .table-wrapper {
        display: none;
    }

    .mobile-cards {
        display: block;
    }

    .page-title {
        font-size: 18px;
    }
}
</style>

<div class="admin-wrapper">

    <h2 class="page-title">
        Daftar Permohonan Sub Domain / Hosting
    </h2>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
            <button class="btn-close">&times;</button>
        </div>
    @endif

    @if(session('info'))
        <div class="alert alert-info">
            {{ session('info') }}
            <button class="btn-close">&times;</button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
            <button class="btn-close">&times;</button>
        </div>
    @endif

    <div class="card">

        <div class="card-body">

            <div class="table-wrapper">

                <table class="table">

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Organisasi</th>
                            <th>Jenis</th>
                            <th>Pemohon</th>
                            <th>Email</th>
                            <th>Sub Domain</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse ($subdomains as $index => $item)
                    <tr>
                            <td>{{ $index + 1 }}</td>

                            <td>{{ $item->nama_organisasi }}</td>

                            <td>{{ $item->jenis_domain }}</td>

                            <td>{{ $item->nama_teknis }}</td>

                            <td>{{ $item->email_teknis }}</td>

                            <td>{{ $item->nama_sub_domain }}</td>

                            <td>

                                @if ($item->status == 'pending')

                                    <span class="badge bg-warning">
                                        Menunggu
                                    </span>

                                @elseif ($item->status == 'active')

                                    <span class="badge bg-success">
                                        Active
                                    </span>

                                @elseif ($item->status == 'disabled')

                                    <span class="badge bg-secondary">
                                        Disabled
                                    </span>

                                @elseif ($item->status == 'rejected')

                                    <span class="badge bg-danger">
                                        Reject
                                    </span>

                                @endif

                            </td>

                            <td>

                                {{-- DETAIL --}}
                                <a href="{{ route('admin.subdomain.show', $item->id) }}"
                                   class="action-btn detail-btn">
                                    <i class="fa-solid fa-eye"></i>
                                </a>

                                {{-- MODIFIKASI: PENULISAN ATRIBUT DATA DISESUAIKAN DENGAN PENANGKAPAN JAVASCRIPT (LOWERCALCASE TANPA UNDERSCORE) --}}
                                <button type="button" 
                                        class="action-btn edit-btn btn-edit"
                                        data-id="{{ $item->id }}"
                                        data-organisasi="{{ $item->nama_organisasi }}"
                                        data-jenis="{{ $item->jenis_domain }}"
                                        data-pemohon="{{ $item->nama_teknis }}"
                                        data-email="{{ $item->email_teknis }}"
                                        data-subdomain="{{ $item->nama_sub_domain }}"
                                        data-status="{{ $item->status }}"
                                        data-ipserver="{{ $item->ip_server ?? '' }}"
                                        data-usersh="{{ $item->user_ssh ?? '' }}"
                                        data-passssh="{{ $item->password_ssh ?? '' }}"
                                        data-dbname="{{ $item->database_name ?? '' }}"
                                        data-dbuser="{{ $item->database_user ?? '' }}"
                                        data-dbpass="{{ $item->database_password ?? '' }}"
                                        data-path="{{ $item->lokasi_aplikasi ?? '' }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>

                                {{-- DISABLE --}}
                                @if ($item->status == 'active')

                                <form action="{{ route('admin.subdomain.disable', $item->id) }}"
                                      method="POST"
                                      style="display:inline;">

                                    @csrf

                                    <button type="submit"
                                            class="action-btn disable-btn btn-disable"
                                            data-name="{{ $item->nama_sub_domain }}">

                                        <i class="fa-solid fa-ban"></i>

                                    </button>

                                </form>

                                @endif

                                {{-- DELETE --}}
                                <form action="{{ route('admin.subdomain.destroy', $item->id) }}"
                                      method="POST"
                                      style="display:inline;">

                                    @csrf
                                    @method('DELETE')

                                    <button type="button"
                                            class="action-btn delete-btn btn-delete"
                                            data-name="{{ $item->nama_sub_domain }}">

                                        <i class="fa-solid fa-trash"></i>

                                    </button>

                                </form>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="8"
                                style="text-align:center; padding:25px; color:#6b7280;">

                                Belum ada pengajuan sub domain / hosting

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="pagination-wrapper">
                {{ $subdomains->links('pagination::bootstrap-5') }}
            </div>
            
            <div class="mobile-cards">

                @forelse ($subdomains ?? [] as $item)

                <div class="sub-card">

                    <h4>{{ $item->nama_sub_domain }}</h4>

                    <p>
                        <b>Organisasi:</b>
                        {{ $item->nama_organisasi }}
                    </p>

                    <p>
                        <b>Jenis:</b>
                        {{ $item->jenis_domain }}
                    </p>

                    <p>
                        <b>Pemohon:</b>
                        {{ $item->nama_teknis }}
                    </p>

                    <p>
                        <b>Email:</b>
                        {{ $item->email_teknis }}
                    </p>

                    <p>

                        <b>Status:</b>

                        @if ($item->status == 'pending')

                            <span class="badge bg-warning">
                                Menunggu
                            </span>

                        @elseif ($item->status == 'active')

                            <span class="badge bg-success">
                                Active
                            </span>

                        @elseif ($item->status == 'disabled')

                            <span class="badge bg-secondary">
                                Disabled
                            </span>

                        @elseif ($item->status == 'rejected')

                            <span class="badge bg-danger">
                                Reject
                            </span>

                        @endif

                    </p>

                    <div>

                        {{-- DETAIL --}}
                        <a href="{{ route('admin.subdomain.show', $item->id) }}"
                           class="action-btn detail-btn">
                            <i class="fa-solid fa-eye"></i>
                        </a>

                        {{-- MODIFIKASI MOBILE: PENULISAN ATRIBUT DATA DISESUAIKAN DENGAN PENANGKAPAN JAVASCRIPT (LOWERCALCASE TANPA UNDERSCORE) --}}
                        <button type="button" 
                                class="action-btn edit-btn btn-edit"
                                data-id="{{ $item->id }}"
                                data-organisasi="{{ $item->nama_organisasi }}"
                                data-jenis="{{ $item->jenis_domain }}"
                                data-pemohon="{{ $item->nama_teknis }}"
                                data-email="{{ $item->email_teknis }}"
                                data-subdomain="{{ $item->nama_sub_domain }}"
                                data-status="{{ $item->status }}"
                                data-ipserver="{{ $item->ip_server ?? '' }}"
                                data-usersh="{{ $item->user_ssh ?? '' }}"
                                data-passssh="{{ $item->password_ssh ?? '' }}"
                                data-dbname="{{ $item->database_name ?? '' }}"
                                data-dbuser="{{ $item->database_user ?? '' }}"
                                data-dbpass="{{ $item->database_password ?? '' }}"
                                data-path="{{ $item->lokasi_aplikasi ?? '' }}">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>

                        {{-- DISABLE --}}
                        @if ($item->status == 'active')

                        <form action="{{ route('admin.subdomain.disable', $item->id) }}"
                              method="POST"
                              style="display:inline;">

                            @csrf

                            <button type="submit"
                                    class="action-btn disable-btn btn-disable"
                                    data-name="{{ $item->nama_sub_domain }}">

                                <i class="fa-solid fa-ban"></i>

                            </button>

                        </form>

                        @endif

                        {{-- DELETE --}}
                        <form action="{{ route('admin.subdomain.destroy', $item->id) }}"
                              method="POST"
                              style="display:inline;">

                            @csrf
                            @method('DELETE')

                            <button type="button"
                                    class="action-btn delete-btn btn-delete"
                                    data-name="{{ $item->nama_sub_domain }}">

                                <i class="fa-solid fa-trash"></i>

                            </button>

                        </form>

                    </div>

                </div>

                @empty

                <div style="text-align:center; padding:20px; color:#6b7280;">

                    Belum ada pengajuan sub domain / hosting

                </div>

                @endforelse

            </div>

        </div>

    </div>

</div>

{{-- MODAL EDIT DATA DENGAN PARAMETER LENGKAP --}}
<div id="editModal" class="custom-modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Edit Data Pengajuan</h3>
            <button type="button" class="modal-close" id="closeModalBtn">&times;</button>
        </div>
        <form id="editForm" method="POST" action="">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="edit_nama_organisasi">Nama Organisasi</label>
                <input type="text" name="nama_organisasi" id="edit_nama_organisasi" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="edit_jenis_domain">Jenis Domain / Hosting</label>
                <input type="text" name="jenis_domain" id="edit_jenis_domain" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="edit_nama_teknis">Nama Pemohon (Teknis)</label>
                <input type="text" name="nama_teknis" id="edit_nama_teknis" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="edit_email_teknis">Email Pemohon</label>
                <input type="email" name="email_teknis" id="edit_email_teknis" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="edit_nama_sub_domain">Nama Sub Domain</label>
                <input type="text" name="nama_sub_domain" id="edit_nama_sub_domain" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="edit_status">Status Pengajuan</label>
                <select name="status" id="edit_status" class="form-control" required>
                    <option value="pending">Menunggu (Pending)</option>
                    <option value="active">Active</option>
                    <option value="disabled">Disabled</option>
                    <option value="rejected">Reject</option>
                </select>
            </div>

            <div class="parameter-section-title">
                <i class="fa-solid fa-server"></i> Parameter Konfigurasi Hosting (Akses Server)
            </div>

            <div class="form-group">
                <label for="edit_ip_server">IP Server</label>
                <input type="text" name="ip_server" id="edit_ip_server" class="form-control">
            </div>

            <div class="form-group">
                <label for="edit_user_ssh">User SSH</label>
                <input type="text" name="user_ssh" id="edit_user_ssh" class="form-control">
            </div>

            {{-- FIELD BARU: PASSWORD SSH --}}
            <div class="form-group">
                <label for="edit_password_ssh">Password SSH</label>
                <input type="text" name="password_ssh" id="edit_password_ssh" class="form-control">
            </div>

            <div class="form-group">
                <label for="edit_database_name">Database Name</label>
                <input type="text" name="database_name" id="edit_database_name" class="form-control">
            </div>

            <div class="form-group">
                <label for="edit_database_user">Database User</label>
                <input type="text" name="database_user" id="edit_database_user" class="form-control">
            </div>

            {{-- FIELD BARU: DATABASE PASSWORD --}}
            <div class="form-group">
                <label for="edit_database_password">Database Password</label>
                <input type="text" name="database_password" id="edit_database_password" class="form-control">
            </div>

            <div class="form-group">
                <label for="edit_lokasi_aplikasi">Lokasi Aplikasi (Path)</label>
                <input type="text" name="lokasi_aplikasi" id="edit_lokasi_aplikasi" class="form-control">
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-cancel" id="cancelModalBtn">Batal</button>
                <button type="button" class="btn-submit" id="submitFormBtn">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>

// --- CONTROLLER MODAL EDIT (NEW) ---
const modal = document.getElementById('editModal');
const closeBtn = document.getElementById('closeModalBtn');
const cancelBtn = document.getElementById('cancelModalBtn');
const editForm = document.getElementById('editForm');
const submitFormBtn = document.getElementById('submitFormBtn');

// Definisikan elemen input form atas yang dapat dikunci
const inputsToLock = [
    document.getElementById('edit_nama_organisasi'),
    document.getElementById('edit_jenis_domain'),
    document.getElementById('edit_nama_teknis'),
    document.getElementById('edit_email_teknis'),
    document.getElementById('edit_nama_sub_domain')
];

// Definisikan array elemen input Parameter Server Baru (Ditambahkan Password SSH & DB Password)
const serverInputs = [
    document.getElementById('edit_ip_server'),
    document.getElementById('edit_user_ssh'),
    document.getElementById('edit_password_ssh'),
    document.getElementById('edit_database_name'),
    document.getElementById('edit_database_user'),
    document.getElementById('edit_database_password'),
    document.getElementById('edit_lokasi_aplikasi')
];

document.querySelectorAll('.btn-edit').forEach(button => {
    button.addEventListener('click', function () {
        const id = this.getAttribute('data-id');
        const organisasi = this.getAttribute('data-organisasi');
        const jenis = this.getAttribute('data-jenis');
        const pemohon = this.getAttribute('data-pemohon');
        const email = this.getAttribute('data-email');
        const subdomain = this.getAttribute('data-subdomain');
        const status = this.getAttribute('data-status');
        
        // Mengambil atribut data server lengkap sesuai nama lowercase yang diberikan di elemen button
        const ipserver = this.getAttribute('data-ipserver');
        const usersh = this.getAttribute('data-usersh');
        const passssh = this.getAttribute('data-passssh');
        const dbname = this.getAttribute('data-dbname');
        const dbuser = this.getAttribute('data-dbuser');
        const dbpass = this.getAttribute('data-dbpass');
        const path = this.getAttribute('data-path');

        // Menggunakan path absolut domain HTTPS untuk mematikan potensi downgrade request di reverse proxy
        editForm.setAttribute('action', window.location.origin + `/admin/subdomain/update/${id}`);

        // Isi data field form di dalam modal
        document.getElementById('edit_nama_organisasi').value = organisasi;
        document.getElementById('edit_jenis_domain').value = jenis;
        document.getElementById('edit_nama_teknis').value = pemohon;
        document.getElementById('edit_email_teknis').value = email;
        document.getElementById('edit_nama_sub_domain').value = subdomain;
        document.getElementById('edit_status').value = status;
        
        // Memasukkan isi value ke field parameter server di dalam modal
        document.getElementById('edit_ip_server').value = ipserver;
        document.getElementById('edit_user_ssh').value = usersh;
        document.getElementById('edit_password_ssh').value = passssh;
        document.getElementById('edit_database_name').value = dbname;
        document.getElementById('edit_database_user').value = dbuser;
        document.getElementById('edit_database_password').value = dbpass;
        document.getElementById('edit_lokasi_aplikasi').value = path;

        // Menerapkan logika penguncian form teks atas & form server berdasarkan status awal data dimuat
        toggleFormLocking(status);

        // Tampilkan modal
        modal.classList.add('show');
    });
});

// KODE BARU LOGIKA DINAMIS: Menangani perubahan dropdown status secara realtime agar form bawah TIDAK HILANG, melainkan berubah mode lock/unlock-nya
document.getElementById('edit_status').addEventListener('change', function() {
    toggleFormLocking(this.value);
});

// KODE BARU LOGIKA DINAMIS: Fungsi terpusat mengatur readonly field form tanpa menghilangkan komponen HTML-nya
function toggleFormLocking(statusValue) {
    if (statusValue === 'active' || statusValue === 'disabled') {
        // Kunci input data pengajuan utama atas
        inputsToLock.forEach(input => {
            input.setAttribute('readonly', true);
        });
        // Buka kunci input parameter server agar administrator bisa menginput IP, DB dll secara berkala
        serverInputs.forEach(input => {
            input.removeAttribute('readonly');
        });
    } else {
        // Jika statusnya pending atau rejected, buka form atas agar bisa diperbaiki
        inputsToLock.forEach(input => {
            input.removeAttribute('readonly');
        });
        // Untuk kenyamanan operasional, form server tetap dibiarkan terbuka (tidak dihilangkan)
        serverInputs.forEach(input => {
            input.removeAttribute('readonly');
        });
    }
}

function hideModal() {
    modal.classList.remove('show');
}

closeBtn.addEventListener('click', hideModal);
cancelBtn.addEventListener('click', hideModal);

// Tutup modal jika user klik di area luar kotak modal
window.addEventListener('click', function (e) {
    if (e.target === modal) {
        hideModal();
    }
});

// Menangani klik tombol "Simpan Perubahan" secara terpisah demi memutus loop submit berulang
submitFormBtn.addEventListener('click', function () {
    // Validasi dasar HTML5 bawaan form tetap diperiksa secara manual sebelum SweetAlert dipanggil
    if (!editForm.checkValidity()) {
        editForm.reportValidity();
        return;
    }

    Swal.fire({
        title: 'Simpan Perubahan?',
        text: "Pastikan data pengajuan yang diubah sudah benar.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#2563eb',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Simpan!',
        cancelButtonText: 'Batal',
        // Perbaikan Z-Index: Memaksa Container SweetAlert berada di atas .custom-modal (9999)
        didOpen: () => {
            const swalContainer = document.querySelector('.swal2-container');
            if (swalContainer) {
                swalContainer.style.zIndex = '100000';
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Menggunakan native requestSubmit() tanpa memicu loop penangkapan event submit kembali
            if (typeof editForm.requestSubmit === 'function') {
                editForm.requestSubmit();
            } else {
                editForm.submit();
            }
        }
    });
});
// ------------------------------------

document.querySelectorAll('.btn-delete').forEach(button => {

    button.addEventListener('click', function () {

        let form = this.closest('form');
        let name = this.getAttribute('data-name');

        Swal.fire({

            title: 'Yakin hapus data?',

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

document.querySelectorAll('.btn-disable').forEach(button => {

    button.addEventListener('click', function (e) {

        e.preventDefault();

        let form = this.closest('form');

        let name = this.getAttribute('data-name');

        Swal.fire({

            title: 'Disable Hosting?',

            text: name + " akan dinonaktifkan!",

            icon: 'warning',

            showCancelButton: true,

            confirmButtonColor: '#f59e0b',

            cancelButtonColor: '#6b7280',

            confirmButtonText: 'Ya, disable!',

            cancelButtonText: 'Batal'

        }).then((result) => {

            if (result.isConfirmed) {

                form.submit();

            }

        });

    });

});

document.querySelectorAll('.btn-close').forEach(button => {

    button.addEventListener('click', function () {

        this.parentElement.style.display = 'none';

    });

});

</script>

@endsection