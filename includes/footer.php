<?php
/**
 * includes/footer.php — Softex Technologies v6 (3D Digital Experience)
 * Client logos strip above footer · Content preserved from v5
 */
?>

<!-- ══════════════════════════════════════════
     CLIENT LOGOS STRIP (above footer)
══════════════════════════════════════════ -->
<section style="background:rgba(7,10,18,.72);border-top:1px solid rgba(255,77,62,.1);padding:3.5rem 0;position:relative;z-index:1">
  <div class="wrap">
    <div class="center" style="margin-bottom:2.5rem">
      <p style="font-size:.72rem;font-weight:700;letter-spacing:.18em;text-transform:uppercase;color:var(--t3)">
        Trusted by leading organisations
      </p>
    </div>
  </div>
  <div class="strip-wrap" style="border:none;background:transparent">
    <div class="strip-inner" style="padding:.8rem 0">
      <div class="marquee-track rev">
        <?php
        $clients = [
          'Almarah Foundation','National Highways Police','Smart Move',
          'Greenshine Cosmetics','Fareed Communications','Hum News',
          'Daily Rasta','MediTrack Pro','EduLearn LMS','PropHub',
          'UrbanEats','FinSight AI','PharmaChain','StyleHub',
          'Almarah Foundation','National Highways Police','Smart Move',
          'Greenshine Cosmetics','Fareed Communications','Hum News',
          'Daily Rasta','MediTrack Pro','EduLearn LMS','PropHub',
          'UrbanEats','FinSight AI','PharmaChain','StyleHub',
        ];
        $half = count($clients) / 2;
        $ci = 0;
        foreach ($clients as $c): ?>
        <div class="client-item"<?= $ci >= $half ? ' aria-hidden="true"' : '' ?>>
          <span class="cl-text"><?= htmlspecialchars($c) ?></span>
        </div>
        <?php $ci++; endforeach; ?>
      </div>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════════════
     SITE FOOTER
══════════════════════════════════════════ -->
<footer class="site-footer" role="contentinfo" itemscope itemtype="https://schema.org/WPFooter">
  <div class="footer-env" aria-hidden="true">
    <span class="f-dot"></span><span class="f-dot"></span><span class="f-dot"></span><span class="f-dot"></span><span class="f-dot"></span>
  </div>
  <div class="wrap">
    <div class="footer-grid">

      <!-- Brand -->
      <div class="footer-brand">
        <a href="index.php" class="logo" aria-label="Softex Technologies">
          <img src="assets/logo.png" alt="Softex Technologies" height="42">
        </a>
        <p>Building world-class digital products since 2015 — from AI-powered web apps to enterprise software and high-converting e-commerce stores. Your vision, our expertise.</p>
        <div class="awards-row">
          <img src="assets/award1.png" alt="SEO Company Badge 2019" title="SEO Company Badge 2019" loading="lazy" height="44">
          <img src="assets/award2.png" alt="The Landy Award" title="The Landy Award" loading="lazy" height="44">
        </div>
        <div class="social-strip">
          <a href="https://facebook.com/softexpak/"       target="_blank" rel="noopener noreferrer" class="soc-btn" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
          <a href="https://twitter.com/softexpak/"        target="_blank" rel="noopener noreferrer" class="soc-btn" aria-label="Twitter"><i class="fab fa-x-twitter"></i></a>
          <a href="https://instagram.com/sotexpak/"       target="_blank" rel="noopener noreferrer" class="soc-btn" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
          <a href="https://linkedin.com/company/sotexpak/" target="_blank" rel="noopener noreferrer" class="soc-btn" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
        </div>
      </div>

      <!-- Services -->
      <div class="footer-col">
        <h5>Services</h5>
        <ul>
          <li><a href="services.php#web"><i class="fas fa-chevron-right" style="font-size:.55rem;color:var(--or)"></i> Web Development</a></li>
          <li><a href="services.php#software"><i class="fas fa-chevron-right" style="font-size:.55rem;color:var(--or)"></i> Software Development</a></li>
          <li><a href="services.php#apps"><i class="fas fa-chevron-right" style="font-size:.55rem;color:var(--or)"></i> Android &amp; iOS Apps</a></li>
          <li><a href="services.php#ecommerce"><i class="fas fa-chevron-right" style="font-size:.55rem;color:var(--or)"></i> E-Commerce Solutions</a></li>
          <li><a href="services.php#seo"><i class="fas fa-chevron-right" style="font-size:.55rem;color:var(--or)"></i> SEO &amp; Marketing</a></li>
          <li><a href="services.php#shopify"><i class="fas fa-chevron-right" style="font-size:.55rem;color:var(--or)"></i> Shopify Development</a></li>
          <li><a href="services.php#ai"><i class="fas fa-chevron-right" style="font-size:.55rem;color:var(--or)"></i> AI Solutions</a></li>
        </ul>
      </div>

      <!-- Company -->
      <div class="footer-col">
        <h5>Company</h5>
        <ul>
          <li><a href="about.php"><i class="fas fa-chevron-right" style="font-size:.55rem;color:var(--or)"></i> About Us</a></li>
          <li><a href="portfolio.php"><i class="fas fa-chevron-right" style="font-size:.55rem;color:var(--or)"></i> Portfolio</a></li>
          <li><a href="contact.php"><i class="fas fa-chevron-right" style="font-size:.55rem;color:var(--or)"></i> Careers</a></li>
          <li><a href="contact.php"><i class="fas fa-chevron-right" style="font-size:.55rem;color:var(--or)"></i> Contact Us</a></li>
        </ul>
      </div>

      <!-- Contact -->
      <div class="footer-col footer-contact-col">
        <h5>Get In Touch</h5>
        <p><i class="fas fa-envelope"></i><a href="mailto:info@softex.pk">info@softex.pk</a></p>
        <p><i class="fas fa-phone"></i><a href="tel:+923450789192">+92 345 0789192</a></p>
        <p><i class="fas fa-map-marker-alt"></i><span>Lahore, Punjab, Pakistan</span></p>
        <p><i class="fas fa-clock"></i><span>Mon–Sat &nbsp;·&nbsp; 9 AM – 6 PM PKT</span></p>
      </div>

    </div>

    <div class="footer-bottom">
      <p>© 2015–<?= date('Y') ?> <strong style="color:var(--t1)">Softex Technologies</strong>. All rights reserved.</p>
      <p style="color:var(--t3)">Start of a New Technology Era</p>
    </div>

  </div>
</footer>

<!-- ══════════════════════════════════════════
     SCRIPTS — core behaviour, motion, 3D engine
══════════════════════════════════════════ -->
<script src="js/main.js" defer></script>
<script src="js/vendor/gsap.min.js" defer></script>
<script src="js/vendor/ScrollTrigger.min.js" defer></script>
<script src="js/animations.js" defer></script>
<script src="js/softex-3d.js" defer></script>
</body>
</html>
