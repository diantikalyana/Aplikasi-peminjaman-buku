<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\User;
use App\Models\Category;
use App\Models\Booking;
use App\Models\Transaction;
use App\Models\Fine;
use App\Services\NotificationService;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // 🔥 ADMIN
        if ($user->role == 'admin') {
            $totalBooks = Book::count();
            $totalUsers = User::where('role', 'user')->count();
            $totalCategories = Category::count();
            $pendingBookings = Booking::where('status', 'pending')->count();
            $activeTransactions = Transaction::where('status', 'dipinjam')->count();
            $unpaidFines = Fine::where('status', 'belum_bayar')->count();
            
            // Notifikasi yang belum dibaca
            $unreadCount = $user->unreadNotificationsCount();
            $unreadNotifications = $user->unreadNotifications()->limit(5)->get();

            return view('dashboard', compact(
                'totalBooks',
                'totalUsers',
                'totalCategories',
                'pendingBookings',
                'activeTransactions',
                'unpaidFines',
                'unreadCount',
                'unreadNotifications'
            ));
        }

        // 🔥 USER
        $categories = Category::all();

        $booksQuery = Book::query();
        if (request('category')) {
            $booksQuery->where('category_id', request('category'));
        }
        $books = $booksQuery->get();

        // Notifikasi yang belum dibaca untuk user
        $unreadCount = $user->unreadNotificationsCount();
        $unreadNotifications = $user->unreadNotifications()->limit(5)->get();

        return view('dashboard-user', compact('categories', 'books', 'unreadCount', 'unreadNotifications'));
    }
}