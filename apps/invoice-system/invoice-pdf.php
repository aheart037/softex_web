<?php
/**
 * Invoice PDF Generator - Matches HTML design (no rotation, stack vertical number)
 */
require_once 'config.php';
require_login();

error_reporting(E_ALL);
ini_set('display_errors', 1);

$invoice_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($invoice_id <= 0) {
    die("Invalid invoice statement specified.");
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

require_once 'fpdf.php';

class PDF_Invoice extends FPDF {
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(148, 163, 184);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . ' of {nb} | Generated via Softex Invoicing Portal', 0, 0, 'C');
    }
}

$pdf = new PDF_Invoice('P', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->SetMargins(15, 15, 15);
$pdf->AddPage();

// Brand primary color (solid, since gradients not supported in standard FPDF)
$brand_rgb = [242, 13, 90]; // #F20D5A

// ============================================================
// 1. VERTICAL INVOICE NUMBER (stacked characters, left side)
// ============================================================
$pdf->SetFont('Courier', 'B', 11);
$pdf->SetTextColor($brand_rgb[0], $brand_rgb[1], $brand_rgb[2]);
$start_x = 15;
$start_y = 45;
$pdf->SetXY($start_x, $start_y);
foreach (str_split($formatted_inv_number) as $char) {
    $pdf->Cell(8, 5, $char, 0, 1, 'C');
    $pdf->SetX($start_x);
}

// ============================================================
// 2. RIBBON (top-right corner, simple rectangle with text)
// ============================================================
$badge_width = 40;
$badge_height = 8;
$badge_x = 195 - $badge_width;
$badge_y = 20;
$pdf->SetXY($badge_x, $badge_y);
if ($invoice['status'] === 'PAID') {
    $pdf->SetFillColor(16, 185, 129); // green
    $pdf->SetTextColor(255, 255, 255);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell($badge_width, $badge_height, '  PAID  ', 0, 0, 'C', true);
} else {
    $pdf->SetFillColor(239, 68, 68); // red
    $pdf->SetTextColor(255, 255, 255);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell($badge_width, $badge_height, '  UNPAID  ', 0, 0, 'C', true);
}

// ============================================================
// 3. HEADER: COMPANY INFO (left) + LOGO (right)
// ============================================================
$y_start = $pdf->GetY() + 10;
$pdf->SetXY(15, $y_start);

// Company info (left)
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetTextColor($brand_rgb[0], $brand_rgb[1], $brand_rgb[2]);
$pdf->Cell(90, 6, get_setting('company_name', 'Softex Technologies'), 0, 1, 'L');

$pdf->SetFont('Arial', '', 8);
$pdf->SetTextColor(71, 85, 105);
$address_text = get_setting('company_address', "H606 Nisther Block Iqbal Town,\nLahore, Pakistan");
$address_text = str_replace("\r", "", $address_text);
$addr_lines = explode("\n", $address_text);
foreach ($addr_lines as $line) {
    if (trim($line) != '') {
        $pdf->Cell(90, 4, trim($line), 0, 1, 'L');
    }
}
$pdf->Cell(90, 4, 'Phone: ' . get_setting('company_phone', '+92 345 0789192'), 0, 1, 'L');
$pdf->Cell(90, 4, 'Email: ' . get_setting('company_email', 'info@softex.pk'), 0, 1, 'L');
$pdf->Cell(90, 4, 'Website: ' . get_setting('company_website', 'www.softex.pk'), 0, 1, 'L');

// Logo (right)
$logo_path = get_setting('company_logo', 'assets/images/logo.png');
if (!empty($logo_path) && file_exists($logo_path) && filesize($logo_path) > 10) {
    try {
        $pdf->Image($logo_path, 150, $y_start, 35, 0);
    } catch (Exception $e) {
        // ignore
    }
}

$pdf->Ln(8);
$pdf->Line(15, $pdf->GetY(), 195, $pdf->GetY());
$pdf->Ln(6);

// ============================================================
// 4. INVOICE DETAILS (right aligned)
// ============================================================
$pdf->SetX(110);
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetTextColor(15, 23, 42);
$pdf->Cell(45, 5, 'Invoice Date:', 0, 0, 'R');
$pdf->SetFont('Arial', '', 10);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(40, 5, $invoice['invoice_date'], 0, 1, 'R');

if ($invoice['status'] !== 'PAID') {
    $pdf->SetX(110);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetTextColor(185, 28, 28);
    $pdf->Cell(45, 5, 'Due Date:', 0, 0, 'R');
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(40, 5, $invoice['due_date'], 0, 1, 'R');
}
$pdf->Ln(6);

// ============================================================
// 5. CLIENT INFORMATION (BILL TO)
// ============================================================
$pdf->SetX(15);
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetTextColor(15, 23, 42);
$pdf->Cell(90, 5, 'BILL TO:', 0, 1, 'L');

$pdf->SetFont('Arial', 'B', 9);
$pdf->SetTextColor($brand_rgb[0], $brand_rgb[1], $brand_rgb[2]);
$pdf->Cell(90, 5, $invoice['client_name'], 0, 1, 'L');

$pdf->SetFont('Arial', '', 8);
$pdf->SetTextColor(71, 85, 105);
$client_addr = str_replace("\r", "", $invoice['client_address']);
$client_lines = explode("\n", $client_addr);
foreach ($client_lines as $cline) {
    if (trim($cline) != '') {
        $pdf->Cell(90, 4, trim($cline), 0, 1, 'L');
    }
}
if (!empty($invoice['client_phone'])) {
    $pdf->Cell(90, 4, 'Phone: ' . $invoice['client_phone'], 0, 1, 'L');
}
if (!empty($invoice['client_email'])) {
    $pdf->Cell(90, 4, 'Email: ' . $invoice['client_email'], 0, 1, 'L');
}
$pdf->Ln(8);

// ============================================================
// 6. LINE ITEMS TABLE (solid brand header)
// ============================================================
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetFillColor($brand_rgb[0], $brand_rgb[1], $brand_rgb[2]);
$pdf->SetTextColor(255, 255, 255);
$w_desc = 95;
$w_price = 30;
$w_disc = 25;
$w_total = 30;
$pdf->Cell($w_desc, 8, '  Item Description', 0, 0, 'L', true);
$pdf->Cell($w_price, 8, 'Unit Price (Rs.)', 0, 0, 'R', true);
$pdf->Cell($w_disc, 8, 'Discount', 0, 0, 'R', true);
$pdf->Cell($w_total, 8, 'Total (Rs.)  ', 0, 1, 'R', true);

$pdf->SetFont('Arial', '', 8);
$pdf->SetTextColor(51, 65, 85);
$fill = false;
foreach ($invoice_items as $item) {
    $x_pos = $pdf->GetX();
    $y_pos = $pdf->GetY();
    $nb_lines = ceil($pdf->GetStringWidth($item['description']) / ($w_desc - 4));
    if ($nb_lines < 1) $nb_lines = 1;
    $row_h = $nb_lines * 4.5 + 2;
    
    if ($fill) {
        $pdf->Rect($x_pos, $y_pos, 180, $row_h, 'F');
    }
    
    $pdf->SetXY($x_pos, $y_pos + 1);
    $pdf->MultiCell($w_desc, 4.5, '  ' . $item['description'], 0, 'L');
    
    $pdf->SetXY($x_pos + $w_desc, $y_pos);
    $pdf->Cell($w_price, $row_h, number_format($item['price'], 2) . ' ', 0, 0, 'R');
    
    $pdf->SetXY($x_pos + $w_desc + $w_price, $y_pos);
    $disc_text = $item['discount'] > 0 ? '-' . number_format($item['discount'], 2) : '0.00';
    $pdf->SetTextColor($item['discount'] > 0 ? 185 : 51, $item['discount'] > 0 ? 28 : 65, $item['discount'] > 0 ? 28 : 85);
    $pdf->Cell($w_disc, $row_h, $disc_text . ' ', 0, 0, 'R');
    
    $pdf->SetTextColor(15, 23, 42);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->SetXY($x_pos + $w_desc + $w_price + $w_disc, $y_pos);
    $pdf->Cell($w_total, $row_h, number_format($item['total'], 2) . '  ', 0, 1, 'R');
    
    $pdf->SetFont('Arial', '', 8);
    $pdf->SetTextColor(51, 65, 85);
    $pdf->Line(15, $pdf->GetY(), 195, $pdf->GetY());
    
    $fill = !$fill;
}
$pdf->Ln(4);

// ============================================================
// 7. TOTALS PANEL (yellow background, right side)
// ============================================================
$y_summary = $pdf->GetY();
$pdf->SetY($y_summary);
$pdf->SetX(115);
$pdf->SetFillColor(254, 252, 232);
$pdf->SetDrawColor(253, 230, 138);
$pdf->Rect(115, $y_summary, 80, 38, 'DF');
$pdf->SetY($y_summary + 3);
$pdf->SetX(120);
$pdf->SetFont('Arial', '', 8);
$pdf->SetTextColor(71, 85, 105);
$pdf->Cell(35, 5, 'Subtotal:', 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->SetTextColor(15, 23, 42);
$pdf->Cell(35, 5, 'Rs. ' . number_format($subtotal, 2), 0, 1, 'R');

$pdf->SetX(120);
$pdf->SetFont('Arial', '', 8);
$pdf->SetTextColor(71, 85, 105);
$pdf->Cell(35, 5, 'Total Discount:', 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->SetTextColor(185, 28, 28);
$pdf->Cell(35, 5, '-Rs. ' . number_format($total_discount, 2), 0, 1, 'R');

$pdf->SetX(120);
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetTextColor($brand_rgb[0], $brand_rgb[1], $brand_rgb[2]);
$pdf->Cell(35, 6, 'Grand Total:', 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(35, 6, 'Rs. ' . number_format($grand_total, 2), 0, 1, 'R');

// ============================================================
// 8. TERMS & CONDITIONS
// ============================================================
$pdf->SetY($y_summary + 42);
$pdf->SetX(15);
$pdf->SetFont('Arial', 'B', 8);
$pdf->SetTextColor(15, 23, 42);
$pdf->Cell(90, 5, 'TERMS & CONDITIONS:', 0, 1, 'L');

$pdf->SetFont('Arial', '', 7);
$pdf->SetTextColor(100, 116, 139);
$terms_text = get_setting('terms_conditions', "1. Payment due within 7 days.\n2. No refund after payment confirmation.\n3. Thank you for your business.");
$terms_text = str_replace("\r", "", $terms_text);
$terms_lines = explode("\n", $terms_text);
foreach ($terms_lines as $line) {
    if (trim($line) != '') {
        $pdf->MultiCell(90, 3.5, trim($line), 0, 'L');
    }
}

// ============================================================
// 9. OUTPUT
// ============================================================
$filename = "Invoice-" . $invoice['invoice_number'] . ".pdf";

if (isset($_GET['save_to_file'])) {
    $file_path = trim($_GET['save_to_file']);
    $pdf->Output('F', $file_path);
    echo "Saved";
} else {
    $output_mode = isset($_GET['download']) && $_GET['download'] == '1' ? 'D' : 'I';
    $pdf->Output($output_mode, $filename);
}
exit;