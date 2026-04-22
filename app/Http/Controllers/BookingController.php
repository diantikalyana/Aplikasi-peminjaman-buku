<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Book;
use App\Models\User;
use App\Models\Transaction;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Booking::with(['user','book']);

        if ($user && $user->role === 'admin') {
            // Admin can see all bookings
        } else {
            // Regular users only see their own bookings
            $query->where('user_id', Auth::id());
        }

        // SEARCH
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

        $bookings = $query->latest()->paginate(20);
        return view('bookings.index', compact('bookings'));
    }

    public function create(Request $request)
    {
        $bookId = $request->query('book_id');
        $books = Book::orderBy('title')->get();
        return view('bookings.create', compact('books', 'bookId'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'book_id' => ['required','exists:books,id'],
            'booking_date' => ['required','date'],
        ]);

        $data['user_id'] = Auth::id();
        $data['status'] = 'pending';

        $booking = Booking::create($data);

        // 🔔 Kirim notifikasi ke user
        $book = Book::find($booking->book_id);
        NotificationService::createBookingNotification(
            $booking->user_id,
            $book->title,
            'pending',
            route('bookings.show', $booking->id)
        );

        // 🔔 Notifikasi ke semua admin tentang booking baru
        NotificationService::notifyAdminBooking(
            $booking->id,
            Auth::user()->name,
            $book->title
        );

        return redirect()->route('bookings.index')->with('success', 'Booking berhasil dibuat.');
    }

    public function show(Booking $booking)
    {
        $this->authorize('view', $booking);
        $booking->load(['user','book']);
        return view('bookings.show', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        $this->authorize('update', $booking);
        $books = Book::orderBy('title')->get();
        return view('bookings.edit', compact('booking','books'));
    }

    public function update(Request $request, Booking $booking)
    {
        $this->authorize('update', $booking);
        $data = $request->validate([
            'book_id' => ['required','exists:books,id'],
            'booking_date' => ['required','date'],
            'status' => ['nullable','in:pending,diambil,batal'],
        ]);

        $booking->update($data);
        return redirect()->route('bookings.index')->with('success', 'Booking diperbarui.');
    }

    public function destroy(Booking $booking)
    {
        $this->authorize('delete', $booking);
        
        // 🔔 Notifikasi user tentang pembatalan booking
        if ($booking->user_id == Auth::id()) {
            NotificationService::createBookingNotification(
                $booking->user_id,
                $booking->book->title,
                'batal',
                route('bookings.index')
            );
        }
        
        $booking->delete();
        return back()->with('success', 'Booking dibatalkan.');
    }

    public function approve(Booking $booking)
    {
        // Update status booking
        $booking->update(['status' => 'approved']);

        // Cek apakah buku tersedia
        if ($booking->book->stock <= 0) {
            return back()->with('error', 'Stok buku habis, tidak bisa approve booking.');
        }

        // Kurangi stok buku
        $booking->book->decrement('stock');

        // 🔔 Notifikasi user tentang persetujuan booking
        NotificationService::createBookingNotification(
            $booking->user_id,
            $booking->book->title,
            'approved',
            route('bookings.show', $booking->id)
        );

        return redirect()->back()->with('success', 'Booking disetujui. Silakan buat transaksi peminjaman.');
    }

    public function reject(Booking $booking)
    {
        $booking->update(['status' => 'rejected']);

        // 🔔 Notifikasi user tentang penolakan booking
        NotificationService::createBookingNotification(
            $booking->user_id,
            $booking->book->title,
            'batal',
            route('bookings.show', $booking->id)
        );

        return redirect()->back()->with('success', 'Booking ditolak.');
    }

    public function createTransaction(Booking $booking)
    {
        // Pastikan booking sudah approved
        if ($booking->status !== 'approved') {
            return back()->with('error', 'Booking belum disetujui.');
        }

        return view('transactions.create-from-booking', compact('booking'));
    }
}
