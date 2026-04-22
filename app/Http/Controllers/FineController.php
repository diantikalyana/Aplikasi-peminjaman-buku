<?php

namespace App\Http\Controllers;

use App\Models\Fine;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class FineController extends Controller
{
    // 🔹 lihat semua denda
    public function index(Request $request)
    {
        $query = Fine::with('transaction.user', 'transaction.book');

        // SEARCH
        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('transaction.user', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%$search%");
                })
                ->orWhereHas('transaction.book', function ($q3) use ($search) {
                    $q3->where('title', 'like', "%$search%");
                });
            });
        }

        $fines = $query->get();
        return view('fines.index', compact('fines'));
    }

    // 🔹 bayar denda
    public function update(Request $request, $id)
    {
        $fine = Fine::findOrFail($id);

        $fine->update([
            'status' => 'sudah_bayar'
        ]);

        return redirect()->route('fines.index')
            ->with('success', 'Denda berhasil dibayar');
    }

    // 🔹 lihat denda user sendiri
    public function userFines()
    {
        $fines = Fine::with('transaction.user', 'transaction.book')
            ->whereHas('transaction', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->where('status', 'belum_bayar')
            ->get();

        return view('user.fines', compact('fines'));
    }
}