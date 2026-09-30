<?php
/**
 * includes/footer.php — Softex Technologies v5
 * Client logos strip above footer · No second phone · No privacy line
 */
?>
</main>

<!-- ══════════════════════════════════════════
     This file is the single home for all shared assets:
     the AI OS design system CSS, the Three.js import
     map, the shared 3D engine and the shared UI script.
══════════════════════════════════════════ -->
<style>
/* ════════════════════════════════════════════════════════════════
   SOFTEX TECHNOLOGIES — AI OS DESIGN SYSTEM
   Fonts: Space Grotesk (headings) · Inter (body) · JetBrains Mono (HUD)
   Palette: logo gradient #F20D5A → #F44A6A → #F78B3D → #FBBF24
   Counterweight: deep cyan #06b6d4 · sparing purple #8b5cf6
════════════════════════════════════════════════════════════════ */

/* ── Design tokens ─────────────────────────────────────────── */
:root{
  /* logo gradient palette */
  --l1:#F20D5A;   /* deep magenta */
  --l2:#F44A6A;   /* coral pink   */
  --l3:#F78B3D;   /* orange       */
  --l4:#FBBF24;   /* golden yellow*/
  --logo-g:linear-gradient(135deg,#F20D5A,#F44A6A,#F78B3D,#FBBF24);

  /* legacy aliases (kept for compat) */
  --or:#F78B3D; --or-l:#F44A6A; --or-d:#d9650a;
  --or-s:rgba(247,139,61,.09); --or-g:rgba(247,139,61,.25);
  --pink:#F20D5A; --cyan:#06b6d4; --cy2:#22d3ee; --pu:#8b5cf6;

  --bg0:#020308; --bg1:#05080f; --bg2:#080d1a; --bg3:#0d1525;
  --bg4:#111e35; --bg5:#162340;

  --bd:rgba(242,13,90,.14);
  --bd2:rgba(255,255,255,.05);

  --t1:#f1f5f9; --t2:#94a3b8; --t3:#475569;

  --fh:'Space Grotesk',sans-serif;                 /* headings   */
  --fb:'Inter',system-ui,-apple-system,sans-serif; /* body       */
  --fm:'JetBrains Mono',monospace;                 /* code / HUD */

  --glass:linear-gradient(160deg,rgba(255,255,255,.06),rgba(255,255,255,.015));
  --glass-bd:rgba(255,255,255,.10);

  --radius:22px;
  --ease:cubic-bezier(.22,.85,.3,1);
  --mw:1220px; --px:clamp(1rem,4vw,2rem);
  --sp:clamp(4.5rem,9vw,7rem);
  --hh:74px;
  --ta:.18s ease; --tb:.32s cubic-bezier(.4,0,.2,1);
}

/* ── Reset & base ──────────────────────────────────────────── */
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html{scroll-behavior:smooth;-webkit-text-size-adjust:100%}
body{
  font-family:var(--fb);background:var(--bg0);color:var(--t1);
  font-size:16px;line-height:1.7;overflow-x:hidden;
  -webkit-font-smoothing:antialiased;
}
img{max-width:100%;display:block}
a{color:inherit;text-decoration:none}
ul{list-style:none}
button,input,textarea,select{font:inherit}
button{cursor:pointer;border:none;background:none}
::selection{background:rgba(242,13,90,.38);color:#fff}
::-webkit-scrollbar{width:10px;height:10px}
::-webkit-scrollbar-track{background:var(--bg0)}
::-webkit-scrollbar-thumb{background:linear-gradient(#F20D5A,#F78B3D,#FBBF24);border-radius:10px;border:3px solid var(--bg0)}
:focus-visible{outline:2px solid rgba(6,182,212,.7);outline-offset:2px}

/* ── Ambient background system ─────────────────────────────── */
body::before{
  content:'';position:fixed;inset:0;z-index:0;pointer-events:none;
  background:
    radial-gradient(900px 600px at 12% -5%,rgba(242,13,90,.15),transparent 62%),
    radial-gradient(800px 600px at 92% 8%,rgba(251,191,36,.07),transparent 60%),
    radial-gradient(700px 700px at 50% 108%,rgba(6,182,212,.07),transparent 62%);
}
body::after{
  content:'';position:fixed;inset:0;z-index:0;pointer-events:none;opacity:.5;
  background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.035'/%3E%3C/svg%3E");
}
main{position:relative;z-index:1}

/* ── Layout primitives ─────────────────────────────────────── */
.wrap{max-width:var(--mw);margin:0 auto;padding:0 var(--px);position:relative;z-index:2}
.section{padding:var(--sp) 0;position:relative;overflow:hidden}
.section>.wrap{position:relative;z-index:2}
.center{text-align:center;max-width:820px;margin:0 auto}
.lead{color:var(--t2);font-size:1.06rem}
.lead.wide{max-width:680px;margin:0 auto}
.gradient-text{
  background:var(--logo-g);
  -webkit-background-clip:text;background-clip:text;
  color:transparent;-webkit-text-fill-color:transparent;
}
.h1{font-family:var(--fh);font-size:clamp(2.6rem,5.4vw,4.4rem);font-weight:700;line-height:1.05;letter-spacing:-.03em;color:var(--t1)}
.h2{font-family:var(--fh);font-size:clamp(1.9rem,3.6vw,2.85rem);font-weight:700;line-height:1.16;letter-spacing:-.02em;color:var(--t1)}
.h3{font-family:var(--fh);font-size:clamp(1.35rem,2.4vw,1.85rem);font-weight:600;line-height:1.22;letter-spacing:-.015em;color:var(--t1)}

/* ── Section eyebrow pill ──────────────────────────────────── */
.eyebrow{
  display:inline-flex;align-items:center;gap:9px;
  font-family:var(--fh);
  font-size:.78rem;font-weight:600;letter-spacing:.16em;text-transform:uppercase;
  color:var(--l3);
  background:rgba(242,13,90,.08);
  border:1px solid rgba(242,13,90,.24);
  padding:8px 16px;border-radius:999px;margin-bottom:1.4rem;
  backdrop-filter:blur(8px);
  position:relative;overflow:hidden;
}
.eyebrow::before{
  content:'';position:absolute;top:0;left:-100%;width:60%;height:100%;
  background:linear-gradient(90deg,transparent,rgba(242,13,90,.22),transparent);
  animation:shimmer 3.2s infinite;
}
@keyframes shimmer{to{left:200%}}
.eyebrow i{color:var(--cyan)}

/* ════════════════════════════════════════════════════════════
   3D FX HOSTS
════════════════════════════════════════════════════════════ */
.fx-host{
  position:absolute;inset:0;z-index:0;pointer-events:none;
  opacity:.9;overflow:hidden;
}
.fx-host canvas{display:block;width:100%!important;height:100%!important}
.fx-host.fx-right{
  left:auto;right:-8%;width:62%;inset-block:0;
  -webkit-mask-image:linear-gradient(90deg,transparent,#000 30%);
  mask-image:linear-gradient(90deg,transparent,#000 30%);
}
.fx-host.hero-fx{
  opacity:.95;
  -webkit-mask-image:radial-gradient(ellipse 90% 80% at 62% 48%,#000 30%,transparent 78%);
  mask-image:radial-gradient(ellipse 90% 80% at 62% 48%,#000 30%,transparent 78%);
}

/* ── Hero / section backdrops ──────────────────────────────── */
.hero-grid-bg{
  position:absolute;inset:0;z-index:0;pointer-events:none;
  background-image:
    linear-gradient(rgba(255,255,255,.03) 1px,transparent 1px),
    linear-gradient(90deg,rgba(255,255,255,.03) 1px,transparent 1px);
  background-size:62px 62px;
  -webkit-mask-image:radial-gradient(ellipse 78% 68% at 50% 42%,#000 20%,transparent 80%);
  mask-image:radial-gradient(ellipse 78% 68% at 50% 42%,#000 20%,transparent 80%);
}
.dots-bg{
  position:absolute;inset:0;pointer-events:none;z-index:0;
  background-image:radial-gradient(circle,rgba(242,13,90,.14) 1px,transparent 1px);
  background-size:30px 30px;
  -webkit-mask-image:radial-gradient(ellipse 80% 60% at 50% 50%,#000 0%,transparent 100%);
  mask-image:radial-gradient(ellipse 80% 60% at 50% 50%,#000 0%,transparent 100%);
}
.orb{position:absolute;border-radius:50%;filter:blur(110px);pointer-events:none;z-index:0}
.orb-or{background:radial-gradient(circle,rgba(242,13,90,.5),transparent 68%)}
.orb-cy{background:radial-gradient(circle,rgba(6,182,212,.4),transparent 68%)}
.orb-pu{background:radial-gradient(circle,rgba(251,191,36,.3),transparent 68%)}
.orb-pk{background:radial-gradient(circle,rgba(236,72,153,.32),transparent 68%)}

/* ── HUD overlay ───────────────────────────────────────────── */
.hud{position:absolute;inset:0;z-index:3;pointer-events:none}
.hud-corner{position:absolute;width:34px;height:34px;border:1.5px solid rgba(242,13,90,.45)}
.hud-corner.tl{top:26px;left:26px;border-right:0;border-bottom:0;border-radius:8px 0 0 0}
.hud-corner.tr{top:26px;right:26px;border-left:0;border-bottom:0;border-radius:0 8px 0 0}
.hud-corner.bl{bottom:26px;left:26px;border-right:0;border-top:0;border-radius:0 0 0 8px}
.hud-corner.br{bottom:26px;right:26px;border-left:0;border-top:0;border-radius:0 0 8px 0}
.hud-scan{
  position:absolute;left:0;right:0;height:140px;
  background:linear-gradient(180deg,transparent,rgba(242,13,90,.07),transparent);
  animation:scan 7s linear infinite;
}
@keyframes scan{0%{top:-140px}100%{top:100%}}
.hud-tag{
  position:absolute;bottom:34px;left:50%;transform:translateX(-50%);
  font-family:var(--fm);font-size:.66rem;letter-spacing:.28em;
  color:rgba(242,13,90,.55);text-transform:uppercase;white-space:nowrap;
}

/* ════════════════════════════════════════════════════════════
   AI ENTITY FRAME — live 3D replaces static imagery
════════════════════════════════════════════════════════════ */
.split-visual{position:relative}
.ai-entity-frame{
  position:relative;width:100%;aspect-ratio:4/3;
  border-radius:24px;overflow:hidden;
  border:1px solid var(--glass-bd);
  background:
    radial-gradient(ellipse 70% 70% at 50% 50%,rgba(242,13,90,.10),transparent 70%),
    linear-gradient(160deg,rgba(8,13,26,.9),rgba(5,8,15,.95));
  box-shadow:
    0 40px 80px -40px rgba(0,0,0,.95),
    0 0 0 1px rgba(242,13,90,.06) inset,
    0 0 60px rgba(242,13,90,.06) inset;
}
.ai-entity-frame::before{
  content:'';position:absolute;inset:0;z-index:1;pointer-events:none;
  background:linear-gradient(140deg,rgba(242,13,90,.10),transparent 42%,rgba(251,191,36,.08));
  mix-blend-mode:screen;
}
.ai-entity-frame::after{
  content:'';position:absolute;inset:0;z-index:1;pointer-events:none;
  background-image:
    linear-gradient(rgba(255,255,255,.028) 1px,transparent 1px),
    linear-gradient(90deg,rgba(255,255,255,.028) 1px,transparent 1px);
  background-size:38px 38px;
  -webkit-mask-image:radial-gradient(ellipse 90% 90% at 50% 50%,#000 40%,transparent 90%);
  mask-image:radial-gradient(ellipse 90% 90% at 50% 50%,#000 40%,transparent 90%);
}
.ai-entity-canvas{position:absolute;inset:0;z-index:0}
.ai-entity-canvas canvas{display:block;width:100%!important;height:100%!important}
.ai-entity-frame .corner{
  position:absolute;width:26px;height:26px;z-index:2;pointer-events:none;
  border:1.5px solid rgba(242,13,90,.55);
}
.ai-entity-frame .corner.tl{top:14px;left:14px;border-right:0;border-bottom:0;border-radius:8px 0 0 0}
.ai-entity-frame .corner.tr{top:14px;right:14px;border-left:0;border-bottom:0;border-radius:0 8px 0 0}
.ai-entity-frame .corner.bl{bottom:14px;left:14px;border-right:0;border-top:0;border-radius:0 0 0 8px}
.ai-entity-frame .corner.br{bottom:14px;right:14px;border-left:0;border-top:0;border-radius:0 0 8px 0}
.ai-entity-label{
  position:absolute;bottom:18px;left:50%;transform:translateX(-50%);z-index:3;
  display:inline-flex;align-items:center;gap:8px;
  padding:7px 14px;border-radius:999px;
  background:rgba(2,3,8,.72);border:1px solid var(--glass-bd);
  backdrop-filter:blur(10px);
  font-family:var(--fm);font-size:.64rem;letter-spacing:.24em;text-transform:uppercase;
  color:#c3cbdb;white-space:nowrap;
}
.ai-entity-label .dot{
  width:6px;height:6px;border-radius:50%;background:var(--l1);
  box-shadow:0 0 10px rgba(242,13,90,.9);
  animation:aiPulse 1.6s ease-in-out infinite;
}
@keyframes aiPulse{0%,100%{opacity:1;transform:scale(1)}50%{opacity:.4;transform:scale(.7)}}
.ai-entity-top{
  position:absolute;top:18px;left:50%;transform:translateX(-50%);z-index:3;
  font-family:var(--fm);font-size:.6rem;letter-spacing:.3em;text-transform:uppercase;
  color:rgba(242,13,90,.75);white-space:nowrap;
}

/* ── Framed imagery (kept photos: services, portfolio, team) ── */
.img-frame{
  position:relative;border-radius:24px;overflow:hidden;
  border:1px solid var(--glass-bd);
  background:var(--glass);
  box-shadow:0 34px 80px -34px rgba(0,0,0,.95),inset 0 1px 0 rgba(255,255,255,.08);
}
.img-frame img{width:100%;aspect-ratio:4/3;object-fit:cover;filter:saturate(.9);transition:transform .8s var(--ease)}
.split-visual:hover .img-frame img{transform:scale(1.05)}
.img-frame::after{
  content:'';position:absolute;inset:0;pointer-events:none;
  background:linear-gradient(160deg,rgba(242,13,90,.13),transparent 42%,rgba(6,182,212,.07));
  mix-blend-mode:screen;
}
.img-badge{
  position:absolute;right:-22px;bottom:-22px;z-index:4;
  display:flex;align-items:center;gap:14px;
  padding:18px 24px;border-radius:18px;
  background:linear-gradient(150deg,rgba(242,13,90,.18),rgba(251,191,36,.14));
  border:1px solid var(--glass-bd);
  backdrop-filter:blur(18px);
  box-shadow:0 26px 54px -24px rgba(0,0,0,.95);
}
.img-badge .num{
  font-family:var(--fh);font-size:2.1rem;font-weight:700;line-height:1;
  background:var(--logo-g);-webkit-background-clip:text;background-clip:text;
  color:transparent;-webkit-text-fill-color:transparent;
}
.img-badge .lbl{font-size:.78rem;color:var(--t2);line-height:1.35}

/* ════════════════════════════════════════════════════════════
   BUTTONS
════════════════════════════════════════════════════════════ */
.btn{
  display:inline-flex;align-items:center;justify-content:center;gap:10px;
  padding:13px 26px;border-radius:999px;
  font-family:var(--fh);font-weight:600;font-size:.95rem;
  border:1px solid transparent;cursor:pointer;
  transition:transform .35s var(--ease),box-shadow .35s var(--ease),background .3s,border-color .3s,color .3s;
  position:relative;overflow:hidden;white-space:nowrap;
}
.btn i{font-size:.85em}
.btn-lg{padding:16px 32px;font-size:1rem}
.btn-sm{padding:10px 20px;font-size:.86rem}
.btn-block{width:100%;display:flex}
.btn-primary{
  background:linear-gradient(135deg,#F20D5A,#F78B3D);
  color:#160400;
  box-shadow:0 12px 34px -12px rgba(242,13,90,.75);
}
.btn-primary:hover{transform:translateY(-3px);box-shadow:0 20px 44px -12px rgba(242,13,90,.95)}
.btn-ghost{
  background:rgba(255,255,255,.04);color:var(--t1);
  border-color:var(--glass-bd);backdrop-filter:blur(10px);
}
.btn-ghost:hover{
  transform:translateY(-3px);
  border-color:rgba(6,182,212,.55);
  background:rgba(6,182,212,.08);
  box-shadow:0 16px 36px -16px rgba(6,182,212,.55);
}
.btn-glow::after{
  content:'';position:absolute;inset:0;border-radius:inherit;
  background:linear-gradient(115deg,transparent 20%,rgba(255,255,255,.5) 50%,transparent 80%);
  transform:translateX(-130%);
  animation:sheen 3.6s ease-in-out infinite;
}
@keyframes sheen{0%,62%{transform:translateX(-130%)}100%{transform:translateX(130%)}}

/* ════════════════════════════════════════════════════════════
   HEADER — sticky glass · gradient brand mark · pill nav
════════════════════════════════════════════════════════════ */
.site-header{
  position:sticky;top:0;z-index:100;
  background:rgba(2,3,8,.55);
  backdrop-filter:blur(18px) saturate(160%);
  border-bottom:1px solid var(--bd2);
  transition:background .35s,box-shadow .35s;
}
.site-header.scrolled{
  background:rgba(2,3,8,.85);
  box-shadow:0 18px 44px -26px rgba(0,0,0,.95);
}
.header-inner{display:flex;align-items:center;justify-content:space-between;gap:24px;height:var(--hh)}
.brand{display:flex;align-items:center;gap:12px;flex-shrink:0}
.brand-logo{
  display:block;width:46px;height:46px;object-fit:cover;
  border-radius:12px;border:1px solid rgba(255,255,255,.14);
  box-shadow:0 10px 28px -12px rgba(242,13,90,.55);
  transition:transform .35s var(--ease),box-shadow .35s var(--ease);
}
.brand:hover .brand-logo{
  transform:translateY(-2px) scale(1.04);
  box-shadow:0 14px 32px -12px rgba(242,13,90,.75);
}
.site-footer .brand-logo{width:42px;height:42px}
.brand-text{font-family:var(--fh);font-weight:700;font-size:1.12rem;letter-spacing:-.01em;line-height:1;color:var(--t1)}
.brand-text em{
  display:block;font-style:normal;
  font-family:var(--fm);font-size:.56rem;letter-spacing:.34em;
  text-transform:uppercase;color:var(--t2);margin-top:5px;
}
.main-nav{
  display:flex;gap:.25rem;
  background:rgba(255,255,255,.035);border:1px solid var(--bd2);
  padding:.3rem;border-radius:999px;backdrop-filter:blur(10px);
}
.main-nav a{
  padding:.45rem .95rem;border-radius:999px;
  font-size:.9rem;font-weight:500;color:var(--t2);
  transition:color .25s,background .25s;
}
.main-nav a:hover{color:var(--t1);background:rgba(255,255,255,.06)}
.main-nav a.active{
  color:#160400;background:var(--logo-g);font-weight:600;
  box-shadow:0 6px 18px -8px rgba(242,13,90,.7);
}
.hdr-cta{display:flex;align-items:center;gap:1.1rem;flex-shrink:0}
.hdr-phone{
  display:inline-flex;align-items:center;gap:.5rem;
  font-family:var(--fm);font-size:.76rem;color:var(--t2);
  transition:color .25s;
}
.hdr-phone i{color:var(--cyan)}
.hdr-phone:hover{color:var(--t1)}
.hamburger{display:none;flex-direction:column;gap:5px;padding:10px;cursor:pointer}
.hamburger span{width:24px;height:2px;border-radius:2px;background:var(--t1);transition:transform .3s var(--ease),opacity .3s}
.hamburger.open span:nth-child(1){transform:translateY(7px) rotate(45deg)}
.hamburger.open span:nth-child(2){opacity:0}
.hamburger.open span:nth-child(3){transform:translateY(-7px) rotate(-45deg)}

/* ── Mobile navigation ─────────────────────────────────────── */
.mob-nav{
  position:fixed;top:var(--hh);left:0;right:0;z-index:99;
  display:flex;flex-direction:column;gap:.25rem;
  padding:1.2rem var(--px) 1.6rem;
  background:rgba(2,3,8,.94);
  border-bottom:1px solid var(--bd2);
  backdrop-filter:blur(22px) saturate(160%);
  transform:translateY(-115%);
  transition:transform .45s var(--ease);
}
.mob-nav.open{transform:translateY(0)}
.mob-nav a{
  display:flex;align-items:center;gap:.8rem;
  padding:.85rem 1rem;border-radius:12px;
  color:var(--t2);font-weight:500;font-size:.98rem;
  transition:color .25s,background .25s;
}
.mob-nav a:hover,.mob-nav a.active{color:var(--t1);background:rgba(255,255,255,.05)}
.mob-nav a i{color:var(--l3);width:18px;text-align:center}
.mob-nav .btn{margin-top:.8rem}

/* ════════════════════════════════════════════════════════════
   HERO
════════════════════════════════════════════════════════════ */
.hero{position:relative;padding:110px 0 130px;overflow:hidden;isolation:isolate}
.hero-wrap{display:grid;grid-template-columns:1.05fr .95fr;gap:64px;align-items:center;position:relative;z-index:4}
.hero-chip{
  display:inline-flex;align-items:center;gap:10px;
  padding:9px 18px;border-radius:999px;
  background:rgba(255,255,255,.045);border:1px solid var(--glass-bd);
  backdrop-filter:blur(12px);
  font-size:.82rem;font-weight:500;color:#cfd6e6;
  margin-bottom:1.6rem;position:relative;
}
.chip-dot{
  width:7px;height:7px;border-radius:50%;background:var(--l1);
  box-shadow:0 0 0 0 rgba(242,13,90,.7);
  animation:pulseDot 2s infinite;
}
@keyframes pulseDot{
  0%{box-shadow:0 0 0 0 rgba(242,13,90,.7)}
  70%{box-shadow:0 0 0 11px rgba(242,13,90,0)}
  100%{box-shadow:0 0 0 0 rgba(242,13,90,0)}
}
.chip-pulse{
  position:absolute;right:12px;top:50%;transform:translateY(-50%);
  width:5px;height:5px;border-radius:50%;background:var(--l4);
  animation:blink 1.6s ease-in-out infinite;
}
@keyframes blink{0%,100%{opacity:1}50%{opacity:.15}}
.hero-title{
  font-family:var(--fh);
  font-size:clamp(2.3rem,5.4vw,4.1rem);
  line-height:1.06;font-weight:700;letter-spacing:-.035em;
  margin-bottom:1.5rem;color:var(--t1);
}
.dynamic-text{
  background:linear-gradient(135deg,#F20D5A,#F78B3D 45%,#FBBF24);
  -webkit-background-clip:text;background-clip:text;
  color:transparent;-webkit-text-fill-color:transparent;
}
.typing-cursor{
  display:inline-block;width:3px;height:.92em;vertical-align:-.1em;
  margin-left:4px;border-radius:2px;
  background:linear-gradient(#F20D5A,#FBBF24);
  animation:caret .85s steps(1) infinite;
}
@keyframes caret{0%,49%{opacity:1}50%,100%{opacity:0}}
.hero-desc{color:var(--t2);font-size:1.06rem;max-width:560px;margin-bottom:2.2rem}
.hero-btns{display:flex;flex-wrap:wrap;gap:16px;margin-bottom:2.6rem}
.hero-trust{display:flex;align-items:center;gap:16px}
.trust-av{display:flex}
.trust-av span{
  width:40px;height:40px;border-radius:50%;
  display:grid;place-items:center;
  font-size:.76rem;font-weight:700;font-family:var(--fh);
  color:#160400;border:2px solid var(--bg0);margin-left:-12px;
  box-shadow:0 6px 18px -6px rgba(0,0,0,.9);
}
.trust-av span:first-child{margin-left:0}
.trust-av span:nth-child(1){background:linear-gradient(135deg,#F20D5A,#F44A6A)}
.trust-av span:nth-child(2){background:linear-gradient(135deg,#F44A6A,#F78B3D)}
.trust-av span:nth-child(3){background:linear-gradient(135deg,#F78B3D,#FBBF24)}
.trust-av span:nth-child(4){background:linear-gradient(135deg,#FBBF24,#F78B3D)}
.trust-label{font-size:.9rem;color:var(--t2);line-height:1.4}
.trust-label strong{color:var(--t1);display:block;font-family:var(--fh)}

/* ── Code panel visual ─────────────────────────────────────── */
.hero-visual{position:relative}
.hero-panel{
  position:relative;
  border-radius:var(--radius);
  border:1px solid var(--glass-bd);
  background:linear-gradient(160deg,rgba(255,255,255,.07),rgba(255,255,255,.018));
  backdrop-filter:blur(20px) saturate(150%);
  box-shadow:0 34px 80px -34px rgba(0,0,0,.95),inset 0 1px 0 rgba(255,255,255,.08);
  overflow:hidden;
  transform:perspective(1400px) rotateY(-9deg) rotateX(4deg);
  transition:transform .7s var(--ease);
}
.hero-visual:hover .hero-panel{transform:perspective(1400px) rotateY(-4deg) rotateX(1.5deg)}
.panel-bar{
  display:flex;align-items:center;gap:8px;
  padding:13px 18px;border-bottom:1px solid var(--bd2);
  background:rgba(0,0,0,.28);
}
.p-dot{width:11px;height:11px;border-radius:50%}
.p-dot.r{background:#ff5f57}.p-dot.y{background:#febc2e}.p-dot.g{background:#28c840}
.p-title{margin-left:12px;font-family:var(--fm);font-size:.74rem;color:var(--t2);letter-spacing:.04em}
.code-area{
  padding:22px;font-family:var(--fm);
  font-size:.79rem;line-height:2;color:#b9c3d6;overflow-x:auto;
}
.c-cm{color:#4d5a75;font-style:italic}
.c-kw{color:#F44A6A}
.c-fn{color:#FBBF24}
.c-st{color:#a7f3a0}
.c-cy{color:#22d3ee}
.c-or{color:#F78B3D}
.c-nu{color:#FBBF24}
.c-cu{display:inline-block;width:7px;height:14px;background:var(--l1);vertical-align:-2px;animation:caret .8s steps(1) infinite}

/* ── Floating pills ────────────────────────────────────────── */
.float-pill{
  position:absolute;display:inline-flex;align-items:center;gap:8px;
  padding:10px 17px;border-radius:999px;
  background:rgba(2,3,8,.82);border:1px solid var(--glass-bd);
  backdrop-filter:blur(14px);
  font-family:var(--fh);font-size:.8rem;font-weight:600;
  box-shadow:0 18px 40px -18px rgba(0,0,0,.95);
  white-space:nowrap;z-index:5;color:var(--t1);
}
.fp-ico{font-size:.95rem}
.fp-1{top:-16px;left:-30px;animation:float1 5.5s ease-in-out infinite;color:#F78B3D}
.fp-2{bottom:38px;right:-34px;animation:float2 6.5s ease-in-out infinite;color:#FBBF24}
.fp-3{bottom:-18px;left:24px;animation:float1 7.5s ease-in-out infinite;color:#F20D5A}
@keyframes float1{0%,100%{transform:translateY(0)}50%{transform:translateY(-15px)}}
@keyframes float2{0%,100%{transform:translateY(0)}50%{transform:translateY(15px)}}

/* ════════════════════════════════════════════════════════════
   TECH MARQUEE / CLIENTS STRIP
════════════════════════════════════════════════════════════ */
.strip-wrap{
  --fade:var(--bg0);
  position:relative;z-index:3;
  border-block:1px solid var(--bd2);
  background:linear-gradient(90deg,rgba(242,13,90,.07),rgba(251,191,36,.05),rgba(6,182,212,.05));
  overflow:hidden;padding:16px 0;
  backdrop-filter:blur(6px);
}
.strip-plain{border:none;background:transparent;backdrop-filter:none;padding:.8rem 0}
.strip-inner{overflow:hidden;position:relative;--fade:var(--bg0)}
.strip-inner::before,.strip-inner::after{
  content:'';position:absolute;top:0;bottom:0;width:130px;z-index:2;pointer-events:none;
}
.strip-inner::before{left:0;background:linear-gradient(90deg,var(--fade),transparent)}
.strip-inner::after{right:0;background:linear-gradient(270deg,var(--fade),transparent)}
.marquee-track{display:flex;gap:52px;width:max-content}
.marquee-track.fwd{animation:marquee 34s linear infinite}
.marquee-track.rev{animation:marquee 44s linear infinite reverse}
@keyframes marquee{from{transform:translateX(0)}to{transform:translateX(-50%)}}
.marquee-track:hover{animation-play-state:paused}
.tech-item{
  display:inline-flex;align-items:center;gap:11px;
  font-family:var(--fh);font-weight:600;font-size:.92rem;
  color:#aab4c8;white-space:nowrap;
}
.tech-item i{color:var(--l1);font-size:1rem}
.tech-item:nth-child(even) i{color:var(--l4)}
.tech-item:nth-child(3n) i{color:var(--cyan)}
.clients-strip{
  position:relative;z-index:3;
  background:var(--bg1);
  border-top:1px solid var(--bd2);
  padding:3.5rem 0;
}
.clients-strip .strip-inner{--fade:var(--bg1)}
.clients-title{
  font-family:var(--fm);font-size:.72rem;font-weight:500;
  letter-spacing:.22em;text-transform:uppercase;color:var(--t3);
}
.client-item{display:inline-flex;align-items:center}
.cl-text{
  font-family:var(--fh);font-weight:600;font-size:.95rem;letter-spacing:.02em;
  color:var(--t3);white-space:nowrap;transition:color .3s;
}
.client-item:hover .cl-text{color:var(--t2)}
.client-item::after{content:'◆';margin:0 1.7rem;font-size:.45rem;color:rgba(242,13,90,.45)}

/* ════════════════════════════════════════════════════════════
   SPLIT SECTIONS + CHECK LIST
════════════════════════════════════════════════════════════ */
.split{display:grid;grid-template-columns:1fr 1fr;gap:64px;align-items:center;position:relative;z-index:2}
.split.flip .split-visual{order:-1}
.split-text p{color:var(--t2);margin-bottom:1.1rem}
.check-list{list-style:none;margin:1.7rem 0 2.2rem;display:grid;gap:13px}
.check-list li{display:flex;align-items:flex-start;gap:13px;font-size:.97rem;color:#c6cddc}
.chk{
  flex-shrink:0;width:23px;height:23px;border-radius:7px;
  display:grid;place-items:center;font-size:.72rem;font-weight:700;
  background:linear-gradient(135deg,rgba(242,13,90,.22),rgba(251,191,36,.22));
  border:1px solid rgba(242,13,90,.36);color:var(--l4);
  margin-top:2px;
}

/* ════════════════════════════════════════════════════════════
   STATS BAND
════════════════════════════════════════════════════════════ */
.stats-band-inner{
  position:relative;overflow:hidden;isolation:isolate;
  border-radius:28px;
  border:1px solid var(--glass-bd);
  background:linear-gradient(160deg,rgba(255,255,255,.055),rgba(255,255,255,.015));
  backdrop-filter:blur(18px) saturate(150%);
  padding:62px 40px;
  box-shadow:0 40px 90px -46px rgba(0,0,0,.95),inset 0 1px 0 rgba(255,255,255,.07);
}
.stats-grid{position:relative;z-index:2;display:grid;grid-template-columns:repeat(4,1fr);gap:30px}
.stat-box{text-align:center;padding:16px 10px;border-radius:16px;transition:background .35s}
.stat-box:hover{background:rgba(255,255,255,.04)}
.stat-num{
  font-family:var(--fh);font-size:clamp(2.2rem,4.2vw,3.2rem);
  font-weight:700;line-height:1;margin-bottom:12px;letter-spacing:-.03em;
}
.stat-label{font-size:.86rem;color:var(--t2);line-height:1.45}

/* ════════════════════════════════════════════════════════════
   SERVICE CARDS
════════════════════════════════════════════════════════════ */
.services-grid{
  display:grid;grid-template-columns:repeat(3,1fr);gap:26px;margin-top:3.4rem;
  position:relative;z-index:2;
}
.svc-card{
  position:relative;overflow:hidden;
  padding:38px 32px;border-radius:var(--radius);
  border:1px solid var(--bd2);
  background:linear-gradient(165deg,rgba(255,255,255,.05),rgba(255,255,255,.012));
  backdrop-filter:blur(14px);
  box-shadow:inset 0 1px 0 rgba(255,255,255,.08);
  transition:transform .45s var(--ease),border-color .45s,box-shadow .45s;
  transform-style:preserve-3d;
}
.svc-card:hover{
  border-color:rgba(242,13,90,.42);
  box-shadow:0 34px 66px -32px rgba(242,13,90,.45),inset 0 1px 0 rgba(255,255,255,.08);
}
.card-glow{
  position:absolute;inset:0;border-radius:inherit;pointer-events:none;
  background:radial-gradient(420px circle at var(--mx,50%) var(--my,50%),rgba(242,13,90,.16),transparent 62%);
  opacity:0;transition:opacity .4s;
}
.svc-card:hover .card-glow,.pf-card:hover .card-glow{opacity:1}
.svc-icon{
  width:60px;height:60px;border-radius:17px;
  display:grid;place-items:center;font-size:1.7rem;
  background:linear-gradient(145deg,rgba(242,13,90,.18),rgba(251,191,36,.14));
  border:1px solid var(--glass-bd);
  box-shadow:inset 0 1px 0 rgba(255,255,255,.08);
  margin-bottom:24px;
  transition:transform .45s var(--ease);
}
.svc-card:hover .svc-icon{transform:translateY(-5px) scale(1.06)}
.svc-title{font-family:var(--fh);font-size:1.2rem;font-weight:600;margin-bottom:12px;letter-spacing:-.01em;color:var(--t1)}
.svc-desc{font-size:.92rem;color:var(--t2);margin-bottom:22px;line-height:1.72}
.svc-more{
  display:inline-flex;align-items:center;gap:9px;
  font-size:.87rem;font-weight:600;color:var(--l3);
  font-family:var(--fh);
  transition:gap .3s,color .3s;
}
.svc-card:hover .svc-more{gap:15px;color:var(--l4)}

/* ════════════════════════════════════════════════════════════
   PORTFOLIO
════════════════════════════════════════════════════════════ */
.filters{display:flex;flex-wrap:wrap;gap:.6rem;justify-content:center;position:relative;z-index:2;margin-bottom:2.8rem}
.filter-btn{
  font-family:var(--fh);font-weight:600;font-size:.85rem;
  color:var(--t2);padding:.55rem 1.25rem;border-radius:999px;
  background:rgba(255,255,255,.04);border:1px solid var(--glass-bd);
  backdrop-filter:blur(8px);
  transition:color .25s,border-color .25s,background .25s,transform .25s;
}
.filter-btn:hover{color:var(--t1);border-color:rgba(242,13,90,.4);transform:translateY(-2px)}
.filter-btn.active{
  color:#fff;
  background:linear-gradient(135deg,rgba(242,13,90,.25),rgba(247,139,61,.16));
  border-color:rgba(242,13,90,.55);
  box-shadow:0 10px 26px -12px rgba(242,13,90,.55);
}
.portfolio-grid{
  display:grid;grid-template-columns:repeat(2,1fr);gap:30px;
  position:relative;z-index:2;
}
.pf-card{
  position:relative;overflow:hidden;border-radius:var(--radius);
  border:1px solid var(--bd2);
  background:linear-gradient(165deg,rgba(255,255,255,.05),rgba(255,255,255,.012));
  backdrop-filter:blur(12px);
  box-shadow:inset 0 1px 0 rgba(255,255,255,.08);
  transition:transform .45s var(--ease),border-color .45s,box-shadow .45s;
}
.pf-card:hover{border-color:rgba(242,13,90,.42);box-shadow:0 36px 70px -34px rgba(242,13,90,.45),inset 0 1px 0 rgba(255,255,255,.08)}
.pf-card.pf-hidden{display:none}
.pf-img{position:relative;overflow:hidden;aspect-ratio:16/10}
.pf-img img{width:100%;height:100%;object-fit:cover;transition:transform .8s var(--ease);filter:saturate(.85)}
.pf-card:hover .pf-img img{transform:scale(1.09)}
.pf-overlay{
  position:absolute;inset:0;display:flex;align-items:center;justify-content:center;gap:16px;
  background:linear-gradient(0deg,rgba(2,3,8,.94),rgba(2,3,8,.35));
  opacity:0;transition:opacity .4s;
}
.pf-card:hover .pf-overlay{opacity:1}
.pf-overlay a{
  width:52px;height:52px;border-radius:50%;
  display:grid;place-items:center;
  background:rgba(255,255,255,.09);border:1px solid var(--glass-bd);
  backdrop-filter:blur(10px);color:#fff;
  transition:transform .35s var(--ease),background .3s;
  transform:translateY(14px);
}
.pf-card:hover .pf-overlay a{transform:translateY(0)}
.pf-overlay a:hover{background:linear-gradient(135deg,#F20D5A,#F78B3D);color:#160400}
.pf-body{padding:26px 28px 30px;position:relative;z-index:2}
.pf-cat{
  font-size:.7rem;font-weight:700;letter-spacing:.16em;text-transform:uppercase;
  color:var(--l4);margin-bottom:10px;font-family:var(--fh);
}
.pf-title{font-family:var(--fh);font-size:1.22rem;font-weight:600;margin-bottom:10px;letter-spacing:-.01em;color:var(--t1)}
.pf-desc{font-size:.9rem;color:var(--t2);line-height:1.68}
.tech-tags{display:flex;flex-wrap:wrap;gap:.45rem;margin-top:1rem}
.tech-tag{
  font-family:var(--fm);font-size:.64rem;letter-spacing:.08em;
  color:var(--cy2);background:rgba(6,182,212,.07);
  border:1px solid rgba(6,182,212,.22);
  padding:.26rem .6rem;border-radius:6px;
}

/* ════════════════════════════════════════════════════════════
   TESTIMONIALS
════════════════════════════════════════════════════════════ */
.testi-grid{
  display:grid;grid-template-columns:repeat(3,1fr);gap:26px;margin-top:3.4rem;
  position:relative;z-index:2;
}
.testi-card{
  padding:34px 30px;border-radius:var(--radius);
  border:1px solid var(--bd2);
  background:linear-gradient(165deg,rgba(255,255,255,.05),rgba(255,255,255,.012));
  backdrop-filter:blur(14px);
  box-shadow:inset 0 1px 0 rgba(255,255,255,.08);
  transition:transform .45s var(--ease),border-color .45s,box-shadow .45s;
}
.testi-card:hover{
  transform:translateY(-7px);
  border-color:rgba(251,191,36,.42);
  box-shadow:0 34px 66px -34px rgba(251,191,36,.4),inset 0 1px 0 rgba(255,255,255,.08);
}
.testi-stars{color:#FBBF24;letter-spacing:3px;font-size:.95rem;margin-bottom:18px}
.testi-text{font-size:.94rem;color:#c3cbdb;line-height:1.78;margin-bottom:24px}
.testi-author{display:flex;align-items:center;gap:14px}
.testi-av{
  width:48px;height:48px;border-radius:50%;flex-shrink:0;
  display:grid;place-items:center;
  font-family:var(--fh);font-weight:700;font-size:1.05rem;
  color:#160400;background:linear-gradient(135deg,#F20D5A,#F78B3D);
  box-shadow:0 10px 24px -10px rgba(242,13,90,.75);
}
.testi-name{font-family:var(--fh);font-weight:600;font-size:.98rem;color:var(--t1)}
.testi-role{font-size:.8rem;color:var(--t2)}

/* ════════════════════════════════════════════════════════════
   TEAM
════════════════════════════════════════════════════════════ */
.team-grid{
  display:grid;grid-template-columns:repeat(4,1fr);gap:26px;margin-top:3.4rem;
  position:relative;z-index:2;
}
.team-card{
  position:relative;overflow:hidden;border-radius:var(--radius);
  border:1px solid var(--bd2);
  background:linear-gradient(165deg,rgba(255,255,255,.05),rgba(255,255,255,.012));
  backdrop-filter:blur(12px);
  transition:transform .45s var(--ease),border-color .45s,box-shadow .45s;
}
.team-card:hover{
  transform:translateY(-7px);
  border-color:rgba(242,13,90,.42);
  box-shadow:0 34px 66px -32px rgba(242,13,90,.45);
}
.team-photo{position:relative;aspect-ratio:4/4.4;overflow:hidden}
.team-photo img{
  width:100%;height:100%;object-fit:cover;object-position:top;
  filter:saturate(.92);transition:transform .8s var(--ease),filter .5s;
}
.team-card:hover .team-photo img{transform:scale(1.06);filter:saturate(1.05)}
.team-photo::after{
  content:'';position:absolute;inset:0;
  background:linear-gradient(180deg,transparent 46%,rgba(2,3,8,.92));
}
.team-info{padding:0 22px 24px;position:relative;z-index:2;margin-top:-34px}
.team-name{font-family:var(--fh);font-weight:600;font-size:1.02rem;color:var(--t1);margin-bottom:2px}
.team-role{font-family:var(--fm);font-size:.68rem;letter-spacing:.06em;color:var(--l3)}

/* ════════════════════════════════════════════════════════════
   PROCESS
════════════════════════════════════════════════════════════ */
.process-grid{
  display:grid;grid-template-columns:repeat(3,1fr);gap:26px;margin-top:3.4rem;
  position:relative;z-index:2;
}
.proc-step{
  position:relative;overflow:hidden;
  padding:30px 28px;border-radius:20px;
  border:1px solid var(--bd2);
  background:linear-gradient(165deg,rgba(255,255,255,.05),rgba(255,255,255,.012));
  backdrop-filter:blur(12px);
  box-shadow:inset 0 1px 0 rgba(255,255,255,.08);
  transition:transform .45s var(--ease),border-color .45s,box-shadow .45s;
}
.proc-step:hover{
  transform:translateY(-6px);
  border-color:rgba(6,182,212,.4);
  box-shadow:0 30px 60px -30px rgba(6,182,212,.35),inset 0 1px 0 rgba(255,255,255,.08);
}
.proc-step::before{
  content:'';position:absolute;top:0;left:0;right:0;height:2px;
  background:linear-gradient(90deg,transparent,rgba(242,13,90,.6),rgba(251,191,36,.5),transparent);
  opacity:0;transition:opacity .4s;
}
.proc-step:hover::before{opacity:1}
.proc-num{
  display:inline-flex;align-items:center;
  font-family:var(--fm);font-size:.72rem;font-weight:500;letter-spacing:.22em;
  color:var(--cy2);background:rgba(6,182,212,.07);
  border:1px solid rgba(6,182,212,.28);
  padding:.3rem .75rem;border-radius:8px;margin-bottom:1.1rem;
}
.proc-title{font-family:var(--fh);font-weight:600;font-size:1.05rem;margin-bottom:.55rem;color:var(--t1);letter-spacing:-.01em}
.proc-desc{font-size:.88rem;color:var(--t2);line-height:1.7}

/* ════════════════════════════════════════════════════════════
   PAGE HERO (inner pages)
════════════════════════════════════════════════════════════ */
.page-hero{
  position:relative;padding:5.5rem 0 4.5rem;overflow:hidden;isolation:isolate;
  border-bottom:1px solid var(--bd2);
}
.page-hero-content{position:relative;z-index:2;text-align:center;max-width:800px;margin:0 auto}
.breadcrumb{
  display:inline-flex;align-items:center;gap:.5rem;
  font-family:var(--fm);font-size:.68rem;letter-spacing:.14em;text-transform:uppercase;
  color:var(--t3);margin-bottom:1.7rem;
}
.breadcrumb a{color:var(--t2);transition:color .25s}
.breadcrumb a:hover{color:var(--l3)}
.breadcrumb .sep{color:var(--l1)}

/* ════════════════════════════════════════════════════════════
   CONTACT
════════════════════════════════════════════════════════════ */
.contact-wrap{
  display:grid;grid-template-columns:.92fr 1.08fr;gap:56px;align-items:start;
  position:relative;z-index:2;
}
.ci-block{
  display:flex;gap:1rem;align-items:center;
  padding:1rem 1.15rem;border-radius:16px;
  border:1px solid var(--bd2);
  background:linear-gradient(160deg,rgba(255,255,255,.045),rgba(255,255,255,.012));
  box-shadow:inset 0 1px 0 rgba(255,255,255,.06);
  margin-bottom:.9rem;
  transition:border-color .35s,transform .35s var(--ease);
}
.ci-block:hover{border-color:rgba(242,13,90,.35);transform:translateX(5px)}
.ci-ico{
  width:44px;height:44px;flex-shrink:0;border-radius:13px;
  display:grid;place-items:center;
  background:linear-gradient(145deg,rgba(242,13,90,.16),rgba(251,191,36,.12));
  border:1px solid var(--glass-bd);
  color:var(--l3);font-size:.95rem;
}
.ci-head{font-family:var(--fh);font-weight:600;font-size:.88rem;color:var(--t1);margin-bottom:.1rem}
.ci-val{font-size:.86rem;color:var(--t2)}
.ci-val a{color:var(--t2);transition:color .25s}
.ci-val a:hover{color:var(--l3)}
.cf-box{
  position:relative;
  padding:44px 42px;border-radius:26px;
  border:1px solid var(--glass-bd);
  background:var(--glass);
  backdrop-filter:blur(18px) saturate(150%);
  box-shadow:0 40px 90px -46px rgba(0,0,0,.95),inset 0 1px 0 rgba(255,255,255,.08);
}
.cf-heading{font-family:var(--fh);font-size:1.55rem;font-weight:700;letter-spacing:-.02em;margin-bottom:.5rem;color:var(--t1)}
.cf-sub{font-size:.92rem;color:var(--t2);margin-bottom:1.9rem}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:1.15rem}
.form-group{margin-bottom:1.15rem}
.form-group label{
  display:block;font-family:var(--fh);font-weight:600;font-size:.82rem;
  color:#c3cbdb;margin-bottom:.5rem;letter-spacing:.01em;
}
.req{color:var(--l1)}
.form-group input,
.form-group select,
.form-group textarea{
  width:100%;
  background:rgba(2,3,8,.55);
  border:1px solid var(--glass-bd);
  border-radius:12px;
  padding:.8rem 1rem;
  color:var(--t1);font-size:.92rem;
  transition:border-color .25s,box-shadow .25s,background .25s;
}
.form-group input::placeholder,
.form-group textarea::placeholder{color:var(--t3)}
.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus{
  outline:none;
  border-color:rgba(242,13,90,.55);
  box-shadow:0 0 0 3px rgba(242,13,90,.12);
  background:rgba(2,3,8,.75);
}
.form-group input.error,
.form-group select.error,
.form-group textarea.error{
  border-color:#ef4444;
  box-shadow:0 0 0 3px rgba(239,68,68,.15);
}
.form-group select{
  appearance:none;-webkit-appearance:none;cursor:pointer;
  padding-right:2.6rem;
  background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23F78B3D' stroke-width='2' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
  background-repeat:no-repeat;background-position:right 1rem center;
}
.form-group select option{background:#0d1525;color:var(--t1)}
.form-group textarea{min-height:150px;resize:vertical;line-height:1.7}
.alert{display:none;gap:.9rem;align-items:flex-start;padding:1rem 1.2rem;border-radius:14px;margin-bottom:1.4rem;font-size:.9rem;line-height:1.65}
.alert.show{display:flex}
.alert i{font-size:1.05rem;margin-top:.2rem}
.alert-ok{background:rgba(16,185,129,.08);border:1px solid rgba(16,185,129,.3);color:#a7f3d0}
.alert-ok i{color:#4ade80}
.alert-err{background:rgba(242,13,90,.08);border:1px solid rgba(242,13,90,.35);color:#fecdd3}
.alert-err i{color:var(--l2)}

/* ── Social buttons ────────────────────────────────────────── */
.social-strip{display:flex;gap:.65rem}
.soc-btn{
  width:40px;height:40px;border-radius:12px;
  display:grid;place-items:center;
  border:1px solid var(--bd2);background:rgba(255,255,255,.03);
  color:var(--t2);transition:all .3s var(--ease);
}
.soc-btn:hover{
  color:#160400;background:linear-gradient(135deg,#F20D5A,#F78B3D);
  border-color:transparent;transform:translateY(-4px);
  box-shadow:0 14px 30px -12px rgba(242,13,90,.8);
}

/* ════════════════════════════════════════════════════════════
   CTA BAND
════════════════════════════════════════════════════════════ */
.cta-band{position:relative;padding:120px 0;overflow:hidden;isolation:isolate}
.cta-box{
  position:relative;z-index:2;text-align:center;
  max-width:880px;margin:0 auto;
  padding:70px 50px;border-radius:32px;
  border:1px solid var(--glass-bd);
  background:linear-gradient(160deg,rgba(255,255,255,.07),rgba(255,255,255,.018));
  backdrop-filter:blur(20px) saturate(150%);
  box-shadow:0 50px 110px -50px rgba(0,0,0,.95),inset 0 1px 0 rgba(255,255,255,.08);
}
.cta-box .eyebrow{margin-inline:auto}
.cta-box h2{
  font-family:var(--fh);
  font-size:clamp(1.9rem,3.8vw,3rem);font-weight:700;line-height:1.14;
  letter-spacing:-.025em;margin-bottom:1.2rem;color:var(--t1);
}
.cta-box p{color:var(--t2);max-width:600px;margin:0 auto 2.4rem;font-size:1.03rem}
.cta-btns{display:flex;flex-wrap:wrap;gap:16px;justify-content:center}

/* ════════════════════════════════════════════════════════════
   FOOTER
════════════════════════════════════════════════════════════ */
.site-footer{
  position:relative;z-index:3;
  border-top:1px solid var(--bd2);
  background:rgba(2,3,8,.6);
  backdrop-filter:blur(14px);
  padding:64px 0 34px;
}
.footer-grid{display:grid;grid-template-columns:1.6fr 1fr 1fr 1.1fr;gap:44px;margin-bottom:48px}
.footer-brand p{color:var(--t2);font-size:.9rem;margin-top:18px;max-width:330px;line-height:1.75}
.footer-brand .social-strip{margin-top:1.6rem}
.footer-col h5{
  font-family:var(--fh);font-size:.8rem;font-weight:700;
  letter-spacing:.16em;text-transform:uppercase;color:var(--t1);
  margin-bottom:1.15rem;
}
.footer-col ul li{margin-bottom:.15rem}
.footer-col ul a{
  display:inline-flex;align-items:center;gap:.55rem;
  color:var(--t2);font-size:.9rem;padding:.36rem 0;
  transition:color .25s,transform .25s;
}
.footer-col ul a:hover{color:var(--l3);transform:translateX(5px)}
.footer-col ul a i{font-size:.55rem;color:var(--l1)}
.footer-contact-col p{display:flex;gap:.7rem;align-items:center;font-size:.88rem;color:var(--t2);padding:.34rem 0}
.footer-contact-col p i{color:var(--l3);width:16px;text-align:center;flex-shrink:0}
.footer-contact-col p a{transition:color .25s}
.footer-contact-col p a:hover{color:var(--l3)}
.footer-bottom{
  display:flex;justify-content:space-between;align-items:center;gap:20px;flex-wrap:wrap;
  padding-top:28px;border-top:1px solid var(--bd2);
  font-size:.85rem;color:var(--t2);
}
.footer-bottom p strong{color:var(--t1);font-weight:600}

/* ════════════════════════════════════════════════════════════
   SCROLL REVEAL
════════════════════════════════════════════════════════════ */
[data-reveal]{
  opacity:0;transform:translateY(30px);
  transition:opacity .9s var(--ease),transform .9s var(--ease);
  will-change:opacity,transform;
}
[data-reveal].in{opacity:1;transform:none}
[data-delay="1"]{transition-delay:.1s}
[data-delay="2"]{transition-delay:.2s}
[data-delay="3"]{transition-delay:.3s}
[data-delay="4"]{transition-delay:.4s}

/* ════════════════════════════════════════════════════════════
   RESPONSIVE
════════════════════════════════════════════════════════════ */
@media(max-width:1080px){
  :root{--hh:66px}
  .main-nav,.hdr-cta{display:none}
  .hamburger{display:flex}
  .hero-wrap{grid-template-columns:1fr;gap:52px}
  .hero-visual{max-width:560px;margin-inline:auto;width:100%}
  .fp-1{left:-10px}.fp-2{right:-10px}
  .services-grid{grid-template-columns:repeat(2,1fr)}
  .testi-grid{grid-template-columns:1fr}
  .team-grid{grid-template-columns:repeat(2,1fr)}
  .foot-col,.footer-grid{grid-template-columns:1fr 1fr}
  .footer-grid{gap:36px}
  .fx-host.fx-right{width:100%;right:0;opacity:.5}
  .hud-corner{display:none}
  .contact-wrap{grid-template-columns:1fr;gap:44px}
}
@media(max-width:860px){
  .section{padding:80px 0}
  .hero{padding:80px 0 100px}
  .split{grid-template-columns:1fr;gap:46px}
  .split.flip .split-visual{order:0}
  .stats-grid{grid-template-columns:repeat(2,1fr);gap:26px}
  .stats-band-inner{padding:44px 26px}
  .portfolio-grid{grid-template-columns:1fr}
  .process-grid{grid-template-columns:1fr}
  .img-badge{right:0;bottom:-16px;padding:14px 18px}
  .cf-box{padding:34px 24px}
  .cta-box{padding:52px 26px}
}
@media(max-width:620px){
  .wrap{padding:0 18px}
  .hero{padding:64px 0 84px}
  .page-hero{padding:4rem 0 3.2rem}
  .services-grid{grid-template-columns:1fr}
  .team-grid{grid-template-columns:1fr}
  .footer-grid{grid-template-columns:1fr}
  .footer-bottom{justify-content:center;text-align:center}
  .hero-btns{flex-direction:column;align-items:stretch}
  .hero-btns .btn{justify-content:center}
  .cta-btns{flex-direction:column}
  .cta-btns .btn{justify-content:center}
  .hero-panel{transform:none}
  .hero-visual:hover .hero-panel{transform:none}
  .code-area{font-size:.68rem;padding:16px;line-height:1.9}
  .form-row{grid-template-columns:1fr}
  .filters{justify-content:flex-start;overflow-x:auto;flex-wrap:nowrap;padding-bottom:.5rem;-webkit-overflow-scrolling:touch}
  .filter-btn{flex-shrink:0}
  .hud-tag{display:none}
}

/* ════════════════════════════════════════════════════════════
   REDUCED MOTION
════════════════════════════════════════════════════════════ */
@media(prefers-reduced-motion:reduce){
  *,*::before,*::after{
    animation-duration:.01ms!important;
    animation-iteration-count:1!important;
    transition-duration:.01ms!important;
    scroll-behavior:auto!important;
  }
  [data-reveal]{opacity:1;transform:none}
  .fx-host{display:none}
  .ai-entity-canvas{background:radial-gradient(circle at center,rgba(242,13,90,.2),transparent 70%)}
}
</style>

<!-- ══════════════════════════════════════════
     CLIENT LOGOS STRIP (above footer)
══════════════════════════════════════════ -->
<section class="clients-strip" aria-label="Our clients">
  <div class="wrap">
    <div class="center" style="margin-bottom:2.4rem">
      <p class="clients-title">
        Trusted by leading organisations
      </p>
    </div>
  </div>
  <div class="strip-wrap strip-plain">
    <div class="strip-inner">
      <div class="marquee-track rev">
        <?php
        $clients = [
          'Almarah Foundation','National Highways Police','Smart Move',
          'Greenshine Cosmetics','Fareed Communications','Hum News',
          'Daily Rasta','MediTrack Pro','EduLearn LMS','PropHub',
          'UrbanEats','FinSight AI','PharmaChain','StyleHub',
          'Almarah Foundation','National Highways Police','Smart Move',
          'Greenshine Cosmetics','Fareed Communications','Hum News',
          'Daily Rasta','MediTrack Pro','EduLearn LMS','PropHub',
          'UrbanEats','FinSight AI','PharmaChain','StyleHub',
        ];
        foreach ($clients as $c): ?>
        <div class="client-item">
          <span class="cl-text"><?= htmlspecialchars($c) ?></span>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════════════
     SITE FOOTER
══════════════════════════════════════════ -->
<footer class="site-footer" role="contentinfo" itemscope itemtype="https://schema.org/WPFooter">
  <div class="wrap">
    <div class="footer-grid">

      <!-- Brand -->
      <div class="footer-brand">
        <a href="index.php" class="brand" aria-label="Softex Technologies">
          <img class="brand-logo" src="assets/logo.jpg" alt="Softex Technologies logo" width="42" height="42">
          <span class="brand-text">Softex<em>Technologies</em></span>
        </a>
        <p>Building world-class digital products since 2015 — from AI-powered web apps to enterprise software and high-converting e-commerce stores. Your vision, our expertise.</p>
        <div class="social-strip">
          <a href="https://facebook.com/softexpak/"       target="_blank" rel="noopener noreferrer" class="soc-btn" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
          <a href="https://twitter.com/softexpak/"        target="_blank" rel="noopener noreferrer" class="soc-btn" aria-label="Twitter"><i class="fab fa-x-twitter"></i></a>
          <a href="https://instagram.com/sotexpak/"       target="_blank" rel="noopener noreferrer" class="soc-btn" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
          <a href="https://linkedin.com/company/sotexpak/" target="_blank" rel="noopener noreferrer" class="soc-btn" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
        </div>
      </div>

      <!-- Services -->
      <div class="footer-col">
        <h5>Services</h5>
        <ul>
          <li><a href="services.php#web"><i class="fas fa-chevron-right" aria-hidden="true"></i> Web Development</a></li>
          <li><a href="services.php#software"><i class="fas fa-chevron-right" aria-hidden="true"></i> Software Development</a></li>
          <li><a href="services.php#apps"><i class="fas fa-chevron-right" aria-hidden="true"></i> Android &amp; iOS Apps</a></li>
          <li><a href="services.php#ecommerce"><i class="fas fa-chevron-right" aria-hidden="true"></i> E-Commerce Solutions</a></li>
          <li><a href="services.php#seo"><i class="fas fa-chevron-right" aria-hidden="true"></i> SEO &amp; Marketing</a></li>
          <li><a href="services.php#shopify"><i class="fas fa-chevron-right" aria-hidden="true"></i> Shopify Development</a></li>
        </ul>
      </div>

      <!-- Company -->
      <div class="footer-col">
        <h5>Company</h5>
        <ul>
          <li><a href="about.php"><i class="fas fa-chevron-right" aria-hidden="true"></i> About Us</a></li>
          <li><a href="portfolio.php"><i class="fas fa-chevron-right" aria-hidden="true"></i> Portfolio</a></li>
          <li><a href="contact.php"><i class="fas fa-chevron-right" aria-hidden="true"></i> Careers</a></li>
          <li><a href="contact.php"><i class="fas fa-chevron-right" aria-hidden="true"></i> Contact Us</a></li>
        </ul>
      </div>

      <!-- Contact -->
      <div class="footer-col footer-contact-col">
        <h5>Get In Touch</h5>
        <p><i class="fas fa-envelope" aria-hidden="true"></i><a href="mailto:info@softex.pk">info@softex.pk</a></p>
        <p><i class="fas fa-phone" aria-hidden="true"></i><a href="tel:+923450789192">+92 345 0789192</a></p>
        <p><i class="fas fa-map-marker-alt" aria-hidden="true"></i><span>Lahore, Punjab, Pakistan</span></p>
        <p><i class="fas fa-clock" aria-hidden="true"></i><span>Mon–Sat &nbsp;·&nbsp; 9 AM – 6 PM PKT</span></p>
      </div>

    </div>

    <div class="footer-bottom">
      <p>© 2015–<?= date('Y') ?> <strong>Softex Technologies</strong>. All rights reserved.</p>
      <p>Start of a New Technology Era</p>
    </div>

  </div>
</footer>

<!-- ══════════════════════════════════════════
     THREE.JS IMPORT MAP
══════════════════════════════════════════ -->
<script type="importmap">
{
  "imports": {
    "three": "https://unpkg.com/three@0.160.0/build/three.module.js"
  }
}
</script>

<!-- ══════════════════════════════════════════
     SOFTEX AI OS — SHARED 3D ENGINE
     One module · one RAF loop · many scenes.
     Reads .fx-host[data-scene] and builds the
     matching procedural scene. Off-screen scenes
     stop rendering (IntersectionObserver), each
     canvas resizes with its host (ResizeObserver),
     the loop pauses on hidden tabs, cameras get a
     gentle pointer parallax, and the whole engine
     is disabled for prefers-reduced-motion users.
══════════════════════════════════════════ -->
<script type="module">
import * as THREE from 'three';

const REDUCED = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

/* ── Brand palette ─────────────────────────── */
const PINK   = 0xF20D5A;
const CORAL  = 0xF44A6A;
const ORANGE = 0xF78B3D;
const GOLD   = 0xFBBF24;
const CYAN   = 0x06b6d4;
const CYAN2  = 0x22d3ee;
const PURPLE = 0x8b5cf6;

const GRAD = [PINK, CORAL, ORANGE, GOLD].map(c => new THREE.Color(c));
const rand = (a, b) => a + Math.random() * (b - a);

/* sample the 4-stop logo gradient at t ∈ [0,1] */
function gradAt(t) {
  const x = Math.min(Math.max(t, 0), 1) * (GRAD.length - 1);
  const i = Math.floor(x);
  return GRAD[i].clone().lerp(GRAD[Math.min(i + 1, GRAD.length - 1)], x - i);
}

/* ── Shared helpers ────────────────────────── */
function makeCamera(host, defZ, defY) {
  const cam = new THREE.PerspectiveCamera(48, 1, 0.1, 220);
  cam.position.set(
    0,
    parseFloat(host.dataset.camY) || (defY || 0),
    parseFloat(host.dataset.camZ) || defZ
  );
  return cam;
}

function makeRenderer(host) {
  const r = new THREE.WebGLRenderer({
    alpha: true,
    antialias: (window.devicePixelRatio || 1) < 2,
    powerPreference: 'high-performance'
  });
  r.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));
  r.setClearColor(0x000000, 0);
  const w = host.clientWidth || 640;
  const h = host.clientHeight || 480;
  r.setSize(w, h, false);
  r.domElement.style.width = '100%';
  r.domElement.style.height = '100%';
  host.appendChild(r.domElement);
  return r;
}

function makeDust(scene, count, spread) {
  const pos = new Float32Array(count * 3);
  for (let i = 0; i < count; i++) {
    pos.set([rand(-spread, spread), rand(-spread * .7, spread * .7), rand(-spread, spread * .5)], i * 3);
  }
  const geo = new THREE.BufferGeometry();
  geo.setAttribute('position', new THREE.BufferAttribute(pos, 3));
  const dust = new THREE.Points(geo, new THREE.PointsMaterial({
    color: 0xffe0bf, size: 0.03, transparent: true, opacity: 0.35,
    sizeAttenuation: true
  }));
  scene.add(dust);
  return dust;
}

/* ════════════════════════════════════════════
   SCENE 1 · NEURAL CORE
   Wireframe icosahedron shells around a pulsing
   solid core, connected node web, dust field.
════════════════════════════════════════════ */
function buildNeuralCore(host) {
  const scene = new THREE.Scene();
  const cam = makeCamera(host, 11);
  const group = new THREE.Group();
  group.scale.setScalar(parseFloat(host.dataset.scale) || 1);
  scene.add(group);

  /* pulsing solid core + additive halo */
  const core = new THREE.Mesh(
    new THREE.IcosahedronGeometry(1.1, 2),
    new THREE.MeshBasicMaterial({ color: PINK, transparent: true, opacity: 0.16 })
  );
  const halo = new THREE.Mesh(
    new THREE.SphereGeometry(1.55, 24, 24),
    new THREE.MeshBasicMaterial({
      color: PINK, transparent: true, opacity: 0.14,
      blending: THREE.AdditiveBlending, depthWrite: false
    })
  );
  group.add(core, halo);

  /* wireframe icosahedron shells */
  const shellA = new THREE.Mesh(
    new THREE.IcosahedronGeometry(1.9, 2),
    new THREE.MeshBasicMaterial({ color: CORAL, wireframe: true, transparent: true, opacity: 0.5 })
  );
  const shellB = new THREE.Mesh(
    new THREE.IcosahedronGeometry(3.0, 1),
    new THREE.MeshBasicMaterial({ color: GOLD, wireframe: true, transparent: true, opacity: 0.15 })
  );
  group.add(shellA, shellB);

  /* connected node web */
  const N = 90;
  const nodes = [];
  for (let i = 0; i < N; i++) {
    nodes.push(new THREE.Vector3().randomDirection().multiplyScalar(rand(3.4, 5.6)));
  }
  group.add(new THREE.Points(
    new THREE.BufferGeometry().setFromPoints(nodes),
    new THREE.PointsMaterial({ color: 0xffd9a8, size: 0.09, transparent: true, opacity: 0.9 })
  ));
  const segs = [];
  for (let i = 0; i < N; i++) {
    for (let j = i + 1; j < N; j++) {
      if (nodes[i].distanceTo(nodes[j]) < 1.8) segs.push(nodes[i].clone(), nodes[j].clone());
    }
  }
  group.add(new THREE.LineSegments(
    new THREE.BufferGeometry().setFromPoints(segs),
    new THREE.LineBasicMaterial({ color: CYAN, transparent: true, opacity: 0.18 })
  ));

  const dust = makeDust(scene, 240, 11);

  return {
    scene, cam,
    update(t) {
      group.rotation.y = t * 0.14;
      group.rotation.x = Math.sin(t * 0.22) * 0.22;
      shellA.rotation.z = t * 0.1;
      shellB.rotation.y = -t * 0.09;
      const pulse = 1 + Math.sin(t * 1.5) * 0.05;
      core.scale.setScalar(pulse);
      halo.scale.setScalar(1 + Math.sin(t * 1.5) * 0.09);
      dust.rotation.y = t * 0.018;
    }
  };
}

/* ════════════════════════════════════════════
   SCENE 2 · DATA SPHERE
   Point-cloud sphere coloured along the 4-stop
   logo gradient, with three orbital torus rings.
════════════════════════════════════════════ */
function buildDataSphere(host) {
  const scene = new THREE.Scene();
  const cam = makeCamera(host, 11);
  const group = new THREE.Group();
  scene.add(group);

  const COUNT = 1400;
  const positions = new Float32Array(COUNT * 3);
  const colors = new Float32Array(COUNT * 3);
  for (let i = 0; i < COUNT; i++) {
    const v = new THREE.Vector3().randomDirection().multiplyScalar(3.4 + Math.random() * 0.22);
    positions.set([v.x, v.y, v.z], i * 3);
    const c = gradAt(Math.random());
    colors.set([c.r, c.g, c.b], i * 3);
  }
  const geo = new THREE.BufferGeometry();
  geo.setAttribute('position', new THREE.BufferAttribute(positions, 3));
  geo.setAttribute('color', new THREE.BufferAttribute(colors, 3));
  const sphere = new THREE.Points(geo, new THREE.PointsMaterial({
    size: 0.06, vertexColors: true, transparent: true, opacity: 0.9, sizeAttenuation: true
  }));
  group.add(sphere);

  const rings = [];
  const ringColors = [PINK, GOLD, CYAN];
  for (let i = 0; i < 3; i++) {
    const r = new THREE.Mesh(
      new THREE.TorusGeometry(3.9 + i * 0.55, 0.008, 6, 160),
      new THREE.MeshBasicMaterial({ color: ringColors[i], transparent: true, opacity: 0.32 - i * 0.06 })
    );
    r.rotation.x = Math.PI / 2 + rand(-0.5, 0.5);
    r.rotation.y = rand(-0.5, 0.5);
    group.add(r);
    rings.push(r);
  }

  return {
    scene, cam,
    update(t) {
      group.rotation.y = t * 0.12;
      sphere.rotation.y = t * 0.05;
      rings.forEach((r, i) => { r.rotation.z = t * (0.16 + i * 0.09) * (i % 2 ? -1 : 1); });
    }
  };
}

/* ════════════════════════════════════════════
   SCENE 3 · HELIX
   Double helix of glowing spheres — magenta and
   gold strands — joined by connecting rungs.
════════════════════════════════════════════ */
function buildHelix(host) {
  const scene = new THREE.Scene();
  const cam = makeCamera(host, 13);
  const group = new THREE.Group();
  group.rotation.z = 0.35;
  scene.add(group);

  const geo = new THREE.SphereGeometry(0.085, 10, 10);
  const matA = new THREE.MeshBasicMaterial({ color: PINK, transparent: true, opacity: 0.9 });
  const matB = new THREE.MeshBasicMaterial({ color: GOLD, transparent: true, opacity: 0.9 });

  const TURNS = 4, POINTS = 120, HEIGHT = 12, RADIUS = 1.9;
  const strandA = new THREE.Group();
  const strandB = new THREE.Group();
  group.add(strandA, strandB);

  const rungPts = [];
  for (let i = 0; i < POINTS; i++) {
    const p = i / POINTS;
    const angle = p * Math.PI * 2 * TURNS;
    const y = (p - 0.5) * HEIGHT;

    const a = new THREE.Mesh(geo, matA);
    a.position.set(Math.cos(angle) * RADIUS, y, Math.sin(angle) * RADIUS);
    strandA.add(a);

    const b = new THREE.Mesh(geo, matB);
    b.position.set(Math.cos(angle + Math.PI) * RADIUS, y, Math.sin(angle + Math.PI) * RADIUS);
    strandB.add(b);

    if (i % 4 === 0) {
      rungPts.push(
        new THREE.Vector3(Math.cos(angle) * RADIUS, y, Math.sin(angle) * RADIUS),
        new THREE.Vector3(Math.cos(angle + Math.PI) * RADIUS, y, Math.sin(angle + Math.PI) * RADIUS)
      );
    }
  }
  group.add(new THREE.LineSegments(
    new THREE.BufferGeometry().setFromPoints(rungPts),
    new THREE.LineBasicMaterial({ color: CORAL, transparent: true, opacity: 0.28 })
  ));

  return {
    scene, cam,
    update(t) {
      group.rotation.y = t * 0.5;
      group.position.y = Math.sin(t * 0.6) * 0.35;
    }
  };
}

/* ════════════════════════════════════════════
   SCENE 4 · GRID WAVE
   Two displaced wireframe planes — magenta and
   gold — rippling continuously.
════════════════════════════════════════════ */
function buildGridWave(host) {
  const scene = new THREE.Scene();
  const cam = makeCamera(host, 8, 2.4);
  const lookAt = new THREE.Vector3(0, -1, 0);

  const geo = new THREE.PlaneGeometry(26, 18, 62, 42);
  const mesh = new THREE.Mesh(geo, new THREE.MeshBasicMaterial({
    color: PINK, wireframe: true, transparent: true, opacity: 0.18
  }));
  mesh.rotation.x = -Math.PI / 2.35;
  mesh.position.y = -1.6;
  scene.add(mesh);

  const geo2 = new THREE.PlaneGeometry(30, 20, 40, 28);
  const mesh2 = new THREE.Mesh(geo2, new THREE.MeshBasicMaterial({
    color: GOLD, wireframe: true, transparent: true, opacity: 0.11
  }));
  mesh2.rotation.x = -Math.PI / 2.35;
  mesh2.position.y = -3.1;
  scene.add(mesh2);

  const base = geo.attributes.position.array.slice();
  const base2 = geo2.attributes.position.array.slice();

  return {
    scene, cam, lookAt,
    update(t) {
      const pos = geo.attributes.position.array;
      for (let i = 0; i < pos.length; i += 3) {
        const x = base[i], y = base[i + 1];
        pos[i + 2] = Math.sin(x * 0.32 + t * 1.1) * 0.55 + Math.cos(y * 0.42 + t * 0.8) * 0.45;
      }
      geo.attributes.position.needsUpdate = true;

      const pos2 = geo2.attributes.position.array;
      for (let i = 0; i < pos2.length; i += 3) {
        const x = base2[i], y = base2[i + 1];
        pos2[i + 2] = Math.sin(x * 0.22 - t * 0.7) * 0.75 + Math.cos(y * 0.3 + t * 0.5) * 0.55;
      }
      geo2.attributes.position.needsUpdate = true;

      mesh.rotation.z = Math.sin(t * 0.15) * 0.05;
    }
  };
}

/* ════════════════════════════════════════════
   SCENE 5 · ORBITAL
   Shaded metallic core, three tilted torus rings
   and orbiting moons in the brand palette.
════════════════════════════════════════════ */
function buildOrbital(host) {
  const scene = new THREE.Scene();
  const cam = makeCamera(host, 11);
  const group = new THREE.Group();
  scene.add(group);

  scene.add(new THREE.AmbientLight(0xffffff, 0.6));
  const l1 = new THREE.PointLight(PINK, 80, 40);  l1.position.set(6, 6, 8);    scene.add(l1);
  const l2 = new THREE.PointLight(GOLD, 70, 40);  l2.position.set(-7, -5, 6);  scene.add(l2);
  const l3 = new THREE.PointLight(CYAN, 45, 40);  l3.position.set(0, 6, -8);   scene.add(l3);

  const core = new THREE.Mesh(
    new THREE.IcosahedronGeometry(1.5, 3),
    new THREE.MeshStandardMaterial({
      color: 0x100814, roughness: 0.28, metalness: 0.85,
      emissive: new THREE.Color(PINK).multiplyScalar(0.28)
    })
  );
  group.add(core);

  const coreWire = new THREE.Mesh(
    new THREE.IcosahedronGeometry(1.56, 1),
    new THREE.MeshBasicMaterial({ color: CORAL, wireframe: true, transparent: true, opacity: 0.4 })
  );
  group.add(coreWire);

  const rings = [];
  [
    { r: 3.1, tube: 0.028, color: PINK, speed: 0.42,  tiltX: 1.15, tiltY: 0.3 },
    { r: 3.9, tube: 0.024, color: GOLD, speed: -0.30, tiltX: 0.5,  tiltY: 1.1 },
    { r: 4.7, tube: 0.020, color: CYAN, speed: 0.22,  tiltX: 1.5,  tiltY: -0.6 },
  ].forEach(cfg => {
    const ring = new THREE.Mesh(
      new THREE.TorusGeometry(cfg.r, cfg.tube, 8, 180),
      new THREE.MeshBasicMaterial({ color: cfg.color, transparent: true, opacity: 0.55 })
    );
    ring.rotation.x = cfg.tiltX;
    ring.rotation.y = cfg.tiltY;
    group.add(ring);
    rings.push({ ring, speed: cfg.speed });
  });

  const moons = [];
  const moonPalette = [PINK, CORAL, ORANGE, GOLD, CYAN];
  for (let i = 0; i < 9; i++) {
    const m = new THREE.Mesh(
      new THREE.SphereGeometry(rand(0.06, 0.13), 10, 10),
      new THREE.MeshBasicMaterial({ color: moonPalette[i % moonPalette.length], transparent: true, opacity: 0.95 })
    );
    const r = rand(3.0, 5.0);
    const a = Math.random() * Math.PI * 2;
    const y = rand(-1.6, 1.6);
    m.position.set(Math.cos(a) * r, y, Math.sin(a) * r);
    group.add(m);
    moons.push({ m, r, a, y, sp: rand(0.2, 0.55) * (Math.random() < 0.5 ? -1 : 1) });
  }

  return {
    scene, cam,
    update(t) {
      group.rotation.y = t * 0.16;
      group.rotation.x = Math.sin(t * 0.2) * 0.12;
      core.rotation.y = t * 0.35;
      coreWire.rotation.y = -t * 0.28;
      coreWire.rotation.x = t * 0.18;
      rings.forEach(o => { o.ring.rotation.z = t * o.speed; });
      moons.forEach(o => {
        const a = o.a + t * o.sp;
        o.m.position.set(Math.cos(a) * o.r, o.y + Math.sin(t * 0.8 + o.a) * 0.4, Math.sin(a) * o.r);
      });
    }
  };
}

/* ════════════════════════════════════════════
   SCENE 6 · CUBE CLUSTER
   Eighteen floating glowing cubes with edge
   outlines, tinted across the logo palette.
════════════════════════════════════════════ */
function buildCubeCluster(host) {
  const scene = new THREE.Scene();
  const cam = makeCamera(host, 12);
  const group = new THREE.Group();
  scene.add(group);

  scene.add(new THREE.AmbientLight(0xffffff, 0.55));
  const l1 = new THREE.PointLight(PINK, 80, 45);  l1.position.set(8, 8, 10);   scene.add(l1);
  const l2 = new THREE.PointLight(GOLD, 70, 45);  l2.position.set(-9, -6, 7);  scene.add(l2);
  const l3 = new THREE.PointLight(CYAN, 55, 45);  l3.position.set(0, 10, -8);  scene.add(l3);

  const palette = [PINK, CORAL, ORANGE, GOLD];
  const cubes = [];

  for (let i = 0; i < 18; i++) {
    const size = rand(0.35, 1.15);
    const geo = new THREE.BoxGeometry(size, size, size);
    const tint = palette[i % palette.length];
    const cube = new THREE.Mesh(geo, new THREE.MeshStandardMaterial({
      color: 0x140810, roughness: 0.25, metalness: 0.9,
      emissive: new THREE.Color(tint).multiplyScalar(0.18)
    }));
    cube.add(new THREE.LineSegments(
      new THREE.EdgesGeometry(geo),
      new THREE.LineBasicMaterial({ color: tint, transparent: true, opacity: 0.75 })
    ));
    cube.position.set(rand(-6.5, 6.5), rand(-4.2, 4.2), rand(-4.5, 2.0));
    cube.rotation.set(rand(0, Math.PI), rand(0, Math.PI), rand(0, Math.PI));
    group.add(cube);
    cubes.push({
      cube,
      rx: rand(-0.28, 0.28), ry: rand(-0.32, 0.32), rz: rand(-0.2, 0.2),
      floatSpeed: rand(0.4, 1.0), floatAmp: rand(0.15, 0.5),
      baseY: cube.position.y, phase: rand(0, Math.PI * 2)
    });
  }

  return {
    scene, cam,
    update(t) {
      group.rotation.y = t * 0.055;
      cubes.forEach(c => {
        c.cube.rotation.x += c.rx * 0.008;
        c.cube.rotation.y += c.ry * 0.008;
        c.cube.rotation.z += c.rz * 0.008;
        c.cube.position.y = c.baseY + Math.sin(t * c.floatSpeed + c.phase) * c.floatAmp;
      });
    }
  };
}

/* ════════════════════════════════════════════
   SCENE 7 · AI BRAIN
   A procedural artificial brain — two hemisphere
   lobes with a wrinkled cortex of gradient-tinted
   neurons, joined by synapse lines with live
   signal pulses travelling between them. No
   rings, no orbiters — pure AI. Replaces any
   static "team photo" style imagery.
════════════════════════════════════════════ */
function buildAiBrain(host) {
  const scene = new THREE.Scene();
  const cam = makeCamera(host, 9.5);
  const group = new THREE.Group();
  group.rotation.z = -0.05;
  scene.add(group);

  /* ── brain proportions: hemisphere radii (width/height/length) ── */
  const LobeR = new THREE.Vector3(1.28, 1.98, 2.78);
  const GAP = 1.40;        /* hemisphere offset — leaves the midline fissure */
  const WRINKLE = 0.13;    /* cortex fold depth (outward only) */

  const lobePoint = side => {
    const d = new THREE.Vector3().randomDirection();
    /* cortex folds — subtle wrinkle displacement */
    const n = Math.sin(d.x * 9.3) * Math.sin(d.y * 7.1) * Math.sin(d.z * 8.4);
    const r = 1 + (n * 0.5 + 0.5) * WRINKLE;
    return new THREE.Vector3(
      side * GAP + d.x * LobeR.x * r,
      d.y * LobeR.y * r,
      d.z * LobeR.z * r
    );
  };

  /* ── dark cerebral mass — gives the cortex a solid silhouette ── */
  const massMat = new THREE.MeshBasicMaterial({ color: 0x0a0714 });
  for (const side of [-1, 1]) {
    const mass = new THREE.Mesh(new THREE.SphereGeometry(1, 48, 32), massMat);
    mass.scale.set(LobeR.x, LobeR.y, LobeR.z);
    mass.position.x = side * GAP;
    group.add(mass);
  }

  /* ── cortex — neurons on both lobes, tinted along the logo gradient ── */
  const NODES = 340;
  const pts = [];
  const nodePos = new Float32Array(NODES * 3);
  const nodeCol = new Float32Array(NODES * 3);
  for (let i = 0; i < NODES; i++) {
    const side = i % 2 === 0 ? 1 : -1;
    const p = lobePoint(side);
    pts.push(p);
    nodePos.set([p.x, p.y, p.z], i * 3);
    const t = (p.z / LobeR.z + 1) / 2;                  /* front → back */
    const c = gradAt(0.12 + 0.76 * t + Math.random() * 0.08);
    nodeCol.set([c.r, c.g, c.b], i * 3);
  }
  const nodeGeo = new THREE.BufferGeometry();
  nodeGeo.setAttribute('position', new THREE.BufferAttribute(nodePos, 3));
  nodeGeo.setAttribute('color', new THREE.BufferAttribute(nodeCol, 3));
  const cortex = new THREE.Points(nodeGeo, new THREE.PointsMaterial({
    size: 0.115, vertexColors: true, transparent: true, opacity: 0.95,
    sizeAttenuation: true, blending: THREE.AdditiveBlending, depthWrite: false
  }));
  group.add(cortex);

  /* ── synapses — near-neighbour connections ── */
  const edges = [];
  const segPts = [];
  const THRESH = 0.95;
  for (let i = 0; i < NODES; i++) {
    for (let j = i + 1; j < NODES; j++) {
      if (pts[i].distanceTo(pts[j]) < THRESH) {
        edges.push([i, j]);
        segPts.push(pts[i], pts[j]);
      }
    }
  }
  const synGeo = new THREE.BufferGeometry().setFromPoints(segPts);
  const synMat = new THREE.LineBasicMaterial({
    color: PINK, transparent: true, opacity: 0.13,
    blending: THREE.AdditiveBlending, depthWrite: false
  });
  group.add(new THREE.LineSegments(synGeo, synMat));

  /* ── live signals — bright pulses travelling along the synapses ── */
  const SIG = 30;
  const sigPos = new Float32Array(SIG * 3);
  const sigCol = new Float32Array(SIG * 3);
  const sigGeo = new THREE.BufferGeometry();
  sigGeo.setAttribute('position', new THREE.BufferAttribute(sigPos, 3));
  sigGeo.setAttribute('color', new THREE.BufferAttribute(sigCol, 3));
  const signals = new THREE.Points(sigGeo, new THREE.PointsMaterial({
    size: 0.17, vertexColors: true, transparent: true, opacity: 0.95,
    sizeAttenuation: true, blending: THREE.AdditiveBlending, depthWrite: false
  }));
  group.add(signals);

  const sigPalette = [CYAN2, GOLD, 0xffffff, CORAL].map(c => new THREE.Color(c));
  const pulses = [];
  const respawn = (s, t) => {
    s.e  = edges[(Math.random() * edges.length) | 0];
    s.t0 = t;
    s.sp = rand(0.45, 1.3);
    s.c  = sigPalette[(Math.random() * sigPalette.length) | 0];
  };
  for (let i = 0; i < SIG; i++) { const s = {}; respawn(s, 0); pulses.push(s); }

  /* ── soft halo — the "mind" glow ── */
  const halo = new THREE.Mesh(
    new THREE.SphereGeometry(1, 32, 24),
    new THREE.MeshBasicMaterial({
      color: PINK, transparent: true, opacity: 0.05,
      blending: THREE.AdditiveBlending, depthWrite: false
    })
  );
  halo.scale.setScalar(3.6);
  group.add(halo);

  const dust = makeDust(scene, 90, 5.5);

  return {
    scene, cam,
    update(t) {
      group.rotation.y = t * 0.22;
      group.rotation.x = Math.sin(t * 0.3) * 0.08;
      group.position.y = Math.sin(t * 0.5) * 0.18;

      cortex.material.opacity = 0.8 + Math.sin(t * 1.9) * 0.15;
      synMat.opacity = 0.10 + Math.sin(t * 1.3) * 0.045;
      halo.scale.setScalar(3.6 + Math.sin(t * 1.1) * 0.25);

      const pa = sigGeo.attributes.position;
      const ca = sigGeo.attributes.color;
      for (let i = 0; i < SIG; i++) {
        const s = pulses[i];
        let p = (t - s.t0) * s.sp;
        if (p >= 1 || p < 0) { respawn(s, t); p = 0; }
        const a = pts[s.e[0]], b = pts[s.e[1]];
        pa.setXYZ(i, a.x + (b.x - a.x) * p, a.y + (b.y - a.y) * p, a.z + (b.z - a.z) * p);
        ca.setXYZ(i, s.c.r, s.c.g, s.c.b);
      }
      pa.needsUpdate = true;
      ca.needsUpdate = true;

      dust.rotation.y = t * 0.012;
    }
  };
}

/* ════════════════════════════════════════════
   SCENE 8 · PARTICLE FLOW
   Streams of gradient-tinted data packets racing
   along procedural wave curves — cyan guide
   lines threading the flow together.
════════════════════════════════════════════ */
function buildParticleFlow(host) {
  const scene = new THREE.Scene();
  const cam = makeCamera(host, 13);
  const group = new THREE.Group();
  scene.add(group);

  const STREAMS = 8, PER_STREAM = 80;
  const streams = [];

  for (let s = 0; s < STREAMS; s++) {
    const pts = [];
    const amp = rand(0.8, 2.4);
    const freq = rand(0.45, 1.1);
    const ph = rand(0, Math.PI * 2);
    const z = rand(-6, 1.5);
    for (let i = 0; i <= 9; i++) {
      const x = -15 + 30 * (i / 9);
      pts.push(new THREE.Vector3(
        x,
        Math.sin(i * freq + ph) * amp + rand(-0.5, 0.5),
        z + Math.cos(i * 0.65 + ph) * 1.6
      ));
    }
    const curve = new THREE.CatmullRomCurve3(pts);

    group.add(new THREE.Line(
      new THREE.BufferGeometry().setFromPoints(curve.getPoints(110)),
      new THREE.LineBasicMaterial({ color: s % 3 === 2 ? CYAN : PINK, transparent: true, opacity: 0.07 })
    ));

    const pos = new Float32Array(PER_STREAM * 3);
    const col = new Float32Array(PER_STREAM * 3);
    for (let i = 0; i < PER_STREAM; i++) {
      const c = gradAt((s / STREAMS) * 0.6 + (i / PER_STREAM) * 0.4);
      col.set([c.r, c.g, c.b], i * 3);
    }
    const geo = new THREE.BufferGeometry();
    geo.setAttribute('position', new THREE.BufferAttribute(pos, 3));
    geo.setAttribute('color', new THREE.BufferAttribute(col, 3));
    group.add(new THREE.Points(geo, new THREE.PointsMaterial({
      size: 0.075, vertexColors: true, transparent: true, opacity: 0.95,
      sizeAttenuation: true, blending: THREE.AdditiveBlending, depthWrite: false
    })));
    streams.push({ curve, geo, count: PER_STREAM, speed: rand(0.05, 0.14) * (s % 2 ? -1 : 1) });
  }

  const dust = makeDust(scene, 160, 12);

  return {
    scene, cam,
    update(t) {
      group.rotation.z = Math.sin(t * 0.07) * 0.05;
      streams.forEach(st => {
        const attr = st.geo.attributes.position;
        for (let i = 0; i < st.count; i++) {
          let u = (i / st.count + t * st.speed) % 1;
          if (u < 0) u += 1;
          const p = st.curve.getPoint(u);
          attr.setXYZ(i, p.x, p.y, p.z);
        }
        attr.needsUpdate = true;
      });
      dust.rotation.y = t * 0.01;
    }
  };
}

/* ════════════════════════════════════════════
   REGISTRY + BOOT + SHARED LOOP
════════════════════════════════════════════ */
const BUILDERS = {
  'neural-core':   buildNeuralCore,
  'data-sphere':   buildDataSphere,
  'helix':         buildHelix,
  'grid-wave':     buildGridWave,
  'orbital':       buildOrbital,
  'cube-cluster':  buildCubeCluster,
  'ai-brain':      buildAiBrain,
  'particle-flow': buildParticleFlow
};

const instances = [];

if (!REDUCED) {
  document.querySelectorAll('.fx-host').forEach(host => {
    const build = BUILDERS[host.dataset.scene];
    if (!build) return;

    let built;
    try { built = build(host); }
    catch (err) { console.warn('[fx] scene build failed:', host.dataset.scene, err); return; }

    let renderer;
    try { renderer = makeRenderer(host); }
    catch (err) { console.warn('[fx] WebGL unavailable:', err); return; }

    const inst = {
      host, renderer, visible: false,
      lookAt: built.lookAt || new THREE.Vector3(0, 0, 0),
      baseY: built.cam.position.y,
      scene: built.scene, cam: built.cam, update: built.update
    };
    instances.push(inst);

    /* only render while on screen */
    if ('IntersectionObserver' in window) {
      const io = new IntersectionObserver(entries => {
        entries.forEach(e => { inst.visible = e.isIntersecting; });
      }, { rootMargin: '180px' });
      io.observe(host);
    } else {
      inst.visible = true;
    }

    /* resize with the host */
    if ('ResizeObserver' in window) {
      new ResizeObserver(() => {
        const w = host.clientWidth, h = host.clientHeight;
        if (!w || !h) return;
        renderer.setSize(w, h, false);
        built.cam.aspect = w / h;
        built.cam.updateProjectionMatrix();
      }).observe(host);
    }
    const w0 = host.clientWidth, h0 = host.clientHeight;
    if (w0 && h0) {
      renderer.setSize(w0, h0, false);
      built.cam.aspect = w0 / h0;
      built.cam.updateProjectionMatrix();
    }
  });

  if (instances.length) {
    /* gentle pointer parallax */
    const pointer = { x: 0, y: 0, tx: 0, ty: 0 };
    window.addEventListener('pointermove', e => {
      pointer.tx = (e.clientX / window.innerWidth - 0.5) * 2;
      pointer.ty = (e.clientY / window.innerHeight - 0.5) * 2;
    }, { passive: true });

    const clock = new THREE.Clock();
    let rafId = null;

    function loop() {
      rafId = requestAnimationFrame(loop);
      const t = clock.getElapsedTime();

      pointer.x += (pointer.tx - pointer.x) * 0.045;
      pointer.y += (pointer.ty - pointer.y) * 0.045;

      for (let i = 0; i < instances.length; i++) {
        const inst = instances[i];
        if (!inst.visible) continue;
        inst.update(t);
        inst.cam.position.x = pointer.x * 0.55;
        inst.cam.position.y = inst.baseY + pointer.y * 0.35;
        inst.cam.lookAt(inst.lookAt);
        inst.renderer.render(inst.scene, inst.cam);
      }
    }
    loop();

    /* pause the shared loop while the tab is hidden */
    document.addEventListener('visibilitychange', () => {
      if (document.hidden) {
        if (rafId) { cancelAnimationFrame(rafId); rafId = null; }
      } else if (!rafId) {
        clock.getDelta();
        loop();
      }
    });
  }
}
</script>

<!-- ══════════════════════════════════════════
     SHARED UI SCRIPT
     Typing · reveal observer · counters · card
     tilt · header scroll shadow · active nav ·
     mobile menu · portfolio filter · smooth
     anchors · contact form validation
══════════════════════════════════════════ -->
<script>
(function () {
  'use strict';
  var d = document;

  /* ── Header: scroll shadow ─────────────── */
  var hdr = d.getElementById('siteHeader');
  if (hdr) {
    var onScroll = function () {
      var s = window.scrollY > 40;
      hdr.classList.toggle('scrolled', s);
      hdr.style.boxShadow = s ? '0 18px 44px -26px rgba(0,0,0,.95)' : 'none';
    };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  }

  /* ── Active nav link ───────────────────── */
  var page = location.pathname.split('/').pop() || 'index.php';
  d.querySelectorAll('.main-nav a, .mob-nav a').forEach(function (a) {
    var href = (a.getAttribute('href') || '').split('/').pop();
    if (href === page || (page === '' && href === 'index.php')) {
      a.classList.add('active');
    }
  });

  /* ── Mobile hamburger ──────────────────── */
  var ham = d.getElementById('hamburger');
  var mob = d.getElementById('mobileMenu');
  if (ham && mob) {
    var closeMob = function () {
      mob.classList.remove('open');
      ham.classList.remove('open');
      ham.setAttribute('aria-expanded', 'false');
      d.body.style.overflow = '';
    };
    ham.addEventListener('click', function (e) {
      e.stopPropagation();
      var open = mob.classList.toggle('open');
      ham.classList.toggle('open', open);
      ham.setAttribute('aria-expanded', String(open));
      d.body.style.overflow = open ? 'hidden' : '';
    });
    mob.querySelectorAll('a').forEach(function (a) {
      a.addEventListener('click', closeMob);
    });
    d.addEventListener('click', function (e) {
      if (mob.classList.contains('open') && !mob.contains(e.target) && !ham.contains(e.target)) {
        closeMob();
      }
    });
    d.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && mob.classList.contains('open')) closeMob();
    });
  }

  /* ── Typing animation ──────────────────── */
  var typingEl = d.getElementById('typingText');
  if (typingEl) {
    var words = ['Solutions', 'Experiences', 'That Convert', 'That Scale', 'With Precision', 'For Tomorrow'];
    var wi = 0, ci = 0, deleting = false;
    var typeLoop = function () {
      var word = words[wi];
      if (!deleting) {
        typingEl.textContent = word.substring(0, ++ci);
        if (ci === word.length) { deleting = true; return setTimeout(typeLoop, 2200); }
        setTimeout(typeLoop, 95);
      } else {
        typingEl.textContent = word.substring(0, --ci);
        if (ci === 0) { deleting = false; wi = (wi + 1) % words.length; return setTimeout(typeLoop, 400); }
        setTimeout(typeLoop, 45);
      }
    };
    setTimeout(typeLoop, 800);
  }

  /* ── Scroll reveal ─────────────────────── */
  var revEls = d.querySelectorAll('[data-reveal]');
  if (revEls.length && 'IntersectionObserver' in window) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) {
        if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target); }
      });
    }, { threshold: 0.12, rootMargin: '0px 0px -8% 0px' });
    revEls.forEach(function (el) { io.observe(el); });
  } else {
    revEls.forEach(function (el) { el.classList.add('in'); });
  }

  /* ── Animated counters ─────────────────── */
  var easeOut = function (t) { return 1 - Math.pow(1 - t, 3); };
  var animateCount = function (node) {
    var target = parseFloat(node.dataset.count) || 0;
    var suffix = node.dataset.suffix || '';
    var dur = 1800;
    var start = performance.now();
    var step = function (now) {
      var p = Math.min((now - start) / dur, 1);
      node.textContent = Math.round(target * easeOut(p)) + suffix;
      if (p < 1) requestAnimationFrame(step);
      else node.textContent = target + suffix;
    };
    requestAnimationFrame(step);
  };
  var counters = d.querySelectorAll('[data-count]');
  if (counters.length && 'IntersectionObserver' in window) {
    var co = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) {
        if (e.isIntersecting) { animateCount(e.target); co.unobserve(e.target); }
      });
    }, { threshold: 0.5 });
    counters.forEach(function (n) { co.observe(n); });
  } else {
    counters.forEach(animateCount);
  }

  /* ── Card tilt + cursor glow ───────────── */
  var fine = window.matchMedia('(hover: hover) and (pointer: fine)').matches;
  var reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if (fine && !reducedMotion) {
    d.querySelectorAll('[data-tilt]').forEach(function (card) {
      var raf = null;
      var onMove = function (e) {
        var r = card.getBoundingClientRect();
        var px = (e.clientX - r.left) / r.width;
        var py = (e.clientY - r.top) / r.height;
        card.style.setProperty('--mx', (px * 100) + '%');
        card.style.setProperty('--my', (py * 100) + '%');
        if (raf) return;
        raf = requestAnimationFrame(function () {
          var rx = (0.5 - py) * 7;
          var ry = (px - 0.5) * 9;
          card.style.transform = 'perspective(1000px) rotateX(' + rx + 'deg) rotateY(' + ry + 'deg) translateY(-6px)';
          raf = null;
        });
      };
      var onLeave = function () {
        if (raf) { cancelAnimationFrame(raf); raf = null; }
        card.style.transform = '';
      };
      card.addEventListener('pointermove', onMove);
      card.addEventListener('pointerleave', onLeave);
    });
  }

  /* ── Portfolio filter ──────────────────── */
  var btns = d.querySelectorAll('.filter-btn');
  var cards = d.querySelectorAll('.pf-card');
  var noRes = d.getElementById('noResults');
  if (btns.length && cards.length) {
    btns.forEach(function (btn) {
      btn.addEventListener('click', function () {
        btns.forEach(function (b) { b.classList.remove('active'); });
        btn.classList.add('active');
        var filter = btn.getAttribute('data-filter') || 'all';
        var vis = 0;
        cards.forEach(function (card) {
          var cat = card.getAttribute('data-category') || '';
          var show = filter === 'all' || cat === filter;
          if (show) { card.classList.remove('pf-hidden'); vis++; }
          else card.classList.add('pf-hidden');
        });
        if (noRes) noRes.style.display = vis === 0 ? 'block' : 'none';
      });
    });
  }

  /* ── Smooth anchor scroll ──────────────── */
  d.querySelectorAll('a[href^="#"]').forEach(function (a) {
    a.addEventListener('click', function (e) {
      var id = a.getAttribute('href');
      if (id === '#') return;
      var t = d.querySelector(id);
      if (t) { e.preventDefault(); t.scrollIntoView({ behavior: 'smooth', block: 'start' }); }
    });
  });

  /* ── Contact form validation ───────────── */
  var cf = d.getElementById('contactForm');
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
        var errEl = d.getElementById('formError');
        if (errEl) {
          errEl.classList.add('show');
          setTimeout(function () { errEl.classList.remove('show'); }, 5000);
        }
        var first = cf.querySelector('.error');
        if (first) first.scrollIntoView({ behavior: 'smooth', block: 'center' });
      }
    });
    cf.querySelectorAll('input,textarea,select').forEach(function (f) {
      f.addEventListener('input', function () { f.classList.remove('error'); });
    });
  }
})();
</script>
</body>
</html>
