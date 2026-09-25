<?php
/**
 * System Settings & Preferences Controller
 * Tabbed control panel managing corporate identity, logos, terms, and SMTP parameters.
 */
require_once 'config.php';
require_login();

$error = '';
$success = '';
$active_tab = isset($_GET['tab']) ? trim($_GET['tab']) : 'profile';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Save Corporate profile details
    if (isset($_POST['save_profile'])) {
        $name = trim($_POST['company_name'] ?? '');
        $phone = trim($_POST['company_phone'] ?? '');
        $email = trim($_POST['company_email'] ?? '');
        $website = trim($_POST['company_website'] ?? '');
        $address = trim($_POST['company_address'] ?? '');

        if (empty($name)) {
            $error = "Company Name is required.";
        } else {
            update_setting('company_name', $name);
            update_setting('company_phone', $phone);
            update_setting('company_email', $email);
            update_setting('company_website', $website);
            update_setting('company_address', $address);
            
            // Handle logo file upload
            if (isset($_FILES['company_logo']) && $_FILES['company_logo']['error'] === UPLOAD_ERR_OK) {
                $file_tmp = $_FILES['company_logo']['tmp_name'];
                $file_name = $_FILES['company_logo']['name'];
                $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                $allowed_exts = ['png', 'jpg', 'jpeg', 'gif'];

                if (!in_array($file_ext, $allowed_exts)) {
                    $error = "Invalid logo file format. Allowed types: PNG, JPG, JPEG, GIF.";
                } else {
                    // Save file as uploads/logo.png (force standard format or save name)
                    $target_path = 'uploads/logo_' . time() . '.' . $file_ext;
                    
                    // Create directory if not exists
                    if (!is_dir('uploads')) {
                        mkdir('uploads', 0755, true);
                    }

                    if (move_uploaded_file($file_tmp, $target_path)) {
                        // Delete older logo to avoid bloat
                        $old_logo = get_setting('company_logo');
                        if (!empty($old_logo) && file_exists($old_logo) && $old_logo !== 'assets/images/logo.png') {
                            @unlink($old_logo);
                        }
                        
                        update_setting('company_logo', $target_path);
                    } else {
                        $error = "Failed to move uploaded logo to target location.";
                    }
                }
            }
            
            if (empty($error)) {
                $_SESSION['flash_success'] = "Corporate profile settings updated successfully.";
                header("Location: settings.php?tab=profile");
                exit;
            }
        }
    }

    // 2. Save Invoice Terms & Conditions
    if (isset($_POST['save_terms'])) {
        $terms = trim($_POST['terms_conditions'] ?? '');
        update_setting('terms_conditions', $terms);
        $_SESSION['flash_success'] = "Default terms & conditions updated successfully.";
        header("Location: settings.php?tab=terms");
        exit;
    }

    // 3. Save SMTP Configurations
    if (isset($_POST['save_smtp'])) {
        $host = trim($_POST['smtp_host'] ?? '');
        $port = trim($_POST['smtp_port'] ?? '');
        $user = trim($_POST['smtp_user'] ?? '');
        $pass = trim($_POST['smtp_pass'] ?? '');
        $secure = trim($_POST['smtp_secure'] ?? '');

        update_setting('smtp_host', $host);
        update_setting('smtp_port', $port);
        update_setting('smtp_user', $user);
        update_setting('smtp_pass', $pass);
        update_setting('smtp_secure', $secure);

        $_SESSION['flash_success'] = "Secure SMTP transport parameters updated successfully.";
        header("Location: settings.php?tab=smtp");
        exit;
    }
}

include 'header.php';
?>

<!-- Error Alert displays -->
<?php if ($error): ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="bi bi-exclamation-triangle-fill me-2"></i><?= h($error) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<div class="row g-4">
  <!-- Left Side Sidebar settings tabs navigation -->
  <div class="col-md-3 col-12">
    <div class="card border-0 shadow-sm">
      <div class="card-body p-0">
        <div class="list-group list-group-flush rounded-3">
          <a href="settings.php?tab=profile" class="list-group-item list-group-item-action py-3 px-4 d-flex align-items-center gap-3 <?= $active_tab === 'profile' ? 'active bg-primary border-primary text-white' : 'text-secondary' ?>">
            <i class="bi bi-building fs-5"></i>
            <span class="fw-semibold">Corporate Profile</span>
          </a>
          <a href="settings.php?tab=terms" class="list-group-item list-group-item-action py-3 px-4 d-flex align-items-center gap-3 <?= $active_tab === 'terms' ? 'active bg-primary border-primary text-white' : 'text-secondary' ?>">
            <i class="bi bi-file-earmark-text fs-5"></i>
            <span class="fw-semibold">Terms &amp; Conditions</span>
          </a>
          <a href="settings.php?tab=smtp" class="list-group-item list-group-item-action py-3 px-4 d-flex align-items-center gap-3 <?= $active_tab === 'smtp' ? 'active bg-primary border-primary text-white' : 'text-secondary' ?>">
            <i class="bi bi-envelope-check fs-5"></i>
            <span class="fw-semibold">SMTP Configurations</span>
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Right Side tab contents -->
  <div class="col-md-9 col-12">
    <div class="card border-0 shadow-sm">
      
      <!-- Tab CONTENT 1: Corporate Profile -->
      <?php if ($active_tab === 'profile'): ?>
        <form action="settings.php?tab=profile" method="POST" enctype="multipart/form-data">
          <div class="card-header bg-white py-3">
            <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-building text-primary me-2"></i>Corporate Profile Details</h5>
          </div>
          <div class="card-body p-4">
            <div class="row g-4 align-items-start mb-4">
              <!-- Current Logo visual display -->
              <div class="col-md-3 text-center">
                <span class="form-label d-block text-secondary small fw-bold mb-2">Company Logo</span>
                <div class="p-3 bg-light border rounded-3 d-flex align-items-center justify-content-center" style="height: 120px;">
                  <?php 
                    $logo = get_setting('company_logo', 'assets/images/logo.png');
                    if (!file_exists($logo)) {
                        $logo = 'assets/images/logo.png';
                    }
                  ?>
                  <img src="<?= $logo ?>?v=<?= time() ?>" class="img-fluid" style="max-height: 90px; object-fit: contain;" alt="Corporate Logo">
                </div>
              </div>
              <!-- Upload control -->
              <div class="col-md-9">
                <label for="company_logo" class="form-label fw-semibold text-secondary small">Upload New Logo Image</label>
                <input type="file" name="company_logo" id="company_logo" class="form-control" accept="image/*">
                <span class="text-xs text-muted mt-1 d-block" style="font-size: 0.75rem;">Supported Formats: PNG, JPG, JPEG, GIF. High-resolution horizontal layout recommended. Maximum size: 2MB.</span>
              </div>
            </div>

            <div class="row g-3">
              <div class="col-md-6">
                <label for="company_name" class="form-label fw-semibold text-secondary small">Company Legal Name <span class="text-danger">*</span></label>
                <input type="text" name="company_name" id="company_name" class="form-control" required value="<?= h(get_setting('company_name', 'Softex Technologies')) ?>">
              </div>
              <div class="col-md-6">
                <label for="company_phone" class="form-label fw-semibold text-secondary small">Company Phone Number</label>
                <input type="text" name="company_phone" id="company_phone" class="form-control" value="<?= h(get_setting('company_phone', '+92 345 0789192')) ?>">
              </div>
              <div class="col-md-6">
                <label for="company_email" class="form-label fw-semibold text-secondary small">Billing Support Email</label>
                <input type="email" name="company_email" id="company_email" class="form-control" value="<?= h(get_setting('company_email', 'info@softex.pk')) ?>">
              </div>
              <div class="col-md-6">
                <label for="company_website" class="form-label fw-semibold text-secondary small">Company Website</label>
                <input type="text" name="company_website" id="company_website" class="form-control" value="<?= h(get_setting('company_website', 'www.softex.pk')) ?>">
              </div>
              <div class="col-12">
                <label for="company_address" class="form-label fw-semibold text-secondary small">Physical Corporate Address</label>
                <textarea name="company_address" id="company_address" class="form-control" rows="3"><?= h(get_setting('company_address', "H606 Nisther Block Iqbal Town, Lahore, Pakistan")) ?></textarea>
              </div>
            </div>
          </div>
          <div class="card-footer bg-light py-3 text-end">
            <button type="submit" name="save_profile" class="btn btn-primary px-4">
              <i class="bi bi-save me-1"></i> Save Profile Details
            </button>
          </div>
        </form>
      <?php endif; ?>

      <!-- Tab CONTENT 2: Terms & Conditions -->
      <?php if ($active_tab === 'terms'): ?>
        <form action="settings.php?tab=terms" method="POST">
          <div class="card-header bg-white py-3">
            <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-file-earmark-text text-primary me-2"></i>Invoice Terms &amp; Conditions</h5>
          </div>
          <div class="card-body p-4">
            <p class="text-muted small mb-3">These terms are pre-loaded at the bottom corner of each generated PDF and printable invoice ledger.</p>
            
            <div class="mb-3">
              <label for="terms_conditions" class="form-label fw-semibold text-secondary small">Terms Specifications (One rule per line recommended)</label>
              <textarea name="terms_conditions" id="terms_conditions" class="form-control font-monospace" rows="8" style="font-size: 0.9rem; line-height: 1.5;"><?= h(get_setting('terms_conditions', "1. Payment due within 7 days.\n2. No refund after payment confirmation.\n3. Thank you for your business.")) ?></textarea>
            </div>
          </div>
          <div class="card-footer bg-light py-3 text-end">
            <button type="submit" name="save_terms" class="btn btn-primary px-4">
              <i class="bi bi-save me-1"></i> Save Terms &amp; Conditions
            </button>
          </div>
        </form>
      <?php endif; ?>

      <!-- Tab CONTENT 3: SMTP Settings -->
      <?php if ($active_tab === 'smtp'): ?>
        <form action="settings.php?tab=smtp" method="POST">
          <div class="card-header bg-white py-3">
            <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-envelope-check text-primary me-2"></i>Secure SMTP Transport Parameters</h5>
          </div>
          <div class="card-body p-4">
            <p class="text-muted small mb-4">Set up your outgoing SMTP mail server to securely email PDF statements directly to client mailboxes.</p>
            
            <div class="row g-3">
              <div class="col-md-8">
                <label for="smtp_host" class="form-label fw-semibold text-secondary small">SMTP Host/Server</label>
                <input type="text" name="smtp_host" id="smtp_host" class="form-control font-monospace" placeholder="e.g. smtp.gmail.com or mail.yourdomain.com" value="<?= h(get_setting('smtp_host', 'smtp.softex.pk')) ?>">
              </div>
              <div class="col-md-4">
                <label for="smtp_port" class="form-label fw-semibold text-secondary small">SMTP Port</label>
                <input type="number" name="smtp_port" id="smtp_port" class="form-control font-monospace" placeholder="e.g. 587 or 465" value="<?= h(get_setting('smtp_port', '587')) ?>">
              </div>
              <div class="col-md-6">
                <label for="smtp_user" class="form-label fw-semibold text-secondary small">SMTP Username/Email Address</label>
                <input type="text" name="smtp_user" id="smtp_user" class="form-control font-monospace" placeholder="e.g. billing@yourdomain.com" value="<?= h(get_setting('smtp_user', 'info@softex.pk')) ?>">
              </div>
              <div class="col-md-6">
                <label for="smtp_pass" class="form-label fw-semibold text-secondary small">SMTP Password</label>
                <input type="password" name="smtp_pass" id="smtp_pass" class="form-control font-monospace" placeholder="••••••••••••" value="<?= h(get_setting('smtp_pass', 'secure_password_here')) ?>">
              </div>
              <div class="col-md-6">
                <label for="smtp_secure" class="form-label fw-semibold text-secondary small">Transport Security/Encryption Type</label>
                <select name="smtp_secure" id="smtp_secure" class="form-select">
                  <option value="tls" <?= get_setting('smtp_secure', 'tls') === 'tls' ? 'selected' : '' ?>>TLS (Recommended - Standard port 587)</option>
                  <option value="ssl" <?= get_setting('smtp_secure', 'ssl') === 'ssl' ? 'selected' : '' ?>>SSL (Standard port 465)</option>
                  <option value="" <?= get_setting('smtp_secure') === '' ? 'selected' : '' ?>>None (Plain-text - Not Recommended)</option>
                </select>
              </div>
            </div>
            
            <div class="mt-4 p-3 bg-light rounded-3 border">
              <span class="d-block fw-bold text-dark small mb-1"><i class="bi bi-info-circle text-primary me-2"></i>SMTP Transport Tip:</span>
              <span class="text-xs text-secondary d-block" style="font-size: 0.8rem; line-height: 1.4;">If utilizing Google Gmail SMTP server, remember to configure an "App Password" under your Google Account Security preferences instead of your primary Gmail login password.</span>
            </div>
          </div>
          <div class="card-footer bg-light py-3 text-end">
            <button type="submit" name="save_smtp" class="btn btn-primary px-4">
              <i class="bi bi-save me-1"></i> Save SMTP Credentials
            </button>
          </div>
        </form>
      <?php endif; ?>

    </div>
  </div>
</div>

<?php include 'footer.php'; ?>
