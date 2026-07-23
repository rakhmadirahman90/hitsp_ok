@extends('operator.layout')

@section('title','Daftar Permohonan Hotspot')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<h2 class="title">
    Daftar Permohonan Hotspot
</h2>

@if(session('success'))
<div class="alert-success">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert-error">
    {{ session('error') }}
</div>
@endif


<style>
*{
margin:0;
padding:0;
box-sizing:border-box;
}

body{
font-family:'Poppins',sans-serif;
background:#f3f4f6;
}

/*========== TITLE =========*/
.title{
text-align:center;
margin:25px 0;
font-size:28px;
font-weight:700;
color:#111827;
}

/*========== ALERT =========*/
.alert-success,
.alert-error{
padding:14px;
border-radius:12px;
margin-bottom:20px;
text-align:center;
font-size:14px;
font-weight:500;
}

.alert-success{
background:#d1fae5;
color:#065f46;
}

.alert-error{
background:#fee2e2;
color:#991b1b;
}

/*========== TABLE =========*/
.table-wrapper{
width:100%;
padding:15px;
overflow-x:auto;
}

.hotspot-table{
width:100%;
max-width:1100px;
margin:auto;
border-collapse:collapse;
background:#fff;
border-radius:18px;
overflow:hidden;
box-shadow:0 8px 22px rgba(0,0,0,.06);
}

.hotspot-table th{
background:#eef2f7;
padding:15px 12px;
font-size:14px;
font-weight:600;
text-align:center;
color:#374151;
}

.hotspot-table td{
padding:15px 12px;
font-size:13px;
border-bottom:1px solid #edf2f7;
text-align:center;
vertical-align:middle;
color:#374151;
}

.hotspot-table tbody tr:hover{
background:#fafafa;
}

/*========== STATUS =========*/
.badge{
display:inline-block;
padding:7px 14px;
border-radius:30px;
font-size:11px;
font-weight:700;
}

.badge-pending{
background:#fef3c7;
color:#92400e;
}

.badge-success{
background:#d1fae5;
color:#065f46;
}

.badge-danger{
background:#fee2e2;
color:#991b1b;
}

/*========== BUTTON =========*/
.action-wrap{
display:flex;
justify-content:center;
gap:10px;
flex-wrap:wrap;
}

.action-btn{
width:40px;
height:40px;
display:flex;
align-items:center;
justify-content:center;
border-radius:10px;
text-decoration:none;
border:none;
cursor:pointer;
color:#fff;
transition:.3s;
}

.action-btn:hover{
transform:translateY(-2px);
box-shadow:0 4px 12px rgba(0,0,0,.12);
}

.btn-view{
background:#3b82f6;
}

.btn-danger{
background:#ef4444;
}

/*========== TABLET =========*/
@media(max-width:992px){

.hotspot-table th,
.hotspot-table td{
font-size:12px;
padding:12px 8px;
}

.action-btn{
width:35px;
height:35px;
}

}

/*========== MOBILE CARD =========*/
@media(max-width:768px){

.title{
font-size:21px;
}

.table-wrapper{
padding:10px;
}

.hotspot-table,
.hotspot-table thead,
.hotspot-table tbody,
.hotspot-table th,
.hotspot-table td,
.hotspot-table tr{
display:block;
width:100%;
}

.hotspot-table{
background:transparent;
box-shadow:none;
}

.hotspot-table thead{
display:none;
}

.hotspot-table tr{
background:#fff;
border-radius:18px;
padding:18px;
margin-bottom:18px;
box-shadow:0 4px 14px rgba(0,0,0,.06);
}

.hotspot-table td{
display:flex;
justify-content:space-between;
align-items:center;
text-align:right;
padding:12px 0;
border-bottom:1px dashed #e5e7eb;
}

.hotspot-table td:last-child{
border-bottom:none;
padding-top:16px;
}

/* label mobile */
.hotspot-table td:nth-child(1)::before{
content:"No";
font-weight:600;
}

.hotspot-table td:nth-child(2)::before{
content:"Nama & NIP";
font-weight:600;
}

.hotspot-table td:nth-child(3)::before{
content:"Email";
font-weight:600;
}

.hotspot-table td:nth-child(4)::before{
content:"Hotspot";
font-weight:600;
}

.hotspot-table td:nth-child(5)::before{
content:"Status";
font-weight:600;
}

.hotspot-table td:nth-child(6)::before{
content:"Aksi";
font-weight:600;
}

.action-wrap{
justify-content:flex-end;
}

.action-btn{
width:42px;
height:42px;
}

}

/* extra small */
@media(max-width:480px){

.title{
font-size:18px;
}

.hotspot-table tr{
padding:15px;
}

.hotspot-table td{
font-size:12px;
}

.action-btn{
width:38px;
height:38px;
}

}
</style>


<div class="table-wrapper">

<table class="hotspot-table">

<thead>
<tr>
<th width="60">No</th>
<th>Nama & NIP</th>
<th>Email</th>
<th>Hotspot</th>
<th>Status</th>
<th width="150">Aksi</th>
</tr>
</thead>

<tbody>

@forelse($hotspots as $hotspot)
<tr>

<td>
{{ $loop->iteration }}
</td>

<td style="text-align:left;">
<strong>
{{ $hotspot->nama_lengkap }}
</strong>
<br>
<small style="color:#6b7280;">
{{ $hotspot->nip }}
</small>
</td>

<td>
{{ $hotspot->email }}
</td>

<td>
{{ $hotspot->nama_hotspot }}
</td>

<td>
@if($hotspot->persetujuan==0)
<span class="badge badge-pending">
Pending
</span>

@elseif($hotspot->persetujuan==1)
<span class="badge badge-success">
Disetujui
</span>

@else
<span class="badge badge-danger">
Ditolak
</span>
@endif
</td>

<td>
<div class="action-wrap">

<a href="{{ route('admin.hotspot.show',$hotspot->id) }}"
class="action-btn btn-view"
title="Detail">
<i class="fa-solid fa-eye"></i>
</a>


<form action="{{ route('admin.hotspot.destroy',$hotspot->id) }}"
method="POST"
class="delete-form"
style="display:inline;">
@csrf
@method('DELETE')

<button type="submit"
class="action-btn btn-danger delete-btn"
title="Hapus">
<i class="fa-solid fa-trash"></i>
</button>

</form>

</div>
</td>

</tr>

@empty

<tr>
<td colspan="6">
Belum ada permohonan hotspot
</td>
</tr>

@endforelse

</tbody>
</table>

</div>


<script>
document.querySelectorAll('.delete-btn').forEach(btn=>{

btn.addEventListener('click',function(e){

e.preventDefault();

let form=this.closest('form');

Swal.fire({
title:'Yakin hapus data?',
text:'Data akan dihapus permanen.',
icon:'warning',
showCancelButton:true,
confirmButtonColor:'#ef4444',
cancelButtonColor:'#6b7280',
confirmButtonText:'Ya Hapus',
cancelButtonText:'Batal'

}).then((result)=>{
if(result.isConfirmed){
form.submit();
}

});

});

});
</script>

@endsection