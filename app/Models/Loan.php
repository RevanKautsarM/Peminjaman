<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Loan extends Model
{
    use HasFactory;

    protected $table = 'loans';

    protected $fillable = [
        'user_id',
        'loan_date',
        'return_date',
        'status',
    ];

    // Mengonversi kolom tanggal menjadi objek Carbon secara otomatis
    protected $casts = [
        'loan_date' => 'date',
        'return_date' => 'date',
    ];

    /**
     * Hubungan ke tabel users (Belongs To)
     * Transaksi peminjaman ini dimiliki oleh seorang user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Hubungan ke tabel loan_details (One to Many)
     * Satu transaksi peminjaman bisa memiliki banyak detail barang
     */
    public function loanDetails(): HasMany
    {
        return $this->hasMany(LoanDetail::class, 'loan_id');
    }
}