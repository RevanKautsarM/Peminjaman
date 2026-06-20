@extends('layout.app')

@section('content')
<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark m-0">Inventaris Barang</h3>
        <p class="text-muted small m-0">Kelola dan pantau seluruh stok barang inventaris kantor.</p>
    </div>
    <a href="{{ route('items.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Tambah Barang Baru
    </a>
</div>

<!-- Metrics Cards Row -->
<div class="row g-4 mb-4">
    <!-- Total Barang -->
    <div class="col-12 col-md-6 col-lg-3">
        <div class="metric-card metric-primary">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="metric-value">{{ $items->count() }}</div>
                    <div class="metric-label">Total Item</div>
                </div>
                <div class="metric-icon-wrapper bg-primary-light">
                    <i class="bi bi-box-seam"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Total Stok -->
    <div class="col-12 col-md-6 col-lg-3">
        <div class="metric-card metric-success">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="metric-value">{{ $items->sum('stock') }}</div>
                    <div class="metric-label">Total Unit Stok</div>
                </div>
                <div class="metric-icon-wrapper bg-success-light">
                    <i class="bi bi-stack"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Barang Ready -->
    <div class="col-12 col-md-6 col-lg-3">
        <div class="metric-card metric-warning">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="metric-value">{{ $items->where('stock', '>', 0)->count() }}</div>
                    <div class="metric-label">Kategori Tersedia</div>
                </div>
                <div class="metric-icon-wrapper bg-warning-light">
                    <i class="bi bi-check-circle"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Barang Habis -->
    <div class="col-12 col-md-6 col-lg-3">
        <div class="metric-card metric-danger">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="metric-value">{{ $items->where('stock', 0)->count() }}</div>
                    <div class="metric-label">Kategori Habis</div>
                </div>
                <div class="metric-icon-wrapper bg-danger-light">
                    <i class="bi bi-exclamation-octagon"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Table Panel -->
<div class="panel-card mb-4">
    <div class="panel-header">
        <h5 class="panel-title">
            <i class="bi bi-list-task text-primary"></i> Daftar Inventaris
        </h5>
        <span class="badge bg-light text-dark fw-bold px-3 py-2 border rounded-pill">
            {{ $items->count() }} Data Barang
        </span>
    </div>
    
    <div class="custom-table-container">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                <tr>
                    <td class="fw-bold text-primary">{{ $item->item_code }}</td>
                    <td>{{ $item->name }}</td>
                    <td>
                        <span class="badge bg-light text-dark border px-2.5 py-1.5 rounded">
                            {{ $item->category }}
                        </span>
                    </td>
                    <td class="fw-bold">{{ $item->stock }}</td>
                    <td>
                        @if($item->status == 'tersedia')
                            <span class="badge-pill badge-success-grad">
                                <i class="bi bi-check-circle"></i> Tersedia
                            </span>
                        @else
                            <span class="badge-pill badge-danger-grad">
                                <i class="bi bi-dash-circle"></i> Habis
                            </span>
                        @endif
                    </td>
                    <td class="text-end">
                        <div class="d-inline-flex gap-2">
                            <a href="{{ route('items.edit', $item->id) }}" class="btn btn-sm btn-warning text-white">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <form action="{{ route('items.destroy', $item->id) }}" method="POST" class="d-inline m-0">
                                @csrf 
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus barang {{ $item->name }}?')">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                        <i class="bi bi-box-seam d-block fs-1 mb-3 text-slate-300"></i>
                        Belum ada data barang. Klik tombol <strong>Tambah Barang Baru</strong> di atas untuk menambahkan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection