@extends('user.layout')

@section('content')
<link rel="stylesheet" href="{{ asset('css/user/reqdomain.css') }}">

<div class="domain-wrapper">
    <h2 class="form-title">Permohonan Sub Domain ITBH</h2>

    <!-- Button Request Domain Baru -->
    <div class="top-action">
        <a href="{{ route('requestdomain') }}" class="btn-submit">Request Domain Baru</a>
    </div>

    <!-- Tabel Riwayat Permohonan -->
    <div class="table-container">
        <table class="domain-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Organisasi</th>
                    <th>Sub Domain</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($subDomains as $key => $sub)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $sub->nama_organisasi }}</td>
                    <td>{{ $sub->nama_sub_domain }}</td>
                    <td>
                        @if($sub->status == 'pending')
                            <span class="badge pending">Pending</span>
                        @elseif($sub->status == 'approved')
                            <span class="badge approved">Approved</span>
                        @elseif($sub->status == 'rejected')
                            <span class="badge rejected">Rejected</span>
                        @else
                            <span class="badge">{{ $sub->status }}</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center;">Belum ada permohonan domain</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<style>
/* ================= DOMAIN WRAPPER ================= */
.domain-wrapper {
    max-width: 1000px;
    margin: 40px auto;
    background: #ffffff; /* putih sesuai body */
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    font-family: 'Poppins', sans-serif;
}

.form-title {
    text-align: center;
    font-weight: 600;
    font-size: 24px;
    margin-bottom: 25px;
    color: #0D2A54; /* biru tua navbar */
}

.top-action {
    text-align: right;
    margin-bottom: 20px;
}

.btn-submit {
    background: #D97706; /* oranye */
    color: #fff;
    padding: 10px 22px;
    border-radius: 999px;
    text-decoration: none;
    font-weight: 500;
    transition: 0.3s;
}

.btn-submit:hover {
    background: #b45309; /* oranye gelap saat hover */
}

/* ================= TABEL RIWAYAT ================= */
.table-container {
    overflow-x: auto;
}

.domain-table {
    width: 100%;
    border-collapse: collapse;
}

.domain-table th, .domain-table td {
    padding: 12px 15px;
    border: 1px solid #E5E7EB; /* abu muda */
    text-align: left;
}

.domain-table th {
    background-color: #f1f1f1; /* selaras nav menu bar */
    color: #0D2A54; /* biru tua */
    font-weight: 600;
}

/* ================= STATUS BADGE ================= */

/* Pending = biru tegas supaya jelas */
.badge.pending {
    background-color: #1D4ED8; /* biru lebih gelap dan tegas */
    color: #fff;
    font-weight: 600;
}

/* Approved = hijau jelas */
.badge.approved {
    background-color: #10B981; /* hijau terang */
    color: #fff;
    font-weight: 600;
}

/* Rejected = merah jelas */
.badge.rejected {
    background-color: #EF4444; /* merah terang */
    color: #fff;
    font-weight: 600;
}

/* Default badge untuk status lain */
.badge {
    padding: 5px 12px;
    border-radius: 8px;
    font-size: 14px;
    text-align: center;
    display: inline-block;
}

/* ================= PEMBERITAHUAN ================= */
.domain-table td:nth-child(5) {
    font-size: 14px;
    color: #374151;
}

/* RESPONSIVE */
@media (max-width:768px){
    .domain-wrapper {
        margin: 20px 16px;
        padding: 20px;
    }

    .domain-table th, .domain-table td {
        padding: 10px;
    }
}
</style>

@endsection
