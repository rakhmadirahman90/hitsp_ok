@extends('operator.layout')

@section('title','Kelola Fasilitas')

@section('content')

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

{{-- ERROR VALIDASI --}}
@if($errors->any())
<div class="alert error-box">
<ul>
@foreach($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif

@if(session('success'))
<div class="alert success-box">
{{ session('success') }}
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
background:#f5f7fb;
}

/*=================== HEADER ===================*/
.header-wrap{
display:flex;
justify-content:space-between;
align-items:center;
flex-wrap:wrap;
gap:15px;
margin-bottom:25px;
}

.page-title{
font-size:28px;
font-weight:700;
color:#0b2545;
}

/*================ BUTTON =================*/
.btn{
border:none;
cursor:pointer;
padding:12px 18px;
border-radius:12px;
font-weight:600;
transition:.3s;
}

.btn:hover{
transform:translateY(-2px);
}

.btn-primary{
background:#0b2545;
color:#fff;
box-shadow:0 6px 14px rgba(11,37,69,.18);
}

.btn-secondary{
background:#9ca3af;
color:#fff;
}

/*================ ALERT =================*/
.alert{
padding:15px;
border-radius:12px;
margin-bottom:20px;
}

.success-box{
background:#dcfce7;
color:#166534;
}

.error-box{
background:#fee2e2;
color:#991b1b;
}

/*================ TABLE =================*/
.table-box{
background:#fff;
border-radius:18px;
overflow:hidden;
box-shadow:0 6px 18px rgba(0,0,0,.05);
}

.table-fasilitas{
width:100%;
border-collapse:collapse;
}

.table-fasilitas th{
background:#eef2f7;
padding:16px;
text-align:center;
font-size:14px;
}

.table-fasilitas td{
padding:16px;
text-align:center;
border-bottom:1px solid #edf2f7;
font-size:14px;
}

.table-fasilitas tr:hover{
background:#fafafa;
}

.badge{
background:#0b2545;
color:#fff;
padding:6px 12px;
border-radius:30px;
font-size:12px;
font-weight:600;
}

.action-wrap{
display:flex;
justify-content:center;
gap:14px;
}

.action-icon{
font-size:19px;
cursor:pointer;
transition:.3s;
}

.action-icon:hover{
transform:scale(1.12);
}

.edit-icon{
color:#f59e0b;
}

.delete-icon{
color:#ef4444;
}

/*================ EMPTY =================*/
.empty-box{
background:#fff;
padding:70px 25px;
border-radius:18px;
text-align:center;
box-shadow:0 6px 18px rgba(0,0,0,.05);
}

.empty-box i{
font-size:70px;
color:#cbd5e1;
margin-bottom:18px;
}

.empty-box h3{
font-size:24px;
margin-bottom:10px;
color:#334155;
}

.empty-box p{
color:#64748b;
margin-bottom:22px;
}

/*================ MODAL =================*/
.modal{
display:none;
position:fixed;
inset:0;
background:rgba(0,0,0,.5);
backdrop-filter:blur(3px);
justify-content:center;
align-items:center;
z-index:9999;
}

.modal-content{
background:#fff;
width:95%;
max-width:560px;
padding:28px;
border-radius:18px;
}

.form-label{
font-size:13px;
font-weight:600;
display:block;
margin-bottom:8px;
margin-top:14px;
}

.form-control{
width:100%;
padding:12px;
border:1px solid #d1d5db;
border-radius:10px;
}

.preview{
display:flex;
flex-wrap:wrap;
gap:12px;
margin-top:15px;
border:2px dashed #ddd;
padding:15px;
border-radius:12px;
min-height:100px;
justify-content:flex-start;
}

.img-container{
position:relative;
width:90px;
height:90px;
border-radius:10px;
overflow:hidden;
}

.img-container img{
width:100%;
height:100%;
object-fit:cover;
}

.btn-remove-old{
position:absolute;
top:5px;
right:5px;
width:22px;
height:22px;
background:red;
color:#fff;
border-radius:50%;
display:flex;
align-items:center;
justify-content:center;
font-size:12px;
cursor:pointer;
}

.removing{
transform:scale(.5);
opacity:0;
transition:.3s;
}

/*================ MOBILE =================*/
@media(max-width:768px){

.page-title{
font-size:22px;
}

.header-wrap{
flex-direction:column;
align-items:stretch;
}

.btn-primary{
width:100%;
}

.table-fasilitas,
.table-fasilitas thead,
.table-fasilitas tbody,
.table-fasilitas th,
.table-fasilitas td,
.table-fasilitas tr{
display:block;
width:100%;
}

.table-box{
background:none;
box-shadow:none;
}

.table-fasilitas thead{
display:none;
}

.table-fasilitas tr{
background:#fff;
padding:18px;
margin-bottom:18px;
border-radius:18px;
box-shadow:0 4px 14px rgba(0,0,0,.06);
}

.table-fasilitas td{
display:flex;
justify-content:space-between;
text-align:right;
padding:12px 0;
border-bottom:1px dashed #ddd;
}

.table-fasilitas td:last-child{
border:none;
}

.table-fasilitas td:nth-child(1)::before{
content:"No";
font-weight:600;
}

.table-fasilitas td:nth-child(2)::before{
content:"Nama";
font-weight:600;
}

.table-fasilitas td:nth-child(3)::before{
content:"Foto";
font-weight:600;
}

.table-fasilitas td:nth-child(4)::before{
content:"Aksi";
font-weight:600;
}

.action-wrap{
justify-content:flex-end;
}

.modal-content{
width:94%;
padding:22px;
}

.preview{
justify-content:center;
}

.img-container{
width:75px;
height:75px;
}

}

</style>



<div class="header-wrap">

<h2 class="page-title">
Kelola Fasilitas
</h2>

<button class="btn btn-primary"
onclick="openTambah()">
<i class="fa fa-plus"></i>
Tambah Fasilitas
</button>

</div>



@if($fasilitas->count())

<div class="table-box">

<table class="table-fasilitas">

<thead>
<tr>
<th>No</th>
<th>Nama</th>
<th>Foto</th>
<th>Aksi</th>
</tr>
</thead>

<tbody>

@foreach($fasilitas as $f)

<tr>

<td>
{{ $loop->iteration }}
</td>

<td style="text-align:left">
{{ $f->nama }}
</td>

<td>
<span class="badge">
{{ $f->gambar_count ?? $f->gambar->count() }}
Gambar
</span>
</td>

<td>
<div class="action-wrap">

<i class="fa-solid fa-pen-to-square
action-icon edit-icon"
onclick="openEdit(
{{ $f->id }},
'{{ addslashes($f->nama) }}',
{{ $f->gambar->toJson() }}
)">
</i>


<form
method="POST"
action="{{ route('fasilitas.destroy',$f->id) }}"
style="display:inline"
>
@csrf
@method('DELETE')

<i class="fa-solid fa-trash
action-icon delete-icon"
onclick="if(confirm('Hapus seluruh data ini?')) this.closest('form').submit()">
</i>

</form>

</div>
</td>

</tr>

@endforeach

</tbody>
</table>

</div>

@else

<div class="empty-box">

<i class="fa-solid fa-building-circle-xmark"></i>

<h3>Belum Ada Fasilitas Ditambahkan</h3>

<p>
Silakan tambahkan fasilitas kampus
seperti laboratorium, ruang kelas,
wifi area, perpustakaan, dan lainnya.
</p>

<button
class="btn btn-primary"
onclick="openTambah()">
Tambah Fasilitas
</button>

</div>

@endif




<div id="modal" class="modal">
<div class="modal-content">

<h3 id="judul"
style="color:#0b2545;margin-bottom:10px;">
Tambah Fasilitas
</h3>


<form id="form"
method="POST"
enctype="multipart/form-data">

@csrf
<div id="method_field"></div>


<label class="form-label">
Nama Fasilitas
</label>

<input
type="text"
id="nama"
name="nama"
class="form-control"
required>


<label class="form-label">
Unggah Foto
</label>

<input
type="file"
id="gambar_input"
name="gambar[]"
multiple
accept="image/*"
class="form-control">


<div id="preview" class="preview">
</div>


<div style="
display:flex;
gap:12px;
margin-top:20px;
">

<button class="btn btn-primary"
style="flex:2">
Simpan
</button>

<button
type="button"
class="btn btn-secondary"
style="flex:1"
onclick="closeModal()">
Batal
</button>

</div>

</form>

</div>
</div>



<script>

let fileBuffer=[];
let oldImages=[];

function renderPreview(){

const preview=
document.getElementById('preview');

preview.innerHTML='';

if(oldImages.length===0 &&
fileBuffer.length===0){

preview.innerHTML=
'<div style="margin:auto;color:#999;">Belum ada foto</div>';

}


oldImages.forEach((img)=>{

let box=document.createElement('div');
box.className='img-container';
box.id='img-old-'+img.id;

box.innerHTML=`
<img src="/storage/fasilitas/${img.gambar}">
<div class="btn-remove-old"
onclick="hapusOld(${img.id})">
�
</div>
`;

preview.appendChild(box);

});


fileBuffer.forEach((file,index)=>{

let box=document.createElement('div');
box.className='img-container';

box.innerHTML=`
<img src="${URL.createObjectURL(file)}">
<div class="btn-remove-old"
onclick="hapusBaru(${index})">
�
</div>
`;

preview.appendChild(box);

});

}


function hapusBaru(index){
fileBuffer.splice(index,1);
updateInput();
renderPreview();
}


function updateInput(){
const dt=new DataTransfer();

fileBuffer.forEach(file=>{
dt.items.add(file);
});

document.getElementById(
'gambar_input'
).files=dt.files;
}


document.getElementById(
'gambar_input'
).addEventListener('change',function(e){

for(let file of e.target.files){
fileBuffer.push(file);
}

updateInput();
renderPreview();

});


function hapusOld(id){

if(confirm('Hapus foto ini?')){

fetch(
"{{ url('admin/fasilitas/gambar') }}/"+id,
{
method:'DELETE',
headers:{
'X-CSRF-TOKEN':
'{{ csrf_token() }}',
'Accept':'application/json'
}
})
.then(r=>r.json())
.then(res=>{
oldImages=
oldImages.filter(x=>x.id!==id);
renderPreview();
})
.catch(()=>{
alert('Gagal menghapus gambar');
});

}

}



function openTambah(){

document.getElementById('judul')
.innerText='Tambah Fasilitas';

document.getElementById('form')
.action=
"{{ route('fasilitas.store') }}";

document.getElementById(
'method_field'
).innerHTML='';

document.getElementById(
'nama'
).value='';

fileBuffer=[];
oldImages=[];

renderPreview();

document.getElementById(
'modal'
).style.display='flex';

}



function openEdit(
id,nama,gambarArray
){

document.getElementById('judul')
.innerText='Edit Fasilitas';

document.getElementById(
'form'
).action=
"{{ url('admin/fasilitas') }}/"+id;

document.getElementById(
'method_field'
).innerHTML=
'<input type="hidden" name="_method" value="PUT">';

document.getElementById(
'nama'
).value=nama;

fileBuffer=[];

oldImages=
Array.isArray(gambarArray)
? gambarArray
: [];

renderPreview();

document.getElementById(
'modal'
).style.display='flex';

}



function closeModal(){
document.getElementById(
'modal'
).style.display='none';
}

window.onclick=function(e){
if(
e.target==
document.getElementById('modal')
){
closeModal();
}
}

</script>

@endsection