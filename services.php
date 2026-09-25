<?php
$pageTitle    = 'Our Services — Web Design, Software Development & More';
$pageDesc     = 'Softex Technologies offers web development, custom software, mobile apps, e-commerce (Shopify/WooCommerce), SEO, UI/UX design and AI solutions for businesses worldwide.';
$pageKeywords = 'web development Pakistan, software development services Lahore, mobile app development, Shopify development Pakistan, WooCommerce, SEO digital marketing Pakistan';

require_once 'includes/header.php';
require_once 'includes/service-objects.php';

$services = [
  ['id'=>'web',      'obj'=>'web',      'icon'=>'🌐','title'=>'Web Development',
   'desc'=>'Custom, high-performance websites built with modern technologies. Fast, secure, and designed to convert visitors into customers — from corporate portals to complex web applications.',
   'points'=>['Custom WordPress & CMS websites','React, Vue & Next.js web apps','Landing pages built for conversion','Performance & Core Web Vitals optimisation','Hosting, SSL & ongoing maintenance']],

  ['id'=>'software', 'obj'=>'software', 'icon'=>'⚙️','title'=>'Software Development',
   'desc'=>'Bespoke software that transforms your operations. We use agile methodologies to deliver scalable web apps, integrations and enterprise products just right for your workflow.',
   'points'=>['Custom business applications & SaaS','ERP, CRM & internal tool development','REST API & third-party integrations','Cloud-native architecture (AWS, Azure, GCP)','Secure, tested & well-documented code']],

  ['id'=>'apps',     'obj'=>'apps',     'icon'=>'📱','title'=>'Android &amp; iOS Apps',
   'desc'=>'Native and cross-platform mobile apps that users love. Clean interfaces, smooth performance, reliable back-ends — from consumer apps to enterprise mobile tools.',
   'points'=>['Native Android & iOS development','React Native / Flutter cross-platform apps','Intuitive UI/UX for mobile','App Store & Play Store submission','Push notifications & analytics']],

  ['id'=>'ecommerce','obj'=>'ecommerce','icon'=>'🛒','title'=>'E-Commerce Solutions',
   'desc'=>'7+ years building online stores that sell. From Shopify and WooCommerce to fully custom e-commerce platforms — design, development, payment integration and conversion optimisation.',
   'points'=>['WooCommerce & Shopify development','Custom checkout & payment gateways','Multi-vendor & marketplace platforms','Product management & inventory systems','CRO audits & A/B testing']],

  ['id'=>'seo',      'obj'=>'seo',      'icon'=>'📈','title'=>'SEO &amp; Digital Marketing',
   'desc'=>'Data-driven SEO and digital marketing campaigns that drive qualified traffic and deliver measurable ROI. We combine technical expertise with content strategy across all digital channels.',
   'points'=>['Technical & on-page SEO audits','Content strategy & creation','Google Ads & PPC management','Social media strategy & management','Monthly performance reporting']],

  ['id'=>'shopify',  'obj'=>'shopify',  'icon'=>'🎨','title'=>'Shopify &amp; UI/UX Design',
   'desc'=>'Expert Shopify development and user-centred design that blends aesthetics with functionality — intuitive interfaces that delight users and strengthen your brand at every touchpoint.',
   'points'=>['Custom Shopify themes & apps','Shopify Plus development','User research & persona mapping','Wireframing & interactive prototypes','Design systems & brand consistency']],
];
?>

<section class="page-hero">
  <div class="scene page-hero-scene" data-scene="rings" aria-hidden="true">
    <div class="scene-fallback"></div>
  </div>
  <div class="hero-grid-bg"></div>
  <div class="hero-scrim"></div>
  <div class="wrap">
    <div class="page-hero-content" id="main-content" data-reveal>
      <nav class="breadcrumb"><a href="index.php">Home</a><span class="sep"> › </span><span>Services</span></nav>
      <div class="eyebrow" style="margin:0 auto 1rem"><i class="fas fa-cogs"></i> What We Do</div>
      <h1 class="h1" style="margin-bottom:1rem">Our <span class="gradient-text">Services</span></h1>
      <p class="lead" style="margin:0 auto">End-to-end digital solutions — from beautiful websites to enterprise software and e-commerce stores that convert.</p>
    </div>
  </div>
</section>

<?php foreach($services as $idx=>$s):
  $even = $idx % 2 === 0; ?>
<section class="section <?= !$even ? 'section-bg1' : '' ?>" id="<?= $s['id'] ?>" style="scroll-margin-top:90px">
  <div class="wrap">
    <div class="split <?= !$even ? 'flip' : '' ?>">

      <div class="split-text" data-reveal="<?= $even ? 'left' : 'right' ?>">
        <div class="eyebrow"><i class="fas fa-code"></i> Service <?= str_pad($idx+1,2,'0',STR_PAD_LEFT) ?></div>
        <h2 class="h3" style="font-size:clamp(1.6rem,2.8vw,2.3rem);margin-bottom:.9rem"><?= $s['icon'] ?> <?= $s['title'] ?></h2>
        <p style="color:var(--t2);margin-bottom:1.1rem;line-height:1.9"><?= $s['desc'] ?></p>
        <ul class="check-list">
          <?php foreach($s['points'] as $p): ?><li><span class="chk">✓</span><?= $p ?></li><?php endforeach; ?>
        </ul>
        <a href="contact.php" class="btn btn-primary" style="margin-top:1rem">Get a Quote <i class="fas fa-arrow-right"></i></a>
      </div>

      <div class="split-visual svc-figure" data-reveal data-delay="2">
        <?php render_service_object($s['obj'], true); ?>
      </div>

    </div>
  </div>
</section>
<?php endforeach; ?>

<!-- PROCESS — connected 3D workflow -->
<section class="section section-bg1" style="position:relative">
  <div class="wrap">
    <div class="center" data-reveal>
      <div class="eyebrow"><i class="fas fa-route"></i> How We Work</div>
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
  <div class="scene cta-scene" data-scene="orb" data-orb-plain aria-hidden="true">
    <div class="scene-fallback"></div>
  </div>
  <div class="wrap"><div data-reveal>
    <div class="cta-box">
      <h2>Ready to Get <span class="gradient-text">Started?</span></h2>
      <p>Tell us about your project — we'll prepare a free, detailed proposal with timeline and pricing.</p>
      <div class="cta-btns">
        <a href="contact.php" class="btn btn-primary btn-lg"><i class="fas fa-paper-plane"></i> Request Free Proposal</a>
        <a href="portfolio.php" class="btn btn-ghost btn-lg">See Our Portfolio</a>
      </div>
    </div>
  </div></div>
</section>

<style>
/* Large service figures — object stage styling on the services page */
.svc-figure{
  display:flex;align-items:center;justify-content:center;
  min-height:340px;
  border-radius:24px;
  background:
    radial-gradient(ellipse 60% 55% at 50% 46%,rgba(255,77,62,.06),transparent 70%),
    var(--glass);
  border:1px solid var(--glass-bd);
  box-shadow:inset 0 1px 0 rgba(255,255,255,.05),0 24px 60px rgba(0,0,0,.3);
  position:relative;overflow:hidden;
}
.svc-figure::before{
  content:'';position:absolute;inset:0;
  background-image:radial-gradient(circle,rgba(255,77,62,.09) 1px,transparent 1px);
  background-size:24px 24px;opacity:.5;
  mask-image:radial-gradient(ellipse 70% 70% at 50% 50%,black,transparent 80%);
  -webkit-mask-image:radial-gradient(ellipse 70% 70% at 50% 50%,black,transparent 80%);
}
.svc-figure .svc-obj{width:100%;margin:0}
@media(max-width:900px){
  .svc-figure{min-height:280px;padding:1rem 0}
}
</style>

<?php require_once 'includes/footer.php'; ?>
