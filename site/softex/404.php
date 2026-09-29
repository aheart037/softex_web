<?php
/**
 * 404.php — Softex Technologies
 * Custom 404 Not Found page — futuristic AI design
 */

// Send proper 404 HTTP status (essential for SEO)
http_response_code(404);
header("HTTP/1.1 404 Not Found");

$pageTitle    = '404 — Page Not Found';
$pageDesc     = 'The page you are looking for does not exist. Return to Softex Technologies homepage.';
$pageKeywords = 'Softex Technologies 404 page not found';
require_once 'includes/header.php';
?>

<style>
/* ── 404 specific styles ── */
.pg404{
  min-height:100vh;display:flex;align-items:center;justify-content:center;
  position:relative;overflow:hidden;padding:8rem 0 4rem;
}

/* Animated glitch number */
.err-num{
  font-family:var(--fh);
  font-size:clamp(8rem,22vw,18rem);
  font-weight:900;line-height:1;
  letter-spacing:-.04em;
  position:relative;
  display:inline-block;
  /* Animated gradient — logo colors */
  background:linear-gradient(135deg,#F20D5A,#F21C6A,#F44A6A,#F78B3D,#FBBF24,#F78B3D,#F44A6A,#F20D5A);
  background-size:300% 300%;
  -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
  animation:gradientShift 4s ease infinite, glitch 6s ease-in-out infinite;
  user-select:none;
}
@keyframes gradientShift{
  0%,100%{background-position:0% 50%}
  50%{background-position:100% 50%}
}

/* Glitch animation */
@keyframes glitch{
  0%,90%,100%{transform:translate(0,0);filter:none}
  91%{transform:translate(-4px,2px);filter:hue-rotate(90deg)}
  92%{transform:translate(4px,-2px);filter:hue-rotate(-90deg)}
  93%{transform:translate(0,0);filter:none}
  94%{transform:translate(-3px,1px);filter:hue-rotate(45deg)}
  95%{transform:translate(0,0);filter:none}
}

/* Ghost duplicate for glitch effect */
.err-num::before,
.err-num::after{
  content:'404';
  position:absolute;top:0;left:0;
  background:inherit;
  -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
  opacity:0;
}
.err-num::before{
  animation:glitchBefore 6s ease-in-out infinite;
  background:linear-gradient(135deg,#06b6d4,#8b5cf6);
  background-size:300% 300%;
}
.err-num::after{
  animation:glitchAfter 6s ease-in-out infinite;
  background:linear-gradient(135deg,#F20D5A,#F44A6A);
  background-size:300% 300%;
}
@keyframes glitchBefore{
  0%,89%,100%{opacity:0;transform:translate(0,0)}
  90%{opacity:.7;transform:translate(-6px,2px);clip-path:polygon(0 30%,100% 30%,100% 60%,0 60%)}
  92%{opacity:0}
}
@keyframes glitchAfter{
  0%,91%,100%{opacity:0;transform:translate(0,0)}
  92%{opacity:.7;transform:translate(6px,-2px);clip-path:polygon(0 60%,100% 60%,100% 80%,0 80%)}
  94%{opacity:0}
}

.pg404-content{
  position:relative;z-index:2;text-align:center;
  max-width:620px;margin:0 auto;
}

.err-label{
  display:inline-flex;align-items:center;gap:.5rem;
  font-size:.72rem;font-weight:700;letter-spacing:.18em;text-transform:uppercase;
  color:#F44A6A;
  background:linear-gradient(135deg,rgba(242,13,90,.1),rgba(247,139,61,.06));
  border:1px solid rgba(242,13,90,.3);
  padding:.32rem .85rem;border-radius:100px;margin-bottom:1.5rem;
}
.err-label .dot{
  width:7px;height:7px;border-radius:50%;
  background:radial-gradient(circle,#F20D5A,#F78B3D);
  box-shadow:0 0 8px #F20D5A;animation:dotPulse 2s infinite;
}
@keyframes dotPulse{0%,100%{opacity:1;transform:scale(1)}50%{opacity:.4;transform:scale(.7)}}

.err-title{
  font-family:var(--fh);
  font-size:clamp(1.8rem,4vw,2.8rem);
  font-weight:800;color:var(--t1);
  margin-bottom:.8rem;letter-spacing:-.02em;
}
.err-desc{
  font-size:1.02rem;color:var(--t2);line-height:1.85;
  margin-bottom:2.5rem;
}

/* Scan line on number */
.err-scanline{
  position:absolute;top:0;left:-5%;right:-5%;
  height:2px;
  background:linear-gradient(90deg,transparent,rgba(242,13,90,.8),rgba(247,139,61,.6),transparent);
  animation:scanDown 3s linear infinite;
  pointer-events:none;
}
@keyframes scanDown{
  0%{top:-5%}
  100%{top:110%}
}

.err-num-wrap{position:relative;display:inline-block}

/* Suggestion links */
.err-links{
  display:flex;flex-wrap:wrap;gap:.65rem;justify-content:center;
  margin-bottom:2.5rem;
}
.err-link{
  display:inline-flex;align-items:center;gap:.4rem;
  font-size:.82rem;font-weight:600;color:var(--t2);
  padding:.5rem 1rem;border-radius:8px;
  border:1px solid rgba(242,13,90,.15);
  transition:var(--tb);background:rgba(13,21,37,.5);
}
.err-link:hover{
  color:var(--t1);border-color:rgba(242,13,90,.4);
  background:linear-gradient(135deg,rgba(242,13,90,.1),rgba(247,139,61,.05));
  transform:translateY(-2px);
  box-shadow:0 8px 20px rgba(0,0,0,.3),0 0 15px rgba(242,13,90,.1);
}
.err-link i{font-size:.8rem;color:#F44A6A}

/* Terminal box */
.err-terminal{
  background:linear-gradient(145deg,rgba(8,13,26,.9),rgba(13,21,37,.8));
  border:1px solid rgba(242,13,90,.2);border-radius:14px;
  padding:1.4rem 1.6rem;margin-bottom:2.5rem;text-align:left;
  position:relative;overflow:hidden;
  backdrop-filter:blur(10px);
}
.err-terminal::before{
  content:'';position:absolute;top:0;left:10%;right:10%;height:1px;
  background:linear-gradient(90deg,transparent,#F20D5A,#F78B3D,transparent);
}
.term-bar{display:flex;align-items:center;gap:.5rem;margin-bottom:.9rem;padding-bottom:.7rem;border-bottom:1px solid rgba(255,255,255,.05)}
.term-dot{width:9px;height:9px;border-radius:50%}
.term-dot.r{background:#ff5f57}.term-dot.y{background:#febc2e}.term-dot.g{background:#28c840}
.term-path{font-size:.7rem;color:var(--t3);margin-left:.3rem;font-family:monospace}
.term-line{
  font-family:var(--fm);
  font-size:.8rem;line-height:1.9;
  display:flex;align-items:flex-start;gap:.6rem;
}
.term-prompt{color:#F78B3D;flex-shrink:0}
.term-cmd{color:var(--t2)}
.term-output{color:#4ade80}
.term-err{color:#F44A6A}
.term-blink{
  display:inline-block;width:7px;height:.9em;
  background:#F78B3D;animation:cur .9s step-end infinite;
  vertical-align:text-bottom;margin-left:2px;border-radius:1px;
  box-shadow:0 0 6px rgba(247,139,61,.6);
}
@keyframes cur{0%,49%{opacity:1}50%,100%{opacity:0}}
</style>

<!-- ═══════════════════════════════════════
     404 PAGE — cube-cluster
═══════════════════════════════════════ -->
<section class="pg404">

  <!-- 3D scene: lost among the cubes -->
  <div class="fx-host" data-scene="cube-cluster" data-cam-z="14" data-scale="0.9" aria-hidden="true"></div>

  <!-- Orbs -->
  <div class="orb orb-or"  style="width:600px;height:600px;top:-180px;left:-150px;opacity:.7" aria-hidden="true"></div>
  <div class="orb orb-cy"  style="width:450px;height:450px;bottom:-120px;right:-100px;opacity:.5" aria-hidden="true"></div>
  <div class="orb orb-pk"  style="width:350px;height:350px;top:40%;left:40%;opacity:.4" aria-hidden="true"></div>
  <div class="hero-grid-bg"></div>
  <div class="dots-bg" style="opacity:.4" aria-hidden="true"></div>

  <div class="wrap">
    <div class="pg404-content" data-reveal>

      <!-- Glitch 404 number -->
      <div class="err-num-wrap">
        <div class="err-scanline" aria-hidden="true"></div>
        <div class="err-num">404</div>
      </div>

      <!-- Badge -->
      <div class="err-label">
        <span class="dot" aria-hidden="true"></span> Error — Page Not Found
      </div>

      <!-- Heading -->
      <h1 class="err-title">
        Oops! You've entered <span class="gradient-text">uncharted territory</span>
      </h1>
      <p class="err-desc">
        The page you're looking for doesn't exist, has been moved, or is temporarily unavailable. Let's get you back on track.
      </p>

      <!-- Terminal -->
      <div class="err-terminal">
        <div class="term-bar">
          <span class="term-dot r" aria-hidden="true"></span>
          <span class="term-dot y" aria-hidden="true"></span>
          <span class="term-dot g" aria-hidden="true"></span>
          <span class="term-path">softex-system ~ bash</span>
        </div>
        <div class="term-line"><span class="term-prompt">$</span><span class="term-cmd">GET <?= htmlspecialchars($_SERVER['REQUEST_URI'] ?? '/unknown') ?></span></div>
        <div class="term-line"><span class="term-prompt"> </span><span class="term-err">Error 404: Resource not found on this server</span></div>
        <div class="term-line"><span class="term-prompt"> </span><span class="term-output">Suggestion: Navigate to /index.php</span></div>
        <div class="term-line"><span class="term-prompt">$</span><span class="term-cmd"><span class="term-blink"></span></span></div>
      </div>

      <!-- Quick links -->
      <div class="err-links">
        <a href="index.php"     class="err-link"><i class="fas fa-home" aria-hidden="true"></i> Home</a>
        <a href="services.php"  class="err-link"><i class="fas fa-code" aria-hidden="true"></i> Services</a>
        <a href="portfolio.php" class="err-link"><i class="fas fa-briefcase" aria-hidden="true"></i> Portfolio</a>
        <a href="about.php"     class="err-link"><i class="fas fa-users" aria-hidden="true"></i> About</a>
        <a href="contact.php"   class="err-link"><i class="fas fa-envelope" aria-hidden="true"></i> Contact</a>
      </div>

      <!-- CTA buttons -->
      <div style="display:flex;gap:.85rem;justify-content:center;flex-wrap:wrap">
        <a href="index.php"  class="btn btn-primary btn-lg">
          <i class="fas fa-rocket" aria-hidden="true"></i> Back to Homepage
        </a>
        <a href="contact.php" class="btn btn-ghost btn-lg">
          <i class="fas fa-headset" aria-hidden="true"></i> Get Help
        </a>
      </div>

    </div>
  </div>

</section>

<?php require_once 'includes/footer.php'; ?>
