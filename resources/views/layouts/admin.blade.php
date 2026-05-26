<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard') - TripWay</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
:root {
--primary: #30525c;
            --primary-dark: #24414a;
            --secondary: #1D4ED8;
            --text-dark: #111827;
            --text-medium: #4B5563;
            --text-light: #6B7280;
            --bg-light: #F1F5F9;
            --border: #D1D5DB;
            --white: #FFFFFF;
            --shadow: 0 2px 8px rgba(0,0,0,0.08);
            --shadow-lg: 0 4px 20px rgba(0,0,0,0.12);
            --radius: 12px;
            --radius-sm: 8px;
            --sidebar-width: 260px;
            --sidebar-bg: #0F172A;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            color: var(--text-dark);
            background: var(--bg-light);
            line-height: 1.6;
        }

        a { text-decoration: none; color: inherit; }

        /* Layout */
        .admin-layout {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--text-dark);
            color: #aaa;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
        }
        .sidebar-header {
            padding: 24px;
            border-bottom: 1px solid #333;
        }
        .sidebar-header .logo {
            font-size: 20px;
            font-weight: 800;
            color: var(--white);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .sidebar-header .logo i { color: var(--primary); }
        .sidebar-user {
            padding: 16px 24px;
            border-bottom: 1px solid #333;
            font-size: 13px;
            color: #888;
        }
        .sidebar-user strong {
            color: var(--white);
            font-size: 14px;
            display: block;
        }
        .sidebar-nav {
            padding: 16px 0;
        }
        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 24px;
            font-size: 14px;
            color: #aaa;
            transition: all 0.2s;
        }
        .sidebar-nav a:hover,
        .sidebar-nav a.active {
            background: rgba(255,255,255,0.05);
            color: var(--white);
        }
        .sidebar-nav a i {
            width: 20px;
            text-align: center;
        }
        .sidebar-footer {
            padding: 16px 24px;
            border-top: 1px solid #333;
            margin-top: auto;
        }
        .sidebar-footer a {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #888;
            font-size: 13px;
        }
        .sidebar-footer a:hover { color: var(--white); }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding: 32px;
        }

        /* Header */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
        }
        .page-header h1 {
            font-size: 24px;
            font-weight: 700;
        }

        /* Cards */
        .card {
            background: var(--white);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            overflow: hidden;
        }
        .card-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .card-header h2 {
            font-size: 16px;
            font-weight: 600;
        }
        .card-body {
            padding: 24px;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 32px;
        }
        .stat-card {
            background: var(--white);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            padding: 24px;
        }
        .stat-card .label {
            font-size: 13px;
            color: var(--text-light);
            margin-bottom: 8px;
        }
        .stat-card .value {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-dark);
        }
        .stat-card .icon {
            width: 40px;
            height: 40px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            margin-bottom: 12px;
        }
        .stat-card .icon.blue { background: #e3f2fd; color: #1976d2; }
        .stat-card .icon.green { background: #e8f5e9; color: #388e3c; }
        .stat-card .icon.orange { background: #fff3e0; color: #f57c00; }
        .stat-card .icon.red { background: #ffebee; color: #d32f2f; }

        /* Tables */
        .table-responsive { overflow-x: auto; }
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }
        .data-table th,
        .data-table td {
            padding: 12px 16px;
            text-align: left;
            font-size: 14px;
            border-bottom: 1px solid var(--border);
        }
        .data-table th {
            font-weight: 600;
            color: var(--text-medium);
            background: var(--bg-light);
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .data-table tr:last-child td { border-bottom: none; }
        .data-table tr:hover td { background: var(--bg-light); }

        /* Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .badge-pending { background: #fff3e0; color: #f57c00; }
        .badge-confirmed { background: #e8f5e9; color: #388e3c; }
        .badge-cancelled { background: #ffebee; color: #d32f2f; }
        .badge-completed { background: #e3f2fd; color: #1976d2; }
        .badge-featured { background: #fff3e0; color: #f57c00; }
        .badge-active { background: #e8f5e9; color: #388e3c; }
        .badge-inactive { background: #ffebee; color: #d32f2f; }
        .badge-fake { background: #f3e5f5; color: #7b1fa2; }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 20px;
            border-radius: var(--radius-sm);
            font-size: 14px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            gap: 6px;
        }
        .btn-primary {
            background: var(--primary);
            color: var(--white);
        }
        .btn-primary:hover { background: var(--primary-dark); }
        .btn-secondary {
            background: var(--bg-light);
            color: var(--text-medium);
            border: 1px solid var(--border);
        }
        .btn-secondary:hover { background: var(--border); }
        .btn-danger {
            background: #dc3545;
            color: var(--white);
        }
        .btn-danger:hover { background: #c82333; }
        .btn-sm { padding: 6px 12px; font-size: 13px; }
        .btn-icon {
            width: 32px;
            height: 32px;
            padding: 0;
            border-radius: var(--radius-sm);
        }

        /* Forms */
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 6px;
            color: var(--text-dark);
        }
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            font-size: 14px;
            outline: none;
            font-family: inherit;
        }
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: var(--primary);
        }
        .form-group textarea {
            resize: vertical;
            min-height: 120px;
        }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }
        .form-check {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .form-check input {
            width: auto;
        }

        /* Alerts */
        .alert {
            padding: 16px 20px;
            border-radius: var(--radius-sm);
            margin-bottom: 24px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .alert-success {
            background: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #a5d6a7;
        }
        .alert-danger {
            background: #ffebee;
            color: #c62828;
            border: 1px solid #ef9a9a;
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 4px;
            margin-top: 24px;
        }
        .pagination a,
        .pagination span {
            padding: 8px 14px;
            border-radius: var(--radius-sm);
            font-size: 14px;
            border: 1px solid var(--border);
            background: var(--white);
        }
        .pagination .active {
            background: var(--primary);
            color: var(--white);
            border-color: var(--primary);
        }

        /* Two Columns */
        .two-columns {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .two-columns { grid-template-columns: 1fr; }
        }
        @media (max-width: 768px) {
            .sidebar { width: 100%; position: relative; height: auto; }
            .main-content { margin-left: 0; }
            .admin-layout { flex-direction: column; }
            .stats-grid { grid-template-columns: 1fr; }
        }
    </style>

    @yield('styles')
</head>
<body>
    <div class="admin-layout">
        <aside class="sidebar">
            <div class="sidebar-header">
                <a href="{{ route('landing') }}" class="logo">
                    <i class="fas fa-paper-plane"></i>
                    TripWay Admin
                </a>
            </div>
            <div class="sidebar-user">
                <strong>{{ auth()->user()->name }}</strong>
                {{ auth()->user()->email }}
            </div>
            <nav class="sidebar-nav">
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i> Dashboard
                </a>
                <a href="{{ route('admin.tours.index') }}" class="{{ request()->routeIs('admin.tours.*') ? 'active' : '' }}">
                    <i class="fas fa-map-marked-alt"></i> Kelola Tour
                </a>
                <a href="{{ route('admin.packages.index') }}" class="{{ request()->routeIs('admin.packages.*') ? 'active' : '' }}">
                    <i class="fas fa-box-open"></i> Kelola Paket
                </a>
                <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i class="fas fa-tags"></i> Kategori
                </a>
                <a href="{{ route('admin.destinations.index') }}" class="{{ request()->routeIs('admin.destinations.*') ? 'active' : '' }}">
                    <i class="fas fa-globe-asia"></i> Destinasi
                </a>
                <a href="{{ route('admin.bookings.index') }}" class="{{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-check"></i> Booking
                </a>
<a href="{{ route('admin.reviews.index') }}" class="{{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
                    <i class="fas fa-star"></i> Review & Fake Review
                </a>
                <a href="{{ route('admin.payments.index') }}" class="{{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
                    <i class="fas fa-credit-card"></i> Pembayaran
                </a>
            </nav>
            <div class="sidebar-footer">
                <a href="{{ route('landing') }}">
                    <i class="fas fa-arrow-left"></i> Kembali ke Website
                </a>
            </div>
        </aside>

        <main class="main-content">
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @yield('scripts')

{{-- Global Delete Modal --}}
<div id="admin-delete-modal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.55); z-index:99999; align-items:center; justify-content:center;">
    <div style="background:white; border-radius:16px; padding:32px 28px; max-width:420px; width:90%; text-align:center; box-shadow:0 24px 60px rgba(0,0,0,0.25); animation:modalIn 0.2s ease;">
        <div style="width:64px; height:64px; background:#fef2f2; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 18px;">
            <i class="fas fa-trash-alt" style="font-size:26px; color:#dc2626;"></i>
        </div>
        <h3 style="font-size:18px; font-weight:800; color:#1e293b; margin:0 0 8px;">Konfirmasi Hapus</h3>
        <p style="font-size:13px; color:#64748b; margin:0 0 6px;">Anda akan menghapus:</p>
        <p id="admin-modal-item" style="font-size:14px; font-weight:700; color:#dc2626; margin:0 0 8px; padding:8px 16px; background:#fef2f2; border-radius:8px;"></p>
        <p style="font-size:12px; color:#94a3b8; margin:0 0 24px;">Tindakan ini <strong>tidak dapat dibatalkan</strong>.</p>
        <div style="display:flex; gap:10px;">
            <button onclick="closeAdminModal()" style="flex:1; padding:12px; border-radius:10px; border:1px solid #e2e8f0; background:white; color:#64748b; font-size:14px; font-weight:600; cursor:pointer; transition:all 0.2s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='white'">
                <i class="fas fa-times" style="margin-right:6px;"></i>Batal
            </button>
            <button onclick="submitAdminDelete()" style="flex:1; padding:12px; border-radius:10px; border:none; background:#dc2626; color:white; font-size:14px; font-weight:700; cursor:pointer; transition:all 0.2s;" onmouseover="this.style.background='#b91c1c'" onmouseout="this.style.background='#dc2626'">
                <i class="fas fa-trash-alt" style="margin-right:6px;"></i>Ya, Hapus
            </button>
        </div>
    </div>
</div>

<style>
@keyframes modalIn {
    from { opacity:0; transform:scale(0.92) translateY(-10px); }
    to   { opacity:1; transform:scale(1) translateY(0); }
}
</style>

<script>
let _adminDeleteForm = null;

function confirmAdminDelete(formId, itemName) {
    _adminDeleteForm = document.getElementById(formId);
    document.getElementById('admin-modal-item').textContent = itemName;
    const modal = document.getElementById('admin-delete-modal');
    modal.style.display = 'flex';
}

function closeAdminModal() {
    document.getElementById('admin-delete-modal').style.display = 'none';
    _adminDeleteForm = null;
}

function submitAdminDelete() {
    if (_adminDeleteForm) _adminDeleteForm.submit();
}

document.getElementById('admin-delete-modal').addEventListener('click', function(e) {
    if (e.target === this) closeAdminModal();
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeAdminModal();
});
</script>
</body>
</html>

