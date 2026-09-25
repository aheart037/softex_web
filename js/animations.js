/**
 * Softex Technologies — animations.js v6
 * ─────────────────────────────────────────────────────────────
 * Motion & interaction layer (GSAP-powered, progressive):
 *   · preloader orchestration
 *   · page transitions (fade + depth)
 *   · custom cursor (desktop)
 *   · reusable tilt system ([data-tilt])
 *   · hero DOM parallax (chips / holographic panel)
 *   · services 3D network (2D canvas, faux-3D projection)
 *   · testimonial 3D carousel
 *   · process-step illumination
 *   · smooth portfolio filter transitions (used by main.js)
 *
 * Everything degrades gracefully: no GSAP / no JS → static site.
 */
window.SoftexFX = (function () {
  'use strict';

  var REDUCED = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var FINE_POINTER = window.matchMedia && window.matchMedia('(hover: hover) and (pointer: fine)').matches;
  var HAS_GSAP = typeof window.gsap !== 'undefined';

  if (HAS_GSAP && window.ScrollTrigger) gsap.registerPlugin(ScrollTrigger);

  /* ── Shared pointer (Softex3D tracks it; local fallback) ──── */
  var ptr = { x: 0, y: 0, sx: 0, sy: 0 };
  window.addEventListener('pointermove', function (e) {
    ptr.x = (e.clientX / window.innerWidth) * 2 - 1;
    ptr.y = (e.clientY / window.innerHeight) * 2 - 1;
  }, { passive: true });

  function smooth() {
    var p = window.Softex3D ? window.Softex3D.pointer : ptr;
    ptr.sx += (p.x - ptr.sx) * 0.06;
    ptr.sy += (p.y - ptr.sy) * 0.06;
    requestAnimationFrame(smooth);
  }
  if (!REDUCED) requestAnimationFrame(smooth);

  function pointerNow() {
    return window.Softex3D ? window.Softex3D.pointer : ptr;
  }

  /* ═══ PRELOADER ═══════════════════════════════════════════ */
  function initPreloader() {
    var pl = document.getElementById('preloader');
    if (!pl) return;

    var seen = false;
    try { seen = sessionStorage.getItem('softex-visited') === '1'; } catch (e) { /* private mode */ }

    if (seen || REDUCED || document.documentElement.classList.contains('no-js')) {
      pl.classList.add('done');
      document.documentElement.classList.add('skip-preload');
      try { sessionStorage.setItem('softex-visited', '1'); } catch (e) {}
      return;
    }

    var minTime = 1150;
    var start = performance.now();
    var loaded = document.readyState === 'complete';

    function finish() {
      var wait = Math.max(0, minTime - (performance.now() - start));
      setTimeout(function () {
        pl.classList.add('done');
        try { sessionStorage.setItem('softex-visited', '1'); } catch (e) {}
        /* content entrance */
        var hero = document.querySelector('.hero [data-reveal], .page-hero [data-reveal]');
        if (HAS_GSAP && !REDUCED && hero) {
          gsap.fromTo(hero, { opacity: 0, y: 22 }, { opacity: 1, y: 0, duration: .8, ease: 'power3.out', clearProps: 'all' });
        }
      }, wait);
    }

    if (loaded) finish();
    else window.addEventListener('load', finish);
    /* safety valve — never trap the user */
    setTimeout(function () { pl.classList.add('done'); }, 3000);
  }

  /* ═══ PAGE TRANSITIONS ═════════════════════════════════════ */
  function initPageTransitions() {
    document.body.classList.add('page-enter');
    setTimeout(function () { document.body.classList.remove('page-enter'); }, 700);
    if (REDUCED) return;

    document.addEventListener('click', function (e) {
      if (e.defaultPrevented || e.button !== 0 || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;
      var a = e.target.closest ? e.target.closest('a') : null;
      if (!a) return;
      var href = a.getAttribute('href') || '';
      if (!href || href.charAt(0) === '#' || a.target === '_blank' || a.hasAttribute('download')) return;
      /* same-document links only, internal pages only */
      if (/^(https?:)?\/\//i.test(href) || href.indexOf('mailto:') === 0 || href.indexOf('tel:') === 0) {
        var loc = location.protocol + '//' + location.host + '/';
        if (href.indexOf(loc) !== 0) return;  /* external — leave untouched */
      }
      var target = href.split('#')[0];
      var here = location.pathname.split('/').pop() || 'index.php';
      if (target === here || target === '') return; /* anchor nav — keep native smooth scroll */

      e.preventDefault();
      document.body.classList.add('page-exit');
      setTimeout(function () { location.href = href; }, 240);
    }, true);
  }

  /* ═══ CUSTOM CURSOR ════════════════════════════════════════ */
  function initCursor() {
    if (!FINE_POINTER || REDUCED) return;
    var dot = document.getElementById('cursorDot');
    var ring = document.getElementById('cursorRing');
    if (!dot || !ring) return;

    document.documentElement.classList.add('cursor-on');
    var rx = 0, ry = 0, tx = 0, ty = 0;

    window.addEventListener('pointermove', function (e) {
      tx = e.clientX; ty = e.clientY;
      dot.style.transform = 'translate(' + (tx - 3) + 'px,' + (ty - 3) + 'px)';
    }, { passive: true });

    (function loop() {
      rx += (tx - rx) * 0.16; ry += (ty - ry) * 0.16;
      ring.style.transform = 'translate(' + (rx - 17) + 'px,' + (ry - 17) + 'px)';
      requestAnimationFrame(loop);
    })();

    document.addEventListener('pointerover', function (e) {
      var el = e.target.closest ? e.target.closest('a,button,[data-tilt],.filter-btn,.pf-card,.t-dot') : null;
      document.documentElement.classList.toggle('cursor-hover', !!el);
      var txt = e.target.closest ? e.target.closest('input,textarea,select') : null;
      document.documentElement.classList.toggle('cursor-text', !!txt);
    }, { passive: true });
  }

  /* ═══ TILT SYSTEM ══════════════════════════════════════════ */
  function initTilt() {
    if (!FINE_POINTER || REDUCED) return;
    var els = document.querySelectorAll('[data-tilt]');
    if (!els.length) return;

    els.forEach(function (el) {
      var max = parseFloat(el.getAttribute('data-tilt-max')) || 6;
      var raf = 0, px = 0, py = 0;
      var card = el.closest('.svc-card, .team-card');

      function apply() {
        raf = 0;
        var rx = (-py * max).toFixed(2);
        var ry = (px * max).toFixed(2);
        el.style.setProperty('--rx', rx + 'deg');
        el.style.setProperty('--ry', ry + 'deg');
        if (card) {
          card.style.setProperty('--rx', (rx * 0.55) + 'deg');
          card.style.setProperty('--ry', (ry * 0.55) + 'deg');
          card.style.setProperty('--mx', ((px + 1) / 2 * 100).toFixed(1) + '%');
          card.style.setProperty('--my', ((py + 1) / 2 * 100).toFixed(1) + '%');
        }
      }

      el.addEventListener('pointerenter', function () {
        el.style.transition = 'transform .18s ease-out';
      });

      el.addEventListener('pointermove', function (e) {
        var r = el.getBoundingClientRect();
        px = ((e.clientX - r.left) / r.width) * 2 - 1;
        py = ((e.clientY - r.top) / r.height) * 2 - 1;
        if (!raf) raf = requestAnimationFrame(apply);
      }, { passive: true });

      el.addEventListener('pointerleave', function () {
        el.style.transition = 'transform .6s cubic-bezier(.16,1,.3,1)';
        el.style.setProperty('--rx', '0deg');
        el.style.setProperty('--ry', '0deg');
        if (card) {
          card.style.setProperty('--rx', '0deg');
          card.style.setProperty('--ry', '0deg');
        }
        px = py = 0;
      });
    });
  }

  /* ═══ HERO DOM PARALLAX (chips + holographic panel) ════════ */
  function initHeroParallax() {
    if (REDUCED) return;
    var pills = document.querySelectorAll('.float-pill');
    var panel = document.querySelector('.hero-panel');
    if (!pills.length && !panel) return;

    (function loop() {
      var p = pointerNow();
      pills.forEach(function (pill) {
        var d = parseFloat(pill.getAttribute('data-depth')) || 0.5;
        var x = (-p.sx * 18 * d).toFixed(2);
        var y = (-p.sy * 14 * d).toFixed(2);
        pill.style.transform = 'translate3d(' + x + 'px,' + y + 'px,0)';
      });
      requestAnimationFrame(loop);
    })();
  }

  /* ═══ SERVICES NETWORK (2D canvas, faux-3D) ════════════════ */
  function initServicesNet() {
    var canvas = document.querySelector('[data-net]');
    if (!canvas || REDUCED) return;
    var ctx = canvas.getContext('2d');
    if (!ctx) return;

    var wrap = canvas.parentElement;
    var W = 0, H = 0, dpr = Math.min(window.devicePixelRatio || 1, 1.5);
    var nodes = [];
    var hot = -1;

    function build() {
      W = wrap.clientWidth; H = wrap.clientHeight;
      canvas.width = W * dpr; canvas.height = H * dpr;
      canvas.style.width = W + 'px'; canvas.style.height = H + 'px';
      ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
      var n = W < 700 ? 16 : 30;
      nodes = [];
      for (var i = 0; i < n; i++) {
        nodes.push({
          x: Math.random() * W, y: Math.random() * H,
          vx: (Math.random() - .5) * .12, vy: (Math.random() - .5) * .12,
          z: .35 + Math.random() * .65,           /* faux depth */
          r: 1.1 + Math.random() * 1.6
        });
      }
    }

    function near(i, j) {
      var a = nodes[i], b = nodes[j];
      var dx = a.x - b.x, dy = a.y - b.y;
      return dx * dx + dy * dy < 150 * 150;
    }

    function frame() {
      requestAnimationFrame(frame);
      if (!isVisible()) return;
      ctx.clearRect(0, 0, W, H);

      for (var i = 0; i < nodes.length; i++) {
        var nd = nodes[i];
        nd.x += nd.vx; nd.y += nd.vy;
        if (nd.x < -20) nd.x = W + 20; if (nd.x > W + 20) nd.x = -20;
        if (nd.y < -20) nd.y = H + 20; if (nd.y > H + 20) nd.y = -20;
      }

      ctx.lineWidth = 1;
      for (var a = 0; a < nodes.length; a++) {
        for (var b = a + 1; b < nodes.length; b++) {
          if (!near(a, b)) continue;
          var boost = (a === hot || b === hot);
          var za = (nodes[a].z + nodes[b].z) / 2;
          var alpha = (boost ? .5 : .12) * za;
          var grd = boost ? '255,110,80' : '255,122,92';
          ctx.strokeStyle = 'rgba(' + grd + ',' + alpha.toFixed(3) + ')';
          ctx.beginPath();
          ctx.moveTo(nodes[a].x, nodes[a].y);
          ctx.lineTo(nodes[b].x, nodes[b].y);
          ctx.stroke();
        }
      }
      for (var k = 0; k < nodes.length; k++) {
        var nn = nodes[k];
        var isHot = k === hot;
        ctx.fillStyle = isHot ? 'rgba(255,182,72,.95)' : 'rgba(255,140,110,' + (0.22 * nn.z + .08).toFixed(2) + ')';
        ctx.beginPath();
        ctx.arc(nn.x, nn.y, nn.r * (isHot ? 2 : 1), 0, 6.2832);
        ctx.fill();
      }
    }

    var visible = true;
    function isVisible() { return visible; }
    if ('IntersectionObserver' in window) {
      new IntersectionObserver(function (en) { visible = en[0].isIntersecting; }, { rootMargin: '80px' }).observe(canvas);
    }

    /* hovering a service card brightens nearby nodes */
    var cards = wrap.querySelectorAll('.svc-card');
    cards.forEach(function (card, i) {
      card.addEventListener('pointerenter', function () {
        var r = card.getBoundingClientRect(), c = wrap.getBoundingClientRect();
        var cx = r.left - c.left + r.width / 2, cy = r.top - c.top + r.height / 2;
        var best = -1, bd = 1e9;
        for (var n2 = 0; n2 < nodes.length; n2++) {
          var d = (nodes[n2].x - cx) * (nodes[n2].x - cx) + (nodes[n2].y - cy) * (nodes[n2].y - cy);
          if (d < bd) { bd = d; best = n2; }
        }
        hot = best;
      });
      card.addEventListener('pointerleave', function () { hot = -1; });
    });

    var rt; window.addEventListener('resize', function () {
      clearTimeout(rt); rt = setTimeout(build, 200);
    }, { passive: true });

    build();
    frame();
  }

  /* ═══ TESTIMONIAL 3D CAROUSEL ══════════════════════════════ */
  function initCarousel() {
    var root = document.querySelector('[data-carousel]');
    if (!root) return;
    var cards = Array.prototype.slice.call(root.querySelectorAll('.testi-card'));
    if (cards.length < 2) return;

    root.classList.add('carousel-on');
    var dotsWrap = root.querySelector('.t-dots');
    var idx = 0, timer = 0;

    cards.forEach(function (c, i) {
      if (dotsWrap) {
        var d = document.createElement('button');
        d.className = 't-dot' + (i === 0 ? ' on' : '');
        d.type = 'button';
        d.setAttribute('aria-label', 'Go to review ' + (i + 1));
        d.addEventListener('click', function () { go(i); });
        dotsWrap.appendChild(d);
      }
    });

    function go(n) {
      idx = (n + cards.length) % cards.length;
      cards.forEach(function (c, i) {
        c.classList.remove('is-center', 'is-prev', 'is-next', 'is-far');
        if (i === idx) c.classList.add('is-center');
        else {
          var rel = (i - idx + cards.length) % cards.length;
          if (rel === 1) c.classList.add('is-next');
          else if (rel === cards.length - 1) c.classList.add('is-prev');
          else c.classList.add('is-far');
        }
      });
      if (dotsWrap) dotsWrap.querySelectorAll('.t-dot').forEach(function (d, i) {
        d.classList.toggle('on', i === idx);
      });
      restartAuto();
    }

    function restartAuto() {
      clearInterval(timer);
      if (!REDUCED) timer = setInterval(function () { go(idx + 1); }, 8000);
    }

    var prev = root.querySelector('.t-prev');
    var next = root.querySelector('.t-next');
    if (prev) prev.addEventListener('click', function () { go(idx - 1); });
    if (next) next.addEventListener('click', function () { go(idx + 1); });

    root.addEventListener('pointerenter', function () { clearInterval(timer); });
    root.addEventListener('pointerleave', restartAuto);

    /* swipe */
    var sx = null;
    root.addEventListener('pointerdown', function (e) { sx = e.clientX; }, { passive: true });
    root.addEventListener('pointerup', function (e) {
      if (sx === null) return;
      var dx = e.clientX - sx;
      if (Math.abs(dx) > 44) go(idx + (dx < 0 ? 1 : -1));
      sx = null;
    }, { passive: true });

    document.addEventListener('keydown', function (e) {
      if (!root.getBoundingClientRect().top < 0) return;
      if (e.key === 'ArrowLeft') go(idx - 1);
      if (e.key === 'ArrowRight') go(idx + 1);
    });

    go(0);
  }

  /* ═══ PROCESS STEP ILLUMINATION ════════════════════════════ */
  function initProcessSteps() {
    var steps = document.querySelectorAll('.proc-step');
    if (!steps.length || !('IntersectionObserver' in window)) return;
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (en) {
        if (en.isIntersecting) {
          en.target.classList.add('lit');
          io.unobserve(en.target);
        }
      });
    }, { threshold: 0.6 });
    steps.forEach(function (s) { io.observe(s); });
  }

  /* ═══ SMOOTH PORTFOLIO FILTER (used by main.js) ═════════════ */
  function animateFilter(filter, cards) {
    if (!HAS_GSAP) return null;
    var shown = [], hidden = [];

    cards.forEach(function (card) {
      var cat = card.getAttribute('data-category') || '';
      (filter === 'all' || cat === filter ? shown : hidden).push(card);
    });

    gsap.killTweensOf(cards);

    hidden.forEach(function (card) {
      gsap.to(card, {
        opacity: 0, scale: .88, rotateY: 10, duration: .3, ease: 'power2.in',
        onComplete: function () {
          card.classList.add('pf-hidden');
          gsap.set(card, { clearProps: 'transform,opacity' });
        }
      });
    });

    if (shown.length) {
      shown.forEach(function (card) { card.classList.remove('pf-hidden'); });
      gsap.fromTo(shown,
        { opacity: 0, scale: .92, rotateY: -8, y: 18 },
        {
          opacity: 1, scale: 1, rotateY: 0, y: 0,
          duration: .5, ease: 'back.out(1.4)', stagger: .05, delay: hidden.length ? .18 : 0,
          clearProps: 'transform,opacity'
        });
    }
    return true;
  }

  /* ═══ SCROLLTRIGGER CHOREOGRAPHY ═══════════════════════════ */
  function initScrollFX() {
    if (!HAS_GSAP || !window.ScrollTrigger || REDUCED) return;

    /* hero copy parallaxes away gently on scroll */
    var heroCopy = document.querySelector('.hero .hero-wrap > div:first-child');
    var heroVisual = document.querySelector('.hero-visual');
    if (heroCopy && document.querySelector('.hero')) {
      gsap.to(heroCopy, {
        y: -70, opacity: .1, ease: 'none',
        scrollTrigger: { trigger: '.hero', start: 'top top', end: 'bottom 35%', scrub: .6 }
      });
    }
    if (heroVisual && !window.matchMedia('(max-width:900px)').matches) {
      gsap.to(heroVisual, {
        y: 50, ease: 'none',
        scrollTrigger: { trigger: '.hero', start: 'top top', end: 'bottom top', scrub: .8 }
      });
    }

    /* section headings — refined entrance */
    document.querySelectorAll('.section .center[data-reveal], .section .split-text[data-reveal]').forEach(function (el) {
      /* reveals already handled by [data-reveal]; ScrollTrigger adds parallax dust */
    });

    /* CTA box gentle float on approach */
    var cta = document.querySelector('.cta-box');
    if (cta) {
      gsap.fromTo(cta, { y: 46 },
        {
          y: 0, ease: 'power2.out', duration: 1,
          scrollTrigger: { trigger: '.cta-band', start: 'top 78%' }
        });
    }

    ScrollTrigger.refresh();
  }

  /* ═══ BOOT ═════════════════════════════════════════════════ */
  function boot() {
    initPreloader();
    initPageTransitions();
    initCursor();
    initTilt();
    initHeroParallax();
    initServicesNet();
    initCarousel();
    initProcessSteps();
    initScrollFX();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot);
  } else {
    boot();
  }

  return { filter: animateFilter, pointer: ptr };
})();
