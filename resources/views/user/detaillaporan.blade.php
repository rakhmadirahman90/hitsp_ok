@extends('user.layout')

@section('content')
<link rel="stylesheet" href="{{ asset('css/user/tracking.css') }}">
<style>
    .detail-container {
        max-width: 800px;
        margin: 40px auto;
        padding: 20px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .detail-header {
        border-bottom: 2px solid #f4f4f4;
        margin-bottom: 20px;
        padding-bottom: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .info-table {
        width: 100%;
        border-collapse: collapse;
    }
    .info-table th {
        width: 30%;
        text-align: left;
        padding: 12px;
        background: #f9f9f9;
        border: 1px solid #eee;
        color: #555;
    }
    .info-table td {
        padding: 12px;
        border: 1px solid #eee;
        color: #333;
    }
    .badge-status {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: bold;
        text-transform: uppercase;
    }
    .bg-menunggu { background: #ffeeba; color: #856404; }
    .bg-proses { background: #b8daff; color: #004085; }
    .bg-diterima { background: #c3e6cb; color: #155724; }
    .bg-selesai { background: #28a745; color: #fff; }
    .img-evidence {
        max-width: 100%;
        border-radius: 8px;
        margin-top: 10px;
        border: 1px solid #ddd;
    }
</style>

<div class="detail-container">
    <div class="detail-header">
        <h2 style="color: #333; margin: 0;">Detail Laporan</h2>
        <a href="{{ route('tracking') }}" class="btn-back" style="text-decoration: none; color: #007bff; font-weight: bold;">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <table class="info-table">
        <tr>
            <th>No. Ticket</th>
            <td style="font-weight: bold; color: #007bff;">{{ $laporan->ticket_no }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>
                <span class="badge-status 
                    {{ $laporan->status == 'Selesai' ? 'bg-selesai' : 
                    ($laporan->status == 'Di Terima' ? 'bg-diterima' : 
                    ($laporan->status == 'Di proses' ? 'bg-proses' : 'bg-menunggu')) }}">
                    {{ $laporan->status }}
                </span>
            </td>
        </tr>
        <tr>
            <th>Judul Laporan</th>
            <td>{{ $laporan->judul }}</td>
        </tr>
        <tr>
            <th>Kategori</th>
            <td>{{ $laporan->kategori }}</td>
        </tr>
        <tr>
            <th>Tingkat Urgensi</th>
            <td>{{ $laporan->tingkat_urgensi }}</td>
        </tr>
        <tr>
            <th>Area Layanan</th>
            <td>{{ $laporan->lokasi }}</td>
        </tr>
        <tr>
            <th>Tanggal Pengajuan</th>
            <td>{{ \Carbon\Carbon::parse($laporan->tanggal)->format('d F Y') }}</td>
        </tr>
        <tr>
            <th>Deskripsi</th>
            <td>{{ $laporan->deskripsi }}</td>
        </tr>
        <tr>
            <th>Bukti Lampiran</th>
            <td>
                @if($laporan->bukti)
                    @php $extension = pathinfo($laporan->bukti, PATHINFO_EXTENSION); @endphp
                    @if(in_array($extension, ['jpg', 'jpeg', 'png']))
                        <img src="{{ asset('storage/' . $laporan->bukti) }}" alt="Bukti Laporan" class="img-evidence">
                    @else
                        <a href="{{ asset('storage/' . $laporan->bukti) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                            <i class="fa-solid fa-file-pdf"></i> Lihat Dokumen (PDF)
                        </a>
                    @endif
                @else
                    <span style="color: #999; font-style: italic;">Tidak ada lampiran</span>
                @endif
            </td>
        </tr>
    </table>
</div>
@endsection