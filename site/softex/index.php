<?php
$pageTitle    = 'Best Web Design, Software Development & AI Solutions';
$pageDesc     = 'Softex Technologies — Pakistan\'s leading web design, custom software development, mobile apps & digital marketing agency. 150+ projects delivered. Based in Lahore, serving clients globally since 2015.';
$pageKeywords = 'web design Pakistan, software development Lahore, mobile app Pakistan, e-commerce Shopify WooCommerce, AI solutions, digital marketing SEO, Softex Technologies';
require_once 'includes/header.php';
?>

<!-- ══════════════════════════════════════
     HERO — neural-core
══════════════════════════════════════ -->
<section class="hero" aria-label="Hero">
  <div class="fx-host hero-fx" data-scene="neural-core" data-cam-z="11" aria-hidden="true"></div>
  <div class="orb orb-or" style="width:700px;height:700px;top:-200px;left:-150px;opacity:.9"></div>
  <div class="orb orb-cy" style="width:500px;height:500px;bottom:-100px;right:-100px;opacity:.8"></div>
  <div class="orb orb-pu" style="width:300px;height:300px;top:40%;left:40%;opacity:.6"></div>
  <div class="hero-grid-bg"></div>

  <div class="hud" aria-hidden="true">
    <span class="hud-corner tl"></span>
    <span class="hud-corner tr"></span>
    <span class="hud-corner bl"></span>
    <span class="hud-corner br"></span>
    <span class="hud-scan"></span>
    <span class="hud-tag">SYS // SOFTEX AI OS · ONLINE</span>
  </div>

  <div class="wrap">
    <div class="hero-wrap">

      <!-- Copy -->
      <div data-reveal>
        <div class="hero-chip">
          <span class="chip-dot"></span> Start of a New Technology Era
          <span class="chip-pulse"></span>
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
          <a href="contact.php" class="btn btn-primary btn-lg btn-glow">
            <i class="fas fa-rocket" aria-hidden="true"></i> Start a Project
          </a>
          <a href="portfolio.php" class="btn btn-ghost btn-lg">
            Discover Our Work <i class="fas fa-arrow-right" aria-hidden="true"></i>
          </a>
        </div>
        <div class="hero-trust">
          <div class="trust-av" aria-hidden="true">
            <span>SG</span><span>LC</span><span>AK</span><span>KM</span>
          </div>
          <p class="trust-label"><strong>150+ happy clients</strong> across the globe</p>
        </div>
      </div>

      <!-- Visual panel -->
      <div class="hero-visual" data-reveal data-delay="2" aria-hidden="true">
        <div class="hero-panel">
          <div class="panel-bar">
            <div class="p-dot r"></div><div class="p-dot y"></div><div class="p-dot g"></div>
            <span class="p-title">softex-engine.ts</span>
          </div>
          <div class="code-area">
            <div><span class="c-cm">// Softex Technologies — v5.0</span></div>
            <div><span class="c-kw">import</span> { <span class="c-fn">build</span>, <span class="c-fn">deploy</span> } <span class="c-kw">from</span> <span class="c-st">'@softex/ai'</span>;</div>
            <div>&nbsp;</div>
            <div><span class="c-kw">const</span> <span class="c-or">solution</span> = <span class="c-kw">await</span> <span class="c-fn">build</span>({</div>
            <div>&nbsp;&nbsp;<span class="c-cy">stack</span>:    [<span class="c-st">'React'</span>, <span class="c-st">'Node'</span>, <span class="c-st">'AI'</span>],</div>
            <div>&nbsp;&nbsp;<span class="c-cy">clients</span>:  <span class="c-nu">150</span>,</div>
            <div>&nbsp;&nbsp;<span class="c-cy">since</span>:    <span class="c-nu">2015</span>,</div>
            <div>&nbsp;&nbsp;<span class="c-cy">delivery</span>: <span class="c-st">'on-time'</span>,</div>
            <div>&nbsp;&nbsp;<span class="c-cy">quality</span>:  <span class="c-st">'world-class'</span>,</div>
            <div>});</div>
            <div>&nbsp;</div>
            <div><span class="c-cm">// ✓ Vision launched.</span><span class="c-cu"></span></div>
          </div>
        </div>
        <div class="float-pill fp-1"><span class="fp-ico">⚡</span> 150+ Projects</div>
        <div class="float-pill fp-2"><span class="fp-ico">🤖</span> AI-Powered</div>
        <div class="float-pill fp-3"><span class="fp-ico">⭐</span> 5-Star Agency</div>
      </div>

    </div>
  </div>
</section>

<!-- Tech marquee -->
<div class="strip-wrap">
  <div class="strip-inner">
    <div class="marquee-track fwd">
      <?php
      $tech = ['fa-globe'=>'Web Development','fa-code'=>'Software Dev','fa-mobile-alt'=>'Mobile Apps',
               'fa-shopping-cart'=>'E-Commerce','fa-robot'=>'AI Solutions','fa-chart-line'=>'SEO & Marketing',
               'fa-paint-brush'=>'UI/UX Design','fa-cloud'=>'Cloud Services','fa-database'=>'Data Engineering','fa-shield-alt'=>'Cybersecurity'];
      $doubled = array_merge($tech, $tech);
      foreach ($doubled as $icon => $label): ?>
      <div class="tech-item"><i class="fas <?= $icon ?>" aria-hidden="true"></i> <?= $label ?></div>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<!-- ══════════════════════════════════════
     ABOUT PREVIEW — ai-brain entity + data-sphere field
══════════════════════════════════════ -->
<section class="section" id="about">
  <div class="fx-host fx-right" data-scene="data-sphere" data-cam-z="11" aria-hidden="true"></div>
  <div class="wrap">
    <div class="split">
      <div class="split-visual" data-reveal>
        <div class="ai-entity-frame">
          <div class="ai-entity-canvas fx-host"
               data-scene="ai-brain"
               data-cam-z="9.5"
               aria-hidden="true"></div>
          <span class="corner tl" aria-hidden="true"></span>
          <span class="corner tr" aria-hidden="true"></span>
          <span class="corner bl" aria-hidden="true"></span>
          <span class="corner br" aria-hidden="true"></span>
          <div class="ai-entity-top">// NEURAL CORE ONLINE</div>
          <div class="ai-entity-label"><span class="dot" aria-hidden="true"></span> SOFTEX AI · v5.0</div>
        </div>
        <div class="img-badge">
          <div class="num">7+</div>
          <div class="lbl">Years of<br>Excellence</div>
        </div>
      </div>

      <div class="split-text" data-reveal data-delay="2">
        <div class="eyebrow"><i class="fas fa-bolt" aria-hidden="true"></i> Who We Are</div>
        <h2 class="h2" style="margin-bottom:1.2rem">
          We are Making Ideas Better <span class="gradient-text">for Everyone</span>
        </h2>
        <p>In 2015, a technologist and an innovator saw an opportunity for customizing technology to solve unique business problems that off-the-shelf products couldn't — and so Softex was born.</p>
        <p>With our agile methodologies and in-depth industry knowledge, we have gained the reputation of a leading software and e-commerce company in the region, extending our hands across the globe.</p>
        <ul class="check-list">
          <li><span class="chk" aria-hidden="true">✓</span> World-class solutions in Web Development &amp; Software</li>
          <li><span class="chk" aria-hidden="true">✓</span> Dedicated professionals passionate about results</li>
          <li><span class="chk" aria-hidden="true">✓</span> 24/7 delivery — client satisfaction guaranteed</li>
          <li><span class="chk" aria-hidden="true">✓</span> 150+ successfully launched projects</li>
        </ul>
        <a href="about.php" class="btn btn-primary">Meet Our Team <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
      </div>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════════
     STATS — helix
══════════════════════════════════════ -->
<section class="section" style="padding-top:0">
  <div class="wrap">
    <div class="stats-band-inner">
      <div class="fx-host" data-scene="helix" data-cam-z="13" aria-hidden="true"></div>
      <div class="orb orb-or" style="width:300px;height:300px;top:-100px;right:10%;opacity:.6;position:absolute;filter:blur(80px)" aria-hidden="true"></div>
      <div class="orb orb-cy" style="width:250px;height:250px;bottom:-80px;left:5%;opacity:.4;position:absolute;filter:blur(80px)" aria-hidden="true"></div>
      <div class="stats-grid">
        <?php foreach([['150','+','Successfully Launched Projects'],['10','K+','Users Use Our Products'],['20','+','Talented Team Members'],['7','+','Years of Experience']] as $i=>[$n,$s,$l]): ?>
        <div class="stat-box" data-reveal data-delay="<?= $i ?>">
          <div class="stat-num gradient-text"><span data-count="<?= $n ?>" data-suffix="<?= $s ?>">0</span></div>
          <div class="stat-label"><?= $l ?></div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════════
     SERVICES — grid-wave
══════════════════════════════════════ -->
<section class="section" id="services" style="background:var(--bg1)">
  <div class="fx-host" data-scene="grid-wave" data-cam-z="8" data-cam-y="2.4" aria-hidden="true"></div>
  <div class="wrap">
    <div class="center" data-reveal>
      <div class="eyebrow"><i class="fas fa-microchip" aria-hidden="true"></i> What We Can Do For You</div>
      <h2 class="h2" style="margin-bottom:1rem">Services Tailored to <span class="gradient-text">Your Business</span></h2>
      <p class="lead wide">From beautiful websites to enterprise software — we build digital solutions that drive real growth for businesses across every industry.</p>
    </div>
    <div class="services-grid">
      <?php
      $svcs = [
        ['🌐','Web Development',        'Custom, high-performance websites built with modern technologies — fast, secure, and designed to convert visitors into customers.'],
        ['⚙️','Software Development',   'Bespoke software using agile methodologies. We build scalable web apps, integrations and products that are just right for you.'],
        ['📱','Android &amp; iOS Apps', 'Native and cross-platform mobile apps that deliver seamless user experiences on every device with clean UX and robust back-ends.'],
        ['🛒','E-Commerce Solutions',   'End-to-end e-commerce development — Shopify, WooCommerce and custom stores built for performance and maximum sales conversion.'],
        ['📈','SEO &amp; Digital Marketing','Data-driven SEO strategies and digital marketing campaigns that increase visibility, drive traffic and grow your bottom line.'],
        ['🎨','UI/UX Design',           'User-centred design blending aesthetics with functionality — intuitive interfaces that delight users and strengthen brand identity.'],
      ];
      foreach($svcs as $i=>[$ico,$title,$desc]): ?>
      <div class="svc-card" data-tilt data-reveal data-delay="<?= ($i%3)+1 ?>">
        <div class="svc-icon" aria-hidden="true"><?= $ico ?></div>
        <h3 class="svc-title"><?= $title ?></h3>
        <p class="svc-desc"><?= $desc ?></p>
        <a href="services.php" class="svc-more">Learn more <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
        <span class="card-glow" aria-hidden="true"></span>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════════
     PORTFOLIO PREVIEW — orbital
══════════════════════════════════════ -->
<section class="section" id="work">
  <div class="fx-host fx-right" data-scene="orbital" data-cam-z="11" aria-hidden="true"></div>
  <div class="wrap">
    <div class="center" data-reveal>
      <div class="eyebrow"><i class="fas fa-star" aria-hidden="true"></i> Our Work</div>
      <h2 class="h2" style="margin-bottom:1rem">We Take Pride <span class="gradient-text">In Our Work</span></h2>
      <p class="lead">Providing great value to our customers by making products that push the envelope of web design is what drives us.</p>
    </div>
    <div class="portfolio-grid" style="margin-top:3rem">
      <?php
      $projs = [
        ['Almarah Foundation',              'Web Development','web', 'https://images.unsplash.com/photo-1497366811353-6870744d04b2?w=640&q=80','NGO platform with donation management and event calendar.'],
        ['National Highways &amp; Motorway Police','Web Development','web','https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=640&q=80','Government portal with real-time traffic reporting.'],
        ['Smart Move E-Commerce',           'E-Commerce',     'ecommerce','https://images.unsplash.com/photo-1563013544-824ae1b704d3?w=640&q=80','Full-featured WooCommerce store with loyalty rewards.'],
        ['Greenshine Cosmetics',            'E-Commerce',     'ecommerce','https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=640&q=80','Shopify beauty store with custom product configurator.'],
      ];
      foreach($projs as $i=>[$title,$cat,$catKey,$img,$desc]): ?>
      <div class="pf-card" data-category="<?= $catKey ?>" data-tilt data-reveal data-delay="<?= ($i%3)+1 ?>">
        <div class="pf-img">
          <img src="<?= $img ?>" alt="<?= htmlspecialchars(strip_tags($title)) ?>" loading="lazy">
          <div class="pf-overlay">
            <a href="portfolio.php" aria-label="View project"><i class="fas fa-eye" aria-hidden="true"></i></a>
            <a href="contact.php"   aria-label="Start similar"><i class="fas fa-rocket" aria-hidden="true"></i></a>
          </div>
        </div>
        <div class="pf-body">
          <div class="pf-cat"><?= $cat ?></div>
          <div class="pf-title"><?= $title ?></div>
          <p class="pf-desc"><?= $desc ?></p>
        </div>
        <span class="card-glow" aria-hidden="true"></span>
      </div>
      <?php endforeach; ?>
    </div>
    <div class="center" style="margin-top:2.5rem" data-reveal>
      <a href="portfolio.php" class="btn btn-ghost btn-lg">Discover More Works <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════════
     TESTIMONIALS — cube-cluster
══════════════════════════════════════ -->
<section class="section" id="reviews" style="background:var(--bg1)">
  <div class="fx-host" data-scene="cube-cluster" data-cam-z="12" aria-hidden="true"></div>
  <div class="wrap">
    <div class="center" data-reveal>
      <div class="eyebrow"><i class="fas fa-heart" aria-hidden="true"></i> Our Reviews</div>
      <h2 class="h2" style="margin-bottom:1rem">What Our Clients <span class="gradient-text">Say About Us</span></h2>
    </div>
    <div class="testi-grid">
      <?php foreach([
        ['S','Sarah Goldman','',     'Softex has provided an excellent service for me and really helped to increase the sales of my business through an outstanding website. Quality work and friendly service are what I would highlight the most.'],
        ['L','Leo Cooper',  'CEO',   'Softex has provided an excellent service for me and really helped to increase the sales of my business through an outstanding website. Definitely recommend this team of specialists.'],
        ['A','Aisha Khan',  'Owner', 'Our Shopify store was completely transformed — conversions went up 40% after the redesign. Softex genuinely cares about results, not just deliverables. An exceptional team.'],
      ] as [$init,$name,$role,$text]): ?>
      <div class="testi-card" data-reveal>
        <div class="testi-stars" aria-label="Rated 5 out of 5">★★★★★</div>
        <p class="testi-text">"<?= $text ?>"</p>
        <div class="testi-author">
          <div class="testi-av" aria-hidden="true"><?= $init ?></div>
          <div>
            <div class="testi-name"><?= $name ?></div>
            <?php if($role): ?><div class="testi-role"><?= $role ?></div><?php endif; ?>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════════
     CTA — neural-core (encore)
══════════════════════════════════════ -->
<section class="cta-band" id="contact">
  <div class="fx-host" data-scene="neural-core" data-cam-z="12" data-scale="0.85" aria-hidden="true"></div>
  <div class="orb orb-or" style="width:600px;height:600px;top:50%;left:50%;transform:translate(-50%,-50%);opacity:.7" aria-hidden="true"></div>
  <div class="orb orb-cy" style="width:400px;height:400px;top:20%;right:10%;opacity:.4" aria-hidden="true"></div>
  <div class="wrap">
    <div data-reveal>
      <div class="cta-box">
        <div class="eyebrow" style="margin:0 auto 1rem"><i class="fas fa-paper-plane" aria-hidden="true"></i> Free Proposal</div>
        <h2>Does Your Need Match <span class="gradient-text">Our Expertise?</span></h2>
        <p>Let's talk about your project. We'll review it personally and send you a transparent proposal — completely free, no obligation.</p>
        <div class="cta-btns">
          <a href="contact.php" class="btn btn-primary btn-lg btn-glow"><i class="fas fa-rocket" aria-hidden="true"></i> Get Free Proposal</a>
          <a href="tel:+923450789192" class="btn btn-ghost btn-lg"><i class="fas fa-phone" aria-hidden="true"></i> Call Us Now</a>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require_once 'includes/footer.php'; ?>
