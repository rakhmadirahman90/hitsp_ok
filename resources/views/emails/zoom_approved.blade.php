<!DOCTYPE html>

<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>Link Zoom Disetujui</title>

</head>

<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">

    <h2>Halo {{ $zoom->nama }},</h2>



    <p>Kegiatan Anda telah disetujui oleh admin. Berikut detailnya:</p>



    <table style="border-collapse: collapse; width: 100%;">

        <tr>

            <td style="padding: 8px; font-weight: bold;">Jenis Kegiatan</td>

            <td style="padding: 8px;">{{ $zoom->jenis_kegiatan }}</td>

        </tr>

        <tr>

            <td style="padding: 8px; font-weight: bold;">Tanggal</td>

            <td style="padding: 8px;">{{ $zoom->tanggal }}</td>

        </tr>

        <tr>

            <td style="padding: 8px; font-weight: bold;">Waktu</td>

            <td style="padding: 8px;">{{ $zoom->waktu_mulai }} - {{ $zoom->waktu_selesai }}</td>

        </tr>

        <tr>

            <td style="padding: 8px; font-weight: bold;">Link Zoom</td>

            <td style="padding: 8px;"><a href="{{ $zoom->link_zoom }}" target="_blank">{{ $zoom->link_zoom }}</a></td>

        </tr>

    </table>



    <p>Silakan bergabung sesuai jadwal.</p>



    <p>Terima kasih,<br>

    <strong>Admin UPT TIK</strong></p>

</body>

</html>

