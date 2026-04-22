<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Book;
use App\Models\Fine;
use App\Models\Setting;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with('user', 'book');

        // SEARCH (FIXED - sebelumnya rusak + dobel query)
        if ($request->search) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%$search%");
                })
                ->orWhereHas('book', function ($q3) use ($search) {
                    $q3->where('title', 'like', "%$search%");
                });
            });
        }

        $transactions = $query->latest()->get();

        $users = User::all();
        $books = Book::all();

        return view('transactions.index', compact('transactions', 'users', 'books'));
    }

    public function create()
    {
        $users = User::all();
        $books = Book::all();

        return view('transactions.create', compact('users', 'books'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'book_id' => 'required',
            'duration' => 'required|integer|min:1|max:7'
        ]);

        $book = Book::findOrFail($request->book_id);
        $duration = (int)$request->duration;

        // Cek apakah ini dari booking yang sudah approved
        $existingBooking = \App\Models\Booking::where('user_id', $request->user_id)
            ->where('book_id', $request->book_id)
            ->where('status', 'approved')
            ->first();

        if (!$existingBooking && $book->stock <= 0) {
            return back()->with('error', 'Stok buku habis!');
        }

       // default normal (sesuai input hari)
$dueDate = now()->addDays($duration);

// 🔥 sementara untuk demo (biar langsung telat)
if (app()->environment('local')) {
    $dueDate = now()->subDays(5);
}

        $transaction = Transaction::create([
            'user_id' => $request->user_id,
            'book_id' => $request->book_id,
            'borrow_date' => now(),
            'due_date' => $dueDate,
            'status' => 'dipinjam',
        ]);

        // Hanya kurangi stok jika bukan dari booking approved
        if (!$existingBooking) {
            $book->decrement('stock');
        }

        // Update booking status jika ada
        if ($existingBooking) {
            $existingBooking->update(['status' => 'completed']);
        }

        // 🔔 Notifikasi user tentang peminjaman buku
        $user = User::find($request->user_id);
        NotificationService::createTransactionNotification(
            $request->user_id,
            $book->title,
            'borrowed',
            $dueDate->format('d/m/Y'),
            route('transactions.index')
        );

        return redirect('/transactions')->with('success', 'Buku berhasil dipinjam');
    }

    public function edit($id)
    {
        $transaction = Transaction::with('user', 'book')->findOrFail($id);

        return view('transactions.edit', compact('transaction'));
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);

        if ($transaction->return_date) {
            return back()->with('error', 'Buku sudah dikembalikan!');
        }

        $returnDate = now();
        $dueDate = Carbon::parse($transaction->due_date);

        $daysLate = $returnDate->gt($dueDate)
            ? $dueDate->diffInDays($returnDate)
            : 0;

        $transaction->update([
            'return_date' => $returnDate,
            'status' => $daysLate > 0 ? 'telat' : 'kembali',
        ]);

        $transaction->book->increment('stock');

        // 🔔 Notifikasi pengembalian buku ke user
        NotificationService::createTransactionNotification(
            $transaction->user_id,
            $transaction->book->title,
            'returned',
            null,
            route('transactions.index')
        );

        // ⚠️ DISABLE FINE RELATION (BIAR TIDAK ERROR LAGI)
        // karena DB kamu belum punya transaction_id
        if ($daysLate > 0) {
            $finePerDay = Setting::value('fine_per_day') ?? 20000;
            $fineAmount = $daysLate * $finePerDay;

            Fine::create([
                'days_late' => $daysLate,
                'amount' => $fineAmount,
                'status' => 'belum_bayar',
            ]);

            // 🔔 Notifikasi denda ke user
            NotificationService::createFineNotification(
                $transaction->user_id,
                $transaction->book->title,
                $daysLate,
                $fineAmount,
                route('fines.index')
            );

            // 🔔 Notifikasi admin tentang denda baru
            NotificationService::notifyAdminFine(
                $transaction->user->name,
                $transaction->book->title,
                $fineAmount
            );

            // 🔔 Notifikasi overdue ke admin
            NotificationService::notifyAdminOverdue(
                $transaction->user->name,
                $transaction->book->title,
                $daysLate
            );
        }

        return redirect('/transactions')->with('success', 'Buku dikembalikan');
    }

    public function destroy($id)
    {
        Transaction::findOrFail($id)->delete();

        return redirect('/transactions')->with('success', 'Data dihapus');
    }

    public function userHistory()
    {
        $user = auth()->user();
        $transactions = Transaction::with('book')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        return view('user.history', compact('transactions'));
    }
}