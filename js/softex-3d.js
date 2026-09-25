/**
 * Softex Technologies — softex-3d.js v6
 * ─────────────────────────────────────────────────────────────
 * Global 3D engine. Powers the "Softex digital world":
 *   · hero       — interactive Softex Technology Core
 *   · orb        — network sphere (about visual / CTA core)
 *   · globe      — abstract connected-points sphere (contact)
 *   · rings      — page-hero ring structure
 *   · field      — floating project screens (portfolio hero)
 *   · atmosphere — site-wide subtle particle dust
 *
 * Architecture
 *   · Three.js is lazy-loaded only when a scene exists
 *   · One shared rAF loop, scenes pause when off-screen
 *   · Quality tiers (desktop / tablet / mobile / save-data)
 *   · prefers-reduced-motion → static renders, no motion
 *   · WebGL failure → CSS fallback stays, console warns
 *   · Full disposal on pagehide — no leaks
 */
window.Softex3D = (function () {
  'use strict';

  /* ── Environment & quality detection ─────────────────────── */
  var mqlReduced = window.matchMedia ? window.matchMedia('(prefers-reduced-motion: reduce)') : null;
  var REDUCED = !!(mqlReduced && mqlReduced.matches);

  var conn = navigator.connection || navigator.mozConnection || navigator.webkitConnection;
  var SAVE_DATA = !!(conn && (conn.saveData || /(^|\b)(slow-2g|2g)\b/.test(conn.effectiveType || '')));
  var COARSE = window.matchMedia ? window.matchMedia('(max-width: 900px)').matches : false;
  var LOW_CPU = (navigator.hardwareConcurrency || 8) <= 4;
  var LOW_MEM = navigator.deviceMemory ? navigator.deviceMemory <= 4 : false;

  var IS_TOUCH = ('ontouchstart' in window) || (navigator.maxTouchPoints > 0);

  var QUALITY = 'high';
  if (REDUCED || SAVE_DATA || (COARSE && (LOW_CPU || LOW_MEM))) QUALITY = 'low';
  else if (COARSE || LOW_CPU) QUALITY = 'medium';

  /* ── Shared pointer state (used by DOM parallax too) ─────── */
  var pointer = { x: 0, y: 0, sx: 0, sy: 0 }; // sx/sy = smoothed

  function onPointerMove(e) {
    pointer.x = (e.clientX / window.innerWidth) * 2 - 1;
    pointer.y = (e.clientY / window.innerHeight) * 2 - 1;
  }
  window.addEventListener('pointermove', onPointerMove, { passive: true });

  function smoothPointer() {
    pointer.sx += (pointer.x - pointer.sx) * 0.055;
    pointer.sy += (pointer.y - pointer.sy) * 0.055;
  }

  /* ── WebGL capability ─────────────────────────────────────── */
  function webglSupported() {
    try {
      var c = document.createElement('canvas');
      return !!(window.WebGLRenderingContext && (c.getContext('webgl') || c.getContext('experimental-webgl')));
    } catch (e) { return false; }
  }

  /* ── Shared, cached resources (skipped on dispose) ────────── */
  var CACHE = { textures: {} };

  function softCircleTexture() {
    if (CACHE.textures.soft) return CACHE.textures.soft;
    var s = 64, c = document.createElement('canvas'); c.width = c.height = s;
    var g = c.getContext('2d');
    var grd = g.createRadialGradient(s / 2, s / 2, 0, s / 2, s / 2, s / 2);
    grd.addColorStop(0, 'rgba(255,255,255,1)');
    grd.addColorStop(0.35, 'rgba(255,255,255,.5)');
    grd.addColorStop(1, 'rgba(255,255,255,0)');
    g.fillStyle = grd; g.fillRect(0, 0, s, s);
    var t = new THREE.CanvasTexture(c);
    t.userData.shared = true;
    CACHE.textures.soft = t;
    return t;
  }

  function glowTexture(hexInner, hexOuter) {
    var key = hexInner + hexOuter;
    if (CACHE.textures[key]) return CACHE.textures[key];
    var s = 128, c = document.createElement('canvas'); c.width = c.height = s;
    var g = c.getContext('2d');
    var grd = g.createRadialGradient(s / 2, s / 2, 0, s / 2, s / 2, s / 2);
    grd.addColorStop(0, hexInner);
    grd.addColorStop(0.28, hexOuter);
    grd.addColorStop(1, 'rgba(0,0,0,0)');
    g.fillStyle = grd; g.fillRect(0, 0, s, s);
    var t = new THREE.CanvasTexture(c);
    t.userData.shared = true;
    CACHE.textures[key] = t;
    return t;
  }

  /* Brand palette */
  var C = {
    brand: 0xff4d3e, brand2: 0xff7a45, amber: 0xffb648,
    cyan: 0x37d3e6, purple: 0x8b5cf6, ink: 0x0b1220,
    white: 0xf1f5f9
  };

  /* ── Engine (single rAF, visibility-aware) ────────────────── */
  var scenes = [];
  var running = false, rafId = 0, lastT = 0, pageHidden = false;
  var io = null;
  var _v1 = null;
  function V1() { if (!_v1) _v1 = new THREE.Vector3(); return _v1; }

  function tick(now) {
    rafId = requestAnimationFrame(tick);
    var dt = Math.min((now - lastT) / 1000, 0.05);
    lastT = now;
    smoothPointer();
    if (pageHidden) return;
    for (var i = 0; i < scenes.length; i++) {
      var s = scenes[i];
      if (s.active) { s.update(dt, now / 1000); s.render(); }
    }
  }

  function ensureLoop() {
    if (running || REDUCED) return;
    running = true;
    lastT = performance.now();
    rafId = requestAnimationFrame(tick);
  }

  function watchVisibility(scene) {
    if (!('IntersectionObserver' in window)) { scene.active = true; ensureLoop(); return; }
    if (!io) io = new IntersectionObserver(function (entries) {
      entries.forEach(function (en) {
        var s = en.target._scene;
        if (!s) return;
        s.active = en.isIntersecting;
        if (s.active) ensureLoop();
      });
    }, { rootMargin: '120px' });
    scene.el._scene = scene;
    io.observe(scene.el);
  }

  var resizeTimer = 0;
  window.addEventListener('resize', function () {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(function () {
      scenes.forEach(function (s) { s.resize(); if (REDUCED) { s.update(0, 0); s.render(); } });
    }, 160);
  }, { passive: true });

  document.addEventListener('visibilitychange', function () {
    pageHidden = document.hidden;
    if (!pageHidden) { lastT = performance.now(); ensureLoop(); }
  });

  window.addEventListener('pagehide', function () {
    cancelAnimationFrame(rafId);
    running = false;
    scenes.forEach(function (s) { s.dispose(); });
    scenes.length = 0;
  });

  /* ── Renderer / camera factory ────────────────────────────── */
  function makeRenderer(canvas) {
    var renderer = new THREE.WebGLRenderer({
      canvas: canvas, alpha: true,
      antialias: QUALITY === 'high',
      powerPreference: 'high-performance'
    });
    var prCap = QUALITY === 'high' ? 2 : (QUALITY === 'medium' ? 1.5 : 1.2);
    renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, prCap));
    if (THREE.sRGBEncoding !== undefined) renderer.outputEncoding = THREE.sRGBEncoding;
    return renderer;
  }

  function makeScene(container) {
    var canvas = document.createElement('canvas');
    container.insertBefore(canvas, container.firstChild);
    var renderer = makeRenderer(canvas);
    var scene = new THREE.Scene();
    var camera = new THREE.PerspectiveCamera(45, 1, 0.1, 100);
    var api = {
      el: container, canvas: canvas, renderer: renderer,
      three: scene, camera: camera, active: false, dead: false,
      render: function () { renderer.render(scene, camera); },
      resize: function () {
        var w = container.clientWidth || 1, h = container.clientHeight || 1;
        renderer.setSize(w, h, false);
        camera.aspect = w / h; camera.updateProjectionMatrix();
      },
      dispose: function () {
        if (api.dead) return; api.dead = true;
        if (io) io.unobserve(container);
        scene.traverse(function (o) {
          if (o.geometry) o.geometry.dispose();
          if (o.material) {
            var mats = Array.isArray(o.material) ? o.material : [o.material];
            mats.forEach(function (m) {
              for (var p in m) {
                var v = m[p];
                if (v && v.isTexture && !(v.userData && v.userData.shared)) v.dispose();
              }
              m.dispose();
            });
          }
        });
        renderer.dispose();
      }
    };
    return api;
  }

  /* Standard lighting rig — brand-tinted, elegant */
  function addLights(scene, opts) {
    opts = opts || {};
    scene.add(new THREE.AmbientLight(0x2b3550, opts.ambient != null ? opts.ambient : 0.9));
    var key = new THREE.DirectionalLight(0xffffff, opts.key != null ? opts.key : 0.65);
    key.position.set(3, 4, 6); scene.add(key);
    var brand = new THREE.PointLight(C.brand, opts.brand != null ? opts.brand : 1.15, 14, 2);
    brand.position.set(1.6, 1.2, 2.4); scene.add(brand);
    var rim = new THREE.PointLight(C.cyan, opts.rim != null ? opts.rim : 0.55, 12, 2);
    rim.position.set(-4, -2, -3); scene.add(rim);
    return { key: key, brand: brand, rim: rim };
  }

  /* ── Reusable: particle field ─────────────────────────────── */
  function createParticleField(count, spread, colorMix, size) {
    var geo = new THREE.BufferGeometry();
    var pos = new Float32Array(count * 3);
    var col = new Float32Array(count * 3);
    var palette = [new THREE.Color(C.white), new THREE.Color(C.brand2), new THREE.Color(C.cyan), new THREE.Color(C.amber)];
    var w = [0.55, 0.22, 0.13, 0.1];
    for (var i = 0; i < count; i++) {
      pos[i * 3] = (Math.random() - 0.5) * spread.x;
      pos[i * 3 + 1] = (Math.random() - 0.5) * spread.y;
      pos[i * 3 + 2] = (Math.random() - 0.5) * spread.z;
      var r = Math.random(), ci = 0, acc = 0;
      for (var k = 0; k < palette.length; k++) { acc += w[k]; if (r <= acc) { ci = k; break; } }
      col[i * 3] = palette[ci].r; col[i * 3 + 1] = palette[ci].g; col[i * 3 + 2] = palette[ci].b;
    }
    geo.setAttribute('position', new THREE.BufferAttribute(pos, 3));
    geo.setAttribute('color', new THREE.BufferAttribute(col, 3));
    var mat = new THREE.PointsMaterial({
      size: size || 0.055, map: softCircleTexture(), vertexColors: true,
      transparent: true, opacity: 0.75, depthWrite: false,
      blending: THREE.AdditiveBlending, sizeAttenuation: true
    });
    return new THREE.Points(geo, mat);
  }

  /* ── Reusable: tech node primitives ───────────────────────── */
  function createDatabaseNode(s) {
    s = s || 1;
    var g = new THREE.Group();
    var mat = new THREE.MeshStandardMaterial({ color: 0x1c2a47, roughness: .35, metalness: .3, emissive: 0x37d3e6, emissiveIntensity: .12 });
    var edge = new THREE.MeshBasicMaterial({ color: C.cyan, transparent: true, opacity: .55 });
    for (var i = 0; i < 3; i++) {
      var y = (i - 1) * 0.11 * s;
      var cyl = new THREE.Mesh(new THREE.CylinderGeometry(0.15 * s, 0.15 * s, 0.055 * s, 20), mat);
      cyl.position.y = y; g.add(cyl);
      var ring = new THREE.Mesh(new THREE.TorusGeometry(0.153 * s, 0.006 * s, 6, 28), edge);
      ring.rotation.x = Math.PI / 2; ring.position.y = y + 0.03 * s; g.add(ring);
    }
    return g;
  }

  function createCloudNode(s) {
    s = s || 1;
    var g = new THREE.Group();
    var mat = new THREE.MeshStandardMaterial({ color: 0xdde7ff, roughness: .5, metalness: 0, transparent: true, opacity: .92, emissive: 0xffffff, emissiveIntensity: .06 });
    var p = [[0, 0, 0, .13], [.12, -.02, .03, .1], [-.12, -.02, .02, .1], [.05, .07, -.02, .09]];
    p.forEach(function (q) {
      var sp = new THREE.Mesh(new THREE.SphereGeometry(q[3] * s, 14, 10), mat);
      sp.position.set(q[0] * s, q[1] * s, q[2] * s); g.add(sp);
    });
    return g;
  }

  function createPanelNode(s) {
    s = s || 1;
    var c = document.createElement('canvas'); c.width = 64; c.height = 44;
    var g = c.getContext('2d');
    g.fillStyle = '#0d1526'; g.fillRect(0, 0, 64, 44);
    g.strokeStyle = 'rgba(255,122,92,.8)'; g.strokeRect(.5, .5, 63, 43);
    g.fillStyle = 'rgba(255,77,62,.75)'; g.fillRect(5, 5, 22, 6);
    g.fillStyle = 'rgba(255,255,255,.28)';
    g.fillRect(5, 16, 50, 3); g.fillRect(5, 22, 38, 3); g.fillRect(5, 28, 44, 3);
    g.fillStyle = 'rgba(55,211,230,.8)'; g.fillRect(5, 35, 16, 4);
    var tex = new THREE.CanvasTexture(c);
    var panel = new THREE.Mesh(
      new THREE.BoxGeometry(0.44 * s, 0.3 * s, 0.02 * s),
      [
        new THREE.MeshBasicMaterial({ color: 0x0d1526 }),
        new THREE.MeshBasicMaterial({ color: 0x0d1526 }),
        new THREE.MeshBasicMaterial({ color: 0x0d1526 }),
        new THREE.MeshBasicMaterial({ color: 0x0d1526 }),
        new THREE.MeshBasicMaterial({ map: tex }),
        new THREE.MeshBasicMaterial({ color: 0x0d1526 })
      ]
    );
    var glow = new THREE.Sprite(new THREE.SpriteMaterial({ map: glowTexture('rgba(255,77,62,.28)', 'rgba(255,77,62,.07)'), transparent: true, opacity: .8, depthWrite: false, blending: THREE.AdditiveBlending }));
    glow.scale.set(0.9 * s, 0.7 * s, 1);
    var grp = new THREE.Group(); grp.add(panel); grp.add(glow);
    return grp;
  }

  function createCodeNode(s) {
    s = s || 1;
    var c = document.createElement('canvas'); c.width = 64; c.height = 48;
    var g = c.getContext('2d');
    g.fillStyle = '#0a0f1c'; g.fillRect(0, 0, 64, 48);
    g.fillStyle = '#c084fc'; g.fillRect(5, 6, 14, 3);
    g.fillStyle = '#34d399'; g.fillRect(5, 13, 26, 3);
    g.fillStyle = '#ffb648'; g.fillRect(5, 20, 18, 3);
    g.fillStyle = 'rgba(255,255,255,.25)'; g.fillRect(5, 27, 40, 3); g.fillRect(5, 34, 30, 3);
    g.fillStyle = '#ff4d3e'; g.fillRect(5, 41, 10, 3);
    var tex = new THREE.CanvasTexture(c);
    var chip = new THREE.Mesh(
      new THREE.BoxGeometry(0.3 * s, 0.23 * s, 0.03 * s),
      [
        new THREE.MeshBasicMaterial({ color: 0x0a0f1c }), new THREE.MeshBasicMaterial({ color: 0x0a0f1c }),
        new THREE.MeshBasicMaterial({ color: 0x0a0f1c }), new THREE.MeshBasicMaterial({ color: 0x0a0f1c }),
        new THREE.MeshBasicMaterial({ map: tex }), new THREE.MeshBasicMaterial({ color: 0x0a0f1c })
      ]
    );
    return chip;
  }

  function createAiNode(s) {
    s = s || 1;
    var core = new THREE.Mesh(
      new THREE.OctahedronGeometry(0.15 * s, 0),
      new THREE.MeshStandardMaterial({ color: 0x241a3f, roughness: .3, metalness: .4, emissive: C.purple, emissiveIntensity: .7 })
    );
    var halo = new THREE.Mesh(
      new THREE.TorusGeometry(0.23 * s, 0.007 * s, 6, 30),
      new THREE.MeshBasicMaterial({ color: C.purple, transparent: true, opacity: .5 })
    );
    halo.rotation.x = Math.PI / 2.4;
    var g = new THREE.Group(); g.add(core); g.add(halo); g.userData.halo = halo;
    return g;
  }

  function createCubeNode(s, color) {
    s = s || 1;
    var box = new THREE.Mesh(
      new THREE.BoxGeometry(0.17 * s, 0.17 * s, 0.17 * s),
      new THREE.MeshStandardMaterial({ color: 0x1c2a47, roughness: .35, metalness: .35, emissive: color || C.brand, emissiveIntensity: .3 })
    );
    var edges = new THREE.LineSegments(
      new THREE.EdgesGeometry(box.geometry),
      new THREE.LineBasicMaterial({ color: color || C.brand2, transparent: true, opacity: .85 })
    );
    box.add(edges);
    return box;
  }

  function createSphereNode(s, color) {
    s = s || 1;
    return new THREE.Mesh(
      new THREE.SphereGeometry(0.1 * s, 14, 12),
      new THREE.MeshStandardMaterial({ color: 0x1c2a47, roughness: .3, metalness: .3, emissive: color || C.amber, emissiveIntensity: .55 })
    );
  }

  /* Map of node factories — reusable tech-node system */
  var NODES = {
    database: createDatabaseNode, cloud: createCloudNode, panel: createPanelNode,
    code: createCodeNode, ai: createAiNode, cube: createCubeNode, sphere: createSphereNode
  };

  /* ══════════════════════════════════════════════════════════
     SCENE: HERO — the Softex Technology Core
  ═══════════════════════════════════════════════════════════ */
  function buildHeroScene(container) {
    var S = makeScene(container);
    var cam = S.camera;
    cam.fov = 42; cam.position.set(0, 0, 7);
    var lights = addLights(S.three, { ambient: .75, key: .7, brand: 1.25, rim: .6 });

    var heroEl = container.closest('.hero') || container.parentElement;
    var anchorEl = document.getElementById('coreAnchor');

    var world = new THREE.Group(); S.three.add(world);
    var core = new THREE.Group(); world.add(core);

    /* — the core — */
    var coreMesh = new THREE.Mesh(
      new THREE.IcosahedronGeometry(0.92, 1),
      new THREE.MeshStandardMaterial({ color: 0x2a1210, roughness: .38, metalness: .2, emissive: C.brand, emissiveIntensity: .55, flatShading: true })
    );
    core.add(coreMesh);

    var shell = new THREE.Mesh(
      new THREE.IcosahedronGeometry(1.14, 1),
      new THREE.MeshBasicMaterial({ color: 0xff6a4a, wireframe: true, transparent: true, opacity: .5 })
    );
    core.add(shell);

    var glass = new THREE.Mesh(
      new THREE.SphereGeometry(1.5, 40, 28),
      new THREE.MeshPhongMaterial({ color: 0x93a7cc, transparent: true, opacity: .07, shininess: 90, side: THREE.DoubleSide, depthWrite: false })
    );
    core.add(glass);

    var coreGlow = new THREE.Sprite(new THREE.SpriteMaterial({
      map: glowTexture('rgba(255,110,80,.5)', 'rgba(255,77,62,.12)'),
      transparent: true, opacity: .55, depthWrite: false, blending: THREE.AdditiveBlending
    }));
    coreGlow.scale.set(4.6, 4.6, 1);
    core.add(coreGlow);

    /* — orbit rings — */
    var rings = [];
    var ringDefs = [
      { r: 2.0, color: C.brand2, op: .6, tilt: [Math.PI / 2.35, 0, .3], speed: .22 },
      { r: 2.42, color: C.cyan, op: .28, tilt: [Math.PI / 1.9, .4, -.2], speed: -.16 },
      { r: 1.72, color: C.amber, op: .38, tilt: [Math.PI / 2.05, -.5, .15], speed: .3 }
    ];
    if (QUALITY === 'low') ringDefs = ringDefs.slice(0, 2);
    ringDefs.forEach(function (d) {
      var grp = new THREE.Group();
      grp.rotation.set(d.tilt[0], d.tilt[1], d.tilt[2]);
      var ring = new THREE.Mesh(
        new THREE.TorusGeometry(d.r, 0.011, 8, 120),
        new THREE.MeshBasicMaterial({ color: d.color, transparent: true, opacity: d.op })
      );
      grp.add(ring); core.add(grp); rings.push({ grp: grp, speed: d.speed, def: d });
    });

    /* — orbiting tech nodes — */
    var orbitSpecs = [
      { kind: 'database', r: 2.0, speed: .34, phase: 0.2, ring: 0, s: 1.1 },
      { kind: 'cloud', r: 2.42, speed: -.22, phase: 2.4, ring: 1, s: 1.15 },
      { kind: 'panel', r: 2.0, speed: .34, phase: 3.4, ring: 0, s: 1 },
      { kind: 'code', r: 1.72, speed: .42, phase: 1.1, ring: 2, s: 1.1 },
      { kind: 'ai', r: 2.42, speed: -.22, phase: 5.1, ring: 1, s: 1.15 },
      { kind: 'cube', r: 1.72, speed: .42, phase: 4.2, ring: 2, s: 1 },
      { kind: 'sphere', r: 2.0, speed: .34, phase: 5.7, ring: 0, s: 1.2 }
    ];
    if (QUALITY === 'medium') orbitSpecs = orbitSpecs.slice(0, 5);
    if (QUALITY === 'low') orbitSpecs = orbitSpecs.slice(0, 4);

    var orbiters = [];
    orbitSpecs.forEach(function (spec) {
      var host = rings[spec.ring] ? rings[spec.ring].grp : core;
      var mesh = NODES[spec.kind](spec.s);
      var holder = new THREE.Group();
      holder.add(mesh);
      host.add(holder);
      orbiters.push({ holder: holder, mesh: mesh, spec: spec, angle: spec.phase });
    });

    /* — connection lines core ↔ nodes — */
    var linePos = new Float32Array(orbiters.length * 6);
    var lineGeo = new THREE.BufferGeometry();
    lineGeo.setAttribute('position', new THREE.BufferAttribute(linePos, 3));
    var lineMat = new THREE.LineBasicMaterial({ color: 0xff5a3e, transparent: true, opacity: .22, blending: THREE.AdditiveBlending, depthWrite: false });
    var lines = new THREE.LineSegments(lineGeo, lineMat);
    core.add(lines);

    /* — ambient particles — */
    var pCount = QUALITY === 'high' ? 420 : (QUALITY === 'medium' ? 220 : 110);
    var particles = createParticleField(pCount, { x: 19, y: 10, z: 7 }, null, 0.05);
    S.three.add(particles);

    /* — anchor placement (core follows the visual column) — */
    var anchorPos = new THREE.Vector3(1.9, 0, 0);
    var scrollP = 0, baseZ = 7;

    function computeAnchor() {
      if (!anchorEl || !heroEl) return;
      var hr = heroEl.getBoundingClientRect();
      var ar = anchorEl.getBoundingClientRect();
      if (hr.width < 2) return;
      var nx = ((ar.left + ar.width / 2 - hr.left) / hr.width) * 2 - 1;
      var ny = -(((ar.top + ar.height / 2 - hr.top) / hr.height) * 2 - 1);
      var v = new THREE.Vector3(nx, ny, 0.5).unproject(cam);
      var dir = v.sub(cam.position).normalize();
      var dist = -cam.position.z / dir.z;
      anchorPos.copy(cam.position).add(dir.multiplyScalar(dist));
      if (anchorPos.x < 0) anchorPos.x = 0.35 * anchorPos.x; // keep clear of text column
      core.position.copy(anchorPos);
    }

    S.resize = function () {
      var w = container.clientWidth || 1, h = container.clientHeight || 1;
      S.renderer.setSize(w, h, false);
      cam.aspect = w / h; cam.updateProjectionMatrix();
      computeAnchor();
    };

    S.update = function (dt, t) {
      /* scroll choreography — recede / rotate / scale down */
      var hh = heroEl ? heroEl.offsetHeight : 800;
      var target = Math.min(Math.max(window.scrollY / (hh * 0.92), 0), 1);
      scrollP += (target - scrollP) * 0.08;

      /* core motion */
      core.rotation.y += dt * 0.14;
      shell.rotation.y -= dt * 0.1;
      shell.rotation.x += dt * 0.05;
      coreMesh.material.emissiveIntensity = 0.5 + 0.22 * Math.sin(t * 1.5);
      coreGlow.material.opacity = 0.45 + 0.15 * Math.sin(t * 1.2);

      /* scroll-driven transforms */
      core.rotation.y += scrollP * 0.0009;
      var sc = 1 - scrollP * 0.2;
      core.scale.setScalar(sc);
      core.position.y = anchorPos.y - scrollP * 1.4;
      container.style.opacity = String(1 - scrollP * 0.55);

      /* rings */
      rings.forEach(function (r) { r.grp.rotation.z += dt * r.speed * 0.16; });

      /* orbiters + connection lines */
      var lp = lines.geometry.attributes.position.array;
      for (var i = 0; i < orbiters.length; i++) {
        var o = orbiters[i];
        o.angle += dt * o.spec.speed * (0.55 + scrollP * 0.35);
        var x = Math.cos(o.angle) * o.spec.r;
        var z = Math.sin(o.angle) * o.spec.r;
        var y = Math.sin(t * 0.8 + o.spec.phase) * 0.16;
        o.holder.position.set(x, y, z);
        o.mesh.rotation.y += dt * 0.7;
        o.mesh.rotation.x += dt * 0.3;
        if (o.mesh.userData.halo) o.mesh.userData.halo.rotation.z += dt * 0.8;
        o.holder.getWorldPosition(V1());
        core.worldToLocal(V1());
        lp[i * 6] = 0; lp[i * 6 + 1] = 0; lp[i * 6 + 2] = 0;
        lp[i * 6 + 3] = V1().x; lp[i * 6 + 4] = V1().y; lp[i * 6 + 5] = V1().z;
      }
      lines.geometry.attributes.position.needsUpdate = true;
      lineMat.opacity = 0.16 + 0.1 * Math.sin(t * 2.1);

      /* lighting drift */
      lights.brand.position.x = Math.cos(t * 0.4) * 2.2 + core.position.x;
      lights.brand.position.y = Math.sin(t * 0.3) * 1.4 + 0.8;
      lights.brand.position.z = 2.6;
      lights.rim.position.x = -4 + Math.sin(t * 0.22) * 1.2;

      /* particles drift + subtle mouse parallax */
      particles.rotation.y += dt * 0.011;
      particles.position.x = pointer.sx * 0.42;
      particles.position.y = -pointer.sy * 0.26;

      /* camera parallax + scroll dolly */
      cam.position.x += (pointer.sx * 0.55 - cam.position.x) * 0.045;
      cam.position.y += (-pointer.sy * 0.3 - cam.position.y) * 0.045;
      var tz = baseZ + scrollP * 2.6;
      cam.position.z += (tz - cam.position.z) * 0.06;
      cam.lookAt(0, 0, 0);
    };

    computeAnchor();
    S.resize();
    return S;
  }

  /* ══════════════════════════════════════════════════════════
     SCENE: ORB — network sphere (about visual / CTA)
  ═══════════════════════════════════════════════════════════ */
  var ORB_NODES = {
    ai: [0, 1, 0], cloud: [-1, 0.18, 0.28], web: [1, 0.18, 0.28],
    mobile: [-0.64, -0.74, 0.1], data: [0, -0.98, 0], software: [0.64, -0.74, 0.1]
  };

  function buildOrbScene(container) {
    var S = makeScene(container);
    var cam = S.camera;
    cam.fov = 45; cam.position.set(0, 0, 5.6);
    addLights(S.three, { ambient: .8, key: .5, brand: 1, rim: .5 });

    var withLabels = container.hasAttribute('data-orb-labels');
    var world = new THREE.Group(); S.three.add(world);
    var R = 1.78;

    /* core sphere */
    var core = new THREE.Mesh(
      new THREE.IcosahedronGeometry(0.62, 1),
      new THREE.MeshStandardMaterial({ color: 0x2a1210, roughness: .4, metalness: .2, emissive: C.brand, emissiveIntensity: .5, flatShading: true })
    );
    world.add(core);
    var shell = new THREE.Mesh(
      new THREE.IcosahedronGeometry(R, 1),
      new THREE.MeshBasicMaterial({ color: 0xff6a4a, wireframe: true, transparent: true, opacity: .12 })
    );
    world.add(shell);
    var glow = new THREE.Sprite(new THREE.SpriteMaterial({
      map: glowTexture('rgba(255,110,80,.45)', 'rgba(255,77,62,.1)'),
      transparent: true, opacity: .5, depthWrite: false, blending: THREE.AdditiveBlending
    }));
    glow.scale.set(4.2, 4.2, 1); world.add(glow);

    /* surface points */
    var pCount = QUALITY === 'high' ? 110 : (QUALITY === 'medium' ? 70 : 40);
    var geo = new THREE.BufferGeometry();
    var pos = new Float32Array(pCount * 3);
    for (var i = 0; i < pCount; i++) {
      var phi = Math.acos(1 - 2 * (i + 0.5) / pCount);
      var th = Math.PI * (1 + Math.sqrt(5)) * i;
      pos[i * 3] = R * Math.sin(phi) * Math.cos(th);
      pos[i * 3 + 1] = R * Math.cos(phi);
      pos[i * 3 + 2] = R * Math.sin(phi) * Math.sin(th);
    }
    geo.setAttribute('position', new THREE.BufferAttribute(pos, 3));
    world.add(new THREE.Points(geo, new THREE.PointsMaterial({
      color: 0xdfe8ff, size: 0.028, map: softCircleTexture(), transparent: true,
      opacity: .7, depthWrite: false, blending: THREE.AdditiveBlending
    })));

    /* labeled tech nodes + connection lines + travelling pulses */
    var labels = [], nodes = [], lineGeo, pulses = [];
    if (withLabels) {
      var labelEls = container.parentElement ? container.parentElement.querySelectorAll('[data-node]') : [];
      var linePos = new Float32Array(Object.keys(ORB_NODES).length * 6);
      lineGeo = new THREE.BufferGeometry();
      lineGeo.setAttribute('position', new THREE.BufferAttribute(linePos, 3));
      world.add(new THREE.LineSegments(lineGeo, new THREE.LineBasicMaterial({
        color: 0xff5a3e, transparent: true, opacity: .3, blending: THREE.AdditiveBlending, depthWrite: false
      })));

      var idx = 0;
      Object.keys(ORB_NODES).forEach(function (key) {
        var d = ORB_NODES[key];
        var node = createCubeNode(0.85, key === 'ai' ? C.purple : (key === 'data' ? C.cyan : C.brand));
        node.position.set(d[0] * R * 0.99, d[1] * R * 0.99, d[2] * R * 0.99);
        world.add(node);
        nodes.push(node);
        var el = null;
        for (var le = 0; le < labelEls.length; le++) {
          if (labelEls[le].getAttribute('data-node') === key) { el = labelEls[le]; break; }
        }
        labels.push({ key: key, el: el, node: node });

        var pulse = new THREE.Sprite(new THREE.SpriteMaterial({
          map: glowTexture('rgba(255,190,120,.95)', 'rgba(255,77,62,.25)'),
          transparent: true, opacity: .95, depthWrite: false, blending: THREE.AdditiveBlending
        }));
        pulse.scale.set(.14, .14, 1);
        world.add(pulse);
        pulses.push({ sprite: pulse, from: new THREE.Vector3(0, 0, 0), to: node.position.clone(), t: Math.random(), speed: .3 + Math.random() * .3 });

        var a = linePos;
        a[idx * 6] = 0; a[idx * 6 + 1] = 0; a[idx * 6 + 2] = 0;
        a[idx * 6 + 3] = node.position.x; a[idx * 6 + 4] = node.position.y; a[idx * 6 + 5] = node.position.z;
        idx++;
      });
      lineGeo.attributes.position.needsUpdate = true;
    }

    /* ambient dust */
    var dust = createParticleField(QUALITY === 'low' ? 60 : 140, { x: 8.5, y: 8.5, z: 4 }, null, 0.045);
    S.three.add(dust);

    var rotY = 0;

    S.update = function (dt, t) {
      rotY += dt * (withLabels ? 0.16 : 0.2);
      world.rotation.y = rotY + pointer.sx * 0.22;
      world.rotation.x = Math.sin(t * 0.14) * 0.06 - pointer.sy * 0.12;
      core.rotation.y -= dt * 0.25;
      core.material.emissiveIntensity = 0.42 + 0.2 * Math.sin(t * 1.4);
      glow.material.opacity = 0.4 + 0.14 * Math.sin(t * 1.1);
      dust.rotation.y -= dt * 0.02;
      nodes.forEach(function (n, i2) { n.rotation.y += dt * 0.6; n.rotation.x += dt * 0.25; });

      pulses.forEach(function (p) {
        p.t += dt * p.speed;
        if (p.t > 1) p.t = 0;
        p.sprite.position.lerpVectors(p.from, p.to, p.t);
        p.sprite.material.opacity = 0.25 + 0.75 * Math.sin(p.t * Math.PI);
      });

      cam.position.x += (pointer.sx * 0.4 - cam.position.x) * 0.04;
      cam.position.y += (-pointer.sy * 0.22 - cam.position.y) * 0.04;
      cam.lookAt(0, 0, 0);

      /* project DOM labels */
      if (withLabels) {
        var w = container.clientWidth, h = container.clientHeight;
        for (var li = 0; li < labels.length; li++) {
          var L = labels[li];
          if (!L.el) continue;
          V1().copy(L.node.position).applyMatrix4(world.matrixWorld).project(cam);
          if (V1().z > 1) { L.el.style.opacity = '0'; continue; }
          var x = (V1().x * 0.5 + 0.5) * w;
          var y = (-V1().y * 0.5 + 0.5) * h;
          var behind = L.node.position.clone().applyAxisAngle(new THREE.Vector3(0, 1, 0), world.rotation.y).z < 0;
          L.el.style.transform = 'translate(-50%,-50%) translate(' + x.toFixed(1) + 'px,' + y.toFixed(1) + 'px)';
          L.el.style.opacity = behind ? '.45' : '1';
          L.el.classList.toggle('lbl-behind', behind);
        }
      }
    };

    S.resize();
    return S;
  }

  /* ══════════════════════════════════════════════════════════
     SCENE: GLOBE — abstract connected network (contact)
  ═══════════════════════════════════════════════════════════ */
  function buildGlobeScene(container) {
    var S = makeScene(container);
    var cam = S.camera;
    cam.fov = 45; cam.position.set(0, 0, 5.4);
    addLights(S.three, { ambient: .8, key: .4, brand: .8, rim: .5 });

    var world = new THREE.Group(); S.three.add(world);
    var R = 1.9;

    var globe = new THREE.Mesh(
      new THREE.SphereGeometry(R * 0.99, 28, 20),
      new THREE.MeshBasicMaterial({ color: 0x0a1122, transparent: true, opacity: .55 })
    );
    world.add(globe);

    var wire = new THREE.Mesh(
      new THREE.IcosahedronGeometry(R, 1),
      new THREE.MeshBasicMaterial({ color: 0x37d3e6, wireframe: true, transparent: true, opacity: .1 })
    );
    world.add(wire);

    var pCount = QUALITY === 'high' ? 130 : (QUALITY === 'medium' ? 80 : 45);
    var geo = new THREE.BufferGeometry();
    var pos = new Float32Array(pCount * 3);
    var pts = [];
    for (var i = 0; i < pCount; i++) {
      var phi = Math.acos(1 - 2 * (i + 0.5) / pCount);
      var th = Math.PI * (1 + Math.sqrt(5)) * i;
      var p = new THREE.Vector3(R * Math.sin(phi) * Math.cos(th), R * Math.cos(phi), R * Math.sin(phi) * Math.sin(th));
      pts.push(p);
      pos[i * 3] = p.x; pos[i * 3 + 1] = p.y; pos[i * 3 + 2] = p.z;
    }
    geo.setAttribute('position', new THREE.BufferAttribute(pos, 3));
    world.add(new THREE.Points(geo, new THREE.PointsMaterial({
      color: 0xffd9c4, size: 0.03, map: softCircleTexture(), transparent: true,
      opacity: .8, depthWrite: false, blending: THREE.AdditiveBlending
    })));

    /* animated arcs between random points */
    var arcCount = QUALITY === 'high' ? 9 : (QUALITY === 'medium' ? 6 : 4);
    var arcs = [];
    for (var a = 0; a < arcCount; a++) {
      var p1 = pts[Math.floor(Math.random() * pts.length)];
      var p2 = pts[Math.floor(Math.random() * pts.length)];
      if (p1.distanceTo(p2) < R * 0.9) { p2 = pts[(pts.indexOf(p1) + 17) % pts.length]; }
      var mid = p1.clone().add(p2).multiplyScalar(0.5).normalize().multiplyScalar(R * (1.25 + Math.random() * 0.3));
      var curve = new THREE.QuadraticBezierCurve3(p1, mid, p2);
      var tube = new THREE.Mesh(
        new THREE.TubeGeometry(curve, 36, 0.008, 5, false),
        new THREE.MeshBasicMaterial({
          color: a % 3 === 0 ? C.cyan : (a % 3 === 1 ? C.brand2 : C.amber),
          transparent: true, opacity: .3, blending: THREE.AdditiveBlending, depthWrite: false
        })
      );
      world.add(tube);
      var spark = new THREE.Sprite(new THREE.SpriteMaterial({
        map: glowTexture('rgba(255,220,170,.95)', 'rgba(255,150,90,.3)'),
        transparent: true, opacity: .9, depthWrite: false, blending: THREE.AdditiveBlending
      }));
      spark.scale.set(.12, .12, 1);
      world.add(spark);
      arcs.push({ curve: curve, tube: tube, spark: spark, t: Math.random(), speed: .12 + Math.random() * .12, phase: Math.random() * 6 });
    }

    var halo = new THREE.Sprite(new THREE.SpriteMaterial({
      map: glowTexture('rgba(255,110,80,.3)', 'rgba(255,77,62,.08)'),
      transparent: true, opacity: .4, depthWrite: false, blending: THREE.AdditiveBlending
    }));
    halo.scale.set(6.5, 6.5, 1); world.add(halo);

    S.update = function (dt, t) {
      world.rotation.y += dt * 0.1;
      world.rotation.x = Math.sin(t * 0.1) * 0.08 - pointer.sy * 0.08;
      wire.rotation.y -= dt * 0.04;
      halo.material.opacity = 0.3 + 0.1 * Math.sin(t * 0.9);

      arcs.forEach(function (arc) {
        arc.t += dt * arc.speed;
        if (arc.t > 1) arc.t = 0;
        arc.curve.getPoint(arc.t, V1());
        arc.spark.position.copy(V1());
        arc.spark.material.opacity = 0.3 + 0.7 * Math.sin(arc.t * Math.PI);
        arc.tube.material.opacity = 0.16 + 0.14 * Math.sin(t * 0.7 + arc.phase);
      });

      cam.position.x += (pointer.sx * 0.35 - cam.position.x) * 0.04;
      cam.position.y += (-pointer.sy * 0.2 - cam.position.y) * 0.04;
      cam.lookAt(0, 0, 0);
    };

    S.resize();
    return S;
  }

  /* ══════════════════════════════════════════════════════════
     SCENE: RINGS — page hero environment
  ═══════════════════════════════════════════════════════════ */
  function buildRingsScene(container) {
    var S = makeScene(container);
    var cam = S.camera;
    cam.fov = 45; cam.position.set(0, 0, 6);

    var world = new THREE.Group(); S.three.add(world);

    var defs = [
      { r: 2.1, color: C.brand2, op: .34, tilt: [1.25, 0, .35], speed: .12 },
      { r: 2.6, color: C.cyan, op: .2, tilt: [1.05, .5, -.25], speed: -.09 },
      { r: 1.65, color: C.amber, op: .26, tilt: [1.45, -.4, .2], speed: .16 }
    ];
    var rings = [];
    defs.forEach(function (d) {
      var grp = new THREE.Group(); grp.rotation.set(d.tilt[0], d.tilt[1], d.tilt[2]);
      grp.add(new THREE.Mesh(
        new THREE.TorusGeometry(d.r, 0.008, 8, 110),
        new THREE.MeshBasicMaterial({ color: d.color, transparent: true, opacity: d.op })
      ));
      world.add(grp); rings.push({ grp: grp, speed: d.speed });
    });

    /* few floating nodes */
    var nodeKinds = ['ai', 'cube', 'sphere'];
    var floats = [];
    var n = QUALITY === 'low' ? 2 : 3;
    for (var i = 0; i < n; i++) {
      var node = NODES[nodeKinds[i % nodeKinds.length]](0.9);
      node.position.set(Math.sin(i * 2.1) * 2.3, Math.cos(i * 1.7) * 1.1, Math.sin(i * 1.3) * .8);
      world.add(node); floats.push(node);
    }

    var dust = createParticleField(QUALITY === 'low' ? 60 : 150, { x: 11, y: 6, z: 4 }, null, 0.04);
    S.three.add(dust);

    var core = new THREE.Mesh(
      new THREE.IcosahedronGeometry(0.5, 1),
      new THREE.MeshStandardMaterial({ color: 0x2a1210, roughness: .4, emissive: C.brand, emissiveIntensity: .4, flatShading: true })
    );
    world.add(core);

    S.update = function (dt, t) {
      world.rotation.y += dt * 0.05;
      world.rotation.x = -pointer.sy * 0.06;
      rings.forEach(function (r) { r.grp.rotation.z += dt * r.speed * 0.2; });
      floats.forEach(function (f, i2) {
        f.rotation.y += dt * 0.5;
        f.position.y += Math.sin(t * 0.8 + i2 * 2) * 0.0016;
      });
      core.rotation.y += dt * 0.3;
      dust.rotation.y += dt * 0.008;
      cam.position.x += (pointer.sx * 0.3 - cam.position.x) * 0.04;
      cam.lookAt(0, 0, 0);
    };

    S.resize();
    return S;
  }

  /* ══════════════════════════════════════════════════════════
     SCENE: FIELD — floating project screens (portfolio hero)
  ═══════════════════════════════════════════════════════════ */
  function buildFieldScene(container) {
    var S = makeScene(container);
    var cam = S.camera;
    cam.fov = 46; cam.position.set(0, 0, 6.2);

    var world = new THREE.Group(); S.three.add(world);

    var imgsAttr = container.getAttribute('data-images') || '';
    var urls = imgsAttr.split(',').map(function (s) { return s.trim(); }).filter(Boolean).slice(0, QUALITY === 'low' ? 3 : 5);

    var layouts = [
      { p: [-2.6, 0.42, -1.1], ry: 0.3 }, { p: [-1.15, -0.5, 0.2], ry: 0.14 },
      { p: [1.2, 0.5, -0.4], ry: -0.18 }, { p: [2.65, -0.35, -1.4], ry: -0.32 },
      { p: [0.05, -1.15, -2.2], ry: -0.05 }
    ];
    var planes = [];
    var loader = new THREE.TextureLoader();
    urls.forEach(function (url, i) {
      var L = layouts[i % layouts.length];
      var mat = new THREE.MeshBasicMaterial({ color: 0x101a30, transparent: true, opacity: .95 });
      var plane = new THREE.Mesh(new THREE.PlaneGeometry(1.72, 1.44), mat);
      plane.position.set(L.p[0], L.p[1], L.p[2]);
      plane.rotation.y = L.ry;
      var frame = new THREE.LineSegments(
        new THREE.EdgesGeometry(plane.geometry),
        new THREE.LineBasicMaterial({ color: 0xff6a4a, transparent: true, opacity: .55 })
      );
      plane.add(frame);
      world.add(plane); planes.push(plane);

      loader.load(url, function (tex) {
        tex.userData = tex.userData || {};
        plane.material.map = tex;
        plane.material.color.set(0xffffff);
        plane.material.needsUpdate = true;
      }, undefined, function () { /* keep dark surface */ });
    });

    var dust = createParticleField(QUALITY === 'low' ? 70 : 170, { x: 10, y: 6, z: 5 }, null, 0.045);
    S.three.add(dust);

    var glowC = new THREE.Sprite(new THREE.SpriteMaterial({
      map: glowTexture('rgba(255,110,80,.22)', 'rgba(255,77,62,.05)'),
      transparent: true, opacity: .5, depthWrite: false, blending: THREE.AdditiveBlending
    }));
    glowC.scale.set(7, 7, 1); glowC.position.z = -3;
    S.three.add(glowC);

    S.update = function (dt, t) {
      world.rotation.y += ((pointer.sx * 0.14) - world.rotation.y) * 0.03;
      world.rotation.x += ((pointer.sy * 0.07) - world.rotation.x) * 0.03;
      planes.forEach(function (pl, i2) {
        pl.position.y = layouts[i2 % layouts.length].p[1] + Math.sin(t * 0.7 + i2 * 1.9) * 0.09;
        pl.rotation.z = Math.sin(t * 0.5 + i2) * 0.012;
      });
      dust.rotation.y += dt * 0.012;
      cam.position.x += (pointer.sx * 0.3 - cam.position.x) * 0.035;
      cam.position.y += (-pointer.sy * 0.18 - cam.position.y) * 0.035;
      cam.lookAt(0, 0, 0);
    };

    S.resize();
    return S;
  }

  /* ══════════════════════════════════════════════════════════
     SCENE: ATMOSPHERE — site-wide particle dust
  ═══════════════════════════════════════════════════════════ */
  function buildAtmosphere(container) {
    if (QUALITY === 'low') { container.style.display = 'none'; return null; }
    var S = makeScene(container);
    var cam = S.camera;
    cam.fov = 60; cam.position.set(0, 0, 10);

    var count = QUALITY === 'high' ? 220 : 120;
    var spread = { x: 26, y: 14, z: 6 };
    var dust = createParticleField(count, spread, null, 0.042);
    dust.material.opacity = 0.5;
    S.three.add(dust);

    S.update = function (dt) {
      dust.rotation.y += dt * 0.006;
      dust.position.x = pointer.sx * 0.5;
      dust.position.y = -pointer.sy * 0.3;
    };

    S.resize();
    return S;
  }

  /* ── Builder registry ─────────────────────────────────────── */
  var builders = {
    hero: buildHeroScene,
    orb: buildOrbScene,
    globe: buildGlobeScene,
    rings: buildRingsScene,
    field: buildFieldScene,
    atmosphere: buildAtmosphere
  };

  /* ── Boot ─────────────────────────────────────────────────── */
  var booted = false;

  function boot() {
    if (booted) return;
    booted = true;

    var containers = document.querySelectorAll('[data-scene]');

    /* atmosphere works even without WebGL-heavy scenes */
    var needsThree = false;
    containers.forEach === undefined; /* guard old browsers below */
    for (var i = 0; i < containers.length; i++) {
      var type = containers[i].getAttribute('data-scene');
      if (type && builders[type]) needsThree = true;
    }

    if (!needsThree) return;

    if (!webglSupported()) {
      console.warn('Softex3D: WebGL unavailable — animated scenes disabled, CSS visual fallback active.');
      return;
    }

    loadThree(function () {
      var built = 0;
      for (var i = 0; i < containers.length; i++) {
        var el = containers[i];
        var type = el.getAttribute('data-scene');
        var builder = builders[type];
        if (!builder) continue;
        try {
          var scene = builder(el);
          if (!scene) { built++; continue; }
          scenes.push(scene);
          watchVisibility(scene);
          scene.resize();
          if (REDUCED) { scene.update(0, 0); scene.render(); }
          else { scene.active = true; }
          el.classList.add('scene-on');
          built++;
        } catch (err) {
          console.warn('Softex3D: scene "' + type + '" failed — ' + err.message + '. CSS fallback active.');
        }
      }
      if (built && !REDUCED) ensureLoop();
    });
  }

  function loadThree(cb) {
    if (window.THREE) return cb();
    var s = document.createElement('script');
    s.src = 'js/vendor/three.min.js';
    s.async = false;
    s.onload = cb;
    s.onerror = function () {
      console.warn('Softex3D: Three.js could not be loaded — 3D scenes disabled, CSS fallback active.');
    };
    document.head.appendChild(s);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot);
  } else {
    boot();
  }

  /* ── Public API ───────────────────────────────────────────── */
  return {
    pointer: pointer,
    quality: QUALITY,
    reduced: REDUCED,
    touch: IS_TOUCH,
    scenes: scenes
  };
})();
