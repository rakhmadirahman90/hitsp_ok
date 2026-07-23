<?php $__env->startSection('content'); ?>

<link rel="stylesheet" href="<?php echo e(asset('css/user/visimisi.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('css/user/dashboard.css')); ?>">
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<?php
/*
Aman untuk:
1. misi berupa array
2. misi JSON string
3. misi teks dipisah enter
*/

$misiList=[];

if(isset($visiMisi->misi) && !empty($visiMisi->misi)){

    if(is_array($visiMisi->misi)){
        $misiList=$visiMisi->misi;
    }

    elseif(is_string($visiMisi->misi)){

        // coba decode json
        $json=json_decode($visiMisi->misi,true);

        if(json_last_error()===JSON_ERROR_NONE && is_array($json)){
            $misiList=$json;
        }else{
            // jika string biasa dipisah baris
            $misiList=preg_split("/\r\n|\n|\r/",$visiMisi->misi);
        }

    }

}
?>

<div class="dashboard-container">

<div class="visi-misi-container">

    <!-- VISI -->
    <div class="box visi-box">

        <div class="box-header">
            <i class="fa-solid fa-eye"></i>
            <h2>Visi</h2>
        </div>

        <p class="visi-text">
            <?php echo e($visiMisi->visi ?? 'Data visi belum tersedia'); ?>

        </p>

    </div>


    <!-- MISI -->
    <div class="box misi-box">

        <div class="box-header">
            <i class="fa-solid fa-list-check"></i>
            <h2>Misi</h2>
        </div>

        <ol class="misi-list">

            <?php if(count($misiList)): ?>
                <?php $__currentLoopData = $misiList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(trim($item)!=''): ?>
                    <li><?php echo e(trim($item)); ?></li>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <li>Data misi belum tersedia</li>
            <?php endif; ?>

        </ol>

    </div>

</div>

</div>


<style>

/* ================= BODY ================= */

body{
margin:0;
font-family:'Poppins',sans-serif;
background:
radial-gradient(circle at 10% 20%,#dbeafe,transparent 40%),
radial-gradient(circle at 90% 80%,#ede9fe,transparent 40%),
linear-gradient(135deg,#f8fafc,#eef2ff);
min-height:100vh;
}

/* ================= CONTAINER ================= */

.dashboard-container{
padding:40px 20px;
}

.visi-misi-container{
max-width:1000px;
margin:auto;
display:grid;
gap:45px;
}

/* ================= CARD ================= */

.box{
background:rgba(255,255,255,.85);
backdrop-filter:blur(14px);
border-radius:30px;
padding:50px;
position:relative;
overflow:hidden;
border:1px solid rgba(255,255,255,.6);

box-shadow:
0 10px 35px rgba(0,0,0,.05),
0 2px 8px rgba(0,0,0,.03);

transition:.4s ease;
}

.box:hover{
transform:translateY(-8px);
box-shadow:
0 20px 60px rgba(0,0,0,.1);
}

/* TOP GRADIENT */

.box::before{
content:"";
position:absolute;
left:0;
top:0;
width:100%;
height:6px;
background:linear-gradient(90deg,#2563eb,#6366f1,#06b6d4);
}

.misi-box::before{
background:linear-gradient(90deg,#f59e0b,#f97316,#fb923c);
}

/* DECOR CIRCLE */

.box::after{
content:"";
position:absolute;
width:220px;
height:220px;
right:-100px;
bottom:-100px;
border-radius:50%;
background:radial-gradient(circle,
rgba(99,102,241,.15),
transparent 70%);
}

/* HEADER */

.box-header{
display:flex;
align-items:center;
gap:18px;
margin-bottom:30px;
}

.box-header i{
width:65px;
height:65px;
display:flex;
align-items:center;
justify-content:center;
border-radius:18px;
font-size:24px;
color:white;
background:linear-gradient(135deg,#2563eb,#6366f1);
box-shadow:0 8px 18px rgba(37,99,235,.25);
transition:.3s;
}

.misi-box .box-header i{
background:linear-gradient(135deg,#f59e0b,#f97316);
}

.box:hover .box-header i{
transform:rotate(8deg) scale(1.05);
}

.box-header h2{
margin:0;
font-size:32px;
font-weight:700;
color:#0f172a;
}

/* VISI */

.visi-text{
font-size:18px;
line-height:2;
color:#334155;
text-align:justify;
}

/* MISI */

.misi-list{
margin:0;
padding-left:28px;
}

.misi-list li{
margin-bottom:18px;
font-size:17px;
line-height:1.9;
color:#475569;
transition:.3s;
}

.misi-list li::marker{
font-weight:bold;
color:#6366f1;
}

.misi-list li:hover{
transform:translateX(8px);
color:#0f172a;
}

/* ================= MOBILE ================= */

@media(max-width:992px){

.box{
padding:40px 35px;
}

.box-header h2{
font-size:28px;
}

}

@media(max-width:768px){

.dashboard-container{
padding:25px 15px;
}

.visi-misi-container{
gap:30px;
}

.box{
padding:30px 24px;
border-radius:24px;
}

.box-header{
gap:14px;
margin-bottom:22px;
}

.box-header i{
width:55px;
height:55px;
font-size:20px;
}

.box-header h2{
font-size:24px;
}

.visi-text{
font-size:16px;
line-height:1.8;
}

.misi-list{
padding-left:22px;
}

.misi-list li{
font-size:15px;
line-height:1.7;
margin-bottom:14px;
}

}

@media(max-width:480px){

.box{
padding:22px 18px;
}

.box-header{
flex-direction:column;
text-align:center;
}

.box-header h2{
font-size:22px;
}

.visi-text,
.misi-list li{
font-size:14px;
}

}

</style>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('user.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/hitspbiz/public_html/HITSP/resources/views/user/visi_misi.blade.php ENDPATH**/ ?>