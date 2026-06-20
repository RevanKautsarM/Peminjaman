@extends('layout.app')

@section('content')
<div class="mb-4">
    <a href="{{ route('loans.index') }}" class="btn btn-secondary btn-sm">
        <i class="bi bi-arrow-left"></i> Kembali ke Daftar
    </a>
</div>

<div class="form-card mb-5">
    <div class="form-header-gradient bg-success-grad">
        <h5 class="fw-bold m-0"><i class="bi bi-arrow-left-right me-2"></i> Form Peminjaman Baru</h5>
        <p class="small text-white-50 m-0 mt-1">Buat transaksi peminjaman barang inventaris untuk pengguna.</p>
    </div>
    
    <div class="form-body">
        <form action="{{ route('loans.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label class="form-label" for="user_id">Pilih Pengguna / Anggota</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-person-fill text-slate-500"></i></span>
                    <select id="user_id" name="user_id" class="form-select" required>
                        <option value="" disabled selected>-- Pilih Anggota Peminjam --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('user_id')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label class="form-label" for="item_id">Pilih Barang yang Tersedia</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-box-seam-fill text-slate-500"></i></span>
                    <select id="item_id" name="item_id" class="form-select" required>
                        <option value="" disabled selected>-- Pilih Barang --</option>
                        @foreach($items as $item)
                            <option value="{{ $item->id }}" {{ old('item_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->name }} (Kode: {{ $item->item_code }} | Stok: {{ $item->stock }})
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('item_id')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label class="form-label" for="quantity">Jumlah Pinjam</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-hash text-slate-500"></i></span>
                    <input type="number" id="quantity" name="quantity" class="form-control" min="1" placeholder="1" required value="{{ old('quantity', 1) }}">
                </div>
                @error('quantity')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-4">
                <label class="form-label" for="return_date">Tanggal Pengembalian (Tenggat)</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-calendar-event text-slate-500"></i></span>
                    <input type="date" id="return_date" name="return_date" class="form-control" required min="{{ date('Y-m-d') }}" value="{{ old('return_date', now()->addDays(7)->format('Y-m-d')) }}">
                </div>
                @error('return_date')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
            
            <button type="submit" class="btn btn-success w-100 py-2.5">
                <i class="bi bi-check-circle-fill"></i> Proses Peminjaman
            </button>
        </form>
    </div>
</div>
@endsection