<?php
$pageTitle    = 'Our Services — Web Design, Software Development & More';
$pageDesc     = 'Softex Technologies offers web development, custom software, mobile apps, e-commerce (Shopify/WooCommerce), SEO, UI/UX design and AI solutions for businesses worldwide.';
$pageKeywords = 'web development Pakistan, software development services Lahore, mobile app development, Shopify development Pakistan, WooCommerce, SEO digital marketing Pakistan';
require_once 'includes/header.php';

$services = [
  ['id'=>'web',      'icon'=>'🌐','title'=>'Web Development',
   'img'=>'https://images.unsplash.com/photo-1547658719-da2b51169166?w=720&q=80',
   'desc'=>'Custom, high-performance websites built with modern technologies. Fast, secure, and designed to convert visitors into customers — from corporate portals to complex web applications.',
   'points'=>['Custom WordPress & CMS websites','React, Vue & Next.js web apps','Landing pages built for conversion','Performance & Core Web Vitals optimisation','Hosting, SSL & ongoing maintenance']],

  ['id'=>'software', 'icon'=>'⚙️','title'=>'Software Development',
   'img'=>'https://images.unsplash.com/photo-1461749280684-dccba630e2f6?w=720&q=80',
   'desc'=>'Bespoke software that transforms your operations. We use agile methodologies to deliver scalable web apps, integrations and enterprise products just right for your workflow.',
   'points'=>['Custom business applications & SaaS','ERP, CRM & internal tool development','REST API & third-party integrations','Cloud-native architecture (AWS, Azure, GCP)','Secure, tested & well-documented code']],

  ['id'=>'apps',     'icon'=>'📱','title'=>'Android &amp; iOS Apps',
   'img'=>'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?w=720&q=80',
   'desc'=>'Native and cross-platform mobile apps that users love. Clean interfaces, smooth performance, reliable back-ends — from consumer apps to enterprise mobile tools.',
   'points'=>['Native Android & iOS development','React Native / Flutter cross-platform apps','Intuitive UI/UX for mobile','App Store & Play Store submission','Push notifications & analytics']],

  ['id'=>'ecommerce','icon'=>'🛒','title'=>'E-Commerce Solutions',
   'img'=>'https://images.unsplash.com/photo-1563013544-824ae1b704d3?w=720&q=80',
   'desc'=>'7+ years building online stores that sell. From Shopify and WooCommerce to fully custom e-commerce platforms — design, development, payment integration and conversion optimisation.',
   'points'=>['WooCommerce & Shopify development','Custom checkout & payment gateways','Multi-vendor & marketplace platforms','Product management & inventory systems','CRO audits & A/B testing']],

  ['id'=>'seo',      'icon'=>'📈','title'=>'SEO &amp; Digital Marketing',
   'img'=>'https://images.unsplash.com/photo-1432888622747-4eb9a8efeb07?w=720&q=80',
   'desc'=>'Data-driven SEO and digital marketing campaigns that drive qualified traffic and deliver measurable ROI. We combine technical expertise with content strategy across all digital channels.',
   'points'=>['Technical & on-page SEO audits','Content strategy & creation','Google Ads & PPC management','Social media strategy & management','Monthly performance reporting']],

  ['id'=>'shopify',  'icon'=>'🎨','title'=>'Shopify &amp; UI/UX Design',
   'img'=>'https://images.unsplash.com/photo-1561070791-2526d30994b5?w=720&q=80',
   'desc'=>'Expert Shopify development and user-centred design that blends aesthetics with functionality — intuitive interfaces that delight users and strengthen your brand at every touchpoint.',
   'points'=>['Custom Shopify themes & apps','Shopify Plus development','User research & persona mapping','Wireframing & interactive prototypes','Design systems & brand consistency']],
];
?>

<!-- ══════════════════════════════════════
     PAGE HERO — helix
══════════════════════════════════════ -->
<section class="page-hero">
  <div class="fx-host hero-fx" data-scene="helix" data-cam-z="14" aria-hidden="true"></div>
  <div class="orb orb-or" style="width:500px;height:500px;top:-120px;right:-80px;opacity:.8" aria-hidden="true"></div>
  <div class="orb orb-cy" style="width:350px;height:350px;bottom:0;left:-50px;opacity:.5" aria-hidden="true"></div>
  <div class="hero-grid-bg"></div>
  <div class="hud" aria-hidden="true">
    <span class="hud-corner tl"></span>
    <span class="hud-corner tr"></span>
    <span class="hud-corner bl"></span>
    <span class="hud-corner br"></span>
    <span class="hud-tag">SYS // SERVICE MODULES · 06 LOADED</span>
  </div>
  <div class="wrap">
    <div class="page-hero-content" data-reveal>
      <nav class="breadcrumb" aria-label="Breadcrumb"><a href="index.php">Home</a><span class="sep"> › </span><span>Services</span></nav>
      <div class="eyebrow" style="margin:0 auto 1rem"><i class="fas fa-cogs" aria-hidden="true"></i> What We Do</div>
      <h1 class="h1" style="margin-bottom:1rem">Our <span class="gradient-text">Services</span></h1>
      <p class="lead" style="margin:0 auto">End-to-end digital solutions — from beautiful websites to enterprise software and e-commerce stores that convert.</p>
    </div>
  </div>
</section>

<?php foreach($services as $idx=>$s):
  $even = $idx % 2 === 0; ?>
<section class="section" <?= !$even ? 'style="background:var(--bg1)"' : '' ?> id="<?= $s['id'] ?>">
  <div class="wrap">
    <div class="split <?= !$even ? 'flip' : '' ?>">

      <?php if($even): ?>
      <div class="split-text" data-reveal>
        <div class="eyebrow"><i class="fas fa-code" aria-hidden="true"></i> Service <?= str_pad($idx+1,2,'0',STR_PAD_LEFT) ?></div>
        <h2 class="h3" style="font-size:clamp(1.6rem,2.8vw,2.3rem);margin-bottom:.9rem"><?= $s['icon'] ?> <?= $s['title'] ?></h2>
        <p style="color:var(--t2);margin-bottom:1.1rem;line-height:1.9"><?= $s['desc'] ?></p>
        <ul class="check-list">
          <?php foreach($s['points'] as $p): ?><li><span class="chk" aria-hidden="true">✓</span><?= $p ?></li><?php endforeach; ?>
        </ul>
        <a href="contact.php" class="btn btn-primary" style="margin-top:1rem">Get a Quote <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
      </div>
      <div class="split-visual" data-reveal data-delay="2">
        <div class="img-frame"><img src="<?= $s['img'] ?>" alt="<?= strip_tags($s['title']) ?>" loading="lazy"></div>
      </div>

      <?php else: ?>
      <div class="split-visual" data-reveal>
        <div class="img-frame"><img src="<?= $s['img'] ?>" alt="<?= strip_tags($s['title']) ?>" loading="lazy"></div>
      </div>
      <div class="split-text" data-reveal data-delay="2">
        <div class="eyebrow"><i class="fas fa-code" aria-hidden="true"></i> Service <?= str_pad($idx+1,2,'0',STR_PAD_LEFT) ?></div>
        <h2 class="h3" style="font-size:clamp(1.6rem,2.8vw,2.3rem);margin-bottom:.9rem"><?= $s['icon'] ?> <?= $s['title'] ?></h2>
        <p style="color:var(--t2);margin-bottom:1.1rem;line-height:1.9"><?= $s['desc'] ?></p>
        <ul class="check-list">
          <?php foreach($s['points'] as $p): ?><li><span class="chk" aria-hidden="true">✓</span><?= $p ?></li><?php endforeach; ?>
        </ul>
        <a href="contact.php" class="btn btn-primary" style="margin-top:1rem">Get a Quote <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
      </div>
      <?php endif; ?>

    </div>
  </div>
</section>
<?php endforeach; ?>

<!-- ══════════════════════════════════════
     PROCESS — grid-wave
══════════════════════════════════════ -->
<section class="section" style="background:var(--bg1)">
  <div class="fx-host" data-scene="grid-wave" data-cam-z="8" data-cam-y="2.4" aria-hidden="true"></div>
  <div class="wrap">
    <div class="center" data-reveal>
      <div class="eyebrow"><i class="fas fa-route" aria-hidden="true"></i> How We Work</div>
      <h2 class="h2" style="margin-bottom:1rem">Our <span class="gradient-text">Proven Process</span></h2>
      <p class="lead">A clear, collaborative workflow that keeps you informed and in control from kickoff to launch.</p>
    </div>
    <div class="process-grid">
      <?php foreach([
        ['01','Discovery',  'We learn your goals, audience, and technical requirements in depth.'],
        ['02','Strategy',   'We define the roadmap, tech stack, and success metrics.'],
        ['03','Design',     'Wireframes and high-fidelity mockups refined to perfection.'],
        ['04','Development','Clean, tested, well-documented code built iteratively.'],
        ['05','QA Testing', 'Rigorous testing across devices, browsers and edge cases.'],
        ['06','Launch',     'Smooth deployment followed by ongoing care and growth support.'],
      ] as $i=>[$n,$t,$d]): ?>
      <div class="proc-step" data-reveal data-delay="<?= ($i%3)+1 ?>">
        <div class="proc-num"><?= $n ?></div>
        <div class="proc-title"><?= $t ?></div>
        <p class="proc-desc"><?= $d ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="cta-band">
  <div class="fx-host" data-scene="neural-core" data-cam-z="12" data-scale="0.85" aria-hidden="true"></div>
  <div class="orb orb-or" style="width:500px;height:500px;top:50%;left:50%;transform:translate(-50%,-50%)" aria-hidden="true"></div>
  <div class="wrap"><div data-reveal>
    <div class="cta-box">
      <h2>Ready to Get <span class="gradient-text">Started?</span></h2>
      <p>Tell us about your project — we'll prepare a free, detailed proposal with timeline and pricing.</p>
      <div class="cta-btns">
        <a href="contact.php" class="btn btn-primary btn-lg btn-glow"><i class="fas fa-paper-plane" aria-hidden="true"></i> Request Free Proposal</a>
        <a href="portfolio.php" class="btn btn-ghost btn-lg">See Our Portfolio</a>
      </div>
    </div>
  </div></div>
</section>

<?php require_once 'includes/footer.php'; ?>
