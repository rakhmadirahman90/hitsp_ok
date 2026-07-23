@extends('user.layout')

@section('content')

<link rel="stylesheet" href="{{ asset('css/user/faq.css') }}">

<div class="faq-container">

    <h2 class="faq-title">Panduan & FAQ</h2>

    <!-- Search -->
    <div class="faq-search-box">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="text" placeholder="Cari Pertanyaan...." id="faq-search">
    </div>

    <div class="faq-box">

        <!-- TAB -->
        <div class="faq-tabs">
            <button class="active" onclick="switchTab('panduan', this)">Panduan Sistem</button>
            <button onclick="switchTab('faq', this)">FAQ Sistem</button>
        </div>

        <div class="faq-content">

            <!-- KIRI -->
            <div class="faq-left" id="faq-left"></div>

            <!-- KANAN -->
            <div class="faq-right" id="faq-right">
                <p>Klik pertanyaan di sebelah kiri untuk melihat jawaban.</p>
            </div>

        </div>

    </div>
</div>

<script>
let currentTab = 'panduan';

// ?? DATA DARI LARAVEL (AMAN)
const faqData = {
    panduan: @json($faqData['panduan']),
    faq: @json($faqData['faq'])
};

// ?? RENDER PERTANYAAN
function renderQuestions(tab){
    const left = document.getElementById('faq-left');
    left.innerHTML = '';

    faqData[tab].forEach((item) => {
        const div = document.createElement('div');
        div.className = 'faq-item';
        div.textContent = item.question;

        div.onclick = () => showAnswer(item.answer);

        left.appendChild(div);
    });
}

// ?? TAMPILKAN JAWABAN
function showAnswer(answer){
    document.getElementById('faq-right').innerHTML = `<p>${answer}</p>`;
}

// ?? SWITCH TAB (FIX ERROR EVENT)
function switchTab(tab, el){
    currentTab = tab;
    renderQuestions(tab);

    document.querySelectorAll('.faq-tabs button').forEach(btn => btn.classList.remove('active'));
    el.classList.add('active');

    document.getElementById('faq-right').innerHTML = '<p>Klik pertanyaan di sebelah kiri untuk melihat jawaban.</p>';
}

// ?? SEARCH
document.getElementById('faq-search').addEventListener('input', function(){

const query = this.value.toLowerCase();
const items = document.querySelectorAll('.faq-item');

let ditemukan = false;

items.forEach(item => {

if(item.textContent.toLowerCase().includes(query)){
item.style.display = '';
ditemukan = true;
}else{
item.style.display = 'none';
}

});

let pesanKosong = document.getElementById('not-found');

if(!ditemukan && query !== ''){
if(!pesanKosong){
const div = document.createElement('div');
div.id='not-found';
div.className='faq-not-found';
div.innerHTML='Pertanyaan yang Anda cari tidak ditemukan';
document.getElementById('faq-left').appendChild(div);
}
}else{
if(pesanKosong){
pesanKosong.remove();
}
}

});
// ?? INIT
renderQuestions(currentTab);
</script>
<style>
.faq-not-found{
text-align:center;
padding:20px;
margin-top:15px;
border-radius:12px;
background:#f8f9fa;
color:#666;
font-style:italic;
}

</style>

@endsection