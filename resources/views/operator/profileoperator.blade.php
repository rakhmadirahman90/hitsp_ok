@extends('operator.layout')

@section('content')

<div class="profile-page">

    <h2 class="title">Profil Saya</h2>

    <!-- CARD PROFILE -->
    <div class="profile-card">
        <div class="profile-left">
            <i class="fa-solid fa-user profile-icon"></i>

            <div class="profile-info">
                <p class="name">{{ $user->name }}</p>
                <p class="username">{{ $user->username }}</p>
                <p class="email">{{ $user->email }}</p>
                <p class="role">Status: {{ ucfirst($user->role) }}</p>
            </div>
        </div>

        <button id="editProfileBtn" class="btn-edit">
            <i class="fa-solid fa-pen-to-square"></i> Edit
        </button>
    </div>

    <!-- SUCCESS -->
    @if(session('success'))
        <div class="alert success">
            {{ session('success') }}
        </div>
    @endif

    <!-- ERROR -->
    @if($errors->any())
        <div class="alert error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

</div>

<!-- ================= MODAL ================= -->
<div id="editProfileModal" class="modal">
    <div class="modal-content">

        <h3>Edit Profil</h3>

        <button id="closeModal" class="close">&times;</button>

        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}">
            </div>

            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" value="{{ old('username', $user->username) }}">
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}">
            </div>

            <div class="form-group">
                <label>Role</label>
                <input type="text" value="{{ ucfirst($user->role) }}" readonly>
            </div>

            <div class="form-group">
                <label>Password Lama</label>
                <input type="password" name="current_password" placeholder="Masukkan password lama">
            </div>

            <div class="form-group">
                <label>Password Baru</label>
                <input type="password" name="new_password" placeholder="Masukkan password baru">
            </div>

            <div class="form-group">
                <label>Konfirmasi Password Baru</label>
                <input type="password" name="new_password_confirmation" placeholder="Konfirmasi password baru">
            </div>

            <button type="submit" class="btn-save">
                Simpan Perubahan
            </button>
        </form>

    </div>
</div>

<style>

/* ===== PAGE ===== */
.profile-page {
    padding: 30px;
    max-width: 650px;
    margin: auto;
    background: #f9fafb;
    border-radius: 16px;
}

/* TITLE */
.title {
    color: #0D2A54;
    margin-bottom: 20px;
}

/* ===== CARD ===== */
.profile-card {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #fff;
    padding: 20px;
    border-radius: 16px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    transition: 0.3s;
}

.profile-card:hover {
    transform: translateY(-4px);
}

/* LEFT */
.profile-left {
    display: flex;
    align-items: center;
    gap: 15px;
}

/* ICON */
.profile-icon {
    font-size: 55px;
    color: #F59E0B;
    background: #FFF7ED;
    padding: 15px;
    border-radius: 50%;
}

/* TEXT */
.name {
    font-weight: 600;
    color: #0D2A54;
}

.username {
    font-weight: 500;
    color: #1f2937;
}

.email {
    font-size: 14px;
    color: #555;
}

.role {
    font-size: 13px;
    color: #777;
}

/* BUTTON */
.btn-edit {
    background: linear-gradient(135deg, #F59E0B, #D97706);
    color: white;
    border: none;
    padding: 10px 16px;
    border-radius: 10px;
    cursor: pointer;
    transition: 0.3s;
}

.btn-edit:hover {
    transform: scale(1.05);
}

/* ===== ALERT ===== */
.alert {
    margin-top: 15px;
    padding: 12px;
    border-radius: 10px;
}

.success {
    background: #ECFDF5;
    color: #065F46;
}

.error {
    background: #FEF2F2;
    color: #991B1B;
}

/* ===== MODAL ===== */
.modal {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.6);
    backdrop-filter: blur(4px);
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.modal-content {
    background: white;
    padding: 20px; /* sebelumnya 25px */
    border-radius: 16px;
    width: 90%;
    max-width: 500px;

    /* TAMBAHAN INI */
    max-height: 80vh;
    overflow-y: auto;

    position: relative;
    animation: pop 0.25s ease;
}
/* CLOSE */
.close {
    position: absolute;
    right: 15px;
    top: 15px;
    font-size: 22px;
    background: none;
    border: none;
    cursor: pointer;
}

/* FORM */
.form-group {
    display: flex;
    flex-direction: column;
    margin-bottom: 12px;
}

.form-group label {
    font-weight: 600;
    margin-bottom: 5px;
}

.form-group input {
    padding: 10px;
    border-radius: 10px;
    border: 1px solid #ddd;
}

.form-group input:focus {
    border-color: #F59E0B;
    outline: none;
    box-shadow: 0 0 0 2px rgba(245,158,11,0.2);
}

/* SAVE BUTTON */
.btn-save {
    width: 100%;
    margin-top: 10px;
    background: linear-gradient(135deg, #F59E0B, #D97706);
    color: white;
    padding: 12px;
    border-radius: 10px;
    border: none;
    cursor: pointer;
}

/* ANIMATION */
@keyframes pop {
    from { transform: scale(0.8); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}

</style>

<script>

const editBtn = document.getElementById('editProfileBtn');
const modal = document.getElementById('editProfileModal');
const closeModalBtn = document.getElementById('closeModal');

editBtn.addEventListener('click', () => {
    modal.style.display = 'flex';
});

closeModalBtn.addEventListener('click', () => {
    modal.style.display = 'none';
});

window.addEventListener('click', (e) => {
    if(e.target == modal){
        modal.style.display = 'none';
    }
});

</script>

@endsection