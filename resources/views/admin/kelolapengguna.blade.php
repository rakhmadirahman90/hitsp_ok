@extends('admin.layout')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>

/* ================= RESET ================= */
*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

body{
background:#f4f7fb;
color:#374151;
line-height:1.5;
}

/* ================= CONTAINER ================= */
.user-container{
max-width:1150px;
margin:30px auto;
padding:30px;
background:#fff;
border-radius:22px;
box-shadow:0 10px 35px rgba(0,0,0,.06);
}

h2{
font-size:30px;
font-weight:700;
margin-bottom:25px;
color:#263238;
}

/* ================= ALERT ================= */
#alert-success{
background:linear-gradient(135deg,#d1fae5,#ecfdf5);
color:#065f46;
padding:15px 18px;
border-left:5px solid #10b981;
border-radius:14px;
margin-bottom:20px;
font-weight:500;
box-shadow:0 4px 15px rgba(16,185,129,.15);
animation:slideDown .4s ease;
}

.alert-danger{
background:#fff1f2;
color:#b91c1c;
padding:15px 18px;
border-left:5px solid #ef4444;
border-radius:14px;
margin-bottom:20px;
}

.alert-danger ul{
padding-left:20px;
}

@keyframes slideDown{
from{
opacity:0;
transform:translateY(-15px);
}
to{
opacity:1;
transform:translateY(0);
}
}

/* ================= BUTTON TOP ================= */
.table-actions{
margin-bottom:20px;
}

.btn-action{
background:linear-gradient(135deg,#607d8b,#455a64);
color:#fff;
border:none;
padding:13px 20px;
border-radius:12px;
font-weight:600;
cursor:pointer;
transition:.3s;
box-shadow:0 5px 14px rgba(0,0,0,.09);
}

.btn-action:hover{
transform:translateY(-2px);
}

/* ================= TABLE ================= */
table{
width:100%;
border-collapse:collapse;
overflow:hidden;
border-radius:18px;
background:#fff;
}

thead{
background:#eef2f7;
}

th{
padding:16px;
font-size:15px;
font-weight:700;
color:#374151;
}

td{
padding:15px;
font-size:14px;
border-bottom:1px solid #edf2f7;
}

tbody tr{
transition:.3s;
}

tbody tr:hover{
background:#f8fbff;
}

td button{
border:none;
cursor:pointer;
transition:.3s;
margin-right:8px;
}

td button:hover{
transform:scale(1.05);
}

/* STATUS */
.status-pending{
background:#fff3cd;
color:#856404;
padding:6px 12px;
border-radius:20px;
font-size:12px;
font-weight:600;
}

.status-approved{
background:#d4edda;
color:#155724;
padding:6px 12px;
border-radius:20px;
font-size:12px;
font-weight:600;
}

.status-rejected{
background:#f8d7da;
color:#721c24;
padding:6px 12px;
border-radius:20px;
font-size:12px;
font-weight:600;
}

/* BUTTON */
.approve-btn{
background:#16a34a;
color:white;
padding:8px 14px;
border-radius:10px;
font-size:13px;
font-weight:600;
}

.reject-btn{
background:#dc2626;
color:white;
padding:8px 14px;
border-radius:10px;
font-size:13px;
font-weight:600;
}

.edit-btn-table{
background:#f39c12;
color:white;
padding:8px 12px;
border-radius:10px;
font-size:13px;
}

.delete-btn-table{
background:#dc2626;
color:white;
padding:8px 12px;
border-radius:10px;
font-size:13px;
}

/* MOBILE CARD */
.mobile-card{
display:none;
background:#fff;
padding:24px; /* Sedikit dinaikkan agar terasa longgar di HP */
border-radius:18px;
margin-bottom:18px;
box-shadow:0 4px 18px rgba(0,0,0,.06);
border: 1px solid #edf2f7;
}

.mobile-card h4{
font-size:20px;
font-weight:700;
margin-bottom:15px;
color:#263238;
}

.mobile-card p{
margin-bottom:10px;
font-size:14px;
display:flex;
justify-content:between;
align-items:center;
border-bottom: 1px dashed #f1f5f9;
padding-bottom: 8px;
}

.mobile-card p b {
color: #64748b;
font-weight: 500;
}

.mobile-card p span.val-data {
font-weight: 600;
color: #334155;
text-align: right;
}

.card-action{
display:flex;
gap:12px;
margin-top:20px;
flex-wrap:nowrap; /* Mencegah berantakan kesamping */
flex-direction: column; /* Sesuai mockup anda: tombol ditumpuk vertikal */
}

.card-action button, .card-action a, .card-action form {
width: 100%;
}

.card-action .edit-btn-table, .card-action .delete-btn-table {
padding: 12px;
font-weight: 600;
font-size: 14px;
display: flex;
align-items: center;
justify-content: center;
gap: 8px;
border-radius: 12px;
border: none;
}

.card-action form .approve-btn {
width: 100%;
height: 44px;
font-size: 14px;
border-radius: 12px;
display: flex;
align-items: center;
justify-content: center;
gap: 8px;
margin-bottom: 5px;
}

/* OVERLAY */
.confirm-overlay{
position:fixed;
inset:0;
display:none;
justify-content:center;
align-items:center;
background:rgba(15,23,42,.45);
backdrop-filter:blur(7px);
z-index:99999;
padding:20px;
overflow-y:auto;
}

/* MODAL */
.login-box,
.confirm-box{
background:#fff;
width:100%;
max-width:520px;
max-height:92vh;
overflow-y:auto;
padding:32px;
border-radius:24px;
box-shadow:0 25px 60px rgba(0,0,0,.2);
animation:zoomIn .3s ease;
}

@keyframes zoomIn{
from{
opacity:0;
transform:scale(.92);
}
to{
opacity:1;
transform:scale(1);
}
}

.login-box h3,
.confirm-box h3{
text-align:center;
font-size:27px;
font-weight:700;
margin-bottom:25px;
color:#263238;
}

/* FORM */
.login-box form,
#editForm{
display:flex;
flex-direction:column;
gap:15px;
}

.login-box input,
.login-box select,
#editForm input,
#editForm select{
width:100%;
padding:14px 16px;
border:1.5px solid #d6dee6;
border-radius:14px;
font-size:15px;
outline:none;
transition:.3s;
background:#fff;
}

.login-box input:focus,
.login-box select:focus,
#editForm input:focus,
#editForm select:focus{
border-color:#607d8b;
box-shadow:0 0 0 4px rgba(96,125,139,.15);
}

/* PASSWORD */
.password-wrap{
position:relative;
}

.password-wrap input{
padding-right:48px;
}

.eye{
position:absolute;
right:16px;
top:50%;
transform:translateY(-50%);
cursor:pointer;
font-size:17px;
color:#6b7280;
}

small{
display:block;
font-size:12px;
line-height:1.5;
color:#6b7280;
margin-top:-4px;
}

#ruleInfo{
background:#f8fafc;
padding:14px;
border-radius:12px;
border:1px solid #e2e8f0;
margin-top:-2px;
}

#passError,
#confirmError{
display:none;
background:#fff1f2;
color:#b91c1c;
padding:11px 14px;
border-left:4px solid #ef4444;
border-radius:12px;
font-size:13px;
}

input.invalid{
border:2px solid #ef4444 !important;
}

input.valid{
border:2px solid #10b981 !important;
}

/* SELECT */
select{
appearance:none;
background:
linear-gradient(45deg,transparent 50%,#555 50%),
linear-gradient(135deg,#555 50%,transparent 50%);
background-position:
calc(100% - 20px) calc(50% - 3px),
calc(100% - 14px) calc(50% - 3px);
background-size:6px 6px;
background-repeat:no-repeat;
}

/* BUTTON FORM */
.submit-btn,
.update-btn{
border:none;
padding:14px;
border-radius:14px;
background:linear-gradient(135deg,#607d8b,#455a64);
color:white;
font-weight:600;
cursor:pointer;
margin-top:8px;
transition:.3s;
}

.cancel-btn{
border:none;
padding:14px;
border-radius:14px;
background:#edf2f7;
font-weight:600;
cursor:pointer;
}

/* ================= PAGINATION ================= */

.pagination-wrapper{
display:flex;
justify-content:center;
align-items:center;
margin-top:35px;
flex-wrap:wrap;
}

.pagination{
display:flex !important;
align-items:center;
gap:10px;
list-style:none;
padding:0;
margin:0;
flex-wrap:wrap;
}

.page-item{
list-style:none;
}

.page-link{
display:flex !important;
justify-content:center;
align-items:center;
min-width:42px;
height:42px;
padding:0 15px !important;
border-radius:12px !important;
border:none !important;
background:#ffffff !important;
color:#455a64 !important;
font-weight:600;
font-size:14px;
box-shadow:0 3px 10px rgba(0,0,0,.08);
transition:all .25s ease;
text-decoration:none !important;
}

.page-link:hover{
background:#607d8b !important;
color:#fff !important;
transform:translateY(-2px);
}

.page-item.active .page-link{
background:linear-gradient(135deg,#607d8b,#455a64) !important;
color:white !important;
box-shadow:0 5px 15px rgba(96,125,139,.35);
}

.page-item.disabled .page-link{
background:#eceff1 !important;
color:#90a4ae !important;
cursor:not-allowed;
box-shadow:none;
opacity:.8;
}

/* TEXT PAGINATION */
.pagination-wrapper p{
width:100%;
text-align:center;
margin-top:18px;
font-size:14px;
color:#607d8b;
font-weight:500;
}

/* MOBILE MEDIA QUERY */
@media(max-width:768px){

.pagination{
gap:6px;
justify-content:center;
}

.page-link{
min-width:36px;
height:36px;
font-size:13px;
padding:0 12px !important;
}

.pagination-wrapper p{
font-size:12px;
line-height:1.6;
}

.user-container{
margin:15px;
padding:18px;
}

table{
display:none !important; /* Paksa sembunyikan tabel desktop di mobile */
}

.mobile-card{
display:block !important; /* Paksa tampilkan card mobile hanya di layar HP */
}

}

/* ================= AKSI BUTTON ================= */

.aksi-cell{
display:flex;
align-items:center;
gap:8px;
flex-wrap:nowrap;
min-width:170px;
}

.aksi-cell form{
margin:0;
}

.aksi-cell button{
display:flex;
align-items:center;
justify-content:center;
gap:5px;
height:38px;
white-space:nowrap;
}

.approve-btn{
    width:38px;
    height:38px;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:0;
    border-radius:10px;
}
</style>

<div class="user-container">

<h2>Kelola Pengguna</h2>

<div class="table-actions">
<button class="btn-action" onclick="openRegisterModal()">
<i class="fa fa-user-plus"></i> Tambah Pengguna
</button>
</div>

@if(session('success'))
<div id="alert-success">
{{ session('success') }}
</div>
@endif

@if ($errors->any())
<div class="alert-danger">
<ul>
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif

{{-- 1. TAMPILAN TABEL (OTOMATIS TERSEMBUNYI DI MOBILE VIA MEDIA QUERY CSS) --}}
<table>

<thead>
<tr>
<th>No</th>
<th>Nama</th>
<th>Username</th>
<th>Email</th>
<th>Role</th>
<th>Status</th>
<th>Aksi</th>
</tr>
</thead>

<tbody>

@forelse($users as $i => $user)

<tr>

<td>{{ $users->firstItem() + $i }}</td>

<td>{{ $user->nama ?? $user->name }}</td>

<td>{{ $user->username }}</td>

<td>{{ $user->email }}</td>

<td>{{ $user->role }}</td>

<td>

@if($user->status == 'pending')

<span class="status-pending">
Pending
</span>

@elseif($user->status == 'approved')

<span class="status-approved">
Approved
</span>

@elseif($user->status == 'rejected')

<span class="status-rejected">
Rejected
</span>

@endif

</td>

<td class="aksi-cell">

{{-- APPROVE --}}
@if($user->status == 'pending')

<form action="{{ route('admin.user.approve',$user->id) }}" method="POST">
@csrf
@method('PUT')

<button type="submit" class="approve-btn">
<i class="fa fa-check"></i>

</button>

</form>

@endif

{{-- EDIT --}}
<button
onclick='openEditModal(@json($user))'
class="edit-btn-table"
>

<i class="fa fa-pen"></i>

</button>

{{-- DELETE --}}
<button
onclick="openConfirm({{$user->id}})"
class="delete-btn-table"
>

<i class="fa fa-trash"></i>

</button>

<form
id="deleteForm{{$user->id}}"
action="{{ route('admin.user.destroy',$user->id) }}"
method="POST"
style="display:none"
>

@csrf
@method('DELETE')

</form>

</td>

</tr>

@empty

<tr>
<td colspan="7" align="center">
Belum ada data pengguna
</td>
</tr>

@endforelse

</tbody>
</table>

{{-- 2. TAMPILAN CARD VERSI MOBILE (OTOMATIS MUNCUL DI MOBILE & TERSEMBUNYI DI DESKTOP) --}}
@forelse($users as $user)

<div class="mobile-card">

<h4>{{ $user->nama ?? $user->name }}</h4>

<p><b>Username :</b> <span class="val-data">{{ $user->username }}</span></p>

<p><b>Email :</b> <span class="val-data">{{ $user->email }}</span></p>

<p><b>Role :</b> <span class="val-data">{{ $user->role }}</span></p>

<p style="border-bottom:none;">
<b>Status :</b>

@if($user->status == 'pending')

<span class="status-pending">
Pending
</span>

@elseif($user->status == 'approved' || $user->status == 'Approved')

<span class="status-approved">
Approved
</span>

@elseif($user->status == 'rejected')

<span class="status-rejected">
Rejected
</span>

@endif

</p>

<div class="card-action">

@if($user->status == 'pending')
<form action="{{ route('admin.user.approve',$user->id) }}" method="POST">
@csrf
@method('PUT')
<button type="submit" class="approve-btn" title="Approve" style="background:#16a34a; color:white;">
    <i class="fa fa-check"></i> Setujui Pengguna
</button>
</form>
@endif

<button
class="edit-btn-table"
onclick='openEditModal(@json($user))'
>
<i class="fa fa-pen"></i>
Edit
</button>

<button
class="delete-btn-table"
onclick="openConfirm({{$user->id}})"
>
<i class="fa fa-trash"></i>
Hapus
</button>

</div>

</div>

@empty
@endforelse

{{-- PAGINATION LINK --}}
@if($users->hasPages())
<div class="pagination-wrapper">
{{ $users->links('pagination::bootstrap-5') }}
</div>
@endif

</div>

{{-- REGISTER OVERLAY --}}
<div class="confirm-overlay" id="registerOverlay">

<div class="login-box">

<h3>Registrasi Pengguna</h3>

<form action="{{ route('admin.user.store') }}" method="POST">

@csrf

<input type="text" name="nama" placeholder="Nama Lengkap" required>

<input type="text" name="username" maxlength="18" placeholder="NIP/NIM" required>

<input type="email" name="email" placeholder="Email" required>

<div class="password-wrap">

<input
type="password"
name="password"
id="password"
placeholder="Password"
required
onkeyup="validatePassword()"
>

<i class="fa fa-eye eye"
onclick="togglePassword('password',this)">
</i>

</div>

<small id="passError">
Password belum memenuhi syarat
</small>

<div class="password-wrap">

<input
type="password"
name="password_confirmation"
id="password_confirmation"
placeholder="Konfirmasi Password"
required
onkeyup="checkConfirmPassword()"
>

<i class="fa fa-eye eye"
onclick="togglePassword('password_confirmation',this)">
</i>

</div>

<small id="confirmError">
Konfirmasi password tidak sama
</small>

<small id="ruleInfo">
Password wajib:
<br>� Minimal 8 karakter
<br>� Diawali huruf besar
<br>� Mengandung angka
<br>� Mengandung simbol
</small>

<select name="role" required>
<option value="">Pilih Role</option>
<option value="admin">Admin</option>
<option value="operator">Operator</option>
<option value="dosen">Dosen</option>
<option value="mahasiswa">Mahasiswa</option>
<option value="staf">Staf</option>
</select>

<button class="submit-btn">
Simpan
</button>

<button
type="button"
class="cancel-btn"
onclick="closeRegisterModal()"
>
Batal
</button>

</form>

</div>
</div>

{{-- EDIT OVERLAY --}}
<div class="confirm-overlay" id="editOverlay">

<div class="login-box">

<h3>Edit Pengguna</h3>

<form id="editForm" method="POST">

@csrf
@method('PUT')

<input type="text" name="nama" id="edit_nama">

<input type="text" name="username" id="edit_username">

<input type="email" name="email" id="edit_email">

<select name="role" id="edit_role">
<option value="admin">Admin</option>
<option value="operator">Operator</option>
<option value="dosen">Dosen</option>
<option value="mahasiswa">Mahasiswa</option>
<option value="staf">Staf</option>
</select>

<button class="update-btn">
Update
</button>

<button
type="button"
class="cancel-btn"
onclick="closeEditModal()"
>
Batal
</button>

</form>

</div>
</div>

{{-- DELETE OVERLAY --}}
<div class="confirm-overlay" id="confirmOverlay">

<div class="confirm-box">

<h3>Konfirmasi Hapus</h3>

<p align="center">
Yakin hapus data?
</p>

<button
onclick="submitDelete()"
style="
background:#d32f2f;
color:#fff;
padding:14px;
border:none;
border-radius:12px;
width:100%;
margin-bottom:10px;
font-weight:600;
cursor:pointer;
"
>
Ya Hapus
</button>

<button
onclick="closeConfirm()"
class="cancel-btn"
style="width:100%;"
>
Batal
</button>

</div>
</div>

<script>

let deleteId=null;

function togglePassword(id,icon){

let input=document.getElementById(id);

if(input.type==="password"){

input.type="text";
icon.classList.replace('fa-eye','fa-eye-slash');

}else{

input.type="password";
icon.classList.replace('fa-eye-slash','fa-eye');

}

}

function openRegisterModal(){
document.getElementById('registerOverlay').style.display='flex';
}

function closeRegisterModal(){
document.getElementById('registerOverlay').style.display='none';
}

function openEditModal(user){

document.getElementById('editForm').action=
`/admin/kelola-pengguna/update/${user.id}`;

document.getElementById('edit_nama').value=
user.nama || user.name;

document.getElementById('edit_username').value=
user.username;

document.getElementById('edit_email').value=
user.email;

document.getElementById('edit_role').value=
user.role;

document.getElementById('editOverlay').style.display='flex';

}

function closeEditModal(){
document.getElementById('editOverlay').style.display='none';
}

function openConfirm(id){

deleteId=id;

document.getElementById('confirmOverlay').style.display='flex';

}

function closeConfirm(){
document.getElementById('confirmOverlay').style.display='none';
}

function submitDelete(){

if(deleteId){

document.getElementById(
'deleteForm'+deleteId
).submit();

}

}

window.onclick=function(e){

if(e.target.classList.contains("confirm-overlay")){

closeRegisterModal();
closeEditModal();
closeConfirm();

}

}

setTimeout(()=>{

let a=document.getElementById('alert-success');

if(a){

a.style.display='none';

}

},3000);

function validatePassword(){

let p=document.getElementById('password');

let err=document.getElementById('passError');

let rule=/^(?=.*[0-9])(?=.*[\W_])[A-Z].{7,}$/;

if(!rule.test(p.value)){

err.style.display='block';

p.classList.add('invalid');

}else{

err.style.display='none';

p.classList.remove('invalid');

p.classList.add('valid');

}

checkConfirmPassword();

}

function checkConfirmPassword(){

let p=document.getElementById('password').value;

let c=document.getElementById('password_confirmation');

let err=document.getElementById('confirmError');

if(c.value!==p){

err.style.display='block';

c.classList.add('invalid');

}else{

err.style.display='none';

c.classList.remove('invalid');

c.classList.add('valid');

}

}

</script>

@endsection