<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Aplikasi Peminjaman Barang Inventaris Kantor Premium">
    <title>Peminjaman</title>
    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom Style -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>
<body>
    <div class="app-container">
        <!-- Sidebar Navigation -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-brand">
                <i class="bi bi-box-seam-fill fs-3 text-primary"></i>
                <span>Peminjaman</span>
            </div>
            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('items.index') }}" class="sidebar-link {{ Request::routeIs('items.*') ? 'active' : '' }}">
                        <i class="bi bi-grid-1x2-fill"></i>
                        <span>Daftar Barang</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('loans.index') }}" class="sidebar-link {{ Request::routeIs('loans.*') ? 'active' : '' }}">
                        <i class="bi bi-arrow-left-right"></i>
                        <span>Transaksi Pinjam</span>
                    </a>
                </li>
            </ul>
        </aside>

        <!-- Mobile Header -->
        <header class="mobile-header">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-box-seam-fill fs-4 text-primary"></i>
                <span class="fw-bold">Peminjaman</span>
            </div>
            <button class="btn btn-dark p-2" id="sidebar-toggle" aria-label="Toggle Sidebar">
                <i class="bi bi-list fs-4"></i>
            </button>
        </header>

        <!-- Main Content Area -->
        <main class="main-content">
            <!-- Flash Notifications -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4 animate-fade-in" role="alert">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-check-circle-fill fs-5"></i>
                        <div>{{ session('success') }}</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-4 animate-fade-in" role="alert">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                        <div>{{ session('error') }}</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Page Content -->
            <div class="animate-fade-in">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Sidebar Toggle Script (Mobile Support) -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('sidebar-toggle');
            const sidebar = document.getElementById('sidebar');
            
            if (toggleBtn && sidebar) {
                toggleBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    sidebar.classList.toggle('open');
                });
                
                // Close sidebar when clicking outside on mobile
                document.addEventListener('click', function(event) {
                    const isClickInside = sidebar.contains(event.target) || toggleBtn.contains(event.target);
                    if (!isClickInside && sidebar.classList.contains('open')) {
                        sidebar.classList.remove('open');
                    }
                });
            }
        });
    </script>
</body>
</html>