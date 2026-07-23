<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Registrasi</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>

body{
margin:0;
padding:0;
font-family:Poppins,sans-serif;
min-height:100vh;
display:flex;
justify-content:center;
align-items:center;
background:linear-gradient(
135deg,#0E243A,#1B3B5F,#0E243A
);
background-size:400% 400%;
animation:bgMove 10s ease infinite;
}

@keyframes bgMove{
0%{background-position:0% 50%;}
50%{background-position:100% 50%;}
100%{background-position:0% 50%;}
}

.login-box{
width:420px;
margin:80px auto;
padding:50px 45px 60px;
background:linear-gradient(
135deg,#1B3B5F,#0E243A
);
border-radius:20px;
box-shadow:0 15px 35px rgba(0,0,0,.3);
}

h2{
text-align:center;
color:white;
margin-bottom:30px;
font-size:26px;
}

.input-field{
width:90%;
margin:12px auto;
padding:10px 12px;
display:flex;
align-items:center;
background:#f1f1f1;
border-radius:10px;
}

.input-field i{
margin-right:10px;
color:#0E243A;
}

.input-field input,
.input-field select{
width:100%;
border:none;
outline:none;
background:transparent;
font-family:Poppins;
font-size:14px;
}

.toggle-password{
margin-left:10px;
cursor:pointer;
}

.alert-danger{
display:none;
margin-bottom:15px;
padding:10px;
border-radius:8px;
text-align:center;
background:#fee2e2;
color:#b91c1c;
}

.btn-login{
width:100%;
margin-top:22px;
padding:14px;
border:none;
border-radius:12px;
cursor:pointer;
font-size:16px;
font-weight:600;
color:white;
background:linear-gradient(
135deg,#f59e0b,#d97706
);
transition:.3s;
}

.btn-login:hover{
transform:translateY(-3px);
}

.login-link{
margin-top:18px;
text-align:center;
color:#e5e7eb;
font-size:14px;
}

.login-link a{
color:#FFD27F;
text-decoration:none;
font-weight:500;
}

</style>
</head>

<body>

<div class="login-box">

<h2>Registrasi</h2>

<div id="alertBox" class="alert-danger"></div>

@if ($errors->any())
<script>
document.addEventListener(
"DOMContentLoaded",
function(){

let alertBox=
document.getElementById("alertBox");

alertBox.style.display="block";

alertBox.innerHTML=
`{!! implode('<br>', $errors->all()) !!}`;

});
</script>
@endif


<form id="regForm"
action="{{ route('register.store') }}"
method="POST">

@csrf



<!-- ROLE -->
<div class="input-field">
<i class="fa-solid fa-user-tag"></i>

<select
name="role"
id="roleSelect"
required>

<option value="" disabled selected>
Daftar Sebagai
</option>

<option value="mahasiswa">
Mahasiswa
</option>

<option value="dosen">
Dosen
</option>

<option value="staf">
Staf
</option>

</select>
</div>



<!-- NAMA -->
<div class="input-field">
<i class="fa-solid fa-user"></i>

<input
type="text"
name="name"
id="name"
placeholder="Masukkan Nama Lengkap"
value="{{ old('name') }}"
required
oninput="
this.value=
this.value.replace(/[^A-Za-z\s]/g,'')
"
pattern="^[A-Za-z\s]+$"
title="Nama hanya boleh huruf">
</div>



<!-- NIM / NIP -->
<div class="input-field">
<i class="fa-solid fa-id-card"></i>

<input
type="text"
name="username"
id="username"
placeholder="Masukkan NIM / NIP"
inputmode="numeric"
maxlength="18"
required
value="{{ old('username') }}"
oninput="
let role =
document.getElementById('roleSelect').value;

this.value =
this.value.replace(/[^0-9]/g,'');

if(role === 'mahasiswa'){
this.maxLength = 9;
this.value = this.value.slice(0,9);
}
else{
this.maxLength = 18;
this.value = this.value.slice(0,18);
}
">
</div>



<!-- EMAIL -->
<div class="input-field">
<i class="fa-solid fa-envelope"></i>

<input
type="email"
id="email"
name="email"
placeholder="Masukkan Email"
value="{{ old('email') }}"
required
pattern='[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[A-Za-z]{2,}'>
</div>



<!-- PASSWORD -->
<div class="input-field">
<i class="fa-solid fa-lock"></i>

<input
type="password"
name="password"
id="password"
placeholder="Masukkan Password"
required>

<i class="fa-solid fa-eye
toggle-password"
id="toggleEye"></i>
</div>



<!-- KONFIRMASI PASSWORD -->
<div class="input-field">
<i class="fa-solid fa-lock"></i>

<input
type="password"
name="password_confirmation"
id="confirmPassword"
placeholder="Konfirmasi Password"
required>

<i class="fa-solid fa-eye
toggle-password"
id="toggleEyeConfirm"></i>
</div>



<button class="btn-login">
DAFTAR
</button>


<div class="login-link">
Sudah memiliki akun?

<a href="{{ route('login') }}">
Login
</a>

</div>

</form>

</div>



<script>

document.getElementById("regForm")
.addEventListener(
"submit",
function(e){

let nama=
document.getElementById("name")
.value.trim();

let username=
document.getElementById("username")
.value.trim();

let email=
document.getElementById("email")
.value.trim();

let passwordValue=
document.getElementById("password")
.value;

let confirmPass=
document.getElementById(
"confirmPassword"
).value;

let role=
document.getElementById(
"roleSelect"
).value;

let alertBox=
document.getElementById(
"alertBox"
);

let pesan="";


// wajib isi
if(
nama==""||
username==""||
email==""||
passwordValue==""||
confirmPass==""||
role==""
){
pesan+="Semua field wajib diisi.<br>";
}


// nama angka
if(/\d/.test(nama)){
pesan+="Nama tidak boleh mengandung angka.<br>";
}


// validasi NIM / NIP
if(role==="mahasiswa"){

if(username.length < 9){
pesan+="NIM yang anda masukkan kurang.<br>";
}
else if(username.length > 9){
pesan+="NIM maksimal 9 digit.<br>";
}

}
else if(
role==="dosen" ||
role==="staf"
){

if(username.length < 18){
pesan+="NIP yang anda masukkan kurang.<br>";
}
else if(username.length > 18){
pesan+="NIP maksimal 18 digit.<br>";
}

}


// email
let emailPattern=
/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[A-Za-z]{2,}$/;

if(email==""){
pesan+="Email wajib diisi.<br>";
}
else if(
!emailPattern.test(email)
){
pesan+="Format email tidak lengkap.<br>";
}


// password
if(passwordValue.length<8){
pesan+="Password minimal 8 karakter.<br>";
}

if(!/[a-z]/.test(passwordValue)){
pesan+="Password harus ada huruf kecil.<br>";
}

if(!/[A-Z]/.test(passwordValue)){
pesan+="Password harus ada huruf besar.<br>";
}

if(!/[0-9]/.test(passwordValue)){
pesan+="Password harus ada angka.<br>";
}

if(
!/[@$!%*#?&]/.test(passwordValue)
){
pesan+="Password harus ada simbol (@$!%*#?&).<br>";
}


// konfirmasi password
if(
passwordValue!==confirmPass
){
pesan+="Konfirmasi password tidak cocok.<br>";
}


if(pesan!=""){

e.preventDefault();

alertBox.style.display=
"block";

alertBox.innerHTML=pesan;

}

});




// browser popup email
const emailInput=
document.getElementById("email");

emailInput.addEventListener(
"invalid",
function(){

if(this.validity.valueMissing){

this.setCustomValidity(
"Email wajib diisi"
);

}
else{

this.setCustomValidity(
"Format email tidak lengkap"
);

}

});

emailInput.addEventListener(
"input",
function(){
this.setCustomValidity("");
});




// toggle password
const password=
document.getElementById(
"password"
);

const toggleEye=
document.getElementById(
"toggleEye"
);

toggleEye.addEventListener(
"click",
()=>{

password.type=
password.type==="password"
? "text"
: "password";

toggleEye.classList.toggle(
"fa-eye"
);

toggleEye.classList.toggle(
"fa-eye-slash"
);

});




// toggle konfirmasi password
const confirmPassword=
document.getElementById(
"confirmPassword"
);

const toggleEyeConfirm=
document.getElementById(
"toggleEyeConfirm"
);

toggleEyeConfirm.addEventListener(
"click",
()=>{

confirmPassword.type=
confirmPassword.type==="password"
? "text"
: "password";

toggleEyeConfirm.classList.toggle(
"fa-eye"
);

toggleEyeConfirm.classList.toggle(
"fa-eye-slash"
);

});




// ubah placeholder NIM / NIP
const roleSelect =
document.getElementById(
"roleSelect"
);

const usernameInput =
document.getElementById(
"username"
);

roleSelect.addEventListener(
"change",
function(){

if(
this.value==="dosen" ||
this.value==="staf"
){

usernameInput.placeholder =
"Masukkan NIP";

}
else if(
this.value==="mahasiswa"
){

usernameInput.placeholder =
"Masukkan NIM";

}
else{

usernameInput.placeholder =
"Masukkan NIM / NIP";

}

}
);

</script>

</body>
</html>