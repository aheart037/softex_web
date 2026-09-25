<?php
/**
 * Print Invoice Template - Hide Due Date if PAID
 * Company Info Left, Logo Right, Ribbon Top-Right
 */
require_once 'config.php';
require_login();

$invoice_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($invoice_id <= 0) {
    die("Invalid invoice statement.");
}

try {
    $stmt = $pdo->prepare("SELECT i.*, c.name as client_name, c.phone as client_phone, 
                           c.email as client_email, c.address as client_address 
                           FROM invoices i 
                           JOIN clients c ON i.client_id = c.id 
                           WHERE i.id = ? LIMIT 1");
    $stmt->execute([$invoice_id]);
    $invoice = $stmt->fetch();

    if (!$invoice) {
        die("Invoice statement not found.");
    }

    $items_stmt = $pdo->prepare("SELECT * FROM invoice_items WHERE invoice_id = ? ORDER BY id ASC");
    $items_stmt->execute([$invoice_id]);
    $invoice_items = $items_stmt->fetchAll();

} catch (PDOException $e) {
    die("Database Query Error: " . $e->getMessage());
}

$subtotal = 0;
$total_discount = 0;
foreach ($invoice_items as $item) {
    $subtotal += $item['price'];
    $total_discount += $item['discount'];
}
$grand_total = $subtotal - $total_discount;

$invoice_number_raw = preg_replace('/[^0-9]/', '', $invoice['invoice_number']);
$formatted_inv_number = 'INV-' . str_pad($invoice_number_raw, 4, '0', STR_PAD_LEFT);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Print <?= $formatted_inv_number ?> | Softex Invoice</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    body {
      background: #eef2f5;
      font-family: 'Inter', sans-serif;
      color: #1e293b;
      padding: 0.25rem;
    }
    .invoice-container {
      max-width: 1300px;
      margin: 0 auto;
      background: #ffffff;
      border-radius: 20px;
      box-shadow: 0 8px 20px -6px rgba(0, 0, 0, 0.08);
      overflow: hidden;
      display: flex;
      position: relative;
    }
    .ribbon-wrapper {
      position: absolute;
      top: 0;
      right: 0;
      width: 120px;
      height: 120px;
      overflow: hidden;
      z-index: 20;
      pointer-events: none;
    }
    .ribbon {
      position: absolute;
      top: 20px;
      right: -28px;
      transform: rotate(45deg);
      width: 170px;
      text-align: center;
      padding: 6px 0;
      font-weight: 800;
      font-size: 0.75rem;
      text-transform: uppercase;
      letter-spacing: 1.5px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      color: white;
    }
    .ribbon-paid {
      background: linear-gradient(135deg, #10b981, #059669);
    }
    .ribbon-unpaid {
      background: linear-gradient(135deg, #ef4444, #dc2626);
    }
    .vertical-number {
      width: 70px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
      padding: 1rem 0;
      background: transparent;
    }
    .vertical-number .number {
      writing-mode: vertical-rl;
      transform: rotate(180deg);
      font-family: 'Space Grotesk', monospace;
      font-size: 1.2rem;
      font-weight: 800;
      letter-spacing: 2px;
      background: linear-gradient(135deg, #F20D5A, #F44A6A, #F78B3D, #FBBF24);
      background-clip: text;
      -webkit-background-clip: text;
      color: transparent;
      word-break: keep-all;
    }
    .invoice-content {
      flex: 1;
      padding: 1rem 1.2rem;
      position: relative;
      z-index: 1;
    }
    .header-split {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      flex-wrap: wrap;
      margin-bottom: 1.5rem;
      padding-top: 1.8rem;
      padding-bottom: 0.8rem;
      border-bottom: 2px solid #eef2ff;
    }
    .company-info-left {
      text-align: left;
      flex: 2;
    }
    .company-info-left h4 {
      font-family: 'Space Grotesk', monospace;
      font-weight: 700;
      font-size: 1.2rem;
      background: linear-gradient(135deg, #F20D5A, #F44A6A, #F78B3D, #FBBF24);
      background-clip: text;
      -webkit-background-clip: text;
      color: transparent;
      display: inline-block;
    }
    .company-details-left {
      font-size: 0.7rem;
      color: #475569;
      line-height: 1.4;
      margin-top: 0.2rem;
    }
    .logo-right {
      text-align: right;
      flex: 1;
    }
    .logo-right img {
      max-height: 45px;
      object-fit: contain;
      margin-right:40%;
    }
    .info-grid {
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 1rem;
      margin-bottom: 1.5rem;
    }
    .info-card {
      background: #f8fafc;
      border-radius: 16px;
      padding: 0.8rem 1.2rem;
      flex: 1;
      min-width: 200px;
      border: 1px solid #e2e8f0;
    }
    .info-label {
      text-transform: uppercase;
      font-size: 0.6rem;
      font-weight: 600;
      letter-spacing: 0.5px;
      color: #64748b;
      margin-bottom: 0.4rem;
    }
    .info-value {
      font-weight: 700;
      font-size: 0.9rem;
      color: #0f172a;
    }
    .info-sub {
      font-size: 0.7rem;
      color: #475569;
    }
    .items-table {
      width: 100%;
      border-collapse: collapse;
      margin: 1.2rem 0;
      font-size: 0.75rem;
    }
    .items-table th {
      text-align: left;
      padding: 0.6rem 0.8rem;
      background: linear-gradient(135deg, #F20D5A, #F44A6A, #F78B3D, #FBBF24);
      color: #ffffff;
      font-weight: 700;
      text-transform: uppercase;
      font-size: 0.6rem;
    }
    .items-table td {
      padding: 0.6rem 0.8rem;
      border-bottom: 1px solid #f1f5f9;
    }
    .text-end {
      text-align: right;
    }
    .item-description {
      font-weight: 500;
      color: #0f172a;
    }
    .totals-panel {
      background: #fefce8;
      border-radius: 16px;
      padding: 0.7rem 1.2rem;
      margin: 0.8rem 0 1rem;
      width: 100%;
      max-width: 320px;
      margin-left: auto;
      border: 1px solid #fde68a;
    }
    .totals-row {
      display: flex;
      justify-content: space-between;
      padding: 0.3rem 0;
      font-size: 0.8rem;
    }
    .totals-grand {
      border-top: 2px dashed #fcd34d;
      margin-top: 0.3rem;
      padding-top: 0.5rem;
      font-weight: 800;
      font-size: 0.95rem;
    }
    .terms-section {
      margin-top: 1rem;
      padding-top: 0.6rem;
      border-top: 1px solid #e2e8f0;
      font-size: 0.65rem;
      color: #475569;
    }
    .action-buttons {
      display: flex;
      gap: 0.8rem;
      justify-content: flex-end;
      margin-bottom: 0.8rem;
    }
    .btn-print, .btn-close {
      border: none;
      padding: 0.35rem 0.9rem;
      border-radius: 40px;
      font-weight: 600;
      font-size: 0.7rem;
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
      cursor: pointer;
    }
    .btn-print {
      background: #0f172a;
      color: white;
    }
    .btn-close {
      background: white;
      border: 1px solid #cbd5e1;
      color: #334155;
    }
    @media print {
      body {
        background: white;
        padding: 0;
      }
      .invoice-container {
        box-shadow: none;
        border-radius: 0;
        max-width: 100%;
      }
      .action-buttons {
        display: none;
      }
      .ribbon, .items-table th {
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
      }
      @page {
        margin: 0.8cm;
        size: A4;
      }
    }
    @media (max-width: 700px) {
      body {
        padding: 0.1rem;
      }
      .invoice-container {
        flex-direction: column;
      }
      .vertical-number {
        width: 100%;
        flex-direction: row;
        justify-content: space-between;
        padding: 0.3rem 0.8rem;
      }
      .vertical-number .number {
        writing-mode: horizontal-tb;
        transform: none;
        font-size: 1rem;
      }
      .invoice-content {
        padding: 0.8rem;
      }
      .header-split {
        flex-direction: column;
        align-items: center;
        text-align: center;
        padding-top: 2rem;
      }
      .company-info-left, .logo-right {
        text-align: center;
        flex: auto;
      }
      .logo-right {
        margin-top: 0.5rem;
      }
      .info-grid {
        flex-direction: column;
      }
      .totals-panel {
        max-width: 100%;
      }
    }
  </style>
</head>
<body>
<div class="invoice-container">
  <div class="ribbon-wrapper">
    <?php if ($invoice['status'] === 'PAID'): ?>
      <div class="ribbon ribbon-paid">✓ PAID</div>
    <?php else: ?>
      <div class="ribbon ribbon-unpaid">✗ UNPAID</div>
    <?php endif; ?>
  </div>

  <div class="vertical-number">
    <div class="number"><?= $formatted_inv_number ?></div>
  </div>

  <div class="invoice-content">
    <div class="action-buttons no-print">
      <button onclick="window.print();" class="btn-print"><i class="bi bi-printer"></i> Print Invoice</button>
      <button onclick="window.close();" class="btn-close"><i class="bi bi-x-lg"></i> Close</button>
    </div>

    <div class="header-split">
      <div class="company-info-left">
        <h4><?= h(get_setting('company_name', 'Softex Technologies')) ?></h4>
        <div class="company-details-left">
          <?= nl2br(h(get_setting('company_address', "H606 Nisther Block Iqbal Town, Lahore, Pakistan"))) ?><br>
          <?= h(get_setting('company_phone', "+92 345 0789192")) ?> | <?= h(get_setting('company_email', "info@softex.pk")) ?><br>
          <?= h(get_setting('company_website', "www.softex.pk")) ?>
        </div>
      </div>
      <div class="logo-right">
        <?php 
          $logo_path = get_setting('company_logo', 'assets/images/logo.png');
          if (!file_exists($logo_path)) $logo_path = 'assets/images/logo.png';
        ?>
        <img src="<?= $logo_path ?>" alt="Softex Logo">
      </div>
    </div>

    <div class="info-grid">
      <div class="info-card">
        <div class="info-label"><i class="bi bi-person-badge me-1"></i> BILL TO</div>
        <div class="info-value"><?= h($invoice['client_name']) ?></div>
        <div class="info-sub"><?= nl2br(h($invoice['client_address'] ?: 'No address specified.')) ?></div>
        <div class="info-sub mt-1">📞 <?= h($invoice['client_phone'] ?: 'N/A') ?></div>
        <div class="info-sub">✉️ <?= h($invoice['client_email'] ?: 'N/A') ?></div>
      </div>
      <div class="info-card">
        <div class="info-label"><i class="bi bi-calendar3 me-1"></i> INVOICE DETAILS</div>
        <div class="info-value">Date: <?= h($invoice['invoice_date']) ?></div>
        <!-- Hide due date if status is PAID -->
        <?php if ($invoice['status'] !== 'PAID'): ?>
          <div class="info-value text-danger">Due: <?= h($invoice['due_date']) ?></div>
        <?php endif; ?>
      </div>
    </div>

    <table class="items-table">
      <thead>
        <tr><th>Description</th><th class="text-end">Unit Price (Rs.)</th><th class="text-end">Discount (Rs.)</th><th class="text-end">Total (Rs.)</th></tr>
      </thead>
      <tbody>
        <?php foreach ($invoice_items as $item): ?>
        <tr>
          <td class="item-description"><?= h($item['description']) ?></td>
          <td class="text-end"><?= number_of_format($item['price']) ?></td>
          <td class="text-end text-danger"><?= $item['discount'] > 0 ? '-' . number_of_format($item['discount']) : '0.00' ?></td>
          <td class="text-end fw-bold"><?= number_of_format($item['total']) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <div class="totals-panel">
      <div class="totals-row"><span>Subtotal</span><span>Rs. <?= number_of_format($subtotal) ?></span></div>
      <div class="totals-row"><span>Total Discount</span><span class="text-danger">- Rs. <?= number_of_format($total_discount) ?></span></div>
      <div class="totals-row totals-grand"><span>Grand Total</span><span>Rs. <?= number_of_format($grand_total) ?></span></div>
    </div>

    <div class="terms-section">
      <strong>TERMS & CONDITIONS</strong>
      <p class="mt-1"><?= nl2br(h(get_setting('terms_conditions', "1. Payment due within 7 days.\n2. No refund after payment confirmation.\n3. Thank you for your business."))) ?></p>
    </div>
  </div>
</div>
<script>
  window.onload = function() { window.print(); };
</script>
</body>
</html>