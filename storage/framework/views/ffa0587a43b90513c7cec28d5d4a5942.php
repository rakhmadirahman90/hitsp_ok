<!DOCTYPE html>

<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login Modern | HITSP</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <script src="https://unpkg.com/feather-icons"></script>



    <style>

       /* ===== GLOBAL ===== */

body{
margin:0;
height:100vh;

font-family:"Poppins",sans-serif;

display:flex;
justify-content:center;
align-items:center;

background:linear-gradient(135deg,#0E243A,#1B3B5F,#0E243A);
background-size:400% 400%;

animation:gradientMove 10s ease infinite;
}

/* animasi background */
@keyframes gradientMove{
0%{background-position:0% 50%;}
50%{background-position:100% 50%;}
100%{background-position:0% 50%;}
}


/* ===== LOGIN BOX ===== */

.login-box{

width:100%;
max-width:420px;

padding:45px 40px;

border-radius:24px;

background:rgba(255,255,255,0.08);
backdrop-filter:blur(20px);

border:1px solid rgba(255,255,255,0.2);

box-shadow:0 20px 50px rgba(0,0,0,0.35);

text-align:center;

animation:fadeUp .8s ease;

}

/* animasi muncul */
@keyframes fadeUp{
from{
opacity:0;
transform:translateY(25px);
}
to{
opacity:1;
transform:translateY(0);
}
}


/* ===== LOGO ===== */

.login-box img{

 width:180px;
 margin-bottom:30px;

filter:drop-shadow(0 6px 12px rgba(0,0,0,.35));

transition:.4s;
}

.login-box img:hover{
transform:scale(1.05) rotate(-2deg);
}


/* ===== INPUT FIELD ===== */

.input-field{

width:100%;
display:flex;
align-items:center;

background:rgba(255,255,255,0.9);

border-radius:14px;

padding:6px 0;

margin:18px 0;

border:2px solid transparent;

transition:.3s;

}

/* hover input */

.input-field:hover{

transform:translateY(-1px);
}

/* focus glow */

.input-field:focus-within{

border-color:#D97706;

box-shadow:0 0 15px rgba(217,118,6,.35);

background:white;

}

/* icon */

.input-field i{

width:20px;
height:20px;

color:#1B3B5F;

margin:0 15px;

}

/* input */

.input-field input{

width:100%;

background:transparent;
border:none;
outline:none;

font-size:15px;

color:#1B3B5F;

padding:12px 0;

}


/* ===== EYE ICON ===== */

.eye-toggle{

cursor:pointer;

margin-right:15px;

display:flex;

align-items:center;

color:#1B3B5F;

transition:.3s;

}

.eye-toggle:hover{

color:#D97706;
transform:scale(1.15);

}


/* ===== LOGIN BUTTON ===== */

.btn-login{

width:100%;

padding:15px;

background:linear-gradient(135deg,#f59e0b,#d97706);

border:none;

border-radius:12px;

font-weight:600;

font-size:17px;

color:white;

cursor:pointer;

transition:.35s;

margin-top:5px;

box-shadow:0 8px 20px rgba(0,0,0,.25);

}

/* hover button */

.btn-login:hover{

transform:translateY(-3px) scale(1.02);

box-shadow:0 12px 30px rgba(0,0,0,.35);

background:linear-gradient(135deg,#ffb347,#d97706);

}


/* ===== REGISTER TEXT ===== */

.register-text{

margin-top:22px;

font-size:14px;

color:#f1f1f1;

}

.register-text a{

color:#FFD27F;

font-weight:600;

text-decoration:none;

transition:.25s;

}

.register-text a:hover{

text-decoration:underline;

color:#fff;

}


/* ===== ALERT ===== */

.error-message{

background:rgba(255,120,120,.15);

color:#ffd6d6;

font-size:13px;

padding:10px;

border-radius:8px;

margin-bottom:15px;

border:1px solid rgba(255,120,120,.5);

}

.success-message{

background:rgba(144,238,144,.15);

color:#90EE90;

font-size:13px;

padding:10px;

border-radius:8px;

margin-bottom:15px;

border:1px solid rgba(144,238,144,.6);

}    </style>

</head>



<body>



    <div class="login-box">



        <img src="<?php echo e(asset('images/logo_itsp.png')); ?>" alt="Logo">



        <?php if($errors->any()): ?>

            <div class="error-message">

                <?php echo e($errors->first()); ?>


            </div>

        <?php endif; ?>



        <?php if(session('success')): ?>

            <div class="success-message">

                <?php echo e(session('success')); ?>


            </div>

        <?php endif; ?>



        <form action="<?php echo e(route('login.submit')); ?>" method="POST">

            <?php echo csrf_field(); ?>



            <div class="input-field">

                <i data-feather="user"></i>

               <input 
                 type="text"
                 name="username"
                 placeholder="Masukkan Nip/Nim"
                 value="<?php echo e(old('username')); ?>" required autofocus maxlength="18" pattern="[0-9]{1,18}"inputmode="numeric"oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,18);"title="Username hanya boleh angka maksimal 18 digit">           
              </div>



            <div class="input-field">

                <i data-feather="lock"></i>



                <input 

                    type="password" 

                    name="password" 

                    id="password" 

                    placeholder="Masukkan Password" 

                    required

                >



                <span id="togglePassword" class="eye-toggle">

                    <i data-feather="eye"></i>

                </span>

            </div>



            <button type="submit" class="btn-login">LOGIN</button>

        </form>



        <div class="register-text">

            Belum punya akun? 

            <a href="<?php echo e(route('register')); ?>">Daftar sekarang</a>

        </div>

    </div>



    <script>

        // Inisialisasi Feather Icons

        feather.replace();



        const passwordInput = document.getElementById("password");

        const togglePassword = document.getElementById("togglePassword");



        togglePassword.addEventListener("click", function () {

            const isPasswordHidden = passwordInput.getAttribute("type") === "password";



            // Ubah tipe input

            passwordInput.setAttribute("type", isPasswordHidden ? "text" : "password");



            // Update Icon

            this.innerHTML = `<i data-feather="${isPasswordHidden ? "eye-off" : "eye"}"></i>`;



            // Render ulang icon Feather khusus di dalam elemen ini

            feather.replace();

        });

    </script>



</body>

</html><?php /**PATH /home/hitspbiz/public_html/HITSP/resources/views/user/login.blade.php ENDPATH**/ ?>