<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    use HasFactory;

    // Menentukan nama tabel secara eksplisit
    protected $table = 'items';

    // Kolom yang boleh diisi secara massal (Mass Assignment)
    protected $fillable = [
        'item_code',
        'name',
        'category',
        'stock',
        'status',
    ];

    /**
     * Hubungan ke tabel loan_details (One to Many)
     * Satu barang bisa ada di banyak detail peminjaman
     */
    public function loanDetails(): HasMany
    {
        return $this->hasMany(LoanDetail::class, 'item_id');
    }
}