/**
 * Softex Technologies — main.js v6
 * Sticky header · Nav · Reveal · Counter · Portfolio filter · Typing · Form
 */
'use strict';

document.addEventListener('DOMContentLoaded', function () {

  /* ── Sticky header ─────────────────────── */
  var hdr = document.getElementById('siteHeader');
  if (hdr) {
    function onScroll() { hdr.classList.toggle('sticky', window.scrollY > 50); }
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  }

  /* ── Active nav link ───────────────────── */
  var page = location.pathname.split('/').pop() || 'index.php';
  document.querySelectorAll('.main-nav a, .mob-nav a').forEach(function (a) {
    var href = (a.getAttribute('href') || '').split('/').pop();
    if (href === page || (page === '' && href === 'index.php')) {
      a.classList.add('active');
    }
  });

  /* ── Mobile hamburger ──────────────────── */
  var ham = document.getElementById('hamburger');
  var mob = document.getElementById('mobileMenu');
  if (ham && mob) {
    function closeMob() {
      mob.classList.remove('open');
      ham.classList.remove('open');
      ham.setAttribute('aria-expanded', 'false');
      document.body.style.overflow = '';
    }
    ham.addEventListener('click', function (e) {
      e.stopPropagation();
      var open = mob.classList.toggle('open');
      ham.classList.toggle('open', open);
      ham.setAttribute('aria-expanded', String(open));
      document.body.style.overflow = open ? 'hidden' : '';
    });
    mob.querySelectorAll('a').forEach(function (a) {
      a.addEventListener('click', closeMob);
    });
    document.addEventListener('click', function (e) {
      if (mob.classList.contains('open') && !mob.contains(e.target) && !ham.contains(e.target)) {
        closeMob();
      }
    });
    // Also close on Escape key
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && mob.classList.contains('open')) closeMob();
    });
  }

  /* ── Typing animation ──────────────────── */
  var typingEl = document.getElementById('typingText');
  if (typingEl) {
    var words = [
      'Solutions',
      'Experiences',
      'That Convert',
      'That Scale',
      'With Precision',
      'For Tomorrow'
    ];
    var wIdx = 0, cIdx = 0, isDeleting = false;

    function typeEffect() {
      var word = words[wIdx];
      if (isDeleting) {
        typingEl.textContent = word.substring(0, cIdx - 1);
        cIdx--;
      } else {
        typingEl.textContent = word.substring(0, cIdx + 1);
        cIdx++;
      }
      if (!isDeleting && cIdx === word.length) {
        isDeleting = true;
        setTimeout(typeEffect, 2200);
        return;
      }
      if (isDeleting && cIdx === 0) {
        isDeleting = false;
        wIdx = (wIdx + 1) % words.length;
        setTimeout(typeEffect, 400);
        return;
      }
      setTimeout(typeEffect, isDeleting ? 45 : 95);
    }
    // Small delay before starting
    setTimeout(typeEffect, 800);
  }

  /* ── Scroll reveal ─────────────────────── */
  var revEls = document.querySelectorAll('[data-reveal]');
  if (revEls.length && 'IntersectionObserver' in window) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) {
        if (e.isIntersecting) { e.target.classList.add('visible'); io.unobserve(e.target); }
      });
    }, { threshold: 0.1 });
    revEls.forEach(function (el) { io.observe(el); });
  } else {
    revEls.forEach(function (el) { el.classList.add('visible'); });
  }

  /* ── Animated counters ─────────────────── */
  document.querySelectorAll('[data-count]').forEach(function (el) {
    var obs = new IntersectionObserver(function (entries) {
      if (!entries[0].isIntersecting) return;
      var target = parseInt(el.dataset.count, 10);
      var suffix = el.dataset.suffix || '';
      var start  = performance.now();
      var dur    = 1600;
      (function tick(now) {
        var p = Math.min((now - start) / dur, 1);
        el.textContent = Math.round((1 - Math.pow(1 - p, 3)) * target) + suffix;
        if (p < 1) requestAnimationFrame(tick);
      })(start);
      obs.unobserve(el);
    }, { threshold: 0.5 });
    obs.observe(el);
  });

  /* ── Portfolio filter ──────────────────── */
  var btns  = document.querySelectorAll('.filter-btn');
  var cards = document.querySelectorAll('.pf-card');
  var noRes = document.getElementById('noResults');

  if (btns.length && cards.length) {
    btns.forEach(function (btn) {
      btn.addEventListener('click', function () {
        btns.forEach(function (b) { b.classList.remove('active'); });
        btn.classList.add('active');
        var filter = btn.getAttribute('data-filter') || 'all';
        var vis = 0;
        cards.forEach(function (card) {
          var cat  = card.getAttribute('data-category') || '';
          var show = filter === 'all' || cat === filter;
          if (show) { card.classList.remove('pf-hidden'); vis++; }
          else        card.classList.add('pf-hidden');
        });
        if (noRes) noRes.style.display = vis === 0 ? 'block' : 'none';
      });
    });
  }

  /* ── Smooth anchor scroll ──────────────── */
  document.querySelectorAll('a[href^="#"]').forEach(function (a) {
    a.addEventListener('click', function (e) {
      var t = document.querySelector(a.getAttribute('href'));
      if (t) { e.preventDefault(); t.scrollIntoView({ behavior: 'smooth', block: 'start' }); }
    });
  });

  /* ── Contact form validation ───────────── */
  var cf = document.getElementById('contactForm');
  if (cf) {
    cf.addEventListener('submit', function (e) {
      var ok = true;
      cf.querySelectorAll('[required]').forEach(function (f) {
        f.classList.remove('error');
        if (!f.value.trim()) { f.classList.add('error'); ok = false; }
      });
      var em = cf.querySelector('[type="email"]');
      if (em && em.value && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(em.value)) {
        em.classList.add('error'); ok = false;
      }
      if (!ok) {
        e.preventDefault();
        var errEl = document.getElementById('formError');
        if (errEl) { errEl.classList.add('show'); setTimeout(function () { errEl.classList.remove('show'); }, 5000); }
        var first = cf.querySelector('.error');
        if (first) first.scrollIntoView({ behavior: 'smooth', block: 'center' });
      }
    });
    cf.querySelectorAll('input,textarea,select').forEach(function (f) {
      f.addEventListener('input', function () { f.classList.remove('error'); });
    });
  }

});
