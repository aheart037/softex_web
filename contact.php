<?php
/**
 * contact.php — Softex Technologies v5
 * SMTP via mail.softex.pk:465 (SSL)
 * Admin → info@softex.pk · Client → visitor's address
 */
$pageTitle    = 'Contact Us — Get a Free Project Proposal';
$pageDesc     = 'Contact Softex Technologies for web design, software development, mobile apps or AI solutions. Get a free, transparent proposal within 24 hours.';
$pageKeywords = 'contact Softex Technologies, hire web developer Pakistan, software development quote Lahore, mobile app development Pakistan contact';

require_once 'includes/mailer.php';
require_once 'includes/email-templates.php';

// ── 🆕 reCAPTCHA keys (replace with your own) ──
define('RECAPTCHA_SITE_KEY', '6LewNEktAAAAALA2wEbag94f4aAulUp2apKpNX9M');
define('RECAPTCHA_SECRET_KEY', '6LewNEktAAAAAOJmDGFW1WTs7Hu8xAd2jQS7A_lF');
define('RECAPTCHA_ENABLED',    true);

/**
 * 🆕 Verify Google reCAPTCHA response
 */
function verifyRecaptcha($response) {
    if (!RECAPTCHA_ENABLED) return true;
    if (empty($response)) return false;

    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = [
        'secret'   => RECAPTCHA_SECRET_KEY,
        'response' => $response,
        'remoteip' => $_SERVER['REMOTE_ADDR'] ?? ''
    ];

    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        ]
    ];
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === false) return false;

    $json = json_decode($result, true);
    return $json['success'] ?? false;
}

$sent   = false;
$errors = [];
$fv     = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Honeypot
  if (!empty($_POST['_hp'])) { $sent = true; }
  else {
    $fv = [
      'name'    => trim(htmlspecialchars(strip_tags($_POST['name']    ?? ''))),
      'email'   => trim(filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL)),
      'phone'   => trim(htmlspecialchars(strip_tags($_POST['phone']   ?? ''))),
      'subject' => trim(htmlspecialchars(strip_tags($_POST['subject'] ?? ''))),
      'service' => trim(htmlspecialchars(strip_tags($_POST['service'] ?? 'Not specified'))),
      'message' => trim(htmlspecialchars(strip_tags($_POST['message'] ?? ''))),
      'year'    => date('Y'),
    ];

    // Validation
    if (empty($fv['name']) || strlen($fv['name']) < 2)
      $errors[] = 'Please enter your full name.';
    elseif (empty($fv['email']) || !filter_var($fv['email'], FILTER_VALIDATE_EMAIL))
      $errors[] = 'Please enter a valid email address.';
    elseif (empty($fv['subject']))
      $errors[] = 'Please enter a project title or subject.';
    elseif (empty($fv['message']) || strlen($fv['message']) < 15)
      $errors[] = 'Please write a bit more about your project (at least 15 characters).';

    // 🆕 reCAPTCHA check
    $recaptchaResponse = $_POST['g-recaptcha-response'] ?? '';
    if (!verifyRecaptcha($recaptchaResponse)) {
        $errors[] = 'Please complete the reCAPTCHA verification.';
    }

    if (empty($errors)) {
      $mailer = getSMTPMailer();

      // ── 1. Admin notification → info@softex.pk
      $adminOk = $mailer->send(
        'info@softex.pk',               // To
        'Softex Team',                  // To name
        '🔔 New Enquiry: ' . $fv['subject'] . ' — from ' . $fv['name'],
        buildAdminEmail($fv),
        'info@softex.pk',               // From
        'Softex Technologies',          // From name
        $fv['email']                    // Reply-To → visitor
      );

      // ── 2. Client confirmation → visitor's email
      $clientOk = $mailer->send(
        $fv['email'],                   // To → visitor
        $fv['name'],                    // To name
        '✅ We received your message — Softex Technologies',
        buildClientEmail($fv),
        'info@softex.pk',               // From
        'Softex Technologies',          // From name
        'info@softex.pk'                // Reply-To → admin
      );

      if ($adminOk || $clientOk) {
        $sent = true;
        $fv   = [];
      } else {
        $errors[] = 'Mail server error: ' . $mailer->getLastError() . '. Please email us directly at info@softex.pk';
      }
    }
  }
}

require_once 'includes/header.php';
?>

<!-- PAGE HERO -->
<section class="page-hero">
  <div class="scene page-hero-scene" data-scene="rings" aria-hidden="true">
    <div class="scene-fallback"></div>
  </div>
  <div class="hero-grid-bg"></div>
  <div class="hero-scrim"></div>
  <div class="wrap">
    <div class="page-hero-content" id="main-content" data-reveal>
      <nav class="breadcrumb"><a href="index.php">Home</a><span class="sep"> › </span><span>Contact Us</span></nav>
      <div class="eyebrow" style="margin:0 auto 1rem"><i class="fas fa-envelope"></i> Get In Touch</div>
      <h1 class="h1" style="margin-bottom:1rem">Start Your <span class="gradient-text">Next Project</span></h1>
      <p class="lead" style="margin:0 auto;max-width:520px">
        Tell us about your idea. We'll review it personally and send you a free, transparent proposal within 24 hours.
      </p>
    </div>
  </div>
</section>

<!-- CONTACT SECTION — 3D globe/network environment -->
<section class="section" style="position:relative;overflow:hidden">
  <div class="scene contact-scene" data-scene="globe" aria-hidden="true">
    <div class="scene-fallback"></div>
  </div>
  <div class="wrap">
    <div class="contact-wrap">

      <!-- Sidebar -->
      <div data-reveal>
        <div class="eyebrow"><i class="fas fa-map-marker-alt"></i> Contact Info</div>
        <h2 class="h3" style="margin-bottom:.6rem">We'd Love to Hear From You</h2>
        <p style="color:var(--t2);font-size:.88rem;line-height:1.88;margin-bottom:2rem">
          Whether you have a clear brief or just a rough idea — our team responds to every enquiry personally within hours.
        </p>

        <div class="ci-block">
          <div class="ci-ico"><i class="fas fa-envelope"></i></div>
          <div><div class="ci-head">Email Us</div>
          <div class="ci-val"><a href="mailto:info@softex.pk">info@softex.pk</a></div></div>
        </div>
        <div class="ci-block">
          <div class="ci-ico"><i class="fas fa-phone"></i></div>
          <div><div class="ci-head">Call Us</div>
          <div class="ci-val"><a href="tel:+923450789192">+92 345 0789192</a></div></div>
        </div>
        <div class="ci-block">
          <div class="ci-ico"><i class="fas fa-map-marker-alt"></i></div>
          <div><div class="ci-head">Location</div>
          <div class="ci-val">Lahore, Punjab, Pakistan</div></div>
        </div>
        <div class="ci-block">
          <div class="ci-ico"><i class="fas fa-clock"></i></div>
          <div><div class="ci-head">Business Hours</div>
          <div class="ci-val">Mon – Sat &nbsp;·&nbsp; 9:00 AM – 6:00 PM PKT</div></div>
        </div>
        <div class="ci-block">
          <div class="ci-ico" style="background:rgba(16,185,129,.1);border-color:rgba(16,185,129,.25)">
            <i class="fas fa-bolt" style="color:#4ade80"></i>
          </div>
          <div><div class="ci-head">Avg. Response Time</div>
          <div class="ci-val" style="color:#4ade80">Within 4 Business Hours</div></div>
        </div>

        <p style="font-size:.7rem;text-transform:uppercase;letter-spacing:.14em;color:var(--t3);font-weight:700;margin-bottom:.65rem">Follow Us</p>
        <div class="social-strip">
          <a href="https://facebook.com/softexpak/"       target="_blank" rel="noopener" class="soc-btn" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
          <a href="https://twitter.com/softexpak/"        target="_blank" rel="noopener" class="soc-btn" aria-label="Twitter"><i class="fab fa-x-twitter"></i></a>
          <a href="https://instagram.com/sotexpak/"       target="_blank" rel="noopener" class="soc-btn" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
          <a href="https://linkedin.com/company/sotexpak/" target="_blank" rel="noopener" class="soc-btn" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
        </div>

        <div style="margin-top:1.8rem;background:linear-gradient(135deg,rgba(255,77,62,.1),rgba(6,182,212,.05));border:1px solid rgba(255,77,62,.22);border-radius:12px;padding:1.1rem 1.3rem">
          <p style="font-size:.82rem;color:var(--t1);line-height:1.75;margin:0">
            <strong style="color:var(--or)">🔒 Our Promise:</strong> Every enquiry is reviewed personally. Your information is 100% confidential and never shared.
          </p>
        </div>
      </div>

      <!-- Form -->
      <div data-reveal data-delay="2">
        <div class="cf-box">
          <h2 class="cf-heading">Send Us a Message</h2>
          <p class="cf-sub">Fill in the form and we'll get back to you with a personalised proposal.</p>

          <?php if($sent): ?>
          <div class="alert alert-ok show" role="alert">
            <i class="fas fa-check-circle"></i>
            <div><strong>Message sent successfully!</strong><br>
              <span style="font-size:.82rem">Thank you! A confirmation has been sent to your email. Our team will be in touch within 24 hours.</span>
            </div>
          </div>
          <?php endif; ?>

          <div class="alert alert-err <?= !empty($errors) ? 'show' : '' ?>" id="formError" role="alert">
            <i class="fas fa-exclamation-circle"></i>
            <div><?php if(!empty($errors)): ?>
              <strong>Please fix:</strong>
              <ul style="margin:.3rem 0 0 1rem;font-size:.82rem">
                <?php foreach($errors as $e): ?><li><?= $e ?></li><?php endforeach; ?>
              </ul>
            <?php else: ?>Please fill in all required fields correctly.<?php endif; ?>
            </div>
          </div>

          <form id="contactForm" method="POST" action="contact.php" novalidate>
            <!-- Honeypot -->
            <div style="position:absolute;left:-9999px;height:0;overflow:hidden" aria-hidden="true">
              <input type="text" name="_hp" tabindex="-1" autocomplete="off" value="">
            </div>

            <div class="form-row">
              <div class="form-group">
                <label for="f-name">Full Name <span class="req">*</span></label>
                <input type="text" id="f-name" name="name" placeholder="Ali Khan"
                  value="<?= htmlspecialchars($fv['name'] ?? '') ?>" required autocomplete="name">
              </div>
              <div class="form-group">
                <label for="f-email">Email Address <span class="req">*</span></label>
                <input type="email" id="f-email" name="email" placeholder="ali@company.com"
                  value="<?= htmlspecialchars($fv['email'] ?? '') ?>" required autocomplete="email">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group">
                <label for="f-phone">Phone Number</label>
                <input type="tel" id="f-phone" name="phone" placeholder="+92 300 0000000"
                  value="<?= htmlspecialchars($fv['phone'] ?? '') ?>" autocomplete="tel">
              </div>
              <div class="form-group">
                <label for="f-service">Service Interested In</label>
                <select id="f-service" name="service">
                  <option value="Not specified">— Select a service —</option>
                  <?php foreach(['Web Development','Software Development','Mobile App (iOS/Android)','E-Commerce (Shopify/WooCommerce)','AI Integration','SEO & Digital Marketing','UI/UX Design','Other'] as $o): ?>
                  <option value="<?= htmlspecialchars($o) ?>" <?= ($fv['service']??'')===$o?'selected':'' ?>><?= htmlspecialchars($o) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="f-subject">Project Title / Subject <span class="req">*</span></label>
              <input type="text" id="f-subject" name="subject"
                placeholder="e.g. Custom E-Commerce Store for my clothing brand"
                value="<?= htmlspecialchars($fv['subject'] ?? '') ?>" required>
            </div>
            <div class="form-group">
              <label for="f-message">Message <span class="req">*</span></label>
              <textarea id="f-message" name="message" required
                placeholder="Tell us about your project — goals, timeline, and budget. The more detail, the better we can help."><?= htmlspecialchars($fv['message'] ?? '') ?></textarea>
            </div>

            <!-- 🆕 reCAPTCHA widget -->
            <div class="form-group" style="margin:1.5rem 0 1rem">
                <div class="g-recaptcha" data-sitekey="<?= RECAPTCHA_SITE_KEY ?>"></div>
            </div>

            <!-- 🆕 Load reCAPTCHA API -->
            <script src="https://www.google.com/recaptcha/api.js" async defer></script>

            <button type="submit" class="btn btn-primary btn-block" style="padding:.95rem;font-size:.9rem">
              <i class="fas fa-paper-plane"></i> Send Message &amp; Get Free Proposal
            </button>
            <p style="font-size:.74rem;color:var(--t3);text-align:center;margin-top:.8rem;line-height:1.75">
              <i class="fas fa-lock" style="color:var(--or)"></i>
              Your data is secure. We reply to every message personally within 24 hours.
            </p>
          </form>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- WHAT HAPPENS NEXT -->
<section class="section section-bg1">
  <div class="wrap">
    <div class="center" data-reveal>
      <div class="eyebrow"><i class="fas fa-route"></i> Our Process</div>
      <h2 class="h2" style="margin-bottom:1rem">What Happens After <span class="gradient-text">You Contact Us</span></h2>
    </div>
    <div class="process-grid">
      <?php foreach([
        ['01','📬','We Review Your Enquiry',  'Our team reads every message carefully and personally before responding.'],
        ['02','📞','Free Consultation',        'We schedule a no-obligation call to understand your scope, goals and timeline.'],
        ['03','📋','Detailed Proposal',        'You receive a transparent proposal — deliverables, timeline and fixed pricing.'],
        ['04','🚀','Kickoff & Development',    'We assign your dedicated team and begin building with regular progress updates.'],
        ['05','✅','QA &amp; Delivery',        'Thorough testing before launch. We deliver on time and on budget.'],
        ['06','🔧','Ongoing Support',          'We remain your long-term partner — updates, growth and continuous support.'],
      ] as $i=>[$n,$ico,$title,$desc]): ?>
      <div class="proc-step" data-reveal data-delay="<?= ($i%3)+1 ?>">
        <div class="proc-num"><?= $n ?></div>
        <div class="proc-title"><?= $ico ?> <?= $title ?></div>
        <p class="proc-desc"><?= $desc ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="cta-band">
  <div class="scene cta-scene" data-scene="orb" data-orb-plain aria-hidden="true">
    <div class="scene-fallback"></div>
  </div>
  <div class="wrap">
    <div data-reveal>
      <div class="cta-box">
        <h2>Ready to Build Something <span class="gradient-text">Extraordinary?</span></h2>
        <p>Join 150+ businesses that trust Softex Technologies to power their digital growth.</p>
        <div class="cta-btns">
          <a href="tel:+923450789192" class="btn btn-primary btn-lg"><i class="fas fa-phone"></i> Call Us Now</a>
          <a href="portfolio.php" class="btn btn-ghost btn-lg">Explore Our Work</a>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require_once 'includes/footer.php'; ?>