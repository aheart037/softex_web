<?php
$pageTitle    = 'About Us — Our Story, Team & Mission';
$pageDesc     = 'Learn about Softex Technologies — founded in 2015 in Lahore, Pakistan. Our story, vision, mission, and the talented team behind Pakistan\'s leading software development company.';
$pageKeywords = 'about Softex Technologies, software development company Lahore, web design team Pakistan, IT company Pakistan 2015';
require_once 'includes/header.php';
?>

<section class="page-hero">
  <div class="scene page-hero-scene" data-scene="rings" aria-hidden="true">
    <div class="scene-fallback"></div>
  </div>
  <div class="hero-grid-bg"></div>
  <div class="hero-scrim"></div>
  <div class="wrap">
    <div class="page-hero-content" id="main-content" data-reveal>
      <nav class="breadcrumb"><a href="index.php">Home</a><span class="sep"> › </span><span>About Us</span></nav>
      <div class="eyebrow" style="margin:0 auto 1rem"><i class="fas fa-users"></i> Our Story</div>
      <h1 class="h1" style="margin-bottom:1rem">Who We <span class="gradient-text">Are</span></h1>
      <p class="lead" style="margin:0 auto">A team of technologists, designers and strategists on a mission to transform businesses through world-class digital solutions.</p>
    </div>
  </div>
</section>

<!-- WHO WE ARE — 3D milestone timeline (facts from our story only) -->
<section class="section">
  <div class="wrap">
    <div class="split">
      <div class="split-text" data-reveal="left">
        <div class="eyebrow"><i class="fas fa-building"></i> Our Story</div>
        <h2 class="h2" style="margin-bottom:1.1rem">Born to Build, <span class="gradient-text">Built to Grow</span></h2>
        <p>In 2015, a technologist and an innovator saw an opportunity for customizing technology to solve unique business problems that off-the-shelf products couldn't — and so <strong style="color:var(--t1)">Softex Technologies</strong> was born.</p>
        <p>With our agile methodologies and in-depth industry knowledge, we have gained the reputation of a leading software and e-commerce company in the region, extending our hands across the globe in providing world-class solutions.</p>
        <p>Our motto — <em style="color:var(--or)">"Start of a New Technology Era"</em> — guides us to not only emerge as a leading solution provider but also to build a team of technology experts and dedicated professionals passionate about creating the finest solutions.</p>
        <a href="contact.php" class="btn btn-primary" style="margin-top:.5rem">Work With Us <i class="fas fa-arrow-right"></i></a>
      </div>

      <div class="split-visual" data-reveal data-delay="2">
        <div class="story3d" role="img" aria-label="Softex journey timeline — from 2015 to today">
          <div class="story-line" aria-hidden="true"></div>

          <div class="story-node sn-left" data-reveal>
            <span class="story-dot" aria-hidden="true"></span>
            <div class="story-card">
              <div class="story-year">2015</div>
              <div class="story-title">Softex is Born</div>
              <p class="story-text">A technologist and an innovator set out to customize technology for unique business problems.</p>
            </div>
          </div>

          <div class="story-node sn-right" data-reveal data-delay="1">
            <span class="story-dot" aria-hidden="true"></span>
            <div class="story-card">
              <div class="story-year gradient-text">150+</div>
              <div class="story-title">Projects Launched</div>
              <p class="story-text">Agile methodologies and industry knowledge build our reputation as a leading software house.</p>
            </div>
          </div>

          <div class="story-node sn-left" data-reveal data-delay="2">
            <span class="story-dot" aria-hidden="true"></span>
            <div class="story-card">
              <div class="story-year gradient-text">Global</div>
              <div class="story-title">Reach Across the Globe</div>
              <p class="story-text">We extend our hands across the globe, delivering world-class solutions to international clients.</p>
            </div>
          </div>

          <div class="story-node sn-right" data-reveal data-delay="3">
            <span class="story-dot" aria-hidden="true"></span>
            <div class="story-card">
              <div class="story-year gradient-text">Today</div>
              <div class="story-title">20+ Experts · 24/7 Delivery</div>
              <p class="story-text">A passionate team of technology experts and dedicated professionals, delivering around the clock.</p>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</section>

<!-- VISION / MISSION / STRENGTH — floating 3D modules -->
<section class="section section-bg1">
  <div class="wrap">
    <div class="center" data-reveal>
      <div class="eyebrow"><i class="fas fa-compass"></i> Our Core</div>
      <h2 class="h2" style="margin-bottom:1rem">What Makes Us <span class="gradient-text">Unique</span></h2>
    </div>
    <div class="vm-grid">
      <?php foreach([
        ['compass','Our Vision',   'To transform businesses, people and communities by embracing the power of technology with our motto "Start of a New Technology Era".'],
        ['target','Our Mission',  'To enable our clients to realize the full potential of their business by consistently offering world-class technological products, services and solutions to enhance their profitability and perception.'],
        ['core','Our Strength', 'Softex believes in autonomy of decision making and functions. We have developed various departments under one umbrella — each with their own driving factors and individuality.'],
      ] as $i=>[$ico,$t,$d]): ?>
      <div class="svc-card vm-card" data-tilt data-tilt-max="5" data-reveal data-delay="<?= $i+1 ?>">
        <div class="svc-glow" aria-hidden="true"></div>
        <div class="vm-ico" aria-hidden="true">
          <?php if($ico==='compass'): ?>
          <span class="vmi-compass"><i class="vmi-ring"></i><i class="vmi-needle"></i><i class="vmi-pin"></i></span>
          <?php elseif($ico==='target'): ?>
          <span class="vmi-target"><i class="vmi-ring r1"></i><i class="vmi-ring r2"></i><i class="vmi-ring r3"></i><i class="vmi-bull"></i></span>
          <?php else: ?>
          <span class="vmi-core"><i class="vmi-blk b1"></i><i class="vmi-blk b2"></i><i class="vmi-blk b3"></i><i class="vmi-beam"></i></span>
          <?php endif; ?>
        </div>
        <h3 class="svc-title" style="text-align:left"><?= $t ?></h3>
        <p class="svc-desc"><?= $d ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- STATS — floating 3D data dashboard -->
<section class="section" style="padding-top:0;background:inherit" aria-label="Company statistics">
  <div class="wrap">
    <div class="stats-band-inner" data-reveal="zoom">
      <div class="orb orb-or" style="width:280px;height:280px;top:-80px;right:10%;opacity:.5;position:absolute;filter:blur(80px)"></div>

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

<!-- TEAM — premium 3D gallery -->
<section class="section">
  <div class="wrap">
    <div class="center" data-reveal>
      <div class="eyebrow"><i class="fas fa-user-friends"></i> Our Team</div>
      <h2 class="h2" style="margin-bottom:1rem">Meet Team <span class="gradient-text">Softex</span></h2>
      <p class="lead">We're a quirky bunch, but we all share the same core values: we're passionate, energetic, committed and gutsy!</p>
    </div>
    <div class="team-grid">
      <?php
      $team = [
        ['Ali Raza',        'Founder &amp; CEO',           'ali'],
        ['SamiUllah',       'Vice President Technology',   'sami'],
        ['Sameer Danish',    'Full Stack Developer',        'sameer'],
        ['Asif Ullah',      'Project Manager',             'asif'],
        ['Faheem Aslam',    'Full Stack Developer',        'faheem'],
        ['Ali Raza Kamyana','Head of Legal Affairs',       'ali-kam'],
        ['Nasir Ashraf',    'Digital Media Manager',       'nasir'],
        ['Mohsin Amjad',    'Director Business Development','mohsin'],
      ];
      foreach($team as $i=>[$name,$role,$img]):
        $ext = ($img === 'asif') ? 'png' : (($img === 'sameer') ? 'jpeg' : 'jpg');
      ?>
      <div class="team-card" data-tilt data-tilt-max="5" data-reveal data-delay="<?= ($i%4)+1 ?>">
        <div class="team-photo">
          <picture>
            <source type="image/webp" srcset="/assets/team/webp/<?= $img ?>.webp">
            <img src="/assets/team/<?= $img ?>.<?= $ext ?>"
                 alt="<?= strip_tags($name) ?> — <?= strip_tags($role) ?>" loading="lazy"
                 onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name=<?= urlencode(html_entity_decode($name)) ?>&background=ff4d3e&color=fff&size=285'">
          </picture>
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

<!-- CTA -->
<section class="cta-band">
  <div class="scene cta-scene" data-scene="orb" data-orb-plain aria-hidden="true">
    <div class="scene-fallback"></div>
  </div>
  <div class="wrap">
    <div data-reveal>
      <div class="cta-box">
        <h2>Does Your Need Match <span class="gradient-text">Our Expertise?</span></h2>
        <p>Let's build something great together. Get a free consultation and project proposal today.</p>
        <div class="cta-btns">
          <a href="contact.php" class="btn btn-primary btn-lg"><i class="fas fa-rocket"></i> Get Free Proposal</a>
          <a href="services.php" class="btn btn-ghost btn-lg">Explore Services</a>
        </div>
      </div>
    </div>
  </div>
</section>

<style>
/* ── 3D milestone timeline ── */
.story3d{position:relative;padding:1rem 0 1rem 8px;perspective:900px}
.story-line{
  position:absolute;left:26px;top:6px;bottom:6px;width:2px;border-radius:2px;
  background:linear-gradient(180deg,transparent,var(--or) 12%,var(--brand-3) 55%,var(--cyan) 90%,transparent);
  box-shadow:0 0 14px rgba(255,77,62,.35);
}
.story-line::after{
  content:'';position:absolute;left:-3px;width:8px;height:26px;border-radius:6px;
  background:linear-gradient(180deg,transparent,#fff,transparent);opacity:.85;
  animation:storyPulse 3.2s ease-in-out infinite;
}
@keyframes storyPulse{0%{top:0;opacity:0}12%{opacity:.9}88%{opacity:.9}100%{top:calc(100% - 26px);opacity:0}}
.story-node{position:relative;padding-left:64px;margin-bottom:1.35rem}
.story-dot{
  position:absolute;left:17px;top:14px;width:20px;height:20px;border-radius:50%;
  background:radial-gradient(circle at 35% 32%,#ff8a5c,#c9372b);
  border:2px solid rgba(255,182,72,.65);
  box-shadow:0 0 16px rgba(255,77,62,.55);
}
.story-card{
  background:var(--glass);border:1px solid var(--glass-bd);border-radius:16px;
  padding:1.05rem 1.25rem;position:relative;overflow:hidden;
  transform:rotateY(6deg) translateZ(0);
  transform-style:preserve-3d;
  transition:transform .55s var(--te),border-color .35s ease,box-shadow .55s ease;
  backdrop-filter:blur(10px);-webkit-backdrop-filter:blur(10px);
  box-shadow:0 14px 38px rgba(0,0,0,.35),inset 0 1px 0 rgba(255,255,255,.05);
}
.story-card::before{
  content:'';position:absolute;top:0;left:0;right:0;height:1px;
  background:linear-gradient(90deg,transparent,rgba(255,122,92,.6),transparent);
}
.sn-right .story-card{transform:rotateY(-6deg)}
.story-node:hover .story-card{
  transform:rotateY(0) translateZ(16px) translateY(-3px);
  border-color:var(--glass-bd-hi);
  box-shadow:0 26px 60px rgba(0,0,0,.5),0 0 34px rgba(255,77,62,.12);
}
.story-year{font-family:var(--fh);font-size:1.5rem;font-weight:900;line-height:1.1;color:var(--t1)}
.story-title{font-size:.82rem;font-weight:700;color:var(--t1);margin:.14rem 0 .3rem}
.story-text{font-size:.8rem;color:var(--t3);line-height:1.7;margin:0}

/* Vision / Mission / Strength modules */
.vm-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:1.6rem;margin-top:3rem}
.vm-card{transform:perspective(1000px) rotateX(var(--rx,0deg)) rotateY(var(--ry,0deg)) translateY(var(--ty,0px))}
.vm-ico{position:relative;height:96px;margin-bottom:1.2rem;perspective:600px;display:flex;align-items:center;justify-content:flex-start}

.vmi-compass,.vmi-target,.vmi-core{position:relative;width:72px;height:72px;display:inline-block;transform-style:preserve-3d}
.vmi-compass{animation:vmiFloat 6s ease-in-out infinite}
.vmi-target{animation:vmiFloat 6s ease-in-out infinite 1.4s}
.vmi-core{animation:vmiFloat 6s ease-in-out infinite 2.8s}
@keyframes vmiFloat{0%,100%{transform:translateY(0) rotateX(8deg)}50%{transform:translateY(-6px) rotateX(8deg)}}

.vmi-compass .vmi-ring{
  position:absolute;inset:0;border-radius:50%;
  border:2px solid rgba(255,122,92,.55);
  box-shadow:0 0 22px rgba(255,77,62,.25),inset 0 0 18px rgba(255,77,62,.12);
}
.vmi-compass .vmi-needle{
  position:absolute;left:50%;top:50%;width:6px;height:46px;margin:-23px 0 0 -3px;
  background:linear-gradient(180deg,#ff4d3e 0%,#ff4d3e 48%,transparent 48%,transparent 52%,#94a3b8 52%,#94a3b8 100%);
  clip-path:polygon(50% 0,100% 30%,50% 100%,0 30%);
  animation:vmiSpin 7s cubic-bezier(.6,.05,.3,.95) infinite;
  transform-origin:50% 50%;
}
@keyframes vmiSpin{0%,55%{transform:rotate(38deg)}75%,100%{transform:rotate(-14deg)}}
.vmi-compass .vmi-pin{
  position:absolute;left:50%;top:50%;width:12px;height:12px;margin:-6px 0 0 -6px;border-radius:50%;
  background:var(--brand-g);box-shadow:0 0 12px rgba(255,77,62,.8);
}

.vmi-target .vmi-ring{position:absolute;border-radius:50%;border:1.5px solid rgba(255,122,92,.4)}
.vmi-target .r1{inset:0}
.vmi-target .r2{inset:12px;border-color:rgba(255,182,72,.55)}
.vmi-target .r3{inset:24px;border-color:rgba(255,77,62,.75)}
.vmi-target .vmi-bull{
  position:absolute;left:50%;top:50%;width:12px;height:12px;margin:-6px 0 0 -6px;border-radius:50%;
  background:var(--brand-g);box-shadow:0 0 18px rgba(255,77,62,.9);
  animation:vmiPulse 2.4s ease-in-out infinite;
}
.vmi-target .r1{animation:vmiRipple 2.8s ease-out infinite}
.vmi-target .r2{animation:vmiRipple 2.8s ease-out infinite .5s}
@keyframes vmiRipple{0%{transform:scale(.92);opacity:1}100%{transform:scale(1.25);opacity:.25}}
@keyframes vmiPulse{0%,100%{box-shadow:0 0 10px rgba(255,77,62,.7)}50%{box-shadow:0 0 26px rgba(255,77,62,1)}}

.vmi-core{perspective:600px}
.vmi-core .vmi-blk{
  position:absolute;left:50%;width:46px;height:16px;margin-left:-23px;border-radius:4px;
  background:linear-gradient(150deg,rgba(30,44,74,.95),rgba(15,22,40,.95));
  border:1px solid rgba(255,122,92,.45);
  box-shadow:0 10px 22px rgba(0,0,0,.5),inset 0 1px 0 rgba(255,255,255,.1);
}
.vmi-core .b1{top:8px;transform:rotateX(56deg) translateZ(0);animation:vmiBlk 5s ease-in-out infinite}
.vmi-core .b2{top:28px;transform:rotateX(56deg) translateZ(12px);animation:vmiBlk 5s ease-in-out infinite .6s}
.vmi-core .b3{top:48px;transform:rotateX(56deg) translateZ(24px);background:linear-gradient(150deg,rgba(255,77,62,.4),rgba(255,182,72,.25));animation:vmiBlk 5s ease-in-out infinite 1.2s}
@keyframes vmiBlk{0%,100%{filter:brightness(1)}50%{filter:brightness(1.35)}}
.vmi-core .vmi-beam{
  position:absolute;left:50%;top:-6px;width:2px;height:84px;margin-left:-1px;
  background:linear-gradient(180deg,transparent,rgba(255,122,92,.5),transparent);
}

@media(max-width:900px){
  .story3d{padding:0}
  .story-line{left:8px}
  .story-node{padding-left:44px}
  .story-dot{left:-1px}
}
</style>

<?php require_once 'includes/footer.php'; ?>
