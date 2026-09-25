<?php
/**
 * Invoices Directory
 * Displays all generated invoices, status metrics, and query filters.
 */
require_once 'config.php';
require_login();

$error = '';

// 1. Toggle Payment Status Action
if (isset($_GET['toggle_id'])) {
    $toggle_id = (int)$_GET['toggle_id'];
    try {
        // Fetch current status
        $stmt = $pdo->prepare("SELECT status FROM invoices WHERE id = ?");
        $stmt->execute([$toggle_id]);
        $current_status = $stmt->fetchColumn();
        
        if ($current_status) {
            $new_status = ($current_status === 'UNPAID') ? 'PAID' : 'UNPAID';
            $update_stmt = $pdo->prepare("UPDATE invoices SET status = ? WHERE id = ?");
            $update_stmt->execute([$new_status, $toggle_id]);
            $_SESSION['flash_success'] = "Invoice payment status marked as " . $new_status . ".";
        }
        header("Location: invoices.php");
        exit;
    } catch (PDOException $e) {
        $error = "Failed to toggle status: " . $e->getMessage();
    }
}

// 2. Delete Invoice Action
if (isset($_GET['delete_id'])) {
    $delete_id = (int)$_GET['delete_id'];
    try {
        $stmt = $pdo->prepare("DELETE FROM invoices WHERE id = ?");
        $stmt->execute([$delete_id]);
        $_SESSION['flash_success'] = "Invoice deleted successfully.";
        header("Location: invoices.php");
        exit;
    } catch (PDOException $e) {
        $error = "Failed to delete invoice: " . $e->getMessage();
    }
}

// 3. Retrieve Clients for search filter dropdown
try {
    $clients_stmt = $pdo->query("SELECT id, name FROM clients ORDER BY name ASC");
    $all_clients = $clients_stmt->fetchAll();
} catch (PDOException $e) {
    $all_clients = [];
}

// 4. Build Search & Filter SQL Query
$search = trim($_GET['search'] ?? '');
$filter_client = isset($_GET['client_id']) ? (int)$_GET['client_id'] : 0;
$filter_status = trim($_GET['status'] ?? '');

$sql = "SELECT i.*, c.name as client_name, c.email as client_email,
        (SELECT SUM(ii.total) FROM invoice_items ii WHERE ii.invoice_id = i.id) as grand_total
        FROM invoices i
        JOIN clients c ON i.client_id = c.id
        WHERE 1=1";

$params = [];

if (!empty($search)) {
    $sql .= " AND (i.invoice_number LIKE ? OR c.name LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

if ($filter_client > 0) {
    $sql .= " AND i.client_id = ?";
    $params[] = $filter_client;
}

if (!empty($filter_status) && in_array($filter_status, ['PAID', 'UNPAID'])) {
    $sql .= " AND i.status = ?";
    $params[] = $filter_status;
}

$sql .= " ORDER BY i.created_at DESC";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $invoices = $stmt->fetchAll();
} catch (PDOException $e) {
    $error = "Database Error: " . $e->getMessage();
    $invoices = [];
}

include 'header.php';
?>

<!-- Alert displays -->
<?php if ($error): ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="bi bi-exclamation-triangle-fill me-2"></i><?= h($error) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<!-- Filter & Search Controls card -->
<div class="card border-0 shadow-sm mb-4">
  <div class="card-body p-4">
    <form action="invoices.php" method="GET" class="row g-3 align-items-end">
      <!-- Search Input -->
      <div class="col-lg-4 col-md-6 col-12">
        <label for="search" class="form-label fw-semibold text-secondary small">Search Invoice / Client</label>
        <div class="input-group">
          <span class="input-group-text bg-white text-muted"><i class="bi bi-search"></i></span>
          <input type="text" name="search" id="search" class="form-control" placeholder="e.g. INV-0001 or Client Name" value="<?= h($search) ?>">
        </div>
      </div>
      
      <!-- Client Dropdown -->
      <div class="col-lg-3 col-md-3 col-12">
        <label for="client_id" class="form-label fw-semibold text-secondary small">Filter by Client</label>
        <select name="client_id" id="client_id" class="form-select">
          <option value="0">All Clients</option>
          <?php foreach ($all_clients as $client): ?>
            <option value="<?= $client['id'] ?>" <?= $filter_client === (int)$client['id'] ? 'selected' : '' ?>>
              <?= h($client['name']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- Status Dropdown -->
      <div class="col-lg-2 col-md-3 col-12">
        <label for="status" class="form-label fw-semibold text-secondary small">Filter Status</label>
        <select name="status" id="status" class="form-select">
          <option value="">All Statuses</option>
          <option value="PAID" <?= $filter_status === 'PAID' ? 'selected' : '' ?>>PAID</option>
          <option value="UNPAID" <?= $filter_status === 'UNPAID' ? 'selected' : '' ?>>UNPAID</option>
        </select>
      </div>

      <!-- Action Buttons -->
      <div class="col-lg-3 col-12 d-flex gap-2">
        <button type="submit" class="btn btn-primary flex-grow-1">
          <i class="bi bi-funnel-fill me-2"></i>Filter
        </button>
        <?php if (!empty($search) || $filter_client > 0 || !empty($filter_status)): ?>
          <a href="invoices.php" class="btn btn-outline-secondary">
            <i class="bi bi-x-circle"></i> Clear
          </a>
        <?php endif; ?>
      </div>
    </form>
  </div>
</div>

<!-- Invoice Records Listing -->
<div class="card border-0 shadow-sm">
  <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
    <h5 class="fw-bold mb-0 text-dark">Invoice Ledgers</h5>
    <span class="badge bg-light text-dark py-2 px-3 border rounded-pill"><?= count($invoices) ?> Statement(s) Found</span>
  </div>
  
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th class="ps-4">Invoice No.</th>
            <th>Client Name</th>
            <th>Invoice Date</th>
            <th>Due Date</th>
            <th class="text-end" style="width: 150px;">Total Amount</th>
            <th class="text-center" style="width: 150px;">Payment Status</th>
            <th class="pe-4 text-center" style="width: 250px;">Action Suite</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($invoices)): ?>
            <tr>
              <td colspan="7" class="text-center py-5 text-muted">
                <i class="bi bi-receipt-cutoff fs-1 d-block mb-3 text-secondary opacity-30"></i>
                No matching invoice statements found.
              </td>
            </tr>
          <?php else: ?>
            <?php foreach ($invoices as $invoice): ?>
              <tr>
                <td class="ps-4">
                  <a href="invoice-view.php?id=<?= $invoice['id'] ?>" class="fw-bold text-decoration-none text-indigo" style="color: var(--primary-color);">
                    <?= h($invoice['invoice_number']) ?>
                  </a>
                </td>
                <td>
                  <div class="fw-semibold text-dark"><?= h($invoice['client_name']) ?></div>
                  <span class="text-muted text-xs d-block" style="font-size: 0.75rem;"><?= h($invoice['client_email']) ?></span>
                </td>
                <td>
                  <span class="text-secondary small"><?= h($invoice['invoice_date']) ?></span>
                </td>
                <td>
                  <?php 
                    $due = strtotime($invoice['due_date']);
                    $today = strtotime(date('Y-m-d'));
                    $is_overdue = ($due < $today && $invoice['status'] === 'UNPAID');
                  ?>
                  <span class="small <?= $is_overdue ? 'text-danger fw-bold' : 'text-secondary' ?>">
                    <?= h($invoice['due_date']) ?>
                    <?php if ($is_overdue): ?>
                      <span class="badge bg-danger-subtle text-danger p-1 text-xs" style="font-size: 0.65rem;">OVERDUE</span>
                    <?php endif; ?>
                  </span>
                </td>
                <td class="text-end fw-bold text-dark">
                  <?= format_currency($invoice['grand_total']) ?>
                </td>
                <td class="text-center">
                  <?php if ($invoice['status'] === 'PAID'): ?>
                    <span class="badge badge-paid rounded-pill">PAID</span>
                  <?php else: ?>
                    <span class="badge badge-unpaid rounded-pill">UNPAID</span>
                  <?php endif; ?>
                </td>
                <td class="pe-4 text-center">
                  <div class="btn-group gap-1">
                    <!-- Quick Toggle Button -->
                    <?php if ($invoice['status'] === 'UNPAID'): ?>
                      <a href="invoices.php?toggle_id=<?= $invoice['id'] ?>" class="btn btn-sm btn-outline-success" title="Mark as Paid">
                        <i class="bi bi-check-circle-fill"></i> <span class="d-none d-xl-inline small">Pay</span>
                      </a>
                    <?php else: ?>
                      <a href="invoices.php?toggle_id=<?= $invoice['id'] ?>" class="btn btn-sm btn-outline-warning" title="Mark as Unpaid">
                        <i class="bi bi-x-circle-fill"></i> <span class="d-none d-xl-inline small">Unpay</span>
                      </a>
                    <?php endif; ?>
                    
                    <!-- View Link -->
                    <a href="invoice-view.php?id=<?= $invoice['id'] ?>" class="btn btn-sm btn-light" title="View Detail">
                      <i class="bi bi-eye text-primary"></i>
                    </a>
                    
                    <!-- Edit Link -->
                    <a href="invoice-edit.php?id=<?= $invoice['id'] ?>" class="btn btn-sm btn-light" title="Edit Invoice">
                      <i class="bi bi-pencil-square text-dark"></i>
                    </a>
                    
                    <!-- Delete Link -->
                    <a href="invoices.php?delete_id=<?= $invoice['id'] ?>" class="btn btn-sm btn-light text-danger" title="Delete Invoice" onclick="return confirm('Are you sure you want to permanently delete this invoice? This cannot be undone!')">
                      <i class="bi bi-trash"></i>
                    </a>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>
