<?php
$pageTitle    = 'About Us — Our Story, Team & Mission';
$pageDesc     = 'Learn about Softex Technologies — founded in 2015 in Lahore, Pakistan. Our story, vision, mission, and the talented team behind Pakistan\'s leading software development company.';
$pageKeywords = 'about Softex Technologies, software development company Lahore, web design team Pakistan, IT company Pakistan 2015';
require_once 'includes/header.php';
?>

<!-- ══════════════════════════════════════
     PAGE HERO — data-sphere
══════════════════════════════════════ -->
<section class="page-hero">
  <div class="fx-host hero-fx" data-scene="data-sphere" data-cam-z="12" aria-hidden="true"></div>
  <div class="orb orb-or" style="width:600px;height:600px;top:-180px;left:-100px;opacity:.8" aria-hidden="true"></div>
  <div class="orb orb-cy" style="width:350px;height:350px;bottom:0;right:-60px;opacity:.5" aria-hidden="true"></div>
  <div class="hero-grid-bg"></div>
  <div class="hud" aria-hidden="true">
    <span class="hud-corner tl"></span>
    <span class="hud-corner tr"></span>
    <span class="hud-corner bl"></span>
    <span class="hud-corner br"></span>
    <span class="hud-tag">SYS // TEAM DATABASE · 20+ PROFILES</span>
  </div>
  <div class="wrap">
    <div class="page-hero-content" data-reveal>
      <nav class="breadcrumb" aria-label="Breadcrumb"><a href="index.php">Home</a><span class="sep"> › </span><span>About Us</span></nav>
      <div class="eyebrow" style="margin:0 auto 1rem"><i class="fas fa-users" aria-hidden="true"></i> Our Story</div>
      <h1 class="h1" style="margin-bottom:1rem">Who We <span class="gradient-text">Are</span></h1>
      <p class="lead" style="margin:0 auto">A team of technologists, designers and strategists on a mission to transform businesses through world-class digital solutions.</p>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════════
     WHO WE ARE — ai-brain entity
══════════════════════════════════════ -->
<section class="section">
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
          <div class="num">2015</div>
          <div class="lbl">Year Founded</div>
        </div>
      </div>
      <div class="split-text" data-reveal data-delay="2">
        <div class="eyebrow"><i class="fas fa-building" aria-hidden="true"></i> Our Story</div>
        <h2 class="h2" style="margin-bottom:1.1rem">Born to Build, <span class="gradient-text">Built to Grow</span></h2>
        <p>In 2015, a technologist and an innovator saw an opportunity for customizing technology to solve unique business problems that off-the-shelf products couldn't — and so <strong style="color:var(--t1)">Softex Technologies</strong> was born.</p>
        <p>With our agile methodologies and in-depth industry knowledge, we have gained the reputation of a leading software and e-commerce company in the region, extending our hands across the globe in providing world-class solutions.</p>
        <p>Our motto — <em style="color:var(--or)">"Start of a New Technology Era"</em> — guides us to not only emerge as a leading solution provider but also to build a team of technology experts and dedicated professionals passionate about creating the finest solutions.</p>
        <a href="contact.php" class="btn btn-primary" style="margin-top:.5rem">Work With Us <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
      </div>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════════
     VISION / MISSION / STRENGTH — cube-cluster
══════════════════════════════════════ -->
<section class="section" style="background:var(--bg1)">
  <div class="fx-host" data-scene="cube-cluster" data-cam-z="13" data-scale="0.8" aria-hidden="true"></div>
  <div class="wrap">
    <div class="center" data-reveal>
      <div class="eyebrow"><i class="fas fa-compass" aria-hidden="true"></i> Our Core</div>
      <h2 class="h2" style="margin-bottom:1rem">What Makes Us <span class="gradient-text">Unique</span></h2>
    </div>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:1.5rem;margin-top:3rem;position:relative;z-index:2">
      <?php foreach([
        ['🎯','Our Vision',   'To transform businesses, people and communities by embracing the power of technology with our motto "Start of a New Technology Era".'],
        ['🚀','Our Mission',  'To enable our clients to realize the full potential of their business by consistently offering world-class technological products, services and solutions to enhance their profitability and perception.'],
        ['💪','Our Strength', 'Softex believes in autonomy of decision making and functions. We have developed various departments under one umbrella — each with their own driving factors and individuality.'],
      ] as $i=>[$ico,$t,$d]): ?>
      <div class="svc-card" data-tilt data-reveal data-delay="<?= $i+1 ?>">

        <h3 class="svc-title"><?= $t ?></h3>
        <p class="svc-desc"><?= $d ?></p>
        <span class="card-glow" aria-hidden="true"></span>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════════
     STATS — helix
══════════════════════════════════════ -->
<section class="section" style="padding-top:0;background:var(--bg1)">
  <div class="wrap">
    <div class="stats-band-inner">
      <div class="fx-host" data-scene="helix" data-cam-z="13" aria-hidden="true"></div>
      <div class="orb orb-or" style="width:280px;height:280px;top:-80px;right:10%;opacity:.5;position:absolute;filter:blur(80px)" aria-hidden="true"></div>
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
     TEAM
══════════════════════════════════════ -->
<section class="section" id="team">
  <div class="wrap">
    <div class="center" data-reveal>
      <div class="eyebrow"><i class="fas fa-user-friends" aria-hidden="true"></i> Our Team</div>
      <h2 class="h2" style="margin-bottom:1rem">Meet Team <span class="gradient-text">Softex</span></h2>
      <p class="lead">We're a quirky bunch, but we all share the same core values: we're passionate, energetic, committed and gutsy!</p>
    </div>
    <div class="team-grid">
      <?php
      $team = [
        ['Ali Raza',        'Founder &amp; CEO',           '/assets/team/ali.jpg'],
        ['SamiUllah',       'Vice President Technology',   '/assets/team/sami.jpg'],
        ['Sameer Danish',    'Full Stack Developer',         '/assets/team/sameer.jpeg'],
        ['Asif Ullah',      'Project Manager',             '/assets/team/asif.png'],
        ['Faheem Aslam',    'Full Stack Developer',        '/assets/team/faheem.jpg'],
        ['Ali Raza Kamyana','Head of Legal Affairs',       '/assets/team/ali-kam.jpg'],
        ['Nasir Ashraf',    'Digital Media Manager',       '/assets/team/nasir.jpg'],
        ['Mohsin Amjad',    'Director Business Development','/assets/team/mohsin.jpg'],
      ];
      foreach($team as $i=>[$name,$role,$img]): ?>
      <div class="team-card" data-reveal data-delay="<?= ($i%4)+1 ?>">
        <div class="team-photo">
          <img src="<?= $img ?>" alt="<?= strip_tags($name) ?> — <?= strip_tags($role) ?>" loading="lazy"
               onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode(html_entity_decode($name)) ?>&background=f97316&color=fff&size=285'">
        </div>
        <div class="team-info">
          <div class="team-name"><?= $name ?></div>
          <div class="team-role"><?= $role ?></div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════════
     CTA — orbital
══════════════════════════════════════ -->
<section class="cta-band">
  <div class="fx-host" data-scene="orbital" data-cam-z="13" data-scale="0.9" aria-hidden="true"></div>
  <div class="orb orb-or" style="width:500px;height:500px;top:50%;left:50%;transform:translate(-50%,-50%)" aria-hidden="true"></div>
  <div class="wrap">
    <div data-reveal>
      <div class="cta-box">
        <h2>Does Your Need Match <span class="gradient-text">Our Expertise?</span></h2>
        <p>Let's build something great together. Get a free consultation and project proposal today.</p>
        <div class="cta-btns">
          <a href="contact.php" class="btn btn-primary btn-lg btn-glow"><i class="fas fa-rocket" aria-hidden="true"></i> Get Free Proposal</a>
          <a href="services.php" class="btn btn-ghost btn-lg">Explore Services</a>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require_once 'includes/footer.php'; ?>
