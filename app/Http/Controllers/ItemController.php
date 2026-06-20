<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::latest()->get();
        return view('items.index', compact('items'));
    }

    public function create()
    {
        return view('items.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_code' => 'required|unique:items,item_code',
            'name' => 'required',
            'category' => 'required',
            'stock' => 'required|integer|min:0',
        ]);

        Item::create([
            'item_code' => $request->item_code,
            'name' => $request->name,
            'category' => $request->category,
            'stock' => $request->stock,
            'status' => $request->stock > 0 ? 'tersedia' : 'habis',
        ]);

        return redirect()->route('items.index')->with('success', 'Barang berhasil ditambahkan!');
    }

    public function edit(Item $item)
    {
        return view('items.edit', compact('item'));
    }

    public function update(Request $request, Item $item)
    {
        $request->validate([
            'item_code' => 'required|unique:items,item_code,' . $item->id,
            'name' => 'required',
            'category' => 'required',
            'stock' => 'required|integer|min:0',
        ]);

        $item->update([
            'item_code' => $request->item_code,
            'name' => $request->name,
            'category' => $request->category,
            'stock' => $request->stock,
            'status' => $request->stock > 0 ? 'tersedia' : 'habis',
        ]);

        return redirect()->route('items.index')->with('success', 'Barang berhasil diperbarui!');
    }

    public function destroy(Item $item)
    {
        if ($item->loanDetails()->exists()) {
            return redirect()->route('items.index')->with('error', 'Barang "' . $item->name . '" tidak dapat dihapus karena memiliki riwayat peminjaman!');
        }

        $item->delete();
        return redirect()->route('items.index')->with('success', 'Barang berhasil dihapus!');
    }
}