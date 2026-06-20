@extends('layout.app')

@section('content')
<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark m-0">Transaksi Peminjaman</h3>
        <p class="text-muted small m-0">Catat, pantau, dan kelola peminjaman barang inventaris.</p>
    </div>
    <a href="{{ route('loans.create') }}" class="btn btn-success">
        <i class="bi bi-plus-lg"></i> Buat Peminjaman Baru
    </a>
</div>

<!-- Metrics Cards Row -->
<div class="row g-4 mb-4">
    <!-- Total Transaksi -->
    <div class="col-12 col-md-6 col-lg-3">
        <div class="metric-card metric-primary">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="metric-value">{{ $loans->count() }}</div>
                    <div class="metric-label">Total Transaksi</div>
                </div>
                <div class="metric-icon-wrapper bg-primary-light">
                    <i class="bi bi-file-earmark-text"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Sedang Dipinjam -->
    <div class="col-12 col-md-6 col-lg-3">
        <div class="metric-card metric-warning">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="metric-value">{{ $loans->where('status', 'dipinjam')->count() }}</div>
                    <div class="metric-label">Sedang Dipinjam</div>
                </div>
                <div class="metric-icon-wrapper bg-warning-light">
                    <i class="bi bi-hourglass-split"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Sudah Kembali -->
    <div class="col-12 col-md-6 col-lg-3">
        <div class="metric-card metric-success">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="metric-value">{{ $loans->where('status', 'dikembalikan')->count() }}</div>
                    <div class="metric-label">Sudah Kembali</div>
                </div>
                <div class="metric-icon-wrapper bg-success-light">
                    <i class="bi bi-arrow-counterclockwise"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Terlambat -->
    <div class="col-12 col-md-6 col-lg-3">
        <div class="metric-card metric-danger">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="metric-value">{{ $loans->filter(fn($l) => $l->status === 'dipinjam' && $l->return_date->lt(today()))->count() }}</div>
                    <div class="metric-label">Terlambat</div>
                </div>
                <div class="metric-icon-wrapper bg-danger-light">
                    <i class="bi bi-clock-history"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Table Panel -->
<div class="panel-card mb-4">
    <div class="panel-header">
        <h5 class="panel-title">
            <i class="bi bi-clock-history text-success"></i> Riwayat Transaksi Peminjaman
        </h5>
        <span class="badge bg-light text-dark fw-bold px-3 py-2 border rounded-pill">
            {{ $loans->count() }} Transaksi
        </span>
    </div>
    
    <div class="custom-table-container">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Nama Peminjam</th>
                    <th>Barang</th>
                    <th>Qty</th>
                    <th>Tgl Pinjam</th>
                    <th>Tenggat Pengembalian</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($loans as $loan)
                @php
                    $isOverdue = $loan->status === 'dipinjam' && $loan->return_date->lt(today());
                @endphp
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle bg-light border d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                <i class="bi bi-person text-slate-600"></i>
                            </div>
                            <div>
                                <span class="fw-bold d-block text-dark">{{ $loan->user->name }}</span>
                                <span class="text-muted small" style="font-size: 0.75rem;">{{ $loan->user->email }}</span>
                            </div>
                        </div>
                    </td>
                    <td>{{ $loan->loanDetails->first()->item->name ?? 'Barang Terhapus' }}</td>
                    <td class="fw-bold">{{ $loan->loanDetails->first()->quantity ?? 0 }}</td>
                    <td>{{ $loan->loan_date->format('d M Y') }}</td>
                    <td class="{{ $isOverdue ? 'text-danger fw-bold' : '' }}">
                        {{ $loan->return_date->format('d M Y') }}
                        @if($isOverdue)
                            <span class="d-block text-danger small" style="font-size: 0.75rem;">(Lewat Tenggat)</span>
                        @endif
                    </td>
                    <td>
                        @if($isOverdue)
                            <span class="badge-pill badge-danger-grad">
                                <i class="bi bi-clock-history"></i> Terlambat
                            </span>
                        @elseif($loan->status == 'dipinjam')
                            <span class="badge-pill badge-warning-grad">
                                <i class="bi bi-hourglass-split"></i> Dipinjam
                            </span>
                        @else
                            <span class="badge-pill badge-success-grad">
                                <i class="bi bi-check-circle"></i> Dikembalikan
                            </span>
                        @endif
                    </td>
                    <td class="text-end">
                        @if($loan->status == 'dipinjam')
                        <form action="{{ route('loans.return', $loan->id) }}" method="POST" class="d-inline m-0">
                            @csrf 
                            @method('PUT')
                            <button type="submit" class="btn btn-sm btn-primary">
                                <i class="bi bi-arrow-counterclockwise"></i> Kembalikan Barang
                            </button>
                        </form>
                        @else
                        <button class="btn btn-sm btn-secondary" disabled>
                            <i class="bi bi-check-all"></i> Selesai
                        </button>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="bi bi-arrow-left-right d-block fs-1 mb-3 text-slate-300"></i>
                        Belum ada transaksi peminjaman. Klik tombol <strong>Buat Peminjaman Baru</strong> di atas untuk memulai transaksi.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection