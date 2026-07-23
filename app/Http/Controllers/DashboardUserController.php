<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Layanan;
use App\Models\Pengumuman;
use App\Models\Kegiatan;
use Illuminate\Support\Facades\DB;

class DashboardUserController extends Controller
{
    public function index(Request $request)
    {
        $layanans = Layanan::all();
        $pengumumans = Pengumuman::orderBy('tanggal', 'desc')->get();
        $kegiatans = Kegiatan::orderBy('created_at', 'desc')->paginate(4);

        $requests = collect();

        if (auth()->check()) {

            $userId = auth()->id();
            $userEmail = auth()->user()->email;

            // 1. ZOOM
            $zoom = DB::table('zoom_requests')
                ->where('user_id', $userId)
                ->select(
                    DB::raw("'Permintaan Zoom Meeting' as layanan"),
                    'status',
                    'updated_at',
                    DB::raw("NULL as catatan_admin")
                )->get();

            // 2. EMAIL PRIBADI
            $emailPribadi = DB::table('permohonan_email_pribadi')
                ->where('user_id', $userId)
                ->select(
                    DB::raw("'Permohonan Email Pribadi' as layanan"),
                    'status',
                    'updated_at',
                    DB::raw("NULL as catatan_admin")
                )->get();

            // 3. EMAIL LEMBAGA
            $emailLembaga = DB::table('permohonan_email_lembaga')
                ->where('email_alternatif', $userEmail)
                ->select(
                    DB::raw("'Permohonan Email Lembaga' as layanan"),
                    'status',
                    'updated_at',
                    DB::raw("NULL as catatan_admin")
                )->get();

            // 4. SUBDOMAIN
            $domain = DB::table('sub_domains')
                ->where('user_id', $userId)
                ->select(
                    DB::raw("'Permintaan Sub Domain' as layanan"),
                    'status',
                    'updated_at',
                    DB::raw("NULL as catatan_admin")
                )->get();

            // 5. HOTSPOT
            $hotspot = DB::table('hotspot_users')
                ->where('user_id', $userId)
                ->select(
                    DB::raw("'Permintaan Hotspot' as layanan"),
                    'status',
                    'updated_at',
                    DB::raw("NULL as catatan_admin")
                )->get();

            // GABUNGKAN SEMUA
            $allRequests = collect()
                ->concat($zoom)
                ->concat($emailPribadi)
                ->concat($emailLembaga)
                ->concat($domain)
                ->concat($hotspot);

            $requests = $allRequests->map(function ($item) {

                if (isset($item->status)) {

                    $normalizedStatus = strtolower(trim($item->status));

                    // APPROVED
                    if (in_array($normalizedStatus, [
                        'disetujui',
                        'approved',
                        'setuju',
                        '1',
                        'aktif',
                        'success',
                        'active'
                    ])) {

                        $item->status = 'disetujui';
                    }

                    // REJECTED
                    elseif (in_array($normalizedStatus, [
                        'ditolak',
                        'rejected',
                        'tolak',
                        '2',
                        'failed'
                    ])) {

                        $item->status = 'ditolak';
                    }

                    // DISABLED
                    elseif (in_array($normalizedStatus, [
                        'disabled',
                        'dinonaktifkan',
                        'nonaktif'
                    ])) {

                        if (stripos($item->layanan, 'zoom') !== false) {
                            $item->status = 'zoom_disabled';
                        }

                        elseif (stripos($item->layanan, 'domain') !== false) {
                            $item->status = 'domain_disabled';
                        }

                        else {
                            $item->status = 'dinonaktifkan';
                        }
                    }

                    // PENDING
                    else {
                        $item->status = 'pending';
                    }

                } else {
                    $item->status = 'pending';
                }

                return $item;
            })

            // INI YANG PENTING
            // Kalau admin update status, item langsung naik ke atas
            ->sortByDesc('updated_at')
            ->values();
        }

        if ($request->ajax()) {
            return view('user.dashboard', compact(
                'layanans',
                'pengumumans',
                'kegiatans',
                'requests'
            ))->render();
        }

        return view('user.dashboard', compact(
            'layanans',
            'pengumumans',
            'kegiatans',
            'requests'
        ));
    }

    public function showBerita($id)
    {
        $berita = Kegiatan::findOrFail($id);
        return view('user.beritadetail', compact('berita'));
    }
}