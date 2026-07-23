<!DOCTYPE html>
<html>
<head>
    <title>Permohonan Email Ditolak</title>
</head>
<body>
    <h3>Permohonan Akun Email Anda Ditolak</h3>
    <p>Halo,</p>
    <p>Mohon maaf, permohonan akun email lembaga Anda **tidak disetujui**. Berikut informasi permohonan Anda:</p>
    <ul>
        <li>Nama Pemohon / Institusi: {{ $nama_akun ?? $nama_pemohon }}</li>
        <li>Email Alternatif: {{ $email_pemohon }}</li>
        <li>Alasan Penolakan: {{ $alasan_tolak }}</li>
    </ul>
    <p>Silakan hubungi admin jika ada pertanyaan lebih lanjut.</p>
</body>
</html>
