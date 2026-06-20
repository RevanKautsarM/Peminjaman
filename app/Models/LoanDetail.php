<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LoanDetail extends Model
{
    use HasFactory;

    protected $table = 'loan_details';

    protected $fillable = [
        'loan_id',
        'item_id',
        'quantity',
    ];

    /**
     * Hubungan ke tabel loans (Belongs To)
     * Detail ini merujuk pada sebuah transaksi induk
     */
    public function loan(): BelongsTo
    {
        return $this->belongsTo(Loan::class, 'loan_id');
    }

    /**
     * Hubungan ke tabel items (Belongs To)
     * Detail ini merujuk pada data barang yang dipinjam
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}