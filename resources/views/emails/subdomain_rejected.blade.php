<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Permohonan Ditolak</title>
</head>
<body>

    <h2>Permohonan Sub Domain Ditolak</h2>

    <p>
        Halo {{ $subdomain->nama_teknis }},
    </p>

    <p>
        Permohonan sub domain Anda:
    </p>

    <ul>
        <li>
            <strong>Organisasi:</strong>
            {{ $subdomain->nama_organisasi }}
        </li>

        <li>
            <strong>Sub Domain:</strong>
            {{ $subdomain->nama_sub_domain }}
        </li>
    </ul>

    <p>
        <strong>Alasan Penolakan:</strong>
    </p>

    <p>
        {{ $alasan }}
    </p>

    <br>

    <p>
        Silakan lakukan perbaikan lalu ajukan kembali.
    </p>

</body>
</html>