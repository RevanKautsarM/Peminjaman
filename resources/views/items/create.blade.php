@extends('layout.app')

@section('content')
<div class="mb-4">
    <a href="{{ route('items.index') }}" class="btn btn-secondary btn-sm">
        <i class="bi bi-arrow-left"></i> Kembali ke Daftar
    </a>
</div>

<div class="form-card mb-5">
    <div class="form-header-gradient">
        <h5 class="fw-bold m-0"><i class="bi bi-box-seam-fill me-2"></i> Tambah Barang Baru</h5>
        <p class="small text-white-50 m-0 mt-1">Masukkan detail data barang inventaris baru secara lengkap.</p>
    </div>
    
    <div class="form-body">
        <form action="{{ route('items.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label class="form-label" for="item_code">Kode Barang</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-qr-code text-slate-500"></i></span>
                    <input type="text" id="item_code" name="item_code" class="form-control" placeholder="Contoh: BRG-001" required value="{{ old('item_code') }}">
                </div>
                @error('item_code')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label class="form-label" for="name">Nama Barang</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-tag text-slate-500"></i></span>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Masukkan nama barang" required value="{{ old('name') }}">
                </div>
                @error('name')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label class="form-label" for="category">Kategori</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-bookmarks text-slate-500"></i></span>
                    <input type="text" id="category" name="category" class="form-control" placeholder="Contoh: Elektronik, ATK, Furnitur" required value="{{ old('category') }}">
                </div>
                @error('category')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-4">
                <label class="form-label" for="stock">Jumlah Stok Awal</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-hash text-slate-500"></i></span>
                    <input type="number" id="stock" name="stock" class="form-control" min="0" placeholder="0" required value="{{ old('stock', 0) }}">
                </div>
                @error('stock')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
            
            <button type="submit" class="btn btn-primary w-100 py-2.5">
                <i class="bi bi-cloud-arrow-up-fill"></i> Simpan Barang
            </button>
        </form>
    </div>
</div>
@endsection