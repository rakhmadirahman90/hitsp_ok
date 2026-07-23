<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faq;

class AdminFaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::orderBy('id', 'desc')->get();
        return view('admin.kelolafaq', compact('faqs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string',
            'answer'   => 'required|string',
            'type'     => 'required|in:panduan,faq',
        ]);

        Faq::create($request->all());

        return redirect()->back()
            ->with('success_add', 'Panduan / FAQ berhasil ditambahkan.');
    }

    public function update(Request $request, Faq $faq)
    {
        $request->validate([
            'question' => 'required|string',
            'answer'   => 'required|string',
            'type'     => 'required|in:panduan,faq',
        ]);

        $faq->update($request->all());

        return redirect()->back()
            ->with('success_add', 'Panduan / FAQ berhasil diperbarui.');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();

        return redirect()->back()
            ->with('success_delete', 'Panduan / FAQ berhasil dihapus.');
    }
}
