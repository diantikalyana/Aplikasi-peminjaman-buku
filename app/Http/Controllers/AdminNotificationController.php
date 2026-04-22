<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminNotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', \App\Http\Middleware\IsAdmin::class]);
    }

    /**
     * Display all notifications for admin
     */
    public function index()
    {
        $notes = Notification::with('user')->latest()->paginate(30);
        return view('admin.notifications.index', compact('notes'));
    }

    /**
     * Get unread notifications count
     */
    public function unreadCount()
    {
        $user = Auth::user();
        $unreadCount = $user->unreadNotificationsCount();

        return response()->json([
            'count' => $unreadCount
        ]);
    }

    /**
     * Get unread notifications
     */
    public function unread()
    {
        $user = Auth::user();
        $unreadNotifications = $user->unreadNotifications()->limit(10)->get();

        return response()->json([
            'notifications' => $unreadNotifications
        ]);
    }

    /**
     * Mark notification as read
     */
    public function markRead($id)
    {
        $notification = Notification::find($id);
        if ($notification && $notification->user_id == Auth::id()) {
            $notification->update(['is_read' => true]);
        }
        return back();
    }

    /**
     * Mark all as read
     */
    public function markAllRead()
    {
        Auth::user()->notifications()
            ->where('is_read', false)
            ->update(['is_read' => true]);
        
        return back()->with('success', 'Semua notifikasi telah ditandai sebagai dibaca.');
    }

    /**
     * Delete a notification
     */
    public function destroy($id)
    {
        $notification = Notification::find($id);
        if ($notification && $notification->user_id == Auth::id()) {
            $notification->delete();
            return back()->with('success', 'Notifikasi dihapus.');
        }
        return back()->with('error', 'Notifikasi tidak ditemukan.');
    }

    /**
     * Delete all notifications
     */
    public function destroyAll()
    {
        Auth::user()->notifications()->delete();
        return back()->with('success', 'Semua notifikasi telah dihapus.');
    }
}
