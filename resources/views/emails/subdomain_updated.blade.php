<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pembaruan Data Pengajuan</title>
</head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #333; line-height: 1.6; background-color: #f4f4f7; padding: 20px; margin: 0;">
    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); border-top: 5px solid #2563eb;">
        
        <h2 style="color: #1e3a8a; margin-top: 0; font-size: 20px; border-bottom: 2px solid #f3f4f6; padding-bottom: 10px;">
            Yth. {{ $subdomain->nama_teknis }},
        </h2>
        
        <p style="font-size: 15px; color: #4b5563;">
            Kami menginformasikan bahwa data permohonan Sub Domain / Hosting Anda telah <strong>diperbarui oleh Administrator</strong> dengan rincian data terbaru sebagai berikut:
        </p>

        <table style="width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 14px;">
            <tr style="background-color: #f9fafb;">
                <td style="padding: 10px; font-weight: bold; width: 35%; border: 1px solid #e5e7eb;">Nama Organisasi</td>
                <td style="padding: 10px; border: 1px solid #e5e7eb;">{{ $subdomain->nama_organisasi }}</td>
            </tr>
            <tr>
                <td style="padding: 10px; font-weight: bold; border: 1px solid #e5e7eb;">Jenis Layanan</td>
                <td style="padding: 10px; border: 1px solid #e5e7eb;">{{ $subdomain->jenis_domain }}</td>
            </tr>
            <tr style="background-color: #f9fafb;">
                <td style="padding: 10px; font-weight: bold; border: 1px solid #e5e7eb;">Nama Pemohon</td>
                <td style="padding: 10px; border: 1px solid #e5e7eb;">{{ $subdomain->nama_teknis }}</td>
            </tr>
            <tr>
                <td style="padding: 10px; font-weight: bold; border: 1px solid #e5e7eb;">Email Pemohon</td>
                <td style="padding: 10px; border: 1px solid #e5e7eb;">{{ $subdomain->email_teknis }}</td>
            </tr>
            <tr style="background-color: #f9fafb;">
                <td style="padding: 10px; font-weight: bold; border: 1px solid #e5e7eb;">Nama Sub Domain</td>
                <td style="padding: 10px; border: 1px solid #e5e7eb; color: #2563eb; font-weight: bold;">{{ $subdomain->nama_sub_domain }}</td>
            </tr>
            <tr>
                <td style="padding: 10px; font-weight: bold; border: 1px solid #e5e7eb;">Status Pengajuan</td>
                <td style="padding: 10px; border: 1px solid #e5e7eb;">
                    @if($subdomain->status == 'pending')
                        <span style="background-color: #fef3c7; color: #78350f; padding: 3px 8px; border-radius: 12px; font-size: 12px; font-weight: bold;">Menunggu (Pending)</span>
                    @elseif($subdomain->status == 'active')
                        <span style="background-color: #dcfce7; color: #166534; padding: 3px 8px; border-radius: 12px; font-size: 12px; font-weight: bold;">Aktif (Active)</span>
                    @elseif($subdomain->status == 'disabled')
                        <span style="background-color: #e5e7eb; color: #374151; padding: 3px 8px; border-radius: 12px; font-size: 12px; font-weight: bold;">Dinonaktifkan (Disabled)</span>
                    @elseif($subdomain->status == 'rejected')
                        <span style="background-color: #fee2e2; color: #991b1b; padding: 3px 8px; border-radius: 12px; font-size: 12px; font-weight: bold;">Ditolak (Rejected)</span>
                    @endif
                </td>
            </tr>
        </table>

        <p style="font-size: 14px; color: #6b7280; margin-top: 25px;">
            Jika Anda memiliki pertanyaan lebih lanjut mengenai perubahan data ini, silakan hubungi unit layanan helpdesk kami.
        </p>
        
        <div style="margin-top: 30px; border-top: 1px solid #e5e7eb; padding-top: 15px; font-size: 13px; color: #9ca3af;">
            <p style="margin: 0;">Terima kasih,</p>
            <p style="margin: 5px 0 0 0; font-weight: bold; color: #4b5563;">Layanan Sistem Administrasi Cloud & Domain</p>
        </div>
    </div>
</body>
</html>