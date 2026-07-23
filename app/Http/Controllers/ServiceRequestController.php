<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceRequest;

class ServiceRequestController extends Controller
{
    public function store(Request $request)
    {
        ServiceRequest::create([
            'user_id'=>auth()->id(),
            'layanan'=>$request->layanan,
            'status'=>'pending'
        ]);

        return back()->with('success','Permintaan berhasil dikirim');
    }
}