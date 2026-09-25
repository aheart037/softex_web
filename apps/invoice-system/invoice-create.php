<?php
/**
 * Create Invoice Controller
 * Features dynamic multi-item invoice scheduling, validation, and real-time computation.
 */
require_once 'config.php';
require_login();

$error = '';
$success = '';

// Retrieve all clients for selection dropdown
try {
    $clients_stmt = $pdo->query("SELECT id, name, email FROM clients ORDER BY name ASC");
    $clients = $clients_stmt->fetchAll();
} catch (PDOException $e) {
    $clients = [];
}

// Generate the automatic invoice number
$next_invoice_number = generate_next_invoice_number();

// Handle Invoice Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_invoice'])) {
    $client_id = (int)($_POST['client_id'] ?? 0);
    $invoice_number = trim($_POST['invoice_number'] ?? '');
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
    } elseif (empty($invoice_number)) {
        $error = "Invoice number cannot be empty.";
    } elseif (empty($invoice_date) || empty($due_date)) {
        $error = "Please provide both Invoice and Due dates.";
    } elseif (empty($descriptions) || count($descriptions) === 0) {
        $error = "Please add at least one line item to the invoice.";
    } else {
        try {
            // Start db transaction to ensure integrity across tables
            $pdo->beginTransaction();

            // 1. Insert Invoice Header
            $stmt = $pdo->prepare("INSERT INTO invoices (invoice_number, client_id, invoice_date, due_date, status, notes) 
                                   VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$invoice_number, $client_id, $invoice_date, $due_date, $status, $notes]);
            $invoice_id = $pdo->lastInsertId();

            // 2. Insert Invoice Items
            $item_stmt = $pdo->prepare("INSERT INTO invoice_items (invoice_id, description, price, discount, total) 
                                        VALUES (?, ?, ?, ?, ?)");

            for ($i = 0; $i < count($descriptions); $i++) {
                $desc = trim($descriptions[$i]);
                $price = (float)$prices[$i];
                $disc = (float)($discounts[$i] ?? 0.00);
                
                if (empty($desc)) {
                    continue; // Skip empty rows
                }
                
                // Calculate item total
                $total = $price - $disc;
                if ($total < 0) $total = 0; // Prevent negative totals

                $item_stmt->execute([$invoice_id, $desc, $price, $disc, $total]);
            }

            // Commit transaction
            $pdo->commit();

            $_SESSION['flash_success'] = "Invoice {$invoice_number} created successfully.";
            header("Location: invoice-view.php?id=" . $invoice_id);
            exit;

        } catch (PDOException $e) {
            $pdo->rollBack();
            $error = "Failed to create invoice statement: " . $e->getMessage();
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

<form action="invoice-create.php" method="POST" id="invoice-form">
  <div class="row g-4">
    <!-- Left Column: Primary Details -->
    <div class="col-lg-8 col-12">
      <!-- 1. Metadata Block -->
      <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
          <h6 class="fw-bold mb-0 text-dark">Invoice Header & Schedule</h6>
        </div>
        <div class="card-body p-4">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="invoice_number" class="form-label fw-semibold text-secondary small">Invoice Number</label>
              <input type="text" name="invoice_number" id="invoice_number" class="form-control bg-light fw-bold text-primary" readonly value="<?= h($next_invoice_number) ?>">
              <span class="text-xs text-muted" style="font-size: 0.75rem;">Automatically sequenced.</span>
            </div>
            
            <div class="col-md-6">
              <label for="client_id" class="form-label fw-semibold text-secondary small">Select Client <span class="text-danger">*</span></label>
              <?php if (empty($clients)): ?>
                <div class="d-flex gap-2">
                  <select class="form-select bg-light" disabled>
                    <option>No clients registered yet</option>
                  </select>
                  <a href="clients.php" class="btn btn-outline-primary"><i class="bi bi-person-plus"></i></a>
                </div>
              <?php else: ?>
                <select name="client_id" id="client_id" class="form-select" required>
                  <option value="">-- Choose client profile --</option>
                  <?php foreach ($clients as $client): ?>
                    <option value="<?= $client['id'] ?>"><?= h($client['name']) ?> (<?= h($client['email']) ?>)</option>
                  <?php endforeach; ?>
                </select>
              <?php endif; ?>
            </div>

            <div class="col-md-6">
              <label for="invoice_date" class="form-label fw-semibold text-secondary small">Invoice Date <span class="text-danger">*</span></label>
              <input type="date" name="invoice_date" id="invoice_date" class="form-control" required value="<?= date('Y-m-d') ?>">
            </div>

            <div class="col-md-6">
              <label for="due_date" class="form-label fw-semibold text-secondary small">Due Date <span class="text-danger">*</span></label>
              <input type="date" name="due_date" id="due_date" class="form-control" required value="<?= date('Y-m-d', strtotime('+7 days')) ?>">
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
                <!-- Row Template -->
                <tr class="item-row">
                  <td class="ps-4">
                    <input type="text" name="item_description[]" class="form-control item-desc" placeholder="e.g. Dedicated Cloud Server Subscription" required>
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
            <input class="form-check-input ms-0" type="checkbox" role="switch" id="payment_received" name="payment_received" value="1" style="width: 2.5em; height: 1.25em;">
          </div>

          <div class="mb-4">
            <label for="notes" class="form-label fw-semibold text-secondary small">Invoice Notes / Work Specifications</label>
            <textarea name="notes" id="notes" class="form-control" rows="3" placeholder="e.g. Terms, project delivery schedule details..."></textarea>
          </div>

          <div class="d-grid gap-2">
            <button type="submit" name="create_invoice" class="btn btn-primary btn-lg fs-6 py-3">
              <i class="bi bi-file-earmark-check me-2"></i> Save and Generate Invoice
            </button>
            <a href="invoices.php" class="btn btn-light py-2">
              Cancel & Exit
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
              <input type="text" name="item_description[]" class="form-control item-desc" placeholder="e.g. Project Phase Milestone" required>
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
            // Ensure we don't delete the last remaining row
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
