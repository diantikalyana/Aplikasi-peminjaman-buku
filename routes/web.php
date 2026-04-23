<?php

use App\Http\Controllers\AdminNotificationController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FineController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/books/pdf', [BookController::class, 'exportPdf'])->name('books.pdf');
Route::get('/users/pdf', [UserController::class, 'exportPdf'])->name('users.pdf');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

    Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/history', [TransactionController::class, 'userHistory'])->name('user.history');

    // User fines
    Route::get('/my-fines', [FineController::class, 'userFines'])->name('user.fines');

    // 🔔 Notifikasi User
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/unread', [NotificationController::class, 'unread'])->name('notifications.unread');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markRead'])->name('notifications.read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.markAllRead');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::post('/notifications/destroy-all', [NotificationController::class, 'destroyAll'])->name('notifications.destroyAll');

    Route::resource('transactions', TransactionController::class);
    Route::resource('bookings', BookingController::class);

    // 🔒 ADMIN ONLY
    Route::middleware([\App\Http\Middleware\IsAdmin::class])->group(function () {
        // Booking approval routes
        Route::post('bookings/{booking}/approve', [BookingController::class, 'approve'])->name('bookings.approve');
        Route::post('bookings/{booking}/reject', [BookingController::class, 'reject'])->name('bookings.reject');
        Route::get('bookings/{booking}/create-transaction', [BookingController::class, 'createTransaction'])->name('bookings.create-transaction');

        Route::resource('books', BookController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('users', \App\Http\Controllers\UserController::class);
        Route::resource('fines', FineController::class);
        // admin reports and notifications
        Route::get('admin/reports/bookings', [ReportController::class, 'bookings'])->name('admin.reports.bookings');
        Route::get('admin/reports/bookings/pdf', [ReportController::class, 'bookingsPdf'])->name('admin.reports.bookings.pdf');
        Route::get('admin/reports/transactions', [ReportController::class, 'transactions'])->name('admin.reports.transactions');
        Route::get('admin/reports/transactions/pdf', [ReportController::class, 'transactionsPdf'])->name('admin.reports.transactions.pdf');
        Route::get('admin/reports/late', [ReportController::class, 'lateReturns'])->name('admin.reports.late');
        Route::get('admin/reports/late/pdf', [ReportController::class, 'lateReturnsPdf'])->name('admin.reports.late.pdf');

        Route::get('admin/notifications', [AdminNotificationController::class, 'index'])->name('admin.notifications.index');
        Route::get('admin/notifications/unread-count', [AdminNotificationController::class, 'unreadCount'])->name('admin.notifications.unreadCount');
        Route::get('admin/notifications/unread', [AdminNotificationController::class, 'unread'])->name('admin.notifications.unread');
        Route::post('admin/notifications/{id}/read', [AdminNotificationController::class, 'markRead'])->name('admin.notifications.read');
        Route::post('admin/notifications/mark-all-read', [AdminNotificationController::class, 'markAllRead'])->name('admin.notifications.markAllRead');
        Route::delete('admin/notifications/{id}', [AdminNotificationController::class, 'destroy'])->name('admin.notifications.destroy');
        Route::post('admin/notifications/destroy-all', [AdminNotificationController::class, 'destroyAll'])->name('admin.notifications.destroyAll');
    });

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::resource('books', BookController::class);
Route::resource('categories', CategoryController::class);
Route::resource('users', UserController::class);
Route::resource('transactions', TransactionController::class);