<?php
/**
 * Login Controller - Redesigned with Brand Colors (No Hardcoded Values)
 */
require_once 'config.php';

// Redirect if already logged in
if (is_logged_in()) {
    header("Location: index.php");
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = "Please enter both username and password.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ? LIMIT 1");
        $stmt->execute([$username]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_user'] = $admin['username'];
            $_SESSION['admin_name'] = $admin['name'];
            
            $_SESSION['flash_success'] = "Welcome back, " . $admin['name'] . "!";
            header("Location: index.php");
            exit;
        } else {
            $error = "Invalid username or password.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | Softex Invoicing Portal</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css" rel="stylesheet">
  <!-- Google Fonts: Inter + Space Grotesk (matching website) -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: radial-gradient(circle at 10% 20%, #0a0b10, #020308);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1rem;
    }

    /* Brand Colors */
    :root {
      --brand-pink: #F20D5A;
      --brand-coral: #F44A6A;
      --brand-orange: #F78B3D;
      --brand-yellow: #FBBF24;
      --brand-grad: linear-gradient(135deg, #F20D5A, #F44A6A, #F78B3D, #FBBF24);
      --bg-card: rgba(15, 17, 25, 0.75);
      --border-glow: rgba(242, 13, 90, 0.3);
    }

    .login-card {
      max-width: 1100px;
      width: 100%;
      background: var(--bg-card);
      backdrop-filter: blur(16px);
      border-radius: 32px;
      overflow: hidden;
      border: 1px solid var(--border-glow);
      box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.4), 0 0 0 1px rgba(242, 13, 90, 0.1);
    }

    /* Left Panel */
    .brand-panel {
      background: rgba(2, 3, 8, 0.7);
      backdrop-filter: blur(12px);
      padding: 3rem;
      height: 100%;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      border-right: 1px solid rgba(242, 13, 90, 0.2);
    }

    .brand-icon {
      width: 48px;
      height: 48px;
      background: linear-gradient(135deg, #F20D5A, #F44A6A);
      border-radius: 16px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 1.5rem;
    }

    .brand-icon i {
      font-size: 1.8rem;
      color: white;
    }

    .brand-title {
      font-family: 'Space Grotesk', monospace;
      font-size: 1.8rem;
      font-weight: 700;
      background: var(--brand-grad);
      background-clip: text;
      -webkit-background-clip: text;
      color: transparent;
      display: inline-block;
    }

    .brand-sub {
      font-size: 0.8rem;
      color: #a0a5b5;
      margin-top: 1rem;
      line-height: 1.6;
    }

    .feature-list {
      list-style: none;
      margin: 2rem 0;
    }

    .feature-list li {
      margin-bottom: 1rem;
      display: flex;
      align-items: center;
      gap: 0.75rem;
      color: #cbd5e1;
      font-size: 0.85rem;
    }

    .feature-list li i {
      color: var(--brand-orange);
      font-size: 1rem;
    }

    .footer-note {
      font-size: 0.7rem;
      color: #6e7485;
      border-top: 1px solid rgba(242, 13, 90, 0.15);
      padding-top: 1rem;
    }

    /* Right Panel (Form) */
    .form-panel {
      padding: 3rem;
      background: rgba(10, 12, 18, 0.5);
    }

    .form-title {
      font-family: 'Space Grotesk', monospace;
      font-size: 1.8rem;
      font-weight: 700;
      color: #ffffff;
      margin-bottom: 0.5rem;
    }

    .form-desc {
      color: #94a3b8;
      font-size: 0.85rem;
      margin-bottom: 2rem;
    }

    .form-control {
      background: rgba(2, 3, 8, 0.6);
      border: 1px solid rgba(242, 13, 90, 0.3);
      border-radius: 12px;
      padding: 0.75rem 1rem;
      color: #ffffff;
      font-size: 0.9rem;
      transition: all 0.2s ease;
    }

    .form-control:focus {
      background: rgba(2, 3, 8, 0.8);
      border-color: var(--brand-orange);
      box-shadow: 0 0 0 3px rgba(247, 139, 61, 0.2);
      color: white;
    }

    .form-control::placeholder {
      color: #6e7485;
    }

    .input-group-text {
      background: rgba(2, 3, 8, 0.6);
      border: 1px solid rgba(242, 13, 90, 0.3);
      border-right: none;
      color: var(--brand-coral);
    }

    .btn-login {
      background: var(--brand-grad);
      border: none;
      border-radius: 40px;
      padding: 0.75rem 1rem;
      font-weight: 600;
      color: white;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(242, 13, 90, 0.3);
    }

    .btn-login:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(242, 13, 90, 0.5);
    }

    .alert {
      background: rgba(239, 68, 68, 0.1);
      border: 1px solid rgba(239, 68, 68, 0.3);
      border-radius: 12px;
      color: #fca5a5;
      font-size: 0.85rem;
    }

    @media (max-width: 768px) {
      .brand-panel {
        display: none;
      }
      .form-panel {
        padding: 2rem;
      }
    }
  </style>
</head>
<body>

<div class="login-card">
  <div class="row g-0">
    <!-- Left Brand Panel (hidden on mobile) -->
    <div class="col-lg-5 d-none d-lg-block">
      <div class="brand-panel">
        <div>
          <div class="brand-icon">
            <i class="bi bi-receipt-cutoff"></i>
          </div>
          <div class="brand-title">Softex Invoicing</div>
          <div class="brand-sub">Secure, smart, and streamlined billing for modern agencies.</div>
          
          <ul class="feature-list">
            <li><i class="bi bi-shield-check"></i> 256‑bit encrypted sessions</li>
            <li><i class="bi bi-graph-up"></i> Real‑time financial analytics</li>
            <li><i class="bi bi-envelope-paper"></i> Automated invoice delivery</li>
            <li><i class="bi bi-cloud-check"></i> GDPR‑compliant data handling</li>
          </ul>
        </div>
        <div class="footer-note">
          <i class="bi bi-c-circle"></i> <?= date('Y') ?> Softex Technologies – Lahore, PK
        </div>
      </div>
    </div>

    <!-- Right Form Panel -->
    <div class="col-lg-7 col-12">
      <div class="form-panel">
        <div class="d-flex align-items-center justify-content-between mb-3 d-lg-none">
          <div class="brand-title" style="font-size: 1.4rem;">Softex Invoicing</div>
        </div>

        <div class="form-title">Welcome back</div>
        <div class="form-desc">Sign in to manage your invoices and clients.</div>

        <!-- Error Alert -->
        <?php if ($error): ?>
          <div class="alert mb-4 d-flex align-items-center gap-2">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <div><?= h($error) ?></div>
          </div>
        <?php endif; ?>

        <form action="login.php" method="POST">
          <div class="mb-3">
            <label for="username" class="form-label text-light small fw-semibold">Username / Email</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-person"></i></span>
              <input type="text" name="username" id="username" class="form-control" placeholder="Enter your username" required autofocus>
            </div>
          </div>

          <div class="mb-4">
            <label for="password" class="form-label text-light small fw-semibold">Password</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-key"></i></span>
              <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
            </div>
          </div>

          <button type="submit" class="btn btn-login w-100 d-flex align-items-center justify-content-center gap-2">
            <span>Access Dashboard</span>
            <i class="bi bi-arrow-right"></i>
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>