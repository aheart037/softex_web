<?php
$pageTitle    = 'Portfolio — 150+ Web, Software & AI Projects';
$pageDesc     = 'Browse Softex Technologies\' portfolio — 150+ successful web development, e-commerce, mobile app, AI and software projects delivered across Pakistan and globally since 2015.';
$pageKeywords = 'portfolio web development Pakistan, software projects Lahore, Shopify portfolio, mobile app projects, Softex Technologies work, e-commerce development examples';
require_once 'includes/header.php';

$projects = [
  // WEB
  ['Almarah Foundation',               'Web Development','web',
   'https://softex.pk/assets/portfolio/almarah.png',   // ← updated
   'NGO website with donation management, event calendar and multilingual support.',
   ['WordPress','PHP','MySQL']],

  ['National Highways &amp; Motorway Police','Web Development','web',
   'https://softex.pk/assets/portfolio/nhmp.png',      // ← updated
   'Government portal with real-time traffic reporting, fine management and public information.',
   ['Laravel','MySQL','Bootstrap']],

  ['PropHub Real Estate',              'Web Development','web',
   'https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=640&q=80',
   'Property listing portal with map-based search, virtual tours and agent CRM.',
   ['Next.js','Prisma','Tailwind']],

  // E-COMMERCE
  ['Smart Move E-Commerce',            'E-Commerce','ecommerce',
   'https://softex.pk/assets/portfolio/smartmove.png', // ← updated
   'Full-featured WooCommerce store with advanced search, product bundles and loyalty rewards.',
   ['WooCommerce','WordPress','Stripe']],

  ['Greenshine Cosmetics',             'Shopify Store','ecommerce',
   'https://softex.pk/assets/portfolio/greenshine.png',// ← updated
   'Beauty brand Shopify store with custom product configurator and influencer discount tracking.',
   ['Shopify','Liquid','JavaScript']],

  ['StyleHub Fashion Store',           'E-Commerce','ecommerce',
   'https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=640&q=80',
   'High-fashion Shopify store with AR try-on integration and influencer dashboard.',
   ['Shopify','React','AR.js']],

  // SOFTWARE
  ['MediTrack Pro',                    'Software','software',
   'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?w=640&q=80',
   'Healthcare patient management system with appointments, records and billing integration.',
   ['React','Node.js','MongoDB']],

  ['EduLearn LMS Platform',            'Software','software',
   'https://images.unsplash.com/photo-1501504905252-473c47e087f8?w=640&q=80',
   'Learning management system for 10,000+ students — video courses, quizzes and certificates.',
   ['Vue.js','Laravel','PostgreSQL']],

  ['PharmaChain Supply Portal',        'Software','software',
   'https://images.unsplash.com/photo-1587854692152-cbe660dbde88?w=640&q=80',
   'Pharmaceutical supply chain management with QR tracking, compliance and audit logs.',
   ['Node.js','MySQL','Vue.js']],

  // APPS
  ['RideNow Mobile App',               'Mobile App','apps',
   'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?w=640&q=80',
   'On-demand ride-sharing platform — real-time GPS tracking and in-app payments.',
   ['React Native','Firebase','Maps API']],

  ['UrbanEats Food Delivery',          'Mobile App','apps',
   'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?w=640&q=80',
   'Multi-restaurant food delivery with live order tracking and restaurant dashboard.',
   ['Flutter','Django','Stripe']],

  // AI
  ['FinSight AI Dashboard',            'AI Solution','ai',
   'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=640&q=80',
   'Intelligent financial analytics with predictive modelling and natural-language query support.',
   ['Python','TensorFlow','React']],

  ['SmartBot CX Automation',           'AI Solution','ai',
   'https://images.unsplash.com/photo-1677442135968-6d89469c5f97?w=640&q=80',
   'AI-powered customer service chatbot reducing support tickets by 65% for a retail client.',
   ['Python','OpenAI API','Node.js']],

  ['DataLens Analytics',               'AI Solution','ai',
   'https://images.unsplash.com/photo-1518770660439-4636190af475?w=640&q=80',
   'Real-time business intelligence dashboard with ML-driven forecasting and anomaly detection.',
   ['Python','Apache Spark','D3.js']],

  // NEW CUSTOM IMAGE PROJECTS
  ['FCN',                             'Web Development','web',
   'https://softex.pk/assets/portfolio/fcn.png',
   'Corporate website for FCN with modern design and integrated client portal.',
   ['WordPress','PHP','MySQL']],

  ['Hum',                             'Media & Entertainment','web',
   'https://softex.pk/assets/portfolio/hum.png',
   'Streaming platform for Hum TV with video-on-demand and live broadcasting.',
   ['Laravel','Vue.js','MySQL']],

  ['Rasta',                           'Mobile App','apps',
   'https://softex.pk/assets/portfolio/rasta.png',
   'Route planning and navigation app for local travelers with offline maps.',
   ['React Native','Firebase','Maps API']],
];
?>

<!-- ══════════════════════════════════════
     PAGE HERO — orbital
══════════════════════════════════════ -->
<section class="page-hero">
  <div class="fx-host hero-fx" data-scene="orbital" data-cam-z="12" aria-hidden="true"></div>
  <div class="orb orb-or" style="width:550px;height:550px;top:-140px;left:10%;opacity:.7" aria-hidden="true"></div>
  <div class="orb orb-cy" style="width:380px;height:380px;bottom:-60px;right:-60px;opacity:.5" aria-hidden="true"></div>
  <div class="hero-grid-bg"></div>
  <div class="hud" aria-hidden="true">
    <span class="hud-corner tl"></span>
    <span class="hud-corner tr"></span>
    <span class="hud-corner bl"></span>
    <span class="hud-corner br"></span>
    <span class="hud-tag">SYS // PROJECT ARCHIVE · 150+ ENTRIES</span>
  </div>
  <div class="wrap">
    <div class="page-hero-content" data-reveal>
      <nav class="breadcrumb" aria-label="Breadcrumb"><a href="index.php">Home</a><span class="sep"> › </span><span>Portfolio</span></nav>
      <div class="eyebrow" style="margin:0 auto 1rem"><i class="fas fa-briefcase" aria-hidden="true"></i> Our Work</div>
      <h1 class="h1" style="margin-bottom:1rem">
        150+ Projects. <span class="gradient-text">Real Results.</span>
      </h1>
      <p class="lead" style="margin:0 auto">
        From government portals to AI dashboards, e-commerce stores and mobile apps — a selection of impactful digital products we've built across 10+ industries.
      </p>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════════
     PORTFOLIO GRID
══════════════════════════════════════ -->
<section class="section">
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
      <?php foreach($projects as $i=>[$title,$cat,$catKey,$img,$desc,$tech]): ?>
      <article class="pf-card"
        data-category="<?= $catKey ?>"
        data-tilt
        data-reveal
        data-delay="<?= ($i%3)+1 ?>"
        itemscope itemtype="https://schema.org/CreativeWork">

        <div class="pf-img">
          <img src="<?= $img ?>"
               alt="<?= htmlspecialchars(strip_tags($title)) ?> — Softex Technologies"
               loading="lazy" itemprop="image" width="640" height="400">
          <div class="pf-overlay">
            <a href="contact.php" aria-label="Enquire about <?= htmlspecialchars(strip_tags($title)) ?>">
              <i class="fas fa-eye" aria-hidden="true"></i>
            </a>
            <a href="contact.php" aria-label="Start a similar project">
              <i class="fas fa-rocket" aria-hidden="true"></i>
            </a>
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
        <span class="card-glow" aria-hidden="true"></span>

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

<!-- ══════════════════════════════════════
     STATS — helix
══════════════════════════════════════ -->
<section class="section" style="padding:0 0 var(--sp)">
  <div class="wrap">
    <div class="stats-band-inner">
      <div class="fx-host" data-scene="helix" data-cam-z="13" aria-hidden="true"></div>
      <div class="orb orb-or" style="width:260px;height:260px;top:-60px;right:8%;opacity:.5;position:absolute;filter:blur(80px)" aria-hidden="true"></div>
      <div class="stats-grid">
        <?php foreach([
          ['150','+', 'Projects Completed'],
          ['40', '+', 'Happy Clients'],
          ['10', '+', 'Industries Served'],
          ['99', '%', 'Satisfaction Rate'],
        ] as $i=>[$n,$s,$l]): ?>
        <div class="stat-box" data-reveal data-delay="<?= $i ?>">
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

<!-- ══════════════════════════════════════
     TESTIMONIALS — cube-cluster
══════════════════════════════════════ -->
<section class="section" style="background:var(--bg1)">
  <div class="fx-host" data-scene="cube-cluster" data-cam-z="12" aria-hidden="true"></div>
  <div class="wrap">
    <div class="center" data-reveal>
      <div class="eyebrow"><i class="fas fa-quote-left" aria-hidden="true"></i> Client Reviews</div>
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
          <div class="testi-av" aria-hidden="true"><?= $init ?></div>
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

<!-- ══════════════════════════════════════
     CTA — data-sphere
══════════════════════════════════════ -->
<section class="cta-band">
  <div class="fx-host" data-scene="data-sphere" data-cam-z="13" data-scale="0.9" aria-hidden="true"></div>
  <div class="orb orb-or" style="width:500px;height:500px;top:50%;left:50%;transform:translate(-50%,-50%)" aria-hidden="true"></div>
  <div class="wrap">
    <div data-reveal>
      <div class="cta-box">
        <h2>Want Your Project <span class="gradient-text">Featured Here?</span></h2>
        <p>Let's collaborate and build something extraordinary together. Get your free project proposal today.</p>
        <div class="cta-btns">
          <a href="contact.php"  class="btn btn-primary btn-lg btn-glow"><i class="fas fa-rocket" aria-hidden="true"></i> Start Your Project</a>
          <a href="services.php" class="btn btn-ghost  btn-lg">View Our Services</a>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require_once 'includes/footer.php'; ?>
