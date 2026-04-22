<?php

namespace App\Console\Commands;

use App\Models\Transaction;
use App\Services\NotificationService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendReturnReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kirim pengingat pengembalian buku kepada pengguna';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Cari semua transaksi yang masih aktif (dipinjam)
        $transactions = Transaction::where('status', 'dipinjam')
            ->where('return_date', null)
            ->with('user', 'book')
            ->get();

        $now = Carbon::now();
        $count = 0;

        foreach ($transactions as $transaction) {
            $dueDate = Carbon::parse($transaction->due_date);
            $daysLeft = $now->diffInDays($dueDate, false);

            // Kirim reminder jika:
            // 1. Sudah jatuh tempo (0 hari) - URGENT
            // 2. 1 hari sebelum jatuh tempo
            // 3. 3 hari sebelum jatuh tempo
            if ($daysLeft === 0 || $daysLeft === 1 || $daysLeft === 3) {
                NotificationService::createReturnReminder(
                    $transaction->user_id,
                    $transaction->book->title,
                    $dueDate->format('d/m/Y'),
                    max(0, $daysLeft),
                    route('transactions.index')
                );

                $count++;
            }

            // Jika sudah terlambat, notifikasi admin
            if ($daysLeft < 0) {
                NotificationService::notifyAdminOverdue(
                    $transaction->user->name,
                    $transaction->book->title,
                    abs($daysLeft)
                );
            }
        }

        $this->info("✅ Pengingat pengembalian buku dikirim ke $count pengguna");
    }
}
