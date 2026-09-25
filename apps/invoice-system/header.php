<?php
/**
 * Global Header Template – Redesigned with Brand Colors
 * Dark theme, gradient accents, full contrast.
 */
require_once 'config.php';
require_login();

$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Softex Invoice Management System</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css" rel="stylesheet">
  <!-- Google Fonts (Inter + Space Grotesk) -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
  
  <style>
    :root {
      --brand-pink: #F20D5A;
      --brand-coral: #F44A6A;
      --brand-orange: #F78B3D;
      --brand-yellow: #FBBF24;
      --brand-grad: linear-gradient(135deg, #F20D5A, #F44A6A, #F78B3D, #FBBF24);
      --brand-grad-hover: linear-gradient(135deg, #F44A6A, #F78B3D, #FBBF24, #F20D5A);
      
      --sidebar-bg: #0a0c10;
      --sidebar-hover: rgba(242, 13, 90, 0.08);
      --sidebar-active: rgba(242, 13, 90, 0.12);
      --topbar-bg: #0f1119;
      --card-bg: #0f1119;
      --border-light: rgba(242, 13, 90, 0.15);
      --text-light: #f1f5f9;
      --text-muted: #94a3b8;
      --sidebar-width: 260px;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: radial-gradient(circle at 10% 20%, #0a0b10, #020308);
      color: var(--text-light);
      overflow-x: hidden;
    }

    /* Scrollbar matching brand */
    ::-webkit-scrollbar {
      width: 6px;
      height: 6px;
    }
    ::-webkit-scrollbar-track {
      background: #1e293b;
    }
    ::-webkit-scrollbar-thumb {
      background: var(--brand-coral);
      border-radius: 4px;
    }
    ::-webkit-scrollbar-thumb:hover {
      background: var(--brand-orange);
    }

    /* ========== SIDEBAR ========== */
    .sidebar {
      position: fixed;
      top: 0;
      bottom: 0;
      left: 0;
      width: var(--sidebar-width);
      z-index: 100;
      background: var(--sidebar-bg);
      border-right: 1px solid var(--border-light);
      transition: all 0.3s ease;
      backdrop-filter: blur(4px);
    }

    .sidebar-brand {
      height: 70px;
      display: flex;
      align-items: center;
      padding: 0 1.5rem;
      border-bottom: 1px solid var(--border-light);
    }

    .brand-icon {
      background: var(--brand-grad);
      border-radius: 12px;
      width: 36px;
      height: 36px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 0.75rem;
    }
    .brand-icon i {
      font-size: 1.2rem;
      color: white;
    }
    .brand-text {
      font-family: 'Space Grotesk', monospace;
      font-weight: 700;
      font-size: 1.2rem;
      background: var(--brand-grad);
      background-clip: text;
      -webkit-background-clip: text;
      color: transparent;
      line-height: 1.2;
    }
    .brand-sub {
      font-size: 0.6rem;
      letter-spacing: 1px;
      color: var(--text-muted);
    }

    .sidebar-menu {
      padding: 1.5rem 0;
      height: calc(100vh - 140px);
      overflow-y: auto;
    }

    .menu-item {
      display: flex;
      align-items: center;
      padding: 0.7rem 1.5rem;
      color: var(--text-muted);
      text-decoration: none;
      transition: all 0.2s ease;
      font-weight: 500;
      border-left: 3px solid transparent;
      margin-bottom: 0.25rem;
      font-size: 0.9rem;
    }

    .menu-item:hover {
      color: var(--text-light);
      background: var(--sidebar-hover);
    }

    .menu-item.active {
      color: var(--brand-yellow);
      background: var(--sidebar-active);
      border-left-color: var(--brand-orange);
    }

    .menu-item i {
      font-size: 1.2rem;
      margin-right: 1rem;
      width: 24px;
      text-align: center;
    }

    .menu-item.active i {
      color: var(--brand-orange);
    }

    .sidebar-footer {
      height: 70px;
      border-top: 1px solid var(--border-light);
      display: flex;
      align-items: center;
      padding: 0 1.5rem;
      background: rgba(2, 3, 8, 0.5);
    }

    .user-avatar {
      background: var(--brand-grad);
      border-radius: 40px;
      width: 36px;
      height: 36px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      color: white;
      margin-right: 0.75rem;
    }

    /* ========== MAIN WRAPPER ========== */
    .main-wrapper {
      margin-left: var(--sidebar-width);
      transition: all 0.3s ease;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    /* ========== TOP NAVBAR ========== */
    .top-navbar {
      height: 70px;
      background: var(--topbar-bg);
      border-bottom: 1px solid var(--border-light);
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 2rem;
      position: sticky;
      top: 0;
      z-index: 99;
      backdrop-filter: blur(8px);
    }

    .page-title {
      font-family: 'Space Grotesk', monospace;
      font-weight: 600;
      color: var(--text-light);
      margin: 0;
    }

    .btn-create {
      background: var(--brand-grad);
      border: none;
      border-radius: 40px;
      padding: 0.5rem 1.2rem;
      font-weight: 600;
      color: white;
      transition: all 0.3s ease;
    }
    .btn-create:hover {
      background: var(--brand-grad-hover);
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(242,13,90,0.3);
    }

    .mobile-toggle {
      display: none;
      background: transparent;
      border: 1px solid var(--border-light);
      border-radius: 8px;
      padding: 0.4rem 0.7rem;
      color: var(--text-light);
    }

    /* Flash messages */
    .alert-flash {
      border-radius: 12px;
      margin-bottom: 1.5rem;
      background: rgba(15, 17, 25, 0.9);
      border-left: 4px solid var(--brand-orange);
      color: var(--text-light);
    }

    /* Footer */
    footer.app-footer {
      background: var(--topbar-bg);
      border-top: 1px solid var(--border-light);
      padding: 1rem 2rem;
      text-align: center;
      color: var(--text-muted);
      font-size: 0.75rem;
    }

    @media (max-width: 991.98px) {
      .sidebar {
        margin-left: calc(-1 * var(--sidebar-width));
      }
      .sidebar.show {
        margin-left: 0;
      }
      .main-wrapper {
        margin-left: 0;
      }
      .mobile-toggle {
        display: block;
      }
    }
  </style>
</head>
<body>

<!-- Sidebar -->
<aside class="sidebar" id="app-sidebar">
  <div class="sidebar-brand">
    <div class="brand-icon">
      <i class="bi bi-receipt-cutoff"></i>
    </div>
    <div>
      <div class="brand-text">Softex Invoicing</div>
      <div class="brand-sub">MANAGEMENT PORTAL</div>
    </div>
  </div>
  
  <div class="sidebar-menu">
    <a href="index.php" class="menu-item <?= ($current_page == 'index.php') ? 'active' : '' ?>">
      <i class="bi bi-speedometer2"></i>
      <span>Dashboard</span>
    </a>
    <a href="clients.php" class="menu-item <?= (in_array($current_page, ['clients.php', 'client-add.php', 'client-edit.php'])) ? 'active' : '' ?>">
      <i class="bi bi-people"></i>
      <span>Clients</span>
    </a>
    <a href="invoices.php" class="menu-item <?= (in_array($current_page, ['invoices.php', 'invoice-create.php', 'invoice-edit.php', 'invoice-view.php'])) ? 'active' : '' ?>">
      <i class="bi bi-file-earmark-ruled"></i>
      <span>Invoices</span>
    </a>
    <a href="settings.php" class="menu-item <?= ($current_page == 'settings.php') ? 'active' : '' ?>">
      <i class="bi bi-gear"></i>
      <span>Settings</span>
    </a>
  </div>

  <div class="sidebar-footer">
    <div class="d-flex align-items-center w-100">
      <div class="user-avatar">
        <?= strtoupper(substr($_SESSION['admin_name'] ?? 'SA', 0, 2)) ?>
      </div>
      <div class="flex-grow-1 overflow-hidden">
        <div class="text-white text-truncate" style="font-size: 0.85rem;"><?= h($_SESSION['admin_name'] ?? 'Admin') ?></div>
        <div class="text-muted text-truncate" style="font-size: 0.7rem;color:white;"><?= h($_SESSION['admin_user'] ?? 'admin@softex.pk') ?></div>
      </div>
      <a href="logout.php" class="text-danger" onclick="return confirm('Are you sure you want to log out?')">
        <i class="bi bi-box-arrow-right fs-5"></i>
      </a>
    </div>
  </div>
</aside>

<!-- Main Wrapper -->
<div class="main-wrapper">
  <!-- Top Navbar -->
  <header class="top-navbar">
    <div class="d-flex align-items-center gap-3">
      <button class="mobile-toggle" id="sidebar-toggle-btn" aria-label="Toggle Sidebar">
        <i class="bi bi-list"></i>
      </button>
      <h5 class="page-title mb-0">
        <?php
          $titles = [
            'index.php' => 'Overview Dashboard',
            'clients.php' => 'Client Registry',
            'invoices.php' => 'Billing Invoices',
            'invoice-create.php' => 'New Billing Invoice',
            'invoice-edit.php' => 'Edit Invoice Details',
            'invoice-view.php' => 'Invoice Summary',
            'settings.php' => 'System Preferences'
          ];
          echo $titles[$current_page] ?? 'Invoice Management';
        ?>
      </h5>
    </div>
    
    <div class="d-flex align-items-center gap-3">
      <div class="text-end d-none d-md-block">
        <div class="text-muted small">Today's Date</div>
        <div class="text-light fw-semibold small"><?= date('F d, Y') ?></div>
      </div>
      <div class="vr text-light opacity-25 d-none d-md-block"></div>
      <a href="invoice-create.php" class="btn btn-create d-flex align-items-center gap-2">
        <i class="bi bi-plus-lg"></i>
        <span>Create Invoice</span>
      </a>
    </div>
  </header>

  <!-- Page Content -->
  <main class="page-content">
    <?= display_flash_message() ?>