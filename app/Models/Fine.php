<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fine extends Model
{
    protected $table = 'fines';

    protected $fillable = [
        'transaction_id',
        'days_late',
        'amount',
        'status',
    ];

    // 🔹 relasi ke transaksi
    public function transaction()
{
    return $this->belongsTo(Transaction::class, 'transaction_id');
}
}