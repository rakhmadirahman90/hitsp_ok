<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class RequestController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        $userEmail = auth()->user()->email;

        $zoom = DB::table('zoom_requests')
            ->where('user_id', $userId)
            ->select(
                DB::raw("'Permintaan Zoom Meeting' as layanan"),
                'status',
                'created_at',
                'updated_at'
            )->get();

        $emailPribadi = DB::table('permohonan_email_pribadi')
            ->where('user_id', $userId)
            ->select(
                DB::raw("'Permohonan Email Pribadi' as layanan"),
                'status',
                'created_at',
                'updated_at'
            )->get();

        $emailLembaga = DB::table('permohonan_email_lembaga')
            ->where('email_alternatif', $userEmail)
            ->select(
                DB::raw("'Permohonan Email Lembaga' as layanan"),
                'status',
                'created_at',
                'updated_at'
            )->get();

        $domain = DB::table('sub_domains')
            ->where('user_id', $userId)
            ->select(
                DB::raw("'Permintaan Sub Domain' as layanan"),
                'status',
                'created_at',
                'updated_at'
            )->get();

        $hotspot = DB::table('hotspot_users')
            ->where('user_id', $userId)
            ->select(
                DB::raw("'Permintaan Hotspot' as layanan"),
                'status',
                'created_at',
                'updated_at'
            )->get();

        $requests = collect()
            ->merge($zoom)
            ->merge($emailPribadi)
            ->merge($emailLembaga)
            ->merge($domain)
            ->merge($hotspot)

            ->map(function ($item) {

                $status = strtolower(trim($item->status ?? ''));

                if (in_array($status, [
                    'disetujui',
                    'approved',
                    'setuju',
                    'aktif',
                    'success',
                    '1'
                ])) {
                    $item->status = 'disetujui';

                } elseif (in_array($status, [
                    'ditolak',
                    'rejected',
                    'tolak',
                    'failed',
                    '2'
                ])) {
                    $item->status = 'ditolak';

                } elseif (in_array($status, [
                    'dinonaktifkan',
                    'disabled',
                    'nonaktif',
                    'zoom_disabled',
                    'domain_disabled'
                ])) {
                    $item->status = 'dinonaktifkan';

                } else {
                    $item->status = 'pending';
                }

                return $item;
            })

            // kalau admin update status -> naik ke atas
            ->sortByDesc('updated_at')

            ->values();

        return view('user.permintaan', compact('requests'));
    }
}