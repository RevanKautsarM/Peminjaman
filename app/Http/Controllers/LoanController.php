<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Item;
use App\Models\LoanDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoanController extends Controller
{
    public function index()
    {
        $loans = Loan::with(['user', 'loanDetails.item'])->latest()->get();
        return view('loans.index', compact('loans'));
    }

    public function create()
    {
        $items = Item::where('stock', '>', 0)->get();
        // Mengambil user pertama sebagai simulasi (karena belum setup Auth login)
        $users = User::all(); 
        
        // Jaga-jaga jika tabel user kosong, kita buatkan user dummy
        if ($users->isEmpty()) {
            $user = User::create([
                'name' => 'Peminjam Dummy',
                'email' => 'peminjam@test.com',
                'password' => bcrypt('password'),
            ]);
            $users = collect([$user]);
        }

        return view('loans.create', compact('items', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'item_id' => 'required',
            'quantity' => 'required|integer|min:1',
            'return_date' => 'required|date|after_or_equal:today',
        ]);

        $item = Item::findOrFail($request->item_id);

        if ($item->stock < $request->quantity) {
            return back()->with('error', 'Stok barang tidak mencukupi!');
        }

        // Gunakan Database Transaction agar jika salah satu error, data tidak corrupt
        DB::transaction(function () use ($request, $item) {
            // 1. Buat data Peminjaman
            $loan = Loan::create([
                'user_id' => $request->user_id,
                'loan_date' => now(),
                'return_date' => $request->return_date,
                'status' => 'dipinjam',
            ]);

            // 2. Buat Detail Peminjaman
            LoanDetail::create([
                'loan_id' => $loan->id,
                'item_id' => $item->id,
                'quantity' => $request->quantity,
            ]);

            // 3. Kurangi Stok Barang
            $newStock = $item->stock - $request->quantity;
            $item->update([
                'stock' => $newStock,
                'status' => $newStock > 0 ? 'tersedia' : 'habis',
            ]);
        });

        return redirect()->route('loans.index')->with('success', 'Transaksi peminjaman berhasil dicatat!');
    }

    public function returnItem($id)
    {
        $loan = Loan::with('loanDetails.item')->findOrFail($id);

        if ($loan->status === 'dikembalikan') {
            return back()->with('error', 'Barang sudah dikembalikan sebelumnya!');
        }

        DB::transaction(function () use ($loan) {
            // 1. Ubah status peminjaman
            $loan->update(['status' => 'dikembalikan']);

            // 2. Kembalikan stok barang semula
            foreach ($loan->loanDetails as $detail) {
                $item = $detail->item;
                $newStock = $item->stock + $detail->quantity;
                $item->update([
                    'stock' => $newStock,
                    'status' => 'tersedia',
                ]);
            }
        });

        return redirect()->route('loans.index')->with('success', 'Barang berhasil dikembalikan!');
    }
}