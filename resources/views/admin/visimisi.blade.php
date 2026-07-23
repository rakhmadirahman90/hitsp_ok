@extends('operator.layout')

@section('title', 'Kelola Visi & Misi')

<link rel="stylesheet" href="{{ asset('css/admin/visimisi.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

@section('content')

{{-- ================= SUCCESS ALERT ================= --}}
@if (session('success'))
<div style="
    display:flex;
    align-items:center;
    gap:14px;
    background:#ecfdf5;
    border:1px solid #10b981;
    border-radius:14px;
    padding:16px 18px;
    margin-bottom:22px;
    box-shadow:0 10px 25px rgba(16,185,129,.25);
    position:relative;
    animation:fadeIn .4s ease;
">
    <div style="
        width:44px;
        height:44px;
        border-radius:50%;
        background:#10b981;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:22px;
        color:white;
    ">
        ?
    </div>

    <div>
        <div style="font-size:15px;font-weight:600;color:#065f46;">
            Berhasil
        </div>
        <div style="font-size:14px;color:#047857;margin-top:2px;">
            {{ session('success') }}
        </div>
    </div>

    <button onclick="this.parentElement.remove()" style="
        position:absolute;
        top:12px;
        right:14px;
        background:none;
        border:none;
        font-size:20px;
        cursor:pointer;
        color:#047857;
    ">
        �
    </button>
</div>

<style>
@keyframes fadeIn {
    from { opacity:0; transform:translateY(-10px); }
    to { opacity:1; transform:translateY(0); }
}

.btn-remove:hover {
    background:#dc2626 !important;
    transform:scale(1.05);
}
</style>

<script>
setTimeout(() => {
    const alert = document.querySelector('[style*="fadeIn"]');
    if(alert){
        alert.style.opacity = '0';
        alert.style.transform = 'translateY(-10px)';
        setTimeout(() => alert.remove(), 500);
    }
}, 4000);
</script>
@endif



<form action="{{ route('admin.visimisi.store') }}" method="POST">
@csrf

<div class="admin-visi-misi">

    {{-- HEADER --}}
    <div class="admin-header">
        <h2>Kelola Visi & Misi</h2>
        <p>Admin dapat mengubah isi visi dan misi institusi</p>
    </div>

    <div class="vm-grid">

        {{-- ================= VISI ================= --}}
        <div class="vm-card">
            <div class="vm-header">
                <h3><i class="fa-solid fa-eye"></i> Visi</h3>
            </div>

            <textarea name="visi" rows="6" required style="width:100%; padding:10px; border-radius:8px;">
{{ old('visi', $visi->visi ?? '') }}
            </textarea>
        </div>

        {{-- ================= MISI ================= --}}
        <div class="vm-card">

            <div class="vm-header">
                <h3><i class="fa-solid fa-list-check"></i> Misi</h3>

                <button type="button" class="btn-add-misi" onclick="addMisi()" style="
                    background:#3b82f6;
                    color:white;
                    border:none;
                    padding:8px 12px;
                    border-radius:8px;
                    cursor:pointer;
                ">
                    <i class="fa-solid fa-plus"></i> Tambah Misi
                </button>
            </div>

            <ul class="misi-list" id="misiList" style="list-style:none; padding:0;">

                {{-- DATA LAMA --}}
                @if(!empty($misiList))
                    @foreach($misiList as $index => $misi)
                        <li style="display:flex; gap:10px; align-items:flex-start; margin-bottom:10px;">

                            <textarea name="misi[]" rows="3" required style="flex:1; padding:10px; border-radius:8px;">
{{ old('misi.'.$index, $misi) }}
                            </textarea>

                            <button type="button" class="btn-remove" onclick="this.parentElement.remove()" style="
                                background:#ef4444;
                                border:none;
                                color:white;
                                padding:10px 12px;
                                border-radius:8px;
                                cursor:pointer;
                                display:flex;
                                align-items:center;
                                justify-content:center;
                            ">
                                <i class="fa-solid fa-trash"></i>
                            </button>

                        </li>
                    @endforeach
                @else
                    <li style="display:flex; gap:10px; align-items:flex-start;">
                        <textarea name="misi[]" rows="3" required placeholder="Masukkan misi..." style="flex:1; padding:10px; border-radius:8px;"></textarea>

                        <button type="button" class="btn-remove" onclick="this.parentElement.remove()" style="
                            background:#ef4444;
                            border:none;
                            color:white;
                            padding:10px 12px;
                            border-radius:8px;
                            cursor:pointer;
                        ">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </li>
                @endif

            </ul>

        </div>

    </div>

    {{-- SIMPAN --}}
    <div style="margin-top:20px;">
        <button type="submit" style="
            background:#10b981;
            color:white;
            border:none;
            padding:12px 20px;
            border-radius:10px;
            cursor:pointer;
        ">
            <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
        </button>
    </div>

</div>

</form>



{{-- ================= SCRIPT ================= --}}
<script>
function addMisi() {
    const misiList = document.getElementById('misiList');

    const li = document.createElement('li');
    li.style.display = "flex";
    li.style.gap = "10px";
    li.style.alignItems = "flex-start";
    li.style.marginBottom = "10px";

    li.innerHTML = `
        <textarea name="misi[]" rows="3" required placeholder="Masukkan misi..." style="flex:1; padding:10px; border-radius:8px;"></textarea>

        <button type="button" class="btn-remove" onclick="this.parentElement.remove()" style="
            background:#ef4444;
            border:none;
            color:white;
            padding:10px 12px;
            border-radius:8px;
            cursor:pointer;
            display:flex;
            align-items:center;
            justify-content:center;
        ">
            <i class="fa-solid fa-trash"></i>
        </button>
    `;

    misiList.appendChild(li);
}
</script>

@endsection