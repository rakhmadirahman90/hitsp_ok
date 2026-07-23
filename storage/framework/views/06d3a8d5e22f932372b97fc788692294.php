<?php $__env->startSection('content'); ?>

<link rel="stylesheet" href="<?php echo e(asset('css/user/pilihemail.css')); ?>">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="email-page">

    <h2 class="page-title">Formulir Pembuatan Akun Email ITH</h2>

    <p class="page-subtitle">
        Silahkan pilih jenis email yang ingin diajukan
    </p>

    <div class="email-card">

        <h3>PILIH JENIS EMAIL</h3>

        <div class="email-actions">

            
            <a href="<?php echo e(route('email-pribadi.index')); ?>" class="btn-email">
                EMAIL PRIBADI
            </a>

            
            
	    <a href="<?php echo e(route('permohonan-email.index')); ?>" class="btn-email">
    		EMAIL LEMBAGA
	    </a>
        </div>

    </div>

</div>

<style>

/* ================= GLOBAL ================= */

body{
    font-family:'Poppins',sans-serif;
    margin:0;
    padding:0;
    background:linear-gradient(135deg,#f1f5f9,#e2e8f0);
}

/* ================= PAGE WRAPPER ================= */

.email-page{
    min-height:100vh;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    padding:80px 20px;
    text-align:center;
}

/* ================= TITLE ================= */

.page-title{
    font-size:30px;
    font-weight:600;
    color:#1e293b;
    margin-bottom:8px;
}

.page-subtitle{
    font-size:15px;
    color:#64748b;
    margin-bottom:40px;
    max-width:420px;
}

/* ================= CARD ================= */

.email-card{
    background:#ffffff;
    padding:45px 40px;
    border-radius:18px;
    box-shadow:0 15px 45px rgba(0,0,0,0.08);
    max-width:520px;
    width:100%;
    transition:.3s;
}

.email-card:hover{
    transform:translateY(-5px);
    box-shadow:0 25px 55px rgba(0,0,0,0.12);
}

.email-card h3{
    font-size:18px;
    font-weight:600;
    color:#1e293b;
    margin-bottom:30px;
}

/* ================= BUTTON ================= */

.email-actions{
    display:flex;
    gap:20px;
    justify-content:center;
    flex-wrap:wrap;
}

.btn-email{
    background:linear-gradient(135deg,#f59e0b,#d97706);
    color:#ffffff;
    text-decoration:none;
    padding:15px 32px;
    border-radius:10px;
    font-size:15px;
    font-weight:500;
    letter-spacing:.3px;
    transition:.3s;
    box-shadow:0 6px 18px rgba(0,0,0,.08);
    border:none;
    cursor:pointer;
}

.btn-email:hover{
    transform:translateY(-3px);
    box-shadow:0 10px 25px rgba(0,0,0,.15);
    background:linear-gradient(135deg,#d97706,#b45309);
}

/* ================= TABLET ================= */

@media (max-width:768px){

    .email-page{
        padding:70px 18px;
    }

    .page-title{
        font-size:26px;
    }

    .email-card{
        padding:35px 28px;
    }

}

/* ================= MOBILE ================= */

@media (max-width:480px){

    .email-page{
        padding:60px 16px;
    }

    .page-title{
        font-size:22px;
        line-height:1.4;
    }

    .page-subtitle{
        font-size:14px;
        margin-bottom:30px;
    }

    .email-card{
        padding:28px 20px;
        border-radius:16px;
    }

    .email-card h3{
        font-size:16px;
        margin-bottom:22px;
    }

    .email-actions{
        flex-direction:column;
        gap:14px;
    }

    .btn-email{
        width:100%;
        padding:16px;
        font-size:14px;
        border-radius:8px;
    }

}

</style>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('user.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/hitspbiz/public_html/HITSP/resources/views/user/pilihemail.blade.php ENDPATH**/ ?>