<?php
/**
 * Dashboard Overview Panel - Fully Consistent Dark Theme with Brand Accents
 */
require_once 'config.php';
require_login();

try {
    $total_invoices = $pdo->query("SELECT COUNT(*) FROM invoices")->fetchColumn();
    $paid_invoices = $pdo->query("SELECT COUNT(*) FROM invoices WHERE status = 'PAID'")->fetchColumn();
    $unpaid_invoices = $pdo->query("SELECT COUNT(*) FROM invoices WHERE status = 'UNPAID'")->fetchColumn();
    
    $total_revenue = $pdo->query("SELECT SUM(ii.total) FROM invoice_items ii JOIN invoices i ON ii.invoice_id = i.id WHERE i.status = 'PAID'")->fetchColumn() ?: 0.00;
    $total_outstanding = $pdo->query("SELECT SUM(ii.total) FROM invoice_items ii JOIN invoices i ON ii.invoice_id = i.id WHERE i.status = 'UNPAID'")->fetchColumn() ?: 0.00;
    
    $recent_invoices = $pdo->query("SELECT i.*, c.name as client_name, (SELECT SUM(ii.total) FROM invoice_items ii WHERE ii.invoice_id = i.id) as grand_total FROM invoices i JOIN clients c ON i.client_id = c.id ORDER BY i.created_at DESC LIMIT 5")->fetchAll();
    $recent_clients = $pdo->query("SELECT * FROM clients ORDER BY created_at DESC LIMIT 5")->fetchAll();
} catch (PDOException $e) {
    die("Data Query Error: " . $e->getMessage());
}

include 'header.php';
?>

<style>
  :root {
    --brand-pink: #F20D5A;
    --brand-coral: #F44A6A;
    --brand-orange: #F78B3D;
    --brand-yellow: #FBBF24;
    --brand-grad: linear-gradient(135deg, #F20D5A, #F44A6A, #F78B3D, #FBBF24);
    --bg-dark: #0a0c10;
    --bg-card: #0f1119;
    --border-subtle: rgba(242, 13, 90, 0.15);
    --text-light: #f1f5f9;
    --text-muted: #a0a5b5;
  }
  body {
    background: radial-gradient(circle at 10% 20%, var(--bg-dark), #020308);
    color: var(--text-light);
  }
  /* Cards with solid dark background (no transparency) */
  .dashboard-card {
    background: var(--bg-card);
    border: 1px solid var(--border-subtle);
    border-radius: 24px;
    transition: all 0.2s ease;
    box-shadow: 0 8px 20px -6px rgba(0,0,0,0.4);
  }
  .dashboard-card:hover {
    transform: translateY(-4px);
    border-color: var(--brand-orange);
  }
  .metric-icon {
    background: rgba(242, 13, 90, 0.12);
    border-radius: 18px;
    padding: 0.75rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: var(--brand-yellow);
  }
  .metric-value {
    font-family: 'Space Grotesk', monospace;
    font-weight: 800;
    font-size: 1.8rem;
    color: white;
  }
  .metric-label {
    color: var(--text-muted);
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 1px;
  }
  /* Badges */
  .badge-paid, .badge-unpaid {
    padding: 0.35rem 1rem;
    border-radius: 40px;
    font-weight: 600;
    font-size: 0.7rem;
    letter-spacing: 0.5px;
  }
  .badge-paid {
    background: rgba(16, 185, 129, 0.15);
    color: #34d399;
    border: 1px solid rgba(16, 185, 129, 0.3);
  }
  .badge-unpaid {
    background: rgba(239, 68, 68, 0.15);
    color: #f87171;
    border: 1px solid rgba(239, 68, 68, 0.3);
  }
  /* Action Cards */
  .action-link-card {
    background: var(--bg-card);
    border: 1px solid var(--border-subtle);
    border-radius: 20px;
    transition: all 0.2s;
    text-decoration: none;
  }
  .action-link-card:hover {
    border-color: var(--brand-yellow);
    transform: translateY(-3px);
  }
  .action-link-card h6 {
    color: white;
    margin-bottom: 0.25rem;
  }
  .action-link-card p {
    color: var(--text-muted);
    margin-bottom: 0;
    font-size: 0.7rem;
  }
  /* Tables */
  .table-custom {
    color: var(--text-light);
  }
  .table-custom th {
    background: rgba(15, 17, 25, 0.9);
    color: var(--text-light);
    font-weight: 600;
    border-bottom: 1px solid var(--border-subtle);
  }
  .table-custom td {
    color: var(--text-muted);
    border-color: rgba(242, 13, 90, 0.08);
    vertical-align: middle;
  }
  .table-custom a {
    color: var(--brand-orange);
    text-decoration: none;
  }
  .table-custom a:hover {
    color: var(--brand-yellow);
  }
  .btn-outline-brand {
    border: 1px solid var(--brand-orange);
    color: var(--brand-orange);
    background: transparent;
    border-radius: 40px;
    padding: 0.3rem 1rem;
    font-size: 0.75rem;
    transition: all 0.2s;
  }
  .btn-outline-brand:hover {
    background: var(--brand-grad);
    border-color: transparent;
    color: white;
  }
  /* List group for clients */
  .list-group-item-custom {
    background: var(--bg-card);
    border-bottom: 1px solid var(--border-subtle);
    color: var(--text-light);
  }
  .list-group-item-custom:hover {
    background: rgba(242, 13, 90, 0.05);
  }
  .progress-bar-brand {
    background: var(--brand-grad);
  }
  .text-brand {
    color: var(--brand-orange);
  }
  .border-brand-bottom {
    border-bottom: 1px solid var(--border-subtle);
  }
</style>

<!-- Metric Cards Row -->
<div class="row g-4 mb-4">
  <div class="col-xl-3 col-md-6">
    <div class="dashboard-card p-3 h-100">
      <div class="d-flex justify-content-between align-items-start mb-3">
        <div class="metric-icon"><i class="bi bi-cash-stack fs-3"></i></div>
        <span class="badge-paid px-2 py-1">PAID</span>
      </div>
      <h3 class="metric-value mb-1"><?= format_currency($total_revenue) ?></h3>
      <p class="metric-label mb-0">Total revenue from <?= $paid_invoices ?> invoices</p>
    </div>
  </div>
  <div class="col-xl-3 col-md-6">
    <div class="dashboard-card p-3 h-100">
      <div class="d-flex justify-content-between align-items-start mb-3">
        <div class="metric-icon"><i class="bi bi-clock-history fs-3"></i></div>
        <span class="badge-unpaid px-2 py-1">UNPAID</span>
      </div>
      <h3 class="metric-value mb-1"><?= format_currency($total_outstanding) ?></h3>
      <p class="metric-label mb-0">Outstanding from <?= $unpaid_invoices ?> invoices</p>
    </div>
  </div>
  <div class="col-xl-3 col-md-6">
    <div class="dashboard-card p-3 h-100">
      <div class="d-flex justify-content-between align-items-start mb-3">
        <div class="metric-icon"><i class="bi bi-receipt fs-3"></i></div>
      </div>
      <h3 class="metric-value mb-1"><?= $total_invoices ?></h3>
      <p class="metric-label mb-0">Total invoices issued</p>
    </div>
  </div>
  <div class="col-xl-3 col-md-6">
    <div class="dashboard-card p-3 h-100">
      <div class="d-flex justify-content-between align-items-start mb-3">
        <div class="metric-icon"><i class="bi bi-percent fs-3"></i></div>
      </div>
      <?php $collection_rate = ($total_invoices > 0) ? round(($paid_invoices / $total_invoices) * 100) : 0; ?>
      <h3 class="metric-value mb-1"><?= $collection_rate ?>%</h3>
      <div class="progress mt-2" style="height: 6px; background: rgba(255,255,255,0.1);">
        <div class="progress-bar progress-bar-brand" style="width: <?= $collection_rate ?>%"></div>
      </div>
      <p class="metric-label mt-2 mb-0">Collection efficiency</p>
    </div>
  </div>
</div>

<!-- Quick Action Cards -->
<div class="row g-4 mb-5">
  <div class="col-md-4">
    <a href="invoice-create.php" class="action-link-card p-3 d-flex align-items-center gap-3 h-100">
      <div class="metric-icon"><i class="bi bi-file-earmark-plus fs-3"></i></div>
      <div>
        <h6 class="fw-bold mb-1">Create Invoice</h6>
        <p class="small">Generate a new bill</p>
      </div>
    </a>
  </div>
  <div class="col-md-4">
    <a href="clients.php" class="action-link-card p-3 d-flex align-items-center gap-3 h-100">
      <div class="metric-icon"><i class="bi bi-person-plus fs-3"></i></div>
      <div>
        <h6 class="fw-bold mb-1">Add Client</h6>
        <p class="small">Register new client</p>
      </div>
    </a>
  </div>
  <div class="col-md-4">
    <a href="settings.php" class="action-link-card p-3 d-flex align-items-center gap-3 h-100">
      <div class="metric-icon"><i class="bi bi-sliders fs-3"></i></div>
      <div>
        <h6 class="fw-bold mb-1">Settings</h6>
        <p class="small">Configure system</p>
      </div>
    </a>
  </div>
</div>

<!-- Recent Invoices & Clients -->
<div class="row g-4">
  <div class="col-xl-8">
    <div class="dashboard-card p-0">
      <div class="p-3 border-brand-bottom d-flex justify-content-between align-items-center">
        <h5 class="fw-bold text-white mb-0"><i class="bi bi-receipt me-2"></i>Recent Invoices</h5>
        <a href="invoices.php" class="btn-outline-brand">View All</a>
      </div>
      <div class="table-responsive">
        <table class="table table-custom mb-0">
          <thead>
            <tr>
              <th class="ps-3">Invoice #</th>
              <th>Client</th>
              <th>Due Date</th>
              <th class="text-end">Total</th>
              <th class="text-center">Status</th>
              <th class="text-center pe-3">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($recent_invoices)): ?>
              <tr><td colspan="6" class="text-center py-4 text-muted">No invoices found. <a href="invoice-create.php" class="text-brand">Create one</a></td></tr>
            <?php else: foreach ($recent_invoices as $inv): ?>
              <tr>
                <td class="ps-3 fw-semibold"><a href="invoice-view.php?id=<?= $inv['id'] ?>"><?= h($inv['invoice_number']) ?></a></td>
                <td class="text-white"><?= h($inv['client_name']) ?></td>
                <td><?= h($inv['due_date']) ?></td>
                <td class="text-end fw-semibold text-white"><?= format_currency($inv['grand_total']) ?></td>
                <td class="text-center"><?= $inv['status'] === 'PAID' ? '<span class="badge-paid">PAID</span>' : '<span class="badge-unpaid">UNPAID</span>' ?></td>
                <td class="text-center pe-3">
                  <a href="invoice-view.php?id=<?= $inv['id'] ?>" class="btn btn-sm btn-link text-light me-1" title="View"><i class="bi bi-eye"></i></a>
                  <a href="invoice-pdf.php?id=<?= $inv['id'] ?>&download=1" class="btn btn-sm btn-link text-danger" title="PDF"><i class="bi bi-file-pdf"></i></a>
                </td>
              </tr>
            <?php endforeach; endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="col-xl-4">
    <div class="dashboard-card p-0">
      <div class="p-3 border-brand-bottom d-flex justify-content-between align-items-center">
        <h5 class="fw-bold text-white mb-0"><i class="bi bi-people me-2"></i>New Clients</h5>
        <a href="clients.php" class="btn-outline-brand">View All</a>
      </div>
      <div class="list-group list-group-flush">
        <?php if (empty($recent_clients)): ?>
          <div class="p-4 text-center text-muted">No clients added yet.</div>
        <?php else: foreach ($recent_clients as $client): ?>
          <div class="list-group-item list-group-item-custom d-flex justify-content-between align-items-center">
            <div>
              <div class="fw-semibold text-white"><?= h($client['name']) ?></div>
              <div class="small"><?= h($client['email'] ?: 'No email') ?></div>
            </div>
            <a href="clients.php?edit_id=<?= $client['id'] ?>" class="btn btn-sm btn-link text-light"><i class="bi bi-pencil-square"></i></a>
          </div>
        <?php endforeach; endif; ?>
      </div>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>