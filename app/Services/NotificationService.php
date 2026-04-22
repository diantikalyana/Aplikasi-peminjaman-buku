<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;

class NotificationService
{
    /**
     * Create a booking notification
     */
    public static function createBookingNotification($userId, $bookTitle, $status = 'pending', $url = null)
    {
        $messages = [
            'pending' => "Booking buku \"$bookTitle\" Anda menunggu persetujuan admin.",
            'approved' => "Booking buku \"$bookTitle\" Anda telah disetujui. Silakan buat transaksi peminjaman.",
            'diambil' => "Booking buku \"$bookTitle\" Anda telah diambil.",
            'batal' => "Booking buku \"$bookTitle\" Anda telah dibatalkan.",
        ];

        return Notification::create([
            'user_id' => $userId,
            'title' => "Booking Buku: $bookTitle",
            'type' => 'booking',
            'message' => $messages[$status] ?? $messages['pending'],
            'url' => $url ?? route('bookings.index'),
        ]);
    }

    /**
     * Notify admin about new booking
     */
    public static function notifyAdminBooking($bookingId, $userName, $bookTitle)
    {
        $admins = User::where('role', 'admin')->get();
        
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'title' => 'Booking Baru',
                'type' => 'booking',
                'message' => "$userName melakukan booking untuk buku \"$bookTitle\".",
                'url' => route('bookings.index'),
            ]);
        }
    }

    /**
     * Create a fine/denda notification
     */
    public static function createFineNotification($userId, $bookTitle, $days, $amount, $url = null)
    {
        return Notification::create([
            'user_id' => $userId,
            'title' => 'Denda Keterlambatan',
            'type' => 'fine',
            'message' => "Anda memiliki denda untuk buku \"$bookTitle\" karena terlambat $days hari. Denda: Rp " . number_format($amount),
            'url' => $url ?? route('fines.index'),
        ]);
    }

    /**
     * Notify admin about new fine
     */
    public static function notifyAdminFine($userName, $bookTitle, $amount)
    {
        $admins = User::where('role', 'admin')->get();
        
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'title' => 'Denda Baru',
                'type' => 'fine',
                'message' => "$userName terkena denda untuk buku \"$bookTitle\" sebesar Rp " . number_format($amount),
                'url' => route('fines.index'),
            ]);
        }
    }

    /**
     * Create new book notification - notify all users
     */
    public static function notifyNewBook($bookTitle, $author = null, $url = null)
    {
        $users = User::where('role', 'user')->get();
        
        foreach ($users as $user) {
            Notification::create([
                'user_id' => $user->id,
                'title' => 'Buku Baru Tersedia',
                'type' => 'new_book',
                'message' => "Buku baru \"$bookTitle\" oleh $author telah ditambahkan ke perpustakaan.",
                'url' => $url ?? route('dashboard'),
            ]);
        }
    }

    /**
     * Notify admin about new book
     */
    public static function notifyAdminNewBook($bookTitle)
    {
        $admins = User::where('role', 'admin')->get();
        
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'title' => 'Buku Baru Ditambahkan',
                'type' => 'new_book',
                'message' => "Buku \"$bookTitle\" telah ditambahkan ke katalog.",
                'url' => route('books.index'),
            ]);
        }
    }

    /**
     * Create return reminder notification
     */
    public static function createReturnReminder($userId, $bookTitle, $returnDate, $daysLeft, $url = null)
    {
        $urgency = $daysLeft <= 1 ? 'segera ' : '';
        
        return Notification::create([
            'user_id' => $userId,
            'title' => 'Pengingat Pengembalian Buku',
            'type' => 'return_reminder',
            'message' => "Harap mengembalikan buku \"$bookTitle\" pada tanggal $returnDate. Sisa waktu: $daysLeft hari.",
            'url' => $url ?? route('transactions.index'),
        ]);
    }

    /**
     * Notify admin about overdue book
     */
    public static function notifyAdminOverdue($userName, $bookTitle, $daysLate)
    {
        $admins = User::where('role', 'admin')->get();
        
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'title' => 'Buku Terlambat',
                'type' => 'return_reminder',
                'message' => "$userName terlambat mengembalikan buku \"$bookTitle\" selama $daysLate hari.",
                'url' => route('transactions.index'),
            ]);
        }
    }

    /**
     * Create transaction notification
     */
    public static function createTransactionNotification($userId, $bookTitle, $type, $dueDate = null, $url = null)
    {
        $messages = [
            'borrowed' => "Anda telah meminjam buku \"$bookTitle\". Batas pengembalian: $dueDate",
            'returned' => "Terima kasih telah mengembalikan buku \"$bookTitle\".",
        ];

        return Notification::create([
            'user_id' => $userId,
            'title' => $type === 'borrowed' ? 'Peminjaman Buku' : 'Pengembalian Buku',
            'type' => 'transaction',
            'message' => $messages[$type] ?? '',
            'url' => $url ?? route('transactions.index'),
        ]);
    }

    /**
     * Mark notification as read
     */
    public static function markAsRead($notificationId)
    {
        $notification = Notification::find($notificationId);
        if ($notification) {
            $notification->update(['is_read' => true]);
        }
        return $notification;
    }

    /**
     * Get unread count for user
     */
    public static function getUnreadCount($userId)
    {
        return Notification::where('user_id', $userId)
            ->where('is_read', false)
            ->count();
    }

    /**
     * Get unread notifications
     */
    public static function getUnreadNotifications($userId, $limit = 5)
    {
        return Notification::where('user_id', $userId)
            ->where('is_read', false)
            ->latest()
            ->limit($limit)
            ->get();
    }
}
