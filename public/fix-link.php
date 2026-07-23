<?php
$target = '/home/hitspbiz/public_html/HITSP/storage/app/public';
$shortcut = '/home/hitspbiz/public_html/HITSP/public/storage';
if (symlink($target, $shortcut)) {
    echo "Shortcut Berhasil Dibuat!";
} else {
    echo "Gagal! Folder 'storage' di public mungkin belum Anda hapus.";
}
?>