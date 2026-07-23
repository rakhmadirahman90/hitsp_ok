<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Faq; // model FAQ

class FaqController extends Controller
{
    public function index()
    {
        // Ambil semua FAQ dan Panduan dari DB
        $faqs = Faq::all();

        // Kelompokkan berdasarkan type
        $faqData = [
            'panduan' => $faqs->where('type', 'panduan')->values(),
            'faq'     => $faqs->where('type', 'faq')->values(),
        ];

        return view('user.faq', compact('faqData'));
    }
}
