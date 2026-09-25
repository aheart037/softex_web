<?php
$pageTitle    = 'Best Web Design, Software Development & AI Solutions';
$pageDesc     = 'Softex Technologies — Pakistan\'s leading web design, custom software development, mobile apps & digital marketing agency. 150+ projects delivered. Based in Lahore, serving clients globally since 2015.';
$pageKeywords = 'web design Pakistan, software development Lahore, mobile app Pakistan, e-commerce Shopify WooCommerce, AI solutions, digital marketing SEO, Softex Technologies';
require_once 'includes/header.php';
require_once 'includes/service-objects.php';
?>

<!-- ══════════════════════════════════════
     HERO — interactive 3D Softex Technology Core
══════════════════════════════════════ -->
<section class="hero" id="main-content" aria-label="Hero">
  <div class="scene hero-scene" data-scene="hero" aria-hidden="true">
    <div class="scene-fallback"></div>
  </div>
  <div class="hero-grid-bg"></div>
  <div class="hero-scrim"></div>

  <div class="wrap">
    <div class="hero-wrap">

      <!-- Copy -->
      <div data-reveal>
        <div class="hero-chip">
          <span class="chip-dot"></span> Start of a New Technology Era
        </div>
        <h1 class="hero-title" itemprop="headline">
          We Build<br>
          <span class="gradient-text">Powerful Digital</span><br>
          <span class="dynamic-text" id="typingText"></span><span class="typing-cursor"></span>
        </h1>
        <p class="hero-desc">
          We have extended our reach across the globe, providing world-class solutions in Web Development, Software Development and Digital Marketing. Our unique approach combines corporate values, skilled professionals and 24/7 delivery.
        </p>
        <div class="hero-btns">
          <a href="contact.php" class="btn btn-primary btn-lg">
            <i class="fas fa-rocket"></i> Start a Project
          </a>
          <a href="portfolio.php" class="btn btn-ghost btn-lg">
            Discover Our Work <i class="fas fa-arrow-right"></i>
          </a>
        </div>
        <div class="hero-trust">
          <div class="trust-av">
            <span>SG</span><span>LC</span><span>AK</span><span>KM</span>
          </div>
          <p class="trust-label"><strong>150+ happy clients</strong> across the globe</p>
        </div>
      </div>

      <!-- 3D stage: core scene (canvas behind) + holographic panel + depth chips -->
      <div class="hero-visual" data-reveal data-delay="2" aria-hidden="true">
        <div class="hero-stage"><span class="core-anchor" id="coreAnchor"></span></div>

        <div class="hero-panel" data-tilt data-tilt-max="5">
          <div class="panel-bar">
            <div class="p-dot r"></div><div class="p-dot y"></div><div class="p-dot g"></div>
            <span class="p-title">softex-engine.ts</span>
          </div>
          <div class="code-area">
            <div><span class="c-cm">// Softex Technologies — v6.0</span></div>
            <div><span class="c-kw">import</span> { <span class="c-fn">build</span>, <span class="c-fn">deploy</span> } <span class="c-kw">from</span> <span class="c-st">'@softex/ai'</span>;</div>
            <div>&nbsp;</div>
            <div><span class="c-kw">const</span> <span class="c-or">solution</span> = <span class="c-kw">await</span> <span class="c-fn">build</span>({</div>
            <div>&nbsp;&nbsp;<span class="c-cy">stack</span>:    [<span class="c-st">'Web'</span>, <span class="c-st">'Apps'</span>, <span class="c-st">'AI'</span>],</div>
            <div>&nbsp;&nbsp;<span class="c-cy">clients</span>:  <span class="c-nu">150</span>,</div>
            <div>&nbsp;&nbsp;<span class="c-cy">since</span>:    <span class="c-nu">2015</span>,</div>
            <div>&nbsp;&nbsp;<span class="c-cy">delivery</span>: <span class="c-st">'on-time'</span>,</div>
            <div>&nbsp;&nbsp;<span class="c-cy">quality</span>:  <span class="c-st">'world-class'</span>,</div>
            <div>});</div>
            <div>&nbsp;</div>
            <div><span class="c-cm">// ✓ Vision launched.</span><span class="c-cu"></span></div>
          </div>
        </div>

        <div class="hero-pill-row">
          <div class="float-pill fp-1" data-depth="0.55"><div class="fp-inner"><span class="fp-ico">⚡</span> 150+ Projects</div></div>
          <div class="float-pill fp-2" data-depth="1"><div class="fp-inner"><span class="fp-ico">🤖</span> AI-Powered</div></div>
          <div class="float-pill fp-3" data-depth="0.75"><div class="fp-inner"><span class="fp-ico">⭐</span> 5-Star Agency</div></div>
        </div>
      </div>

    </div>
  </div>

  <div class="scroll-cue" aria-hidden="true"><span>Scroll</span><span class="cue-line"></span></div>
</section>

<!-- Tech marquee — depth-tilted data strip -->
<div class="strip-wrap">
  <div class="strip-inner">
    <div class="strip-data-line" aria-hidden="true"></div>
    <div class="strip-tilt">
      <div class="marquee-track fwd">
        <?php
        $tech = ['fa-globe'=>'Web Development','fa-code'=>'Software Dev','fa-mobile-alt'=>'Mobile Apps',
                 'fa-shopping-cart'=>'E-Commerce','fa-robot'=>'AI Solutions','fa-chart-line'=>'SEO & Marketing',
                 'fa-paint-brush'=>'UI/UX Design','fa-cloud'=>'Cloud Services','fa-database'=>'Data Engineering','fa-shield-alt'=>'Cybersecurity'];
        $doubled = array_merge($tech, $tech);
        $half = count($tech);
        $i = 0;
        foreach ($doubled as $icon => $label): ?>
        <div class="tech-item"<?= $i >= $half ? ' aria-hidden="true"' : '' ?>><i class="fas <?= $icon ?>"></i> <?= $label ?></div>
        <?php $i++; endforeach; ?>
      </div>
    </div>
  </div>
</div>

<!-- ══════════════════════════════════════
     ABOUT PREVIEW — Softex Digital Architecture (3D)
══════════════════════════════════════ -->
<section class="section">
  <div class="wrap">
    <div class="split">

      <div class="split-visual" data-reveal="left">
        <div class="split-scene">
          <div class="scene" data-scene="orb" data-orb-labels aria-hidden="true">
            <div class="scene-fallback"></div>
          </div>
          <div class="split-scene-labels">
            <span class="node-label lbl-core" data-node="core">SOFTEX</span>
            <span class="node-label" data-node="ai"     style="left:50%;top:8%">AI</span>
            <span class="node-label" data-node="cloud"  style="left:10%;top:34%">Cloud</span>
            <span class="node-label" data-node="web"    style="left:90%;top:34%">Web</span>
            <span class="node-label" data-node="mobile" style="left:16%;top:80%">Mobile</span>
            <span class="node-label" data-node="data"   style="left:50%;top:88%">Data</span>
            <span class="node-label" data-node="software" style="left:84%;top:80%">Software</span>
          </div>
        </div>
      </div>

      <div class="split-text" data-reveal data-delay="2">
        <div class="eyebrow"><i class="fas fa-bolt"></i> Who We Are</div>
        <h2 class="h2" style="margin-bottom:1.2rem">
          We are Making Ideas Better <span class="gradient-text">for Everyone</span>
        </h2>
        <p>In 2015, a technologist and an innovator saw an opportunity for customizing technology to solve unique business problems that off-the-shelf products couldn't — and so Softex was born.</p>
        <p>With our agile methodologies and in-depth industry knowledge, we have gained the reputation of a leading software and e-commerce company in the region, extending our hands across the globe.</p>
        <ul class="check-list">
          <li><span class="chk">✓</span> World-class solutions in Web Development &amp; Software</li>
          <li><span class="chk">✓</span> Dedicated professionals passionate about results</li>
          <li><span class="chk">✓</span> 24/7 delivery — client satisfaction guaranteed</li>
          <li><span class="chk">✓</span> 150+ successfully launched projects</li>
        </ul>
        <a href="about.php" class="btn btn-primary">Meet Our Team <i class="fas fa-arrow-right"></i></a>
      </div>

    </div>
  </div>
</section>

<!-- ══════════════════════════════════════
     STATS — floating 3D data dashboard
══════════════════════════════════════ -->
<section class="section" style="padding-top:0" aria-label="Company statistics">
  <div class="wrap">
    <div class="stats-band-inner" data-reveal="zoom">
      <div class="orb orb-or" style="width:300px;height:300px;top:-100px;right:10%;opacity:.5;position:absolute;filter:blur(80px)"></div>
      <div class="orb orb-cy" style="width:250px;height:250px;bottom:-80px;left:5%;opacity:.35;position:absolute;filter:blur(80px)"></div>

      <svg width="0" height="0" style="position:absolute" aria-hidden="true">
        <defs>
          <linearGradient id="ringGrad" x1="0" y1="0" x2="1" y2="1">
            <stop offset="0" stop-color="#ff4d3e"/><stop offset="1" stop-color="#ffb648"/>
          </linearGradient>
        </defs>
      </svg>

      <div class="stats-grid">
        <?php foreach([
          ['150','+','Successfully Launched Projects',.82],
          ['10','K+','Users Use Our Products',.9],
          ['20','+','Talented Team Members',.68],
          ['7','+','Years of Experience',.58],
        ] as $i=>[$n,$s,$l,$p]): ?>
        <div class="stat-box" data-reveal data-delay="<?= $i ?>" style="--dash-to:<?= (int)round(251.2*(1-$p)) ?>">
          <div class="stat-ring" aria-hidden="true">
            <svg viewBox="0 0 88 88">
              <circle class="ring-track" cx="44" cy="44" r="40"></circle>
              <circle class="ring-val"   cx="44" cy="44" r="40"></circle>
            </svg>
          </div>
          <div class="stat-num gradient-text"><span data-count="<?= $n ?>" data-suffix="<?= $s ?>">0</span></div>
          <div class="stat-label"><?= $l ?></div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════════
     SERVICES — immersive 3D service ecosystem
══════════════════════════════════════ -->
<section class="section section-bg1" style="position:relative">
  <canvas class="services-net" data-net aria-hidden="true"></canvas>
  <div class="wrap">
    <div class="center" data-reveal>
      <div class="eyebrow"><i class="fas fa-microchip"></i> What We Can Do For You</div>
      <h2 class="h2" style="margin-bottom:1rem">Services Tailored to <span class="gradient-text">Your Business</span></h2>
      <p class="lead wide">From beautiful websites to enterprise software — we build digital solutions that drive real growth for businesses across every industry.</p>
    </div>
    <div class="services-grid">
      <?php
      $svcs = [
        ['web',       '🌐','Web Development',        'Custom, high-performance websites built with modern technologies — fast, secure, and designed to convert visitors into customers.'],
        ['software',  '⚙️','Software Development',   'Bespoke software using agile methodologies. We build scalable web apps, integrations and products that are just right for you.'],
        ['apps',      '📱','Android &amp; iOS Apps', 'Native and cross-platform mobile apps that deliver seamless user experiences on every device with clean UX and robust back-ends.'],
        ['ecommerce', '🛒','E-Commerce Solutions',   'End-to-end e-commerce development — Shopify, WooCommerce and custom stores built for performance and maximum sales conversion.'],
        ['seo',       '📈','SEO &amp; Digital Marketing','Data-driven SEO strategies and digital marketing campaigns that increase visibility, drive traffic and grow your bottom line.'],
        ['uiux',      '🎨','UI/UX Design',           'User-centred design blending aesthetics with functionality — intuitive interfaces that delight users and strengthen brand identity.'],
      ];
      foreach($svcs as $i=>[$obj,$ico,$title,$desc]): ?>
      <div class="svc-card" data-tilt data-tilt-max="6" data-reveal data-delay="<?= ($i%3)+1 ?>">
        <div class="svc-glow" aria-hidden="true"></div>
        <?php render_service_object($obj); ?>
        <h3 class="svc-title"><?= $title ?></h3>
        <p class="svc-desc"><?= $desc ?></p>
        <a href="services.php#<?= $obj ?>" class="svc-more">Learn more <i class="fas fa-arrow-right"></i></a>
      </div>
      <?php endforeach; ?>

      <?php /* Featured AI card — full-width highlight with the neural-network object */ ?>
      <div class="svc-card svc-ai-wide" data-tilt data-tilt-max="3" data-reveal data-delay="2">
        <div class="svc-glow" aria-hidden="true"></div>
        <div class="svc-ai-obj">
          <?php render_service_object('ai'); ?>
        </div>
        <div class="svc-ai-text">
          <h3 class="svc-title">AI Solutions &amp; Automation <span class="svc-ai-badge">New</span></h3>
          <p class="svc-desc">Intelligent systems that learn from your data — conversational chatbots, predictive analytics, computer vision and custom machine-learning models, integrated natively into the products we build for you.</p>
          <div class="svc-ai-tags" aria-label="AI capabilities">
            <span>Chatbots &amp; NLP</span><span>Predictive Analytics</span><span>Computer Vision</span><span>Process Automation</span>
          </div>
          <a href="services.php#ai" class="svc-more">Explore AI solutions <i class="fas fa-arrow-right"></i></a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════════
     PORTFOLIO PREVIEW — floating project displays
══════════════════════════════════════ -->
<section class="section" id="main-content-portfolio">
  <div class="wrap">
    <div class="center" data-reveal>
      <div class="eyebrow"><i class="fas fa-star"></i> Our Work</div>
      <h2 class="h2" style="margin-bottom:1rem">We Take Pride <span class="gradient-text">In Our Work</span></h2>
      <p class="lead">Providing great value to our customers by making products that push the envelope of web design is what drives us.</p>
    </div>
    <div class="portfolio-grid" style="margin-top:3rem">
      <?php
      $projs = [
        ['Almarah Foundation',                     'Web Development','web',       'almarah',    'NGO platform with donation management and event calendar.'],
        ['National Highways &amp; Motorway Police','Web Development','web',       'nhmp',       'Government portal with real-time traffic reporting.'],
        ['Smart Move E-Commerce',                  'E-Commerce',     'ecommerce', 'smartmove',  'Full-featured WooCommerce store with loyalty rewards.'],
        ['Greenshine Cosmetics',                   'Shopify Store',  'ecommerce', 'greenshine', 'Shopify beauty store with custom product configurator.'],
      ];
      foreach($projs as $i=>[$title,$cat,$catKey,$img,$desc]): ?>
      <div class="pf-card" data-category="<?= $catKey ?>" data-reveal data-delay="<?= ($i%3)+1 ?>">
        <div class="pf-device" data-tilt data-tilt-max="8">
          <div class="pf-dev-bar" aria-hidden="true">
            <span class="d-dot r"></span><span class="d-dot y"></span><span class="d-dot g"></span>
            <span class="d-url"><?= htmlspecialchars(strip_tags($title)) ?> · softex.pk</span>
          </div>
          <div class="pf-img">
            <picture>
              <source type="image/webp" srcset="assets/portfolio/webp/<?= $img ?>.webp">
              <img src="assets/portfolio/<?= $img ?>.png"
                   alt="<?= htmlspecialchars(strip_tags($title)) ?>" loading="lazy" width="640" height="400">
            </picture>
            <div class="pf-glare" aria-hidden="true"></div>
            <div class="pf-overlay">
              <a href="portfolio.php" aria-label="View project"><i class="fas fa-eye"></i></a>
              <a href="contact.php"   aria-label="Start similar"><i class="fas fa-rocket"></i></a>
            </div>
          </div>
        </div>
        <div class="pf-body">
          <div class="pf-cat"><?= $cat ?></div>
          <div class="pf-title"><?= $title ?></div>
          <p class="pf-desc"><?= $desc ?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <div class="center" style="margin-top:2.5rem" data-reveal>
      <a href="portfolio.php" class="btn btn-ghost btn-lg">Discover More Works <i class="fas fa-arrow-right"></i></a>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════════
     TESTIMONIALS — 3D depth carousel
══════════════════════════════════════ -->
<section class="section section-bg1">
  <div class="wrap">
    <div class="center" data-reveal>
      <div class="eyebrow"><i class="fas fa-heart"></i> Our Reviews</div>
      <h2 class="h2" style="margin-bottom:1rem">What Our Clients <span class="gradient-text">Say About Us</span></h2>
    </div>

    <div class="testi-3d" data-carousel data-reveal>
      <div class="testi-stage">
        <?php foreach([
          ['S','Sarah Goldman','',     'Softex has provided an excellent service for me and really helped to increase the sales of my business through an outstanding website. Quality work and friendly service are what I would highlight the most.'],
          ['L','Leo Cooper',  'CEO',   'Softex has provided an excellent service for me and really helped to increase the sales of my business through an outstanding website. Definitely recommend this team of specialists.'],
          ['A','Aisha Khan',  'Owner', 'Our Shopify store was completely transformed — conversions went up 40% after the redesign. Softex genuinely cares about results, not just deliverables. An exceptional team.'],
        ] as [$init,$name,$role,$text]): ?>
        <div class="testi-card">
          <div class="testi-stars">★★★★★</div>
          <p class="testi-text">"<?= $text ?>"</p>
          <div class="testi-author">
            <div class="testi-av"><?= $init ?></div>
            <div>
              <div class="testi-name"><?= $name ?></div>
              <?php if($role): ?><div class="testi-role"><?= $role ?></div><?php endif; ?>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
      <div class="testi-nav" data-carousel-nav aria-hidden="false">
        <button class="t-btn t-prev" type="button" aria-label="Previous review"><i class="fas fa-arrow-left"></i></button>
        <div class="t-dots"></div>
        <button class="t-btn t-next" type="button" aria-label="Next review"><i class="fas fa-arrow-right"></i></button>
      </div>
    </div>

  </div>
</section>

<!-- ══════════════════════════════════════
     CTA — glowing 3D network core
══════════════════════════════════════ -->
<section class="cta-band">
  <div class="scene cta-scene" data-scene="orb" data-orb-plain aria-hidden="true">
    <div class="scene-fallback"></div>
  </div>
  <div class="wrap">
    <div data-reveal>
      <div class="cta-box">
        <div class="eyebrow" style="margin:0 auto 1rem"><i class="fas fa-paper-plane"></i> Free Proposal</div>
        <h2>Does Your Need Match <span class="gradient-text">Our Expertise?</span></h2>
        <p>Let's talk about your project. We'll review it personally and send you a transparent proposal — completely free, no obligation.</p>
        <div class="cta-btns">
          <a href="contact.php" class="btn btn-primary btn-lg"><i class="fas fa-rocket"></i> Get Free Proposal</a>
          <a href="tel:+923450789192" class="btn btn-ghost btn-lg"><i class="fas fa-phone"></i> Call Us Now</a>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require_once 'includes/footer.php'; ?>
