@extends('operator.layout')

@section('title', 'Kelola FAQ & Panduan')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
/* ===============================
   FONT & GLOBAL
=============================== */
body {
    font-family: 'Inter', sans-serif;
    background: #f4f4f8;
}

/* ===============================
   CONTAINER
=============================== */
.admin-faq-container {
    padding: 40px;
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.05);
}

.admin-faq-container h2 {
    margin-bottom: 25px;
    color: #1b3b5f;
    font-weight: 700;
    font-size: 28px;
}

/* ALERT */
.alert {
    padding: 15px 20px;
    border-radius: 8px;
    margin-bottom: 25px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.alert-success {
    background: #e6f4ea;
    color: #155724;
    border-left: 5px solid #28a745;
}

.alert-danger {
    background: #fbeaea;
    color: #721c24;
    border-left: 5px solid #dc3545;
}

/* FORM */
.faq-form {
    display: grid;
    grid-template-columns: 180px 1fr;
    gap: 18px;
    margin-bottom: 35px;
    padding: 25px;
    border-radius: 12px;
    background: #f8f9fb;
}

.faq-form select,
.faq-form input,
.faq-form textarea {
    padding: 12px 14px;
    border-radius: 8px;
    border: 1px solid #d1d5db;
}

.faq-form textarea {
    grid-column: span 2;
    min-height: 100px;
}

.faq-form button {
    grid-column: span 2;
    padding: 12px;
    background: #1b3b5f;
    color: #fff;
    border: none;
    border-radius: 8px;
    cursor: pointer;
}

/* TABLE */
.faq-table {
    width: 100%;
    border-collapse: collapse;
    border-radius: 12px;
    overflow: hidden;
}

.faq-table th,
.faq-table td {
    padding: 14px;
    font-size: 14px;
}

.faq-table th {
    background: #d1d5db;
}

/* ICON */
.action-icons {
    display: flex;
    gap: 10px;
}

.btn-icon {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    border: none;
    cursor: pointer;
}

.btn-edit {
    background: #e7f1ff;
    color: #0d6efd;
}

.btn-delete {
    background: #fdeaea;
    color: #dc3545;
}

/* MODAL */
/* ===============================
   MODAL PREMIUM
=============================== */

.modal{
    display:none;
    position:fixed;
    inset:0;
    background:rgba(15,23,42,.65);
    backdrop-filter:blur(5px);
    justify-content:center;
    align-items:center;
    z-index:9999;
    animation:fadeIn .3s ease;
}

.modal-content{
    background:#fff;
    width:450px;
    max-width:95%;
    padding:30px;
    border-radius:20px;
    box-shadow:0 25px 50px rgba(0,0,0,.15);
    animation:zoomIn .3s ease;
}

.modal-content h3{
    font-size:24px;
    font-weight:700;
    color:#1b3b5f;
    margin-bottom:12px;
}

.modal-content p{
    color:#64748b;
    line-height:1.7;
    margin-bottom:25px;
}

/* FORM MODAL EDIT */

.modal-content select,
.modal-content input,
.modal-content textarea{
    width:100%;
    padding:12px 14px;
    margin-bottom:15px;
    border:1px solid #dbe2ea;
    border-radius:10px;
    outline:none;
    font-size:14px;
    transition:.3s;
}

.modal-content select:focus,
.modal-content input:focus,
.modal-content textarea:focus{
    border-color:#1b3b5f;
    box-shadow:0 0 0 4px rgba(27,59,95,.1);
}

.modal-content textarea{
    min-height:120px;
    resize:vertical;
}

/* BUTTON MODAL */

.modal-actions{
    display:flex;
    justify-content:flex-end;
    gap:12px;
    margin-top:20px;
}

.modal-actions button{
    border:none;
    padding:11px 22px;
    border-radius:10px;
    cursor:pointer;
    font-weight:600;
    transition:.3s;
}

.modal-actions button:first-child{
    background:#f1f5f9;
    color:#475569;
}

.modal-actions button:first-child:hover{
    background:#e2e8f0;
}

.modal-actions button:last-child{
    background:#1b3b5f;
    color:#fff;
}

.modal-actions button:last-child:hover{
    background:#244d79;
    transform:translateY(-2px);
}

/* MODAL DELETE */

#deleteModal .modal-content{
    text-align:center;
}

.delete-icon{
    font-size:60px;
    color:#dc3545;
    margin-bottom:15px;
    display:block;
}

#deleteModal h3{
    color:#dc3545;
}

#deleteModal .modal-actions{
    justify-content:center;
}

#deleteModal .modal-actions button:last-child{
    background:#dc3545;
}

#deleteModal .modal-actions button:last-child:hover{
    background:#c82333;
}

/* ANIMATION */

@keyframes fadeIn{
    from{
        opacity:0;
    }
    to{
        opacity:1;
    }
}

@keyframes zoomIn{
    from{
        opacity:0;
        transform:scale(.9);
    }
    to{
        opacity:1;
        transform:scale(1);
    }
}
/* ===============================
   RESPONSIVE MOBILE (TANPA MERUSAK DESKTOP)
=============================== */
@media (max-width: 768px) {

    .admin-faq-container {
        padding: 15px;
    }

    .admin-faq-container h2 {
        font-size: 20px;
        text-align: center;
    }

    /* FORM jadi 1 kolom */
    .faq-form {
        grid-template-columns: 1fr;
        padding: 15px;
    }

    .faq-form textarea,
    .faq-form button {
        grid-column: span 1;
    }

    /* TABLE scroll horizontal */
    .faq-table {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }

    .faq-table th,
    .faq-table td {
        font-size: 12px;
        padding: 10px;
    }

    /* ICON lebih kecil */
    .btn-icon {
        width: 32px;
        height: 32px;
        font-size: 14px;
    }

    /* MODAL full mobile */
    .modal-content {
        width: 90%;
        padding: 20px;
    }

    .modal-actions {
        flex-direction: column;
    }

    .modal-actions button {
        width: 100%;
    }
}
</style>

<div class="admin-faq-container">

<h2>Kelola FAQ & Panduan</h2>

@if(session('success_add'))
<div class="alert alert-success">
    {{ session('success_add') }}
</div>
@endif

@if(session('success_delete'))
<div class="alert alert-danger">
    {{ session('success_delete') }}
</div>
@endif

<form action="{{ route('admin.faq.store') }}" method="POST" class="faq-form">
@csrf
<select name="type" required>
    <option value="">Pilih Jenis</option>
    <option value="faq">FAQ</option>
    <option value="panduan">Panduan</option>
</select>

<input type="text" name="question" placeholder="Pertanyaan" required>

<textarea name="answer" placeholder="Jawaban" required></textarea>

<button type="submit"><i class="fa fa-plus"></i> Tambah</button>
</form>

<table class="faq-table">
<thead>
<tr>
    <th>No</th>
    <th>Jenis</th>
    <th>Pertanyaan</th>
    <th>Jawaban</th>
    <th>Aksi</th>
</tr>
</thead>
<tbody>
@forelse($faqs as $faq)
<tr>
<td>{{ $loop->iteration }}</td>
<td>{{ strtoupper($faq->type) }}</td>
<td>{{ $faq->question }}</td>
<td>{{ $faq->answer }}</td>
<td>
<div class="action-icons">
<button class="btn-icon btn-edit"
onclick="openEditModal('{{ $faq->id }}','{{ $faq->type }}','{{ addslashes($faq->question) }}','{{ addslashes($faq->answer) }}')">
<i class="fa fa-pen"></i>
</button>

<form action="{{ route('admin.faq.destroy',$faq->id) }}" method="POST">
@csrf
@method('DELETE')
<button type="button" class="btn-icon btn-delete" onclick="openDeleteModal(this)">
<i class="fa fa-trash"></i>
</button>
</form>
</div>
</td>
</tr>
@empty
<tr><td colspan="5" align="center">Belum ada data</td></tr>
@endforelse
</tbody>
</table>
</div>

<!-- MODAL EDIT -->
<div id="editModal" class="modal">
<div class="modal-content">
<h3>Edit FAQ</h3>
<form id="editForm" method="POST">
@csrf
@method('PUT')
<select name="type" id="editType"></select>
<input type="text" name="question" id="editQuestion">
<textarea name="answer" id="editAnswer"></textarea>

<div class="modal-actions">
<button type="button" onclick="closeEditModal()">Batal</button>
<button type="submit">Simpan</button>
</div>
</form>
</div>
</div>

<!-- MODAL DELETE -->
<div id="deleteModal" class="modal">
<div class="modal-content">
<h3>Hapus FAQ?</h3>
<p>Yakin ingin menghapus data ini?</p>

<div class="modal-actions">
<button onclick="closeDeleteModal()">Batal</button>
<button onclick="confirmDelete()">Hapus</button>
</div>
</div>
</div>

<script>
let deleteForm;

const editModal = document.getElementById('editModal');
const deleteModal = document.getElementById('deleteModal');

const editForm = document.getElementById('editForm');
const editType = document.getElementById('editType');
const editQuestion = document.getElementById('editQuestion');
const editAnswer = document.getElementById('editAnswer');

function openEditModal(id, type, q, a){
    editType.innerHTML = `
        <option value="faq">FAQ</option>
        <option value="panduan">Panduan</option>
    `;

    editType.value = type;
    editQuestion.value = q;
    editAnswer.value = a;

    editForm.action = `/admin/faq/${id}`;
    editModal.style.display = 'flex';
}

function closeEditModal(){
    editModal.style.display = 'none';
}

function openDeleteModal(btn){
    deleteForm = btn.closest('form');
    deleteModal.style.display = 'flex';
}

function closeDeleteModal(){
    deleteModal.style.display = 'none';
}

function confirmDelete(){
    if(deleteForm) deleteForm.submit();
}
</script>

@endsection