# 📢 Dokumentasi Sistem Notifikasi Perpustakaan

## ✅ Fitur yang Telah Diimplementasikan

### 1. **Notifikasi Booking** 📋
- ✅ Notifikasi ketika user membuat booking baru
- ✅ Notifikasi admin ketika ada booking baru dari user
- ✅ Notifikasi user ketika booking disetujui admin
- ✅ Notifikasi user ketika booking ditolak admin
- ✅ Notifikasi user ketika membatalkan booking sendiri

**Controller**: `BookingController.php`
**Service**: `NotificationService::createBookingNotification()`

---

### 2. **Notifikasi Denda** 💰
- ✅ Notifikasi user ketika terkena denda (keterlambatan pengembalian)
- ✅ Notifikasi admin ketika ada denda baru
- ✅ Notifikasi admin ketika ada buku yang terlambat
- ✅ Denda otomatis terbuat saat buku dikembalikan terlambat

**Controller**: `TransactionController.php`
**Service**: `NotificationService::createFineNotification()` & `notifyAdminFine()`

---

### 3. **Notifikasi Buku Terbaru** 📚
- ✅ Notifikasi ke SEMUA user ketika admin menambah buku baru
- ✅ Notifikasi admin ketika ada buku yang ditambahkan
- ✅ Link langsung ke dashboard untuk melihat buku baru

**Controller**: `BookController.php`
**Service**: `NotificationService::notifyNewBook()` & `notifyAdminNewBook()`

---

### 4. **Pengingat Pengembalian Buku** ⏰
- ✅ Notifikasi user 3 hari sebelum deadline
- ✅ Notifikasi user 1 hari sebelum deadline
- ✅ Notifikasi URGENT user saat hari deadline
- ✅ Notifikasi admin untuk buku yang sudah terlambat

**Command**: `SendReturnReminders` (artisan command)
**Service**: `NotificationService::createReturnReminder()` & `notifyAdminOverdue()`

Jalankan dengan: `php artisan notifications:send-reminders`

---

### 5. **Notifikasi Transaksi** 🔄
- ✅ Notifikasi user ketika berhasil meminjam buku
- ✅ Notifikasi user ketika mengembalikan buku
- ✅ Info tenggat waktu pengembalian di notifikasi

**Controller**: `TransactionController.php`
**Service**: `NotificationService::createTransactionNotification()`

---

## 📂 File-File yang Dibuat/Diupdate

### Database & Migration
- ✅ `database/migrations/2026_04_22_000000_create_notifications_table.php`

### Models
- ✅ `app/Models/Notification.php` - Updated dengan type dan url fields
- ✅ `app/Models/User.php` - Added notification relationships

### Services
- ✅ `app/Services/NotificationService.php` - Helper class untuk membuat notifikasi

### Controllers
- ✅ `app/Http/Controllers/NotificationController.php` - User notifications management
- ✅ `app/Http/Controllers/AdminNotificationController.php` - Updated
- ✅ `app/Http/Controllers/BookingController.php` - Added notification triggers
- ✅ `app/Http/Controllers/BookController.php` - Added new book notifications
- ✅ `app/Http/Controllers/TransactionController.php` - Added transaction & fine notifications
- ✅ `app/Http/Controllers/FineController.php` - Updated with NotificationService
- ✅ `app/Http/Controllers/DashboardController.php` - Added unread notification stats

### Console Commands
- ✅ `app/Console/Commands/SendReturnReminders.php` - Scheduled reminder sender

### Routes
- ✅ `routes/web.php` - Added notification routes untuk user dan admin

### Views
- ✅ `resources/views/notifications/index.blade.php` - User notifications list
- ✅ `resources/views/admin/notifications/index.blade.php` - Updated admin notifications list
- ✅ `resources/views/components/notification-bell.blade.php` - Notification bell component
- ✅ `resources/views/dashboard.blade.php` - Admin dashboard updated dengan notifikasi stats
- ✅ `resources/views/dashboard-user.blade.php` - User dashboard updated dengan notifikasi

---

## 🔌 Cara Menggunakan

### Untuk User:
1. Kunjungi **Dashboard** untuk melihat notifikasi terbaru
2. Klik **🔔 Notifikasi Baru** untuk melihat semua notifikasi
3. Setiap event akan membuat notifikasi:
   - Booking buku
   - Persetujuan/penolakan booking
   - Peminjaman buku
   - Pengembalian buku
   - Denda keterlambatan
   - Buku terbaru
   - Pengingat pengembalian

### Untuk Admin:
1. Kunjungi **Dashboard Admin** untuk melihat statistik dan notifikasi
2. Klik **🔔 Notifikasi Baru** atau kunjungi `/admin/notifications`
3. Admin akan menerima notifikasi untuk:
   - Booking baru dari user
   - Denda baru yang terbuat
   - Buku yang terlambat dikembalikan
   - Buku baru yang ditambahkan

### Mengirim Reminder Pengembalian:
```bash
# Jalankan manual
php artisan notifications:send-reminders

# Atau setup cron job untuk otomatis (di production)
* * * * * cd /path/to/app && php artisan schedule:run >> /dev/null 2>&1
```

---

## 📊 Database Schema

Tabel `notifications`:
```sql
- id (bigint, primary key)
- user_id (foreign key to users)
- title (varchar) - Judul notifikasi
- type (varchar) - Tipe: booking, fine, new_book, return_reminder, transaction
- message (text) - Pesan lengkap
- url (varchar, nullable) - Link ke halaman terkait
- is_read (boolean) - Status dibaca/belum dibaca
- created_at, updated_at (timestamp)

Indexes:
- (user_id, is_read) - Cepat untuk query notifikasi belum dibaca
- (created_at) - Cepat untuk sorting
```

---

## 🎯 Fitur Notifikasi Detail

### Tipe Notifikasi:
| Tipe | Warna | Trigger | Penerima |
|------|-------|---------|----------|
| **booking** | 🔵 Biru | Create/Approve/Reject booking | User + Admin |
| **fine** | 🔴 Merah | Buku terlambat dikembalikan | User + Admin |
| **new_book** | 🟢 Hijau | Buku baru ditambahkan | Semua User + Admin |
| **return_reminder** | 🟡 Kuning | Tenggat pengembalian mencapai | User + Admin |
| **transaction** | ⚪ Umum | Pinjam/kembalikan buku | User |

---

## 🚀 Fitur Lanjutan yang Dapat Ditambahkan

1. **Email Notifications** - Kirim notifikasi via email
2. **Push Notifications** - Notifikasi desktop/mobile
3. **SMS Notifications** - Notifikasi via SMS untuk urgent items
4. **Notification Preferences** - User bisa pilih tipe notifikasi yang ingin diterima
5. **Notification History** - Archive notifikasi yang sudah dibaca
6. **Real-time Notifications** - Menggunakan WebSocket/Pusher
7. **Batch Notifications** - Kirim notifikasi dalam batch pada waktu tertentu

---

## 🧪 Testing

Untuk test notifikasi:

```php
// Test create notification
$notif = NotificationService::createBookingNotification(1, "Judul Buku", "pending");
dd($notif);

// Test get unread count
$count = User::find(1)->unreadNotificationsCount();
echo $count; // Jumlah notifikasi belum dibaca
```

---

## 📝 Notes

- Semua notifikasi disimpan di database
- User dapat menghapus dan menandai notifikasi sebagai dibaca
- Admin dapat mengelola semua notifikasi user
- Notifikasi type-based sehingga mudah untuk filter
- URL stored untuk direct link ke action yang relevan

---

**Sistem notifikasi sudah fully integrated dan ready to use! 🎉**
