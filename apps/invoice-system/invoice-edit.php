<?php
/**
 * Invoice Edit Controller
 * Safely updates invoice records, dates, notes, and dynamic line items.
 */
require_once 'config.php';
require_login();

$error = '';
$invoice_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($invoice_id <= 0) {
    $_SESSION['flash_error'] = "Invalid invoice statement specified.";
    header("Location: invoices.php");
    exit;
}

// Fetch invoice header
try {
    $stmt = $pdo->prepare("SELECT * FROM invoices WHERE id = ? LIMIT 1");
    $stmt->execute([$invoice_id]);
    $invoice = $stmt->fetch();
    
    if (!$invoice) {
        $_SESSION['flash_error'] = "Invoice statement not found in the registry.";
        header("Location: invoices.php");
        exit;
    }
} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}

// Fetch invoice line items
try {
    $items_stmt = $pdo->prepare("SELECT * FROM invoice_items WHERE invoice_id = ? ORDER BY id ASC");
    $items_stmt->execute([$invoice_id]);
    $invoice_items = $items_stmt->fetchAll();
} catch (PDOException $e) {
    die("Database Error loading items: " . $e->getMessage());
}

// Retrieve all clients for selection dropdown
try {
    $clients_stmt = $pdo->query("SELECT id, name, email FROM clients ORDER BY name ASC");
    $clients = $clients_stmt->fetchAll();
} catch (PDOException $e) {
    $clients = [];
}

// Handle Invoice Updates
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_invoice'])) {
    $client_id = (int)($_POST['client_id'] ?? 0);
    $invoice_date = $_POST['invoice_date'] ?? '';
    $due_date = $_POST['due_date'] ?? '';
    $notes = trim($_POST['notes'] ?? '');
    $status = isset($_POST['payment_received']) && $_POST['payment_received'] == '1' ? 'PAID' : 'UNPAID';

    // Invoice items arrays
    $descriptions = $_POST['item_description'] ?? [];
    $prices = $_POST['item_price'] ?? [];
    $discounts = $_POST['item_discount'] ?? [];

    if ($client_id <= 0) {
        $error = "Please select a valid client.";
    } elseif (empty($invoice_date) || empty($due_date)) {
        $error = "Please provide both Invoice and Due dates.";
    } elseif (empty($descriptions) || count($descriptions) === 0) {
        $error = "Please add at least one line item.";
    } else {
        try {
            // Start transaction
            $pdo->beginTransaction();

            // 1. Update Invoice Header
            $stmt = $pdo->prepare("UPDATE invoices SET client_id = ?, invoice_date = ?, due_date = ?, status = ?, notes = ? 
                                   WHERE id = ?");
            $stmt->execute([$client_id, $invoice_date, $due_date, $status, $notes, $invoice_id]);

            // 2. Clear out older invoice items
            $delete_items_stmt = $pdo->prepare("DELETE FROM invoice_items WHERE invoice_id = ?");
            $delete_items_stmt->execute([$invoice_id]);

            // 3. Re-insert Invoice items
            $item_stmt = $pdo->prepare("INSERT INTO invoice_items (invoice_id, description, price, discount, total) 
                                        VALUES (?, ?, ?, ?, ?)");

            for ($i = 0; $i < count($descriptions); $i++) {
                $desc = trim($descriptions[$i]);
                $price = (float)$prices[$i];
                $disc = (float)($discounts[$i] ?? 0.00);
                
                if (empty($desc)) {
                    continue; // Skip empty rows
                }
                
                $total = $price - $disc;
                if ($total < 0) $total = 0;

                $item_stmt->execute([$invoice_id, $desc, $price, $disc, $total]);
            }

            // Commit transaction
            $pdo->commit();

            $_SESSION['flash_success'] = "Invoice {$invoice['invoice_number']} updated successfully.";
            header("Location: invoice-view.php?id=" . $invoice_id);
            exit;

        } catch (PDOException $e) {
            $pdo->rollBack();
            $error = "Failed to update invoice statement: " . $e->getMessage();
        }
    }
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

<form action="invoice-edit.php?id=<?= $invoice_id ?>" method="POST" id="invoice-form">
  <div class="row g-4">
    <!-- Left Column: Primary Details -->
    <div class="col-lg-8 col-12">
      <!-- 1. Metadata Block -->
      <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
          <h6 class="fw-bold mb-0 text-dark">Modify Invoice Schedule - <span class="text-primary"><?= h($invoice['invoice_number']) ?></span></h6>
        </div>
        <div class="card-body p-4">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label fw-semibold text-secondary small">Invoice Number</label>
              <input type="text" class="form-control bg-light fw-bold text-dark" readonly value="<?= h($invoice['invoice_number']) ?>">
              <span class="text-xs text-muted" style="font-size: 0.75rem;">Cannot change unique invoice number format.</span>
            </div>
            
            <div class="col-md-6">
              <label for="client_id" class="form-label fw-semibold text-secondary small">Select Client <span class="text-danger">*</span></label>
              <select name="client_id" id="client_id" class="form-select" required>
                <option value="">-- Choose client profile --</option>
                <?php foreach ($clients as $client): ?>
                  <option value="<?= $client['id'] ?>" <?= (int)$invoice['client_id'] === (int)$client['id'] ? 'selected' : '' ?>>
                    <?= h($client['name']) ?> (<?= h($client['email']) ?>)
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-md-6">
              <label for="invoice_date" class="form-label fw-semibold text-secondary small">Invoice Date <span class="text-danger">*</span></label>
              <input type="date" name="invoice_date" id="invoice_date" class="form-control" required value="<?= h($invoice['invoice_date']) ?>">
            </div>

            <div class="col-md-6">
              <label for="due_date" class="form-label fw-semibold text-secondary small">Due Date <span class="text-danger">*</span></label>
              <input type="date" name="due_date" id="due_date" class="form-control" required value="<?= h($invoice['due_date']) ?>">
            </div>
          </div>
        </div>
      </div>

      <!-- 2. Dynamic Items Block -->
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
          <h6 class="fw-bold mb-0 text-dark">Invoice Line Items</h6>
          <button type="button" class="btn btn-sm btn-outline-primary" id="btn-add-item">
            <i class="bi bi-plus-circle me-1"></i> Add Line Item
          </button>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table align-middle mb-0" id="invoice-items-table">
              <thead class="table-light">
                <tr>
                  <th class="ps-4">Item Description <span class="text-danger">*</span></th>
                  <th style="width: 150px;">Unit Price (Rs.)</th>
                  <th style="width: 120px;">Discount (Rs.)</th>
                  <th class="text-end" style="width: 150px;">Total (Rs.)</th>
                  <th class="text-center pe-4" style="width: 80px;">Action</th>
                </tr>
              </thead>
              <tbody id="items-container">
                <?php if (empty($invoice_items)): ?>
                  <!-- Fallback template row if item list is empty -->
                  <tr class="item-row">
                    <td class="ps-4">
                      <input type="text" name="item_description[]" class="form-control item-desc" placeholder="e.g. Service Description" required>
                    </td>
                    <td>
                      <input type="number" name="item_price[]" class="form-control text-end item-price" placeholder="0.00" step="0.01" min="0" required value="0.00">
                    </td>
                    <td>
                      <input type="number" name="item_discount[]" class="form-control text-end item-discount" placeholder="0.00" step="0.01" min="0" value="0.00">
                    </td>
                    <td class="text-end fw-bold text-dark pe-3">
                      <span class="row-total-val">0.00</span>
                    </td>
                    <td class="text-center pe-4">
                      <button type="button" class="btn btn-sm btn-light text-danger btn-remove-row" style="border: none;">
                        <i class="bi bi-trash"></i>
                      </button>
                    </td>
                  </tr>
                <?php else: ?>
                  <?php foreach ($invoice_items as $item): ?>
                    <tr class="item-row">
                      <td class="ps-4">
                        <input type="text" name="item_description[]" class="form-control item-desc" placeholder="e.g. Service Description" required value="<?= h($item['description']) ?>">
                      </td>
                      <td>
                        <input type="number" name="item_price[]" class="form-control text-end item-price" placeholder="0.00" step="0.01" min="0" required value="<?= (float)$item['price'] ?>">
                      </td>
                      <td>
                        <input type="number" name="item_discount[]" class="form-control text-end item-discount" placeholder="0.00" step="0.01" min="0" value="<?= (float)$item['discount'] ?>">
                      </td>
                      <td class="text-end fw-bold text-dark pe-3">
                        <span class="row-total-val"><?= number_of_format((float)$item['total']) ?></span>
                      </td>
                      <td class="text-center pe-4">
                        <button type="button" class="btn btn-sm btn-light text-danger btn-remove-row" style="border: none;">
                          <i class="bi bi-trash"></i>
                        </button>
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

    <!-- Right Column: Summary Card and Action Panel -->
    <div class="col-lg-4 col-12">
      <!-- Summary Block -->
      <div class="card border-0 shadow-sm mb-4 position-sticky" style="top: 90px;">
        <div class="card-header bg-white py-3">
          <h6 class="fw-bold mb-0 text-dark">Invoice Totals Summary</h6>
        </div>
        <div class="card-body">
          <div class="d-flex justify-content-between mb-2">
            <span class="text-secondary small">Gross Subtotal</span>
            <span class="fw-semibold text-dark" id="summary-subtotal">Rs. 0.00</span>
          </div>
          <div class="d-flex justify-content-between mb-2">
            <span class="text-secondary small">Total Discount Applied</span>
            <span class="fw-semibold text-danger" id="summary-discount">-Rs. 0.00</span>
          </div>
          <hr class="my-3">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <span class="fw-bold text-dark">Grand Total</span>
            <span class="fs-4 fw-bold text-primary" id="summary-grand-total">Rs. 0.00</span>
          </div>

          <!-- Payment Received Status toggle -->
          <div class="form-check form-switch mb-4 p-3 bg-light rounded-3 d-flex align-items-center justify-content-between border" style="padding-left: 3rem !important;">
            <div>
              <label class="form-check-label fw-bold text-dark" for="payment_received">Payment Received</label>
              <span class="text-xs text-muted d-block" style="font-size: 0.75rem;">Mark immediately as PAID.</span>
            </div>
            <input class="form-check-input ms-0" type="checkbox" role="switch" id="payment_received" name="payment_received" value="1" style="width: 2.5em; height: 1.25em;" <?= $invoice['status'] === 'PAID' ? 'checked' : '' ?>>
          </div>

          <div class="mb-4">
            <label for="notes" class="form-label fw-semibold text-secondary small">Invoice Notes / Work Specifications</label>
            <textarea name="notes" id="notes" class="form-control" rows="3" placeholder="e.g. Terms, project delivery schedule details..."><?= h($invoice['notes'] ?? '') ?></textarea>
          </div>

          <div class="d-grid gap-2">
            <button type="submit" name="update_invoice" class="btn btn-primary btn-lg fs-6 py-3">
              <i class="bi bi-file-earmark-check-fill me-2"></i> Update Statement Details
            </button>
            <a href="invoice-view.php?id=<?= $invoice_id ?>" class="btn btn-light py-2">
              Back to Summary
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const itemsContainer = document.getElementById('items-container');
    const btnAddItem = document.getElementById('btn-add-item');
    const summarySubtotal = document.getElementById('summary-subtotal');
    const summaryDiscount = document.getElementById('summary-discount');
    const summaryGrandTotal = document.getElementById('summary-grand-total');

    // 1. Calculate and update calculations
    function calculateInvoice() {
        let subtotal = 0;
        let totalDiscount = 0;
        let grandTotal = 0;

        const rows = document.querySelectorAll('.item-row');
        rows.forEach(function(row) {
            const priceInput = row.querySelector('.item-price');
            const discountInput = row.querySelector('.item-discount');
            const rowTotalSpan = row.querySelector('.row-total-val');

            const price = parseFloat(priceInput.value) || 0;
            const discount = parseFloat(discountInput.value) || 0;

            const total = Math.max(0, price - discount);
            rowTotalSpan.textContent = total.toFixed(2);

            subtotal += price;
            totalDiscount += discount;
            grandTotal += total;
        });

        // Update overall summaries
        summarySubtotal.textContent = "Rs. " + subtotal.toFixed(2);
        summaryDiscount.textContent = "-Rs. " + totalDiscount.toFixed(2);
        summaryGrandTotal.textContent = "Rs. " + grandTotal.toFixed(2);
    }

    // 2. Add dynamic Row
    btnAddItem.addEventListener('click', function() {
        const newRow = document.createElement('tr');
        newRow.className = 'item-row';
        newRow.innerHTML = `
            <td class="ps-4">
              <input type="text" name="item_description[]" class="form-control item-desc" placeholder="e.g. Service Description" required>
            </td>
            <td>
              <input type="number" name="item_price[]" class="form-control text-end item-price" placeholder="0.00" step="0.01" min="0" required value="0.00">
            </td>
            <td>
              <input type="number" name="item_discount[]" class="form-control text-end item-discount" placeholder="0.00" step="0.01" min="0" value="0.00">
            </td>
            <td class="text-end fw-bold text-dark pe-3">
              <span class="row-total-val">0.00</span>
            </td>
            <td class="text-center pe-4">
              <button type="button" class="btn btn-sm btn-light text-danger btn-remove-row" style="border: none;">
                <i class="bi bi-trash"></i>
              </button>
            </td>
        `;
        itemsContainer.appendChild(newRow);
        attachRowEvents(newRow);
        calculateInvoice();
    });

    // 3. Remove row and recalculate
    itemsContainer.addEventListener('click', function(e) {
        if (e.target.closest('.btn-remove-row')) {
            const row = e.target.closest('.item-row');
            const totalRows = document.querySelectorAll('.item-row').length;
            if (totalRows > 1) {
                row.remove();
                calculateInvoice();
            } else {
                alert("An invoice must contain at least one line item.");
            }
        }
    });

    // 4. Attach input event listeners for dynamic recalculations
    function attachRowEvents(row) {
        const inputs = row.querySelectorAll('.item-price, .item-discount');
        inputs.forEach(function(input) {
            input.addEventListener('input', calculateInvoice);
        });
    }

    // Attach to initial rows
    document.querySelectorAll('.item-row').forEach(attachRowEvents);

    // Run initial computation
    calculateInvoice();
});
</script>

<?php include 'footer.php'; ?>
