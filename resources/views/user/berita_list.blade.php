<div class="news-grid">
    @forelse($kegiatans as $k)
    <a href="{{ Route::has('berita.show') ? route('berita.show',$k->id) : '#' }}" class="news">
        <div class="img-box">
            <img src="{{ $k->gambar ? asset('storage/'.$k->gambar) : 'https://via.placeholder.com/140x110?text=No+Image' }}" alt="{{ $k->judul }}">
        </div>
        <div class="news-body">
            <span class="date">
                <i class="far fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($k->tanggal)->translatedFormat('d M Y') }}
            </span>
            <h4 class="title">{{ Str::limit($k->judul, 45) }}</h4>
        </div>
    </a>
    @empty
    <p class="empty-state">Belum ada kegiatan</p>
    @endforelse
</div>

{{-- Pagination otomatis --}}
@if($kegiatans->hasPages())
<div class="pagination-wrapper">
    {{ $kegiatans->links('pagination::bootstrap-4') }}
</div>
@endif