@extends('operator.layout')



@section('content')



<link rel="stylesheet" href="{{ asset('css/admin/kelolazoom.css') }}">



<div class="zoom-detail-wrapper">

    <h2 class="page-title">Detail Request Zoom</h2>



    @if(session('success'))

        <div class="alert-success">{{ session('success') }}</div>

    @endif



    <ul class="detail-list">

        <li><strong>Nama:</strong> {{ $request->nama }}</li>

        <li><strong>Email:</strong> {{ $request->email }}</li>

        <li><strong>Kegiatan:</strong> {{ $request->jenis_kegiatan }}</li>

        <li><strong>Tanggal:</strong> {{ $request->tanggal }}</li>

        <li><strong>Waktu:</strong> {{ $request->waktu_mulai }} - {{ $request->waktu_selesai }}</li>

    </ul>



    @if($request->status == 'pending')

    <form method="POST" action="{{ route('admin.zoom.approve', $request->id) }}" class="approve-form">

        @csrf

        <div class="form-group">

            <label>Link Zoom</label>

            <input type="url" name="link_zoom" placeholder="Masukkan link Zoom" required>

        </div>

        <button class="btn-approve" type="submit">Approve & Kirim Email</button>

    </form>

    @else

    <p><strong>Link Zoom:</strong>

        <a href="{{ $request->link_zoom }}" target="_blank">{{ $request->link_zoom }}</a>

    </p>

    <p>Status: <span class="badge-approved">Approved</span></p>

    @endif

</div>

@endsection

