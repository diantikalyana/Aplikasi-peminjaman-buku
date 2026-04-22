<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Transaction;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', \App\Http\Middleware\IsAdmin::class]);
    }

    // report: who booked which book and counts
    public function bookings()
    {
        $counts = Booking::select('book_id', DB::raw('count(*) as total'))
            ->groupBy('book_id')
            ->with('book')
            ->get();

        $list = Booking::with(['user','book'])->latest()->get();
        return view('admin.reports.bookings', compact('counts','list'));
    }

    public function bookingsPdf()
    {
        $counts = Booking::select('book_id', DB::raw('count(*) as total'))
            ->groupBy('book_id')
            ->with('book')
            ->get();

        $list = Booking::with(['user','book'])->latest()->get();
        $pdf = Pdf::loadView('admin.reports.bookings_pdf', compact('counts','list'));
        return $pdf->download('laporan_bookings.pdf');
    }

    // report: all borrowings / returns
    public function transactions()
    {
        $transactions = Transaction::with(['user','book'])->latest()->get();
        return view('admin.reports.transactions', compact('transactions'));
    }

    public function transactionsPdf()
    {
        $transactions = Transaction::with(['user','book'])->latest()->get();
        $pdf = Pdf::loadView('admin.reports.transactions_pdf', compact('transactions'));
        return $pdf->download('laporan_transactions.pdf');
    }

    // report: late returns
    public function lateReturns()
    {
        $lates = Transaction::with(['user','book','fine'])->where('status','telat')->latest()->get();
        return view('admin.reports.late', compact('lates'));
    }

    public function lateReturnsPdf()
    {
        $lates = Transaction::with(['user','book','fine'])->where('status','telat')->latest()->get();
        $pdf = Pdf::loadView('admin.reports.late_pdf', compact('lates'));
        return $pdf->download('laporan_keterlambatan.pdf');
    }
}
