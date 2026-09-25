<?php
$pageTitle    = 'Portfolio — 150+ Web, Software & AI Projects';
$pageDesc     = 'Browse Softex Technologies\' portfolio — 150+ successful web development, e-commerce, mobile app, AI and software projects delivered across Pakistan and globally since 2015.';
$pageKeywords = 'portfolio web development Pakistan, software projects Lahore, Shopify portfolio, mobile app projects, Softex Technologies work, e-commerce development examples';
require_once 'includes/header.php';

$projects = [
  // WEB
  ['Almarah Foundation',               'Web Development','web',
   'assets/portfolio/almarah.png',
   'NGO website with donation management, event calendar and multilingual support.',
   ['WordPress','PHP','MySQL']],

  ['National Highways &amp; Motorway Police','Web Development','web',
   'assets/portfolio/nhmp.png',
   'Government portal with real-time traffic reporting, fine management and public information.',
   ['Laravel','MySQL','Bootstrap']],

  ['PropHub Real Estate',              'Web Development','web',
   'assets/portfolio/webp/prophub.webp',
   'Property listing portal with map-based search, virtual tours and agent CRM.',
   ['Next.js','Prisma','Tailwind']],

  // E-COMMERCE
  ['Smart Move E-Commerce',            'E-Commerce','ecommerce',
   'assets/portfolio/smartmove.png',
   'Full-featured WooCommerce store with advanced search, product bundles and loyalty rewards.',
   ['WooCommerce','WordPress','Stripe']],

  ['Greenshine Cosmetics',             'Shopify Store','ecommerce',
   'assets/portfolio/greenshine.png',
   'Beauty brand Shopify store with custom product configurator and influencer discount tracking.',
   ['Shopify','Liquid','JavaScript']],

  ['StyleHub Fashion Store',           'E-Commerce','ecommerce',
   'assets/portfolio/webp/stylehub.webp',
   'High-fashion Shopify store with AR try-on integration and influencer dashboard.',
   ['Shopify','React','AR.js']],

  // SOFTWARE
  ['MediTrack Pro',                    'Software','software',
   'assets/portfolio/webp/meditrack.webp',
   'Healthcare patient management system with appointments, records and billing integration.',
   ['React','Node.js','MongoDB']],

  ['EduLearn LMS Platform',            'Software','software',
   'assets/portfolio/webp/edulearn.webp',
   'Learning management system for 10,000+ students — video courses, quizzes and certificates.',
   ['Vue.js','Laravel','PostgreSQL']],

  ['PharmaChain Supply Portal',        'Software','software',
   'assets/portfolio/webp/pharmachain.webp',
   'Pharmaceutical supply chain management with QR tracking, compliance and audit logs.',
   ['Node.js','MySQL','Vue.js']],

  // APPS
  ['RideNow Mobile App',               'Mobile App','apps',
   'assets/portfolio/webp/ridenow.webp',
   'On-demand ride-sharing platform — real-time GPS tracking and in-app payments.',
   ['React Native','Firebase','Maps API']],

  ['UrbanEats Food Delivery',          'Mobile App','apps',
   'assets/portfolio/webp/urbaneats.webp',
   'Multi-restaurant food delivery with live order tracking and restaurant dashboard.',
   ['Flutter','Django','Stripe']],

  // AI
  ['FinSight AI Dashboard',            'AI Solution','ai',
   'assets/portfolio/webp/finsight.webp',
   'Intelligent financial analytics with predictive modelling and natural-language query support.',
   ['Python','TensorFlow','React']],

  ['SmartBot CX Automation',           'AI Solution','ai',
   'assets/portfolio/webp/smartbot.webp',
   'AI-powered customer service chatbot reducing support tickets by 65% for a retail client.',
   ['Python','OpenAI API','Node.js']],

  ['DataLens Analytics',               'AI Solution','ai',
   'assets/portfolio/webp/datalens.webp',
   'Real-time business intelligence dashboard with ML-driven forecasting and anomaly detection.',
   ['Python','Apache Spark','D3.js']],

  // CUSTOM IMAGE PROJECTS
  ['FCN',                             'Web Development','web',
   'assets/portfolio/fcn.png',
   'Corporate website for FCN with modern design and integrated client portal.',
   ['WordPress','PHP','MySQL']],

  ['Hum',                             'Media & Entertainment','web',
   'assets/portfolio/hum.png',
   'Streaming platform for Hum TV with video-on-demand and live broadcasting.',
   ['Laravel','Vue.js','MySQL']],

  ['Rasta',                           'Mobile App','apps',
   'assets/portfolio/rasta.png',
   'Route planning and navigation app for local travelers with offline maps.',
   ['React Native','Firebase','Maps API']],
];
?>

<!-- PAGE HERO — floating project screens in depth -->
<section class="page-hero" style="padding-bottom:4.5rem">
  <div class="scene page-hero-scene pf-hero-scene" data-scene="field"
       data-images="assets/portfolio/webp/almarah.webp,assets/portfolio/webp/nhmp.webp,assets/portfolio/webp/smartmove.webp,assets/portfolio/webp/greenshine.webp,assets/portfolio/webp/hum.webp"
       aria-hidden="true">
    <div class="scene-fallback"></div>
  </div>
  <div class="hero-grid-bg"></div>
  <div class="hero-scrim"></div>
  <div class="wrap">
    <div class="page-hero-content" id="main-content" data-reveal>
      <nav class="breadcrumb"><a href="index.php">Home</a><span class="sep"> › </span><span>Portfolio</span></nav>
      <div class="eyebrow" style="margin:0 auto 1rem"><i class="fas fa-briefcase"></i> Our Work</div>
      <h1 class="h1" style="margin-bottom:1rem">
        150+ Projects. <span class="gradient-text">Real Results.</span>
      </h1>
      <p class="lead" style="margin:0 auto">
        From government portals to AI dashboards, e-commerce stores and mobile apps — a selection of impactful digital products we've built across 10+ industries.
      </p>
    </div>
  </div>
</section>

<!-- PORTFOLIO GRID — floating project displays -->
<section class="section" style="padding-top:3rem">
  <div class="wrap">

    <!-- Filter buttons — data-filter values MUST match data-category on cards -->
    <div class="filters" data-reveal role="group" aria-label="Filter projects">
      <button class="filter-btn active" data-filter="all"       type="button">All Projects</button>
      <button class="filter-btn"        data-filter="web"       type="button">Web Dev</button>
      <button class="filter-btn"        data-filter="ecommerce" type="button">E-Commerce</button>
      <button class="filter-btn"        data-filter="software"  type="button">Software</button>
      <button class="filter-btn"        data-filter="apps"      type="button">Mobile Apps</button>
      <button class="filter-btn"        data-filter="ai"        type="button">AI Solutions</button>
    </div>

    <div class="portfolio-grid" id="portfolioGrid">
      <?php foreach($projects as $i=>[$title,$cat,$catKey,$img,$desc,$tech]):
        $isLocal = strpos($img, 'assets/portfolio/') === 0;
        $slug = $isLocal ? preg_replace('/\.(png|webp|jpe?g)$/', '', basename($img)) : '';
      ?>
      <article class="pf-card"
        data-category="<?= $catKey ?>"
        data-reveal
        data-delay="<?= ($i%3)+1 ?>"
        itemscope itemtype="https://schema.org/CreativeWork">

        <div class="pf-device" data-tilt data-tilt-max="8">
          <div class="pf-dev-bar" aria-hidden="true">
            <span class="d-dot r"></span><span class="d-dot y"></span><span class="d-dot g"></span>
            <span class="d-url"><?= htmlspecialchars(strip_tags($title)) ?> · softex.pk</span>
          </div>
          <div class="pf-img">
            <?php if($isLocal): ?>
            <picture>
              <source type="image/webp" srcset="assets/portfolio/webp/<?= $slug ?>.webp">
              <img src="<?= $img ?>"
                   alt="<?= htmlspecialchars(strip_tags($title)) ?> — Softex Technologies"
                   loading="lazy" itemprop="image" width="640" height="400">
            </picture>
            <?php else: ?>
            <img src="<?= $img ?>"
                 alt="<?= htmlspecialchars(strip_tags($title)) ?> — Softex Technologies"
                 loading="lazy" itemprop="image" width="640" height="400">
            <?php endif; ?>
            <div class="pf-glare" aria-hidden="true"></div>
            <div class="pf-overlay">
              <a href="contact.php" aria-label="Enquire about <?= htmlspecialchars(strip_tags($title)) ?>">
                <i class="fas fa-eye"></i>
              </a>
              <a href="contact.php" aria-label="Start a similar project">
                <i class="fas fa-rocket"></i>
              </a>
            </div>
          </div>
        </div>

        <div class="pf-body">
          <div class="pf-cat"><?= $cat ?></div>
          <div class="pf-title" itemprop="name"><?= $title ?></div>
          <p class="pf-desc" itemprop="description"><?= $desc ?></p>
          <div class="tech-tags">
            <?php foreach($tech as $t): ?>
            <span class="tech-tag"><?= htmlspecialchars($t) ?></span>
            <?php endforeach; ?>
          </div>
        </div>

      </article>
      <?php endforeach; ?>
    </div>

    <!-- No-results fallback -->
    <div id="noResults" style="display:none;text-align:center;padding:4rem 0">
      <p style="color:var(--t3);font-size:1rem">
        No projects in this category yet.
        <a href="contact.php" style="color:var(--or-l)">Start yours!</a>
      </p>
    </div>

  </div>
</section>

<!-- STATS -->
<section class="section" style="padding:0 0 var(--sp)" aria-label="Portfolio statistics">
  <div class="wrap">
    <div class="stats-band-inner" data-reveal="zoom">
      <div class="orb orb-or" style="width:260px;height:260px;top:-60px;right:8%;opacity:.5;position:absolute;filter:blur(80px)"></div>

      <svg width="0" height="0" style="position:absolute" aria-hidden="true">
        <defs>
          <linearGradient id="ringGrad" x1="0" y1="0" x2="1" y2="1">
            <stop offset="0" stop-color="#ff4d3e"/><stop offset="1" stop-color="#ffb648"/>
          </linearGradient>
        </defs>
      </svg>

      <div class="stats-grid">
        <?php foreach([
          ['150','+', 'Projects Completed', .85],
          ['40', '+', 'Happy Clients',      .62],
          ['10', '+', 'Industries Served',  .45],
          ['99', '%', 'Satisfaction Rate',  .95],
        ] as $i=>[$n,$s,$l,$p]): ?>
        <div class="stat-box" data-reveal data-delay="<?= $i ?>" style="--dash-to:<?= (int)round(251.2*(1-$p)) ?>">
          <div class="stat-ring" aria-hidden="true">
            <svg viewBox="0 0 88 88">
              <circle class="ring-track" cx="44" cy="44" r="40"></circle>
              <circle class="ring-val"   cx="44" cy="44" r="40"></circle>
            </svg>
          </div>
          <div class="stat-num gradient-text">
            <span data-count="<?= $n ?>" data-suffix="<?= $s ?>">0</span>
          </div>
          <div class="stat-label"><?= $l ?></div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<!-- TESTIMONIALS -->
<section class="section section-bg1">
  <div class="wrap">
    <div class="center" data-reveal>
      <div class="eyebrow"><i class="fas fa-quote-left"></i> Client Reviews</div>
      <h2 class="h2" style="margin-bottom:1rem">What Our <span class="gradient-text">Clients Say</span></h2>
    </div>
    <div class="testi-grid">
      <?php foreach([
        ['S','Sarah Goldman','Business Owner',
         'Softex has provided an excellent service for me and really helped to increase the sales of my business through an outstanding website. Quality work and friendly service are what I would highlight.'],
        ['L','Leo Cooper',   'CEO',
         'Softex has provided an excellent service and really helped increase sales through an outstanding website. Definitely recommend this team of specialists to everyone.'],
        ['K','Khalid Mehmood','E-Commerce Director',
         'Our store revenue increased 60% after the Softex redesign. They turned a dated site into a high-converting machine. The best investment we have ever made in our business.'],
      ] as [$init,$name,$role,$text]): ?>
      <div class="testi-card" data-reveal itemscope itemtype="https://schema.org/Review">
        <div class="testi-stars" itemprop="reviewRating" itemscope itemtype="https://schema.org/Rating">
          <meta itemprop="ratingValue" content="5">★★★★★
        </div>
        <p class="testi-text" itemprop="reviewBody">"<?= $text ?>"</p>
        <div class="testi-author" itemprop="author" itemscope itemtype="https://schema.org/Person">
          <div class="testi-av"><?= $init ?></div>
          <div>
            <div class="testi-name" itemprop="name"><?= $name ?></div>
            <div class="testi-role"><?= $role ?></div>
          </div>
        </div>
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
        <h2>Want Your Project <span class="gradient-text">Featured Here?</span></h2>
        <p>Let's collaborate and build something extraordinary together. Get your free project proposal today.</p>
        <div class="cta-btns">
          <a href="contact.php"  class="btn btn-primary btn-lg"><i class="fas fa-rocket"></i> Start Your Project</a>
          <a href="services.php" class="btn btn-ghost  btn-lg">View Our Services</a>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require_once 'includes/footer.php'; ?>
