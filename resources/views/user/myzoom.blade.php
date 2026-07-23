s@extends('user.layout')



@section('content')

<link rel="stylesheet" href="{{ asset('css/user/myzoom.css') }}">
<style>

/* =========================
   PAGE WRAPPER
========================= */

.zoom-list-wrapper{
    background:#ffffff;
    padding:32px;
    border-radius:16px;
    box-shadow:0 10px 30px rgba(11,36,71,0.08);
    border:1px solid #e5e7eb;
    overflow-x:auto;
}

/* =========================
   HEADER
========================= */

.zoom-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:20px;
    margin-bottom:25px;
    flex-wrap:wrap;
}

.zoom-header h2{
    font-size:24px;
    font-weight:700;
    color:#0B2447;
    margin:0;
}

/* =========================
   BUTTON REQUEST
========================= */

.btn-request{
    background:#D97706;
    color:#ffffff;
    padding:12px 20px;
    border-radius:10px;
    text-decoration:none;
    font-weight:600;
    font-size:14px;
    transition:all 0.25s ease;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    white-space:nowrap;
}

.btn-request:hover{
    background:#b86305;
    transform:translateY(-2px);
    box-shadow:0 8px 18px rgba(217,119,6,0.25);
}

/* =========================
   TABLE CONTAINER
========================= */

.table-responsive{
    width:100%;
    overflow-x:auto;
    border-radius:14px;
}

/* =========================
   TABLE
========================= */

.zoom-table{
    width:100%;
    border-collapse:collapse;
    min-width:750px;
    background:#fff;
}

.zoom-table thead{
    background:#C7DDF0;
}

.zoom-table th{
    padding:16px 14px;
    color:#0B2447;
    font-weight:700;
    text-align:center;
    border-bottom:2px solid #D97706;
    font-size:14px;
}

.zoom-table td{
    padding:15px 14px;
    border-bottom:1px solid #e5e7eb;
    text-align:center;
    color:#0B2447;
    font-size:14px;
    vertical-align:middle;
}

.zoom-table tbody tr{
    transition:0.2s ease;
}

.zoom-table tbody tr:hover{
    background:#f8fafc;
}

/* =========================
   BADGE STATUS
========================= */

.badge{
    padding:7px 15px;
    border-radius:999px;
    font-size:12px;
    font-weight:700;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    letter-spacing:0.3px;
}

/* Pending */

.badge.pending{
    background:#fde68a;
    color:#92400e;
}

/* Approved */

.badge.approved{
    background:#bbf7d0;
    color:#166534;
}

/* Rejected */

.badge.rejected{
    background:#fecaca;
    color:#991b1b;
}

/* =========================
   LINK ACTION
========================= */

.btn-link{
    color:#0B2447;
    font-weight:600;
    text-decoration:none;
    transition:0.2s ease;
}

.btn-link:hover{
    color:#D97706;
    text-decoration:underline;
}

/* =========================
   EMPTY STATE
========================= */

.empty{
    padding:35px 20px;
    text-align:center;
    color:#6b7280;
    font-style:italic;
    font-size:14px;
}

/* =========================
   TEXT MUTED
========================= */

.text-muted{
    color:#9ca3af;
    font-size:13px;
}

/* =========================
   ALERT SUCCESS
========================= */

.alert-success{
    background:#dcfce7;
    color:#166534;
    padding:14px 18px;
    border-radius:10px;
    margin-bottom:22px;
    font-size:14px;
    border-left:5px solid #22c55e;
    font-weight:500;
}

/* =========================
   RESPONSIVE
========================= */

@media(max-width:768px){

    .zoom-list-wrapper{
        padding:20px;
    }

    .zoom-header{
        flex-direction:column;
        align-items:flex-start;
    }

    .zoom-header h2{
        font-size:20px;
    }

    .btn-request{
        width:100%;
    }

    .zoom-table th,
    .zoom-table td{
        padding:13px 10px;
        font-size:13px;
    }

}

</style>
<div class="zoom-list-wrapper">



    <div class="zoom-header">

        <h2>Daftar Permintaan Zoom Saya</h2>



        {{-- BUTTON REQUEST ZOOM --}}

        <a href="{{ route('zoom.create') }}" class="btn-request">

            + Request Link Zoom

        </a>

    </div>



    {{-- ALERT SUCCESS --}}

    @if(session('success'))

        <div class="alert-success">

            {{ session('success') }}

        </div>

    @endif



    <table class="zoom-table">

        <thead>

            <tr>

                <th>No</th>

                <th>Jenis Kegiatan</th>

                <th>Tanggal</th>

                <th>Waktu</th>

                <th>Status</th>

                <th>Link Zoom</th>

            </tr>

        </thead>

        <tbody>

            @forelse($requests as $index => $req)

                <tr>

                    <td>{{ $index + 1 }}</td>

                    <td>{{ $req->jenis_kegiatan }}</td>

                    <td>{{ \Carbon\Carbon::parse($req->tanggal)->format('d-m-Y') }}</td>

                    <td>{{ $req->waktu_mulai }} - {{ $req->waktu_selesai }}</td>



                    {{-- STATUS --}}

                    <td>

                        @if($req->status == 'pending')

                            <span class="badge pending">Pending</span>

                        @elseif($req->status == 'approved')

                            <span class="badge approved">Approved</span>

                        @else

                            <span class="badge rejected">Rejected</span>

                        @endif

                    </td>



                    {{-- LINK ZOOM --}}

                    <td>

                        @if($req->link_zoom)

                            <a href="{{ $req->link_zoom }}" target="_blank" class="btn-link">

                                Buka Zoom

                            </a>

                        @else

                            <span class="text-muted">Belum tersedia</span>

                        @endif

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="6" class="empty">

                        Belum ada permintaan Zoom

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>



</div>

@endsection

