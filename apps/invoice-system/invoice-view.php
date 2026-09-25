<?php
/**
 * Invoice View / Detail Controller
 * Core dashboard for a single invoice. Triggers printable templates, PDF generation,
 * WhatsApp message generation, and email dispatch commands.
 */
require_once 'config.php';
require_login();

$invoice_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($invoice_id <= 0) {
    $_SESSION['flash_error'] = "Invalid invoice selected.";
    header("Location: invoices.php");
    exit;
}

try {
    // 1. Fetch Invoice details along with Client details
    $stmt = $pdo->prepare("SELECT i.*, c.name as client_name, c.phone as client_phone, 
                           c.email as client_email, c.address as client_address 
                           FROM invoices i 
                           JOIN clients c ON i.client_id = c.id 
                           WHERE i.id = ? LIMIT 1");
    $stmt->execute([$invoice_id]);
    $invoice = $stmt->fetch();

    if (!$invoice) {
        $_SESSION['flash_error'] = "Invoice not found.";
        header("Location: invoices.php");
        exit;
    }

    // 2. Fetch invoice line items
    $items_stmt = $pdo->prepare("SELECT * FROM invoice_items WHERE invoice_id = ? ORDER BY id ASC");
    $items_stmt->execute([$invoice_id]);
    $invoice_items = $items_stmt->fetchAll();

} catch (PDOException $e) {
    die("Database Query Error: " . $e->getMessage());
}

// 3. Calculations
$subtotal = 0;
$total_discount = 0;
foreach ($invoice_items as $item) {
    $subtotal += $item['price'];
    $total_discount += $item['discount'];
}
$grand_total = $subtotal - $total_discount;

// 4. Generate Pre-filled WhatsApp message
$app_domain = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
$download_url = $app_domain . dirname($_SERVER['PHP_SELF']) . "/invoice-pdf.php?id=" . $invoice_id . "&download=1";

$wa_text = "Hello *" . $invoice['client_name'] . "*,\n\n";
$wa_text .= "Please find a summary of your invoice from *Softex Technologies*:\n\n";
$wa_text .= "• *Invoice Number:* " . $invoice['invoice_number'] . "\n";
$wa_text .= "• *Invoice Date:* " . $invoice['invoice_date'] . "\n";
$wa_text .= "• *Due Date:* " . $invoice['due_date'] . "\n";
$wa_text .= "• *Total Amount:* " . format_currency($grand_total) . "\n";
$wa_text .= "• *Payment Status:* " . $invoice['status'] . "\n\n";
$wa_text .= "You can view or download the detailed PDF invoice here:\n" . $download_url . "\n\n";
$wa_text .= "Thank you for your business!\n\n_Softex Technologies_";

$wa_url = "https://api.whatsapp.com/send?phone=" . urlencode($invoice['client_phone'] ?? '') . "&text=" . urlencode($wa_text);

include 'header.php';
?>

<!-- Invoice View Suite -->
<div class="row g-4">
  <!-- Invoice Content Panel -->
  <div class="col-lg-9 col-12">
    <!-- Invoice Preview Box -->
    <div class="card border-0 shadow-sm p-4 p-md-5 bg-white mb-4 position-relative overflow-hidden" id="printable-area">
      <!-- Watermark Status Badge -->
      <div class="position-absolute" style="right: -40px; top: 40px; transform: rotate(45deg); width: 200px; text-align: center; z-index: 1;">
        <?php if ($invoice['status'] === 'PAID'): ?>
          <div class="bg-success text-white py-1 fw-bold small tracking-wider shadow">PAID</div>
        <?php else: ?>
          <div class="bg-danger text-white py-1 fw-bold small tracking-wider shadow">UNPAID</div>
        <?php endif; ?>
      </div>

      <!-- Company & Invoice ID Section -->
      <div class="row g-4 align-items-start mb-5" style="position: relative; z-index: 2;">
        <div class="col-sm-6 text-sm-start text-center">
          <!-- Logo Display -->
          <?php 
            $logo_path = get_setting('company_logo', 'assets/images/logo.png');
            if (!file_exists($logo_path)) {
                $logo_path = 'assets/images/logo.png';
            }
          ?>
          <img src="<?= $logo_path ?>?v=<?= time() ?>" alt="Softex Logo" class="img-fluid mb-3" style="max-height: 55px; object-fit: contain;">
          <h5 class="fw-bold text-dark mb-1"><?= h(get_setting('company_name', 'Softex Technologies')) ?></h5>
          <p class="text-muted small mb-0 lh-base" style="font-size: 0.85rem;">
            <?= nl2br(h(get_setting('company_address', "H606 Nisther Block Iqbal Town, Lahore, Pakistan"))) ?><br>
            <i class="bi bi-telephone text-muted me-1"></i> <?= h(get_setting('company_phone', "+92 345 0789192")) ?><br>
            <i class="bi bi-envelope text-muted me-1"></i> <?= h(get_setting('company_email', "info@softex.pk")) ?><br>
            <i class="bi bi-globe text-muted me-1"></i> <?= h(get_setting('company_website', "www.softex.pk")) ?>
          </p>
        </div>
        
        <div class="col-sm-6 text-sm-end text-center mt-4 mt-sm-0">
          <h2 class="fw-bold text-primary mb-1">INVOICE</h2>
          <span class="fs-4 fw-bold text-dark d-block mb-3"><?= h($invoice['invoice_number']) ?></span>
          
          <div class="d-inline-block text-start bg-light rounded-3 p-3 border">
            <div class="row g-2" style="font-size: 0.85rem;">
              <div class="col-6 text-secondary font-semibold">Invoice Date:</div>
              <div class="col-6 fw-bold text-dark text-end"><?= h($invoice['invoice_date']) ?></div>
              <div class="col-6 text-secondary font-semibold">Due Date:</div>
              <div class="col-6 fw-bold text-dark text-end text-danger"><?= h($invoice['due_date']) ?></div>
              <div class="col-6 text-secondary font-semibold">Payment Status:</div>
              <div class="col-6 text-end">
                <?php if ($invoice['status'] === 'PAID'): ?>
                  <span class="badge badge-paid rounded-pill" style="font-size: 0.75rem;">PAID</span>
                <?php else: ?>
                  <span class="badge badge-unpaid rounded-pill" style="font-size: 0.75rem;">UNPAID</span>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      </div>

      <hr class="my-4">

      <!-- Billing Demographics -->
      <div class="row g-4 mb-4">
        <div class="col-sm-6">
          <span class="text-uppercase fw-bold text-muted small tracking-wider d-block mb-2">Billed To (Client Details)</span>
          <h6 class="fw-bold text-dark mb-1"><?= h($invoice['client_name']) ?></h6>
          <p class="text-muted small mb-0 lh-base" style="font-size: 0.85rem;">
            <?= nl2br(h($invoice['client_address'] ?: 'No address specified.')) ?><br>
            <?php if (!empty($invoice['client_phone'])): ?>
              <i class="bi bi-telephone text-muted me-1"></i> <?= h($invoice['client_phone']) ?><br>
            <?php endif; ?>
            <?php if (!empty($invoice['client_email'])): ?>
              <i class="bi bi-envelope text-muted me-1"></i> <?= h($invoice['client_email']) ?>
            <?php endif; ?>
          </p>
        </div>
      </div>

      <!-- Line Items Table -->
      <div class="table-responsive mb-4">
        <table class="table align-middle table-borderless">
          <thead class="table-light text-secondary" style="font-size: 0.85rem; font-weight: 600; border-radius: 6px;">
            <tr>
              <th class="ps-3 py-3" style="border-top-left-radius: 6px; border-bottom-left-radius: 6px;">Description</th>
              <th class="text-end py-3" style="width: 150px;">Unit Price</th>
              <th class="text-end py-3" style="width: 150px;">Discount</th>
              <th class="text-end pe-3 py-3" style="width: 150px; border-top-right-radius: 6px; border-bottom-right-radius: 6px;">Total</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($invoice_items as $item): ?>
              <tr style="border-bottom: 1px solid var(--card-border);">
                <td class="ps-3 py-3">
                  <div class="text-dark fw-semibold" style="font-size: 0.95rem;"><?= h($item['description']) ?></div>
                </td>
                <td class="text-end text-secondary py-3">
                  <?= format_currency($item['price']) ?>
                </td>
                <td class="text-end text-danger py-3">
                  <?= $item['discount'] > 0 ? '-' . format_currency($item['discount']) : 'Rs. 0.00' ?>
                </td>
                <td class="text-end fw-bold text-dark pe-3 py-3">
                  <?= format_currency($item['total']) ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <!-- Invoice Calculation Aggregates -->
      <div class="row justify-content-end mb-4">
        <div class="col-md-5 col-sm-8 col-12">
          <div class="bg-light rounded-3 p-4 border" style="font-size: 0.9rem;">
            <div class="d-flex justify-content-between mb-2">
              <span class="text-secondary font-semibold">Subtotal</span>
              <span class="fw-semibold text-dark"><?= format_currency($subtotal) ?></span>
            </div>
            <div class="d-flex justify-content-between mb-2">
              <span class="text-secondary font-semibold">Discount</span>
              <span class="fw-semibold text-danger"><?= $total_discount > 0 ? '-' . format_currency($total_discount) : 'Rs. 0.00' ?></span>
            </div>
            <hr class="my-2">
            <div class="d-flex justify-content-between align-items-center mb-0">
              <span class="fw-bold text-dark">Grand Total</span>
              <span class="fs-5 fw-bold text-primary"><?= format_currency($grand_total) ?></span>
            </div>
          </div>
        </div>
      </div>

      <hr class="my-4">

      <!-- Terms and Conditions section -->
      <div class="row">
        <div class="col-md-7">
          <h6 class="fw-bold text-dark mb-2"><i class="bi bi-info-circle text-primary me-2"></i>Terms &amp; Conditions</h6>
          <p class="text-muted small mb-0 lh-lg" style="font-size: 0.8rem;">
            <?= nl2br(h(get_setting('terms_conditions', "1. Payment due within 7 days.\n2. No refund after payment confirmation.\n3. Thank you for your business."))) ?>
          </p>
        </div>
        <div class="col-md-5 text-md-end text-center align-self-end mt-4 mt-md-0">
          <span class="text-muted small d-block">Generated securely via Softex Invoicing Portal</span>
          <span class="fw-semibold text-dark small">Authorized Signature</span>
          <div class="border-top mx-auto ms-md-auto me-md-0 mt-4" style="width: 150px;"></div>
        </div>
      </div>
    </div>
  </div>

  <!-- Right Actions sidebar Panel -->
  <div class="col-lg-3 col-12">
    <!-- Payment toggle quick card -->
    <div class="card border-0 shadow-sm p-3 mb-4 text-center">
      <span class="text-xs text-muted d-block uppercase fw-bold mb-2 tracking-wider" style="font-size: 0.75rem;">Mark Payment Status</span>
      <?php if ($invoice['status'] === 'UNPAID'): ?>
        <a href="invoices.php?toggle_id=<?= $invoice_id ?>" class="btn btn-success d-flex align-items-center justify-content-center gap-2 py-2">
          <i class="bi bi-check-circle-fill"></i>
          <span>Payment Received</span>
        </a>
      <?php else: ?>
        <a href="invoices.php?toggle_id=<?= $invoice_id ?>" class="btn btn-warning text-dark d-flex align-items-center justify-content-center gap-2 py-2">
          <i class="bi bi-x-circle-fill"></i>
          <span>Mark as UNPAID</span>
        </a>
      <?php endif; ?>
    </div>

    <!-- Communication & File Management panel -->
    <div class="card border-0 shadow-sm mb-4 position-sticky" style="top: 90px;">
      <div class="card-header bg-white py-3">
        <h6 class="fw-bold mb-0 text-dark">Invoice Operations</h6>
      </div>
      <div class="card-body d-grid gap-2">
        <!-- PDF Export -->
        <a href="invoice-pdf.php?id=<?= $invoice_id ?>&download=1" class="btn btn-primary d-flex align-items-center gap-3 py-2 text-start px-3">
          <i class="bi bi-file-earmark-pdf-fill fs-5 text-white"></i>
          <div class="lh-sm">
            <span class="fw-bold d-block small">Download PDF</span>
            <span class="text-xs text-white-50" style="font-size: 0.7rem;">Offline high-res file</span>
          </div>
        </a>

        <!-- Print Feature -->
        <a href="invoice-print.php?id=<?= $invoice_id ?>" target="_blank" class="btn btn-light border d-flex align-items-center gap-3 py-2 text-start px-3">
          <i class="bi bi-printer fs-5 text-secondary"></i>
          <div class="lh-sm">
            <span class="fw-bold d-block text-dark small">Print Invoice</span>
            <span class="text-xs text-muted" style="font-size: 0.7rem;">Open print dialog box</span>
          </div>
        </a>

        <!-- Send via Email -->
        <a href="invoice-send.php?id=<?= $invoice_id ?>" class="btn btn-outline-primary d-flex align-items-center gap-3 py-2 text-start px-3">
          <i class="bi bi-envelope-at-fill fs-5"></i>
          <div class="lh-sm">
            <span class="fw-bold d-block small">Send via Email</span>
            <span class="text-xs text-muted" style="font-size: 0.7rem;">Sends PDF to client</span>
          </div>
        </a>

        <!-- Send via WhatsApp -->
        <a href="<?= $wa_url ?>" target="_blank" class="btn btn-outline-success d-flex align-items-center gap-3 py-2 text-start px-3">
          <i class="bi bi-whatsapp fs-5"></i>
          <div class="lh-sm">
            <span class="fw-bold d-block small">Send via WhatsApp</span>
            <span class="text-xs text-muted" style="font-size: 0.7rem;">WhatsApp Web sharing</span>
          </div>
        </a>

        <hr class="my-2">

        <!-- Edit/Modify -->
        <a href="invoice-edit.php?id=<?= $invoice_id ?>" class="btn btn-light d-flex align-items-center justify-content-center gap-2 py-2 border">
          <i class="bi bi-pencil-square text-dark"></i>
          <span class="fw-semibold text-dark small">Edit Invoice details</span>
        </a>

        <!-- Delete statement -->
        <a href="invoices.php?delete_id=<?= $invoice_id ?>" class="btn btn-light text-danger d-flex align-items-center justify-content-center gap-2 py-2 border" onclick="return confirm('Are you sure you want to permanently delete this invoice?')">
          <i class="bi bi-trash"></i>
          <span class="fw-semibold small">Delete statement</span>
        </a>
      </div>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>
