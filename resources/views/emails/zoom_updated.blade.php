<div style="font-family: sans-serif; padding: 20px; background: #f9fafb;">
    <div style="max-width: 600px; margin: 0 auto; background: #fff; padding: 20px; border-radius: 8px; border-top: 4px solid #10b981;">
        <h3>Halo {{ $zoom->nama }},</h3>
        <p>Terdapat pembaruan data / status terkait pengajuan sewa room Zoom Anda dengan rincian berikut:</p>
        <hr style="border: 0; border-top: 1px solid #e5e7eb;">
        <p><b>Nama Kegiatan:</b> {{ $zoom->jenis_kegiatan }}</p>
        <p><b>Tanggal:</b> {{ date('d/m/Y', strtotime($zoom->tanggal)) }}</p>
        <p><b>Status Saat Ini:</b> <strong style="color: #2563eb;">{{ strtoupper($zoom->status) }}</strong></p>
        <hr style="border: 0; border-top: 1px solid #e5e7eb;">
        <p>Terima kasih atas kerja samanya.</p>
    </div>
</div>