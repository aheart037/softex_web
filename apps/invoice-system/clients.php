<?php
/**
 * Client Management Controller
 * Handles CRUD operations for corporate and individual client profiles.
 */
require_once 'config.php';
require_login();

$error = '';
$success = '';

// 1. Delete Client Action
if (isset($_GET['delete_id'])) {
    $delete_id = (int)$_GET['delete_id'];
    try {
        $stmt = $pdo->prepare("DELETE FROM clients WHERE id = ?");
        $stmt->execute([$delete_id]);
        $_SESSION['flash_success'] = "Client deleted successfully.";
        header("Location: clients.php");
        exit;
    } catch (PDOException $e) {
        $error = "Failed to delete client: " . $e->getMessage();
    }
}

// 2. Handle Add / Edit Client Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_client'])) {
    $client_id = isset($_POST['client_id']) ? (int)$_POST['client_id'] : 0;
    $name = trim($_POST['name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $address = trim($_POST['address'] ?? '');

    if (empty($name)) {
        $error = "Client Name is required.";
    } else {
        try {
            if ($client_id > 0) {
                // Update existing client
                $stmt = $pdo->prepare("UPDATE clients SET name = ?, phone = ?, email = ?, address = ? WHERE id = ?");
                $stmt->execute([$name, $phone, $email, $address, $client_id]);
                $_SESSION['flash_success'] = "Client updated successfully.";
            } else {
                // Add new client
                $stmt = $pdo->prepare("INSERT INTO clients (name, phone, email, address) VALUES (?, ?, ?, ?)");
                $stmt->execute([$name, $phone, $email, $address]);
                $_SESSION['flash_success'] = "Client registered successfully.";
            }
            header("Location: clients.php");
            exit;
        } catch (PDOException $e) {
            $error = "Database Error: " . $e->getMessage();
        }
    }
}

// 3. Load Selected Client for Editing
$edit_client = null;
if (isset($_GET['edit_id'])) {
    $edit_id = (int)$_GET['edit_id'];
    $stmt = $pdo->prepare("SELECT * FROM clients WHERE id = ? LIMIT 1");
    $stmt->execute([$edit_id]);
    $edit_client = $stmt->fetch();
}

// 4. Query & Search Clients
$search = trim($_GET['search'] ?? '');
try {
    if (!empty($search)) {
        $stmt = $pdo->prepare("SELECT * FROM clients WHERE name LIKE ? OR phone LIKE ? OR email LIKE ? OR address LIKE ? ORDER BY name ASC");
        $like_search = '%' . $search . '%';
        $stmt->execute([$like_search, $like_search, $like_search, $like_search]);
    } else {
        $stmt = $pdo->query("SELECT * FROM clients ORDER BY name ASC");
    }
    $clients = $stmt->fetchAll();
} catch (PDOException $e) {
    $error = "Failed to query clients: " . $e->getMessage();
    $clients = [];
}

include 'header.php';
?>

<!-- Form Error or success warnings -->
<?php if ($error): ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="bi bi-exclamation-triangle-fill me-2"></i><?= h($error) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<div class="row g-4">
  <!-- Left Column: Clients List -->
  <div class="col-lg-8 col-12 order-2 order-lg-1">
    <div class="card border-0 shadow-sm">
      <div class="card-header bg-white py-3">
        <form action="clients.php" method="GET">
          <div class="row align-items-center g-2">
            <div class="col">
              <h5 class="fw-bold mb-0 text-dark">Client Directory</h5>
            </div>
            <div class="col-md-5 col-12">
              <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search clients..." value="<?= h($search) ?>">
                <button type="submit" class="btn btn-outline-primary py-2 px-3">
                  <i class="bi bi-search"></i>
                </button>
                <?php if (!empty($search)): ?>
                  <a href="clients.php" class="btn btn-outline-secondary py-2 px-3" title="Clear Search">
                    <i class="bi bi-x-lg"></i>
                  </a>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </form>
      </div>
      
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th class="ps-4">Client Details</th>
                <th>Phone Number</th>
                <th>Email Address</th>
                <th>Physical Address</th>
                <th class="pe-4 text-center" style="width: 120px;">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($clients)): ?>
                <tr>
                  <td colspan="5" class="text-center py-5 text-muted">
                    <i class="bi bi-people fs-1 d-block mb-3 text-secondary opacity-30"></i>
                    No clients found in the database.
                  </td>
                </tr>
              <?php else: ?>
                <?php foreach ($clients as $client): ?>
                  <tr>
                    <td class="ps-4">
                      <div class="d-flex align-items-center gap-3">
                        <div class="bg-primary-subtle text-primary rounded-circle p-2 font-bold d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; font-weight: 700; font-size: 0.85rem;">
                          <?= strtoupper(substr($client['name'], 0, 2)) ?>
                        </div>
                        <div>
                          <span class="fw-bold text-dark d-block"><?= h($client['name']) ?></span>
                          <span class="text-muted d-block small" style="font-size: 0.75rem;">ID: <?= $client['id'] ?></span>
                        </div>
                      </div>
                    </td>
                    <td>
                      <span class="text-dark small"><i class="bi bi-telephone text-muted me-1"></i><?= h($client['phone'] ?: 'N/A') ?></span>
                    </td>
                    <td>
                      <span class="text-dark small"><i class="bi bi-envelope text-muted me-1"></i><?= h($client['email'] ?: 'N/A') ?></span>
                    </td>
                    <td>
                      <span class="text-muted small text-truncate d-inline-block" style="max-width: 200px;" title="<?= h($client['address']) ?>">
                        <?= h($client['address'] ?: 'N/A') ?>
                      </span>
                    </td>
                    <td class="pe-4 text-center">
                      <div class="btn-group">
                        <a href="clients.php?edit_id=<?= $client['id'] ?>&search=<?= h($search) ?>" class="btn btn-sm btn-light" title="Edit Client">
                          <i class="bi bi-pencil-square text-primary"></i>
                        </a>
                        <a href="clients.php?delete_id=<?= $client['id'] ?>" class="btn btn-sm btn-light text-danger" title="Delete Client" onclick="return confirm('Are you sure you want to delete this client? This will delete all their invoices as well!')">
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
  </div>

  <!-- Right Column: Add / Edit Client Panel Form -->
  <div class="col-lg-4 col-12 order-1 order-lg-2">
    <div class="card border-0 shadow-sm position-sticky" style="top: 90px;">
      <div class="card-header bg-white py-3">
        <h5 class="fw-bold mb-0 text-dark">
          <?= $edit_client ? '<i class="bi bi-pencil-square me-2 text-warning"></i>Modify Client' : '<i class="bi bi-person-plus me-2 text-primary"></i>Add Client' ?>
        </h5>
      </div>
      <div class="card-body">
        <form action="clients.php" method="POST">
          <input type="hidden" name="client_id" value="<?= $edit_client ? (int)$edit_client['id'] : 0 ?>">
          
          <div class="mb-3">
            <label for="name" class="form-label fw-semibold text-secondary small">Client / Corporate Name <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" class="form-control" placeholder="e.g. Alpha Tech Pvt Ltd" required value="<?= h($edit_client['name'] ?? '') ?>">
          </div>
          
          <div class="mb-3">
            <label for="phone" class="form-label fw-semibold text-secondary small">Contact Phone Number</label>
            <input type="text" name="phone" id="phone" class="form-control" placeholder="e.g. +92 345 0000000" value="<?= h($edit_client['phone'] ?? '') ?>">
          </div>
          
          <div class="mb-3">
            <label for="email" class="form-label fw-semibold text-secondary small">Billing Email Address</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="e.g. billing@client.com" value="<?= h($edit_client['email'] ?? '') ?>">
          </div>
          
          <div class="mb-4">
            <label for="address" class="form-label fw-semibold text-secondary small">Office / Physical Address</label>
            <textarea name="address" id="address" class="form-control" rows="3" placeholder="Street Address, City, Country"><?= h($edit_client['address'] ?? '') ?></textarea>
          </div>
          
          <div class="d-grid gap-2">
            <button type="submit" name="submit_client" class="btn btn-primary">
              <i class="bi bi-check-lg me-1"></i>
              <?= $edit_client ? 'Save Client Changes' : 'Register New Client' ?>
            </button>
            <?php if ($edit_client): ?>
              <a href="clients.php" class="btn btn-light">
                Cancel Edit
              </a>
            <?php endif; ?>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>
