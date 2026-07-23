<!DOCTYPE html>
<html>
<head>
    <title>Status Permohonan Hotspot</title>
</head>
<body style="font-family: Arial, sans-serif;">
    <h2>Halo, {{ $hotspot->nama_lengkap }}</h2>
    <p>Mohon maaf, permohonan hotspot Anda dengan nama <strong>{{ $hotspot->nama_hotspot }}</strong> telah <strong>DITOLAK</strong>.</p>
    
    <div style="background: #f8d7da; padding: 15px; border: 1px solid #f5c6cb; border-radius: 5px;">
        <strong>Alasan Penolakan:</strong><br>
        {{ $hotspot->alasan_tolak }}
    </div>

    <p>Silakan ajukan kembali dengan data yang lebih lengkap. Terima kasih.</p>
</body>
</html>