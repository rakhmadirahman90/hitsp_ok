<!DOCTYPE html>

<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>Hosting Disetujui</title>

</head>

<body style="font-family: Arial, sans-serif; line-height: 1.6;">



    <h3>Yth. {{ $subdomain->nama_teknis }}</h3>



    <p>

        Permohonan sub domain

        <strong>{{ $subdomain->nama_sub_domain }}</strong>

        telah <strong>DISETUJUI</strong>.

    </p>



    <h4>Informasi Hosting</h4>

    <table cellpadding="6" cellspacing="0" border="1" style="border-collapse: collapse;">

        <tr>

            <td><strong>IP Server</strong></td>

            <td>{{ $subdomain->hostingAccess->ip_server }}</td>

        </tr>

        <tr>

            <td><strong>User SSH</strong></td>

            <td>{{ $subdomain->hostingAccess->ssh_user }}</td>

        </tr>

        <tr>

            <td><strong>Database Name</strong></td>

            <td>{{ $subdomain->hostingAccess->db_name }}</td>

        </tr>

        <tr>

            <td><strong>Database User</strong></td>

            <td>{{ $subdomain->hostingAccess->db_user }}</td>

        </tr>

        <tr>

            <td><strong>Lokasi Aplikasi</strong></td>

            <td>{{ $subdomain->hostingAccess->app_path }}</td>

        </tr>

    </table>



    <p style="margin-top:15px; color:red;">

        Demi keamanan, password tidak ditampilkan pada email ini.

        Silakan menghubungi admin jika diperlukan.

    </p>



    <br>



    <p>

        Hormat kami,<br>

        <strong>Admin UPT TIK</strong>

    </p>



</body>

</html>

