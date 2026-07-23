<?php $__env->startSection('content'); ?>

<div class="profile-page">

    <h2>Profil Saya</h2>

    
    <?php if(session('success')): ?>
        <div class="alert success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    
    <?php if($errors->any()): ?>
        <div class="alert error">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="profile-card">

        <div class="profile-info">
            <div class="profile-icon">
                <i class="fa-solid fa-user"></i>
            </div>

            <div>
                <p class="name"><?php echo e($user->name); ?></p>
                <p class="username"><?php echo e($user->username); ?></p>
                <p class="email"><?php echo e($user->email); ?></p>
		<p class="institution">Institusi : <?php echo e($user->institution ?? '-'); ?>

		</p>
		<p class="institution">
   			 Domain Email : <?php echo e($user->institution_domain ?? '-'); ?>.ac.id
		</p>
                <p class="role">
                    Status: <?php echo e(ucfirst($user->role)); ?>

                </p>
            </div>
        </div>

        <button id="editProfileBtn" class="btn-edit">
            <i class="fa-solid fa-pen-to-square"></i>
            Edit Profil
        </button>

    </div>

</div>


<!-- MODAL -->
<div id="editProfileModal" class="modal-overlay">

    <div class="modal-box">

        <button id="closeModal"
            class="modal-close">&times;
        </button>

        <h3>Edit Profil</h3>

        <form action="<?php echo e(route('profile.update')); ?>"
              method="POST">

            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="modal-form">

                <div>
                    <label>Nama Lengkap</label>
                    <input type="text"
                        name="name"
                        value="<?php echo e(old('name',$user->name)); ?>">
                </div>

                <div>
                    <label>Username</label>
                    <input type="text"
                        name="username"
                        value="<?php echo e(old('username',$user->username)); ?>">
                </div>

                <div>
                    <label>Email</label>
                    <input type="email"
                        name="email"
                        value="<?php echo e(old('email',$user->email)); ?>">
                </div>
<div>
    <label>Nama Kampus / Institusi</label>

    <input type="text"
        name="institution"
        value="<?php echo e(old('institution',$user->institution)); ?>"
        placeholder="Masukkan nama kampus atau institusi">
</div>
<div>
    <label>Domain Email Institusi</label>

    <input type="text"
        name="institution_domain"
        value="<?php echo e(old('institution_domain', $user->institution_domain)); ?>"
        placeholder="Contoh: ith">
</div>

                <div>
                    <label>Role</label>
                    <input type="text"
                        value="<?php echo e(ucfirst($user->role)); ?>"
                        readonly
                        class="readonly">
                </div>

                <div>
                    <label>Password Lama</label>

                    <input type="password"
                        name="current_password"
                        placeholder="Masukkan password lama">

                    <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <small class="error-text">
                        <?php echo e($message); ?>

                    </small>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>


                <div>
                    <label>Password Baru</label>

                    <input type="password"
                        name="new_password"
                        placeholder="Masukkan password baru">

                    <?php $__errorArgs = ['new_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <small class="error-text">
                        <?php echo e($message); ?>

                    </small>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>


                <div>
                    <label>
                    Konfirmasi Password Baru
                    </label>

                    <input type="password"
                     name="new_password_confirmation"
                     placeholder="Konfirmasi password baru">
                </div>

                <button type="submit"
                    class="btn-save">
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>



<style>
.institution{
    margin:3px 0;
    font-size:13px;
    color:#6B7280;
}
/* PROFILE */
.profile-page{
padding:40px 20px;
max-width:700px;
margin:auto;
}

.profile-page h2{
color:#0D2A54;
margin-bottom:20px;
font-size:26px;
font-weight:700;
}

/* ALERT */
.alert{
margin-bottom:15px;
padding:12px 15px;
border-radius:10px;
font-size:14px;
}

.success{
background:#ECFDF5;
color:#065F46;
border-left:4px solid #10B981;
}

.error{
background:#FEF2F2;
color:#991B1B;
border-left:4px solid #EF4444;
}

.error ul{
margin:0;
padding-left:18px;
}

/* CARD */
.profile-card{
background:#fff;
padding:25px;
border-radius:18px;
display:flex;
justify-content:space-between;
align-items:center;
gap:20px;
box-shadow:0 15px 40px rgba(0,0,0,.08);
border:1px solid #f1f1f1;
}

/* PROFILE INFO */
.profile-info{
display:flex;
align-items:center;
gap:14px;
}

/* PROFILE ICON */
.profile-icon{
width:48px;
height:48px;
border-radius:50%;
background:linear-gradient(
135deg,#D97706,#F59E0B);
display:flex;
justify-content:center;
align-items:center;
flex-shrink:0;
box-shadow:0 5px 15px rgba(217,119,6,.25);
}

/* ICON SIZE */
.profile-icon i{
font-size:18px;
color:#fff;
}

/* TEXT */
.name{
margin:0;
font-weight:700;
font-size:16px;
color:#0D2A54;
}

.username{
margin:3px 0;
font-size:14px;
color:#4B5563;
}

.email{
margin:3px 0;
font-size:13px;
color:#6B7280;
word-break:break-word;
}

.role{
margin-top:4px;
font-size:12px;
color:#9CA3AF;
}

/* BUTTON */
.btn-edit{
background:#D97706;
color:#fff;
padding:10px 16px;
border:none;
border-radius:10px;
cursor:pointer;
font-size:14px;
font-weight:600;
display:flex;
align-items:center;
gap:7px;
transition:.2s ease;
}

.btn-edit:hover{
background:#b45309;
transform:translateY(-1px);
}

/* MODAL */
.modal-overlay{
display:none;
position:fixed;
top:0;
left:0;
width:100%;
height:100%;
background:rgba(0,0,0,.65);
backdrop-filter:blur(6px);
justify-content:center;
align-items:center;
z-index:999999;
padding:20px;
}

.modal-box{
background:#fff;
width:100%;
max-width:520px;
max-height:90vh;
overflow-y:auto;
border-radius:20px;
padding:30px;
position:relative;
box-shadow:0 30px 70px rgba(0,0,0,.25);
animation:popUp .3s ease;
}

.modal-box h3{
color:#0D2A54;
margin-bottom:20px;
font-size:22px;
font-weight:700;
}

/* FORM */
.modal-form{
display:flex;
flex-direction:column;
gap:15px;
}

.modal-form label{
font-size:13px;
font-weight:600;
color:#0D2A54;
margin-bottom:5px;
display:block;
}

.modal-form input{
width:100%;
padding:11px 12px;
border:1px solid #dcdcdc;
border-radius:10px;
font-size:14px;
transition:.2s ease;
}

.modal-form input:focus{
border-color:#D97706;
outline:none;
box-shadow:0 0 0 3px rgba(217,119,6,.15);
}

.readonly{
background:#f3f4f6;
cursor:not-allowed;
}

/* ERROR TEXT */
.error-text{
display:block;
margin-top:5px;
color:#dc2626;
font-size:12px;
}

/* SAVE BUTTON */
.btn-save{
margin-top:10px;
background:#D97706;
color:#fff;
padding:12px;
border:none;
border-radius:10px;
font-weight:600;
font-size:14px;
cursor:pointer;
transition:.2s ease;
}

.btn-save:hover{
background:#b45309;
}

/* CLOSE BUTTON */
.modal-close{
position:absolute;
top:15px;
right:15px;
width:36px;
height:36px;
border:none;
border-radius:50%;
background:#f1f5f9;
font-size:20px;
cursor:pointer;
transition:.2s ease;
}

.modal-close:hover{
background:#ef4444;
color:#fff;
}

/* ANIMATION */
@keyframes popUp{
from{
transform:scale(.85);
opacity:0;
}
to{
transform:scale(1);
opacity:1;
}
}

/* RESPONSIVE */
@media(max-width:768px){

.profile-card{
flex-direction:column;
align-items:flex-start;
}

.btn-edit{
width:100%;
justify-content:center;
}

.modal-box{
padding:22px;
}

.profile-page{
padding:25px 15px;
}

}
</style>


<script>

const editBtn =
document.getElementById('editProfileBtn');

const modal =
document.getElementById('editProfileModal');

const closeModalBtn =
document.getElementById('closeModal');

editBtn.addEventListener('click',()=>{
modal.style.display='flex';
});

closeModalBtn.addEventListener('click',()=>{
modal.style.display='none';
});

window.addEventListener('click',(e)=>{
if(e.target===modal){
modal.style.display='none';
}
});

</script>


<?php if($errors->any()): ?>
<script>
document.getElementById(
'editProfileModal'
).style.display='flex';
</script>
<?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('user.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/hitspbiz/public_html/HITSP/resources/views/user/profile.blade.php ENDPATH**/ ?>