<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Laporan;
use App\Models\HotspotUser;
use App\Models\PermohonanEmailPribadi;
use App\Models\PermohonanEmail;
use App\Models\SubDomain;
use App\Models\Notification;

class HalamanUtamaController extends Controller
{
    public function index()
    {

       // ==========================
// TOTAL USER
// ==========================

$totalMahasiswa = User::where('role', 'mahasiswa')
    ->where('status', 'Approved')
    ->count();

$totalDosen = User::where('role', 'dosen')
    ->where('status', 'Approved')
    ->count();

$totalStaf = User::where('role', 'staf')
    ->where('status', 'Approved')
    ->count();

$totalOperator = User::where('role', 'operator')
    ->where('status', 'Approved')
    ->count();

$totalAdmin = User::where('role', 'admin')
    ->where('status', 'Approved')
    ->count();

        // ==========================
        // TOTAL PENGAJUAN
        // ==========================

        $laporanMasuk = Laporan::count();

        $emailPribadi = PermohonanEmailPribadi::count();

        $emailLembaga = PermohonanEmail::count();

        $hotspot = HotspotUser::count();

        $subdomain = SubDomain::count();


        $totalPengajuan =
            $laporanMasuk +
            $emailPribadi +
            $emailLembaga +
            $hotspot +
            $subdomain;



        // ==========================
        // TOTAL PENGAJUAN SELESAI
        // ==========================

        $selesai =

            Laporan::where('status','Selesai')->count()

            +

            PermohonanEmailPribadi::where('status','approved')->count()

            +

            PermohonanEmail::where('status','approved')->count()

            +

            SubDomain::whereIn('status',['approved','active'])->count()

            +

            HotspotUser::where('persetujuan',1)->count();



        // ==========================
        // GRAFIK PER BULAN
        // ==========================

        $chart = [];


        for($i = 1; $i <= 12; $i++)
        {

            $jumlah =

                Laporan::whereMonth('created_at',$i)->count()

                +

                PermohonanEmailPribadi::whereMonth('created_at',$i)->count()

                +

                PermohonanEmail::whereMonth('created_at',$i)->count()

                +

                HotspotUser::whereMonth('created_at',$i)->count()

                +

                SubDomain::whereMonth('created_at',$i)->count();


            $chart[] = $jumlah;

        }



        // ==========================
        // AKTIVITAS TERBARU
        // ==========================

        $activities = Notification::latest()
                        ->take(8)
                        ->get();



        return view('admin.dashboard', compact(

            'totalMahasiswa',
            'totalDosen',
            'totalStaf',
            'totalOperator',
            'totalAdmin',

            'totalPengajuan',

            'selesai',

            'chart',

            'activities'

        ));

    }
}