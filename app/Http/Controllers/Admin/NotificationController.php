<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;

class NotificationController extends Controller
{
    /**
     * TAMPILKAN NOTIFIKASI (PAGINATION)
     */
    public function index()
    {
        // ambil data terbaru + pagination
        $notifications = Notification::latest()->paginate(10);

        // tandai semua notif belum dibaca jadi sudah dibaca
        Notification::where('is_read', 0)->update([
            'is_read' => 1
        ]);

        return view('admin.notifikasi', compact('notifications'));
    }

    /**
     * MARK ALL AS READ (opsional tombol manual)
     */
    public function readAll()
    {
        Notification::where('is_read', 0)->update([
            'is_read' => 1
        ]);

        return redirect()
            ->route('admin.notifikasi')
            ->with('success', 'Semua notifikasi sudah dibaca');
    }
}