<?php
/**
 * includes/service-objects.php — Softex Technologies v6
 * Reusable CSS-3D service visuals. Pure markup + CSS depth
 * (no JS required to display; JS adds cursor tilt & extra motion).
 *
 * Usage:  render_service_object('web');            // card size
 *         render_service_object('web', true);      // large (services page)
 */

if (!function_exists('render_service_object')) {

  function render_service_object($type, $large = false) {
    $cls = 'svc-obj obj-3d-' . htmlspecialchars($type) . ($large ? ' obj-lg' : '');
    echo '<div class="' . $cls . '" aria-hidden="true"><div class="o3d">';

    switch ($type) {

      /* ── Web Development — 3D browser window ─────────────── */
      case 'web':
        echo '<div class="b3d">'
           . '<div class="b3d-bar"><i></i><i></i><i></i><span class="b3d-url"></span></div>'
           . '<div class="b3d-screen">'
           . '<div class="b3d-l l1"></div>'
           . '<div class="b3d-l l2"></div>'
           . '<div class="b3d-l l3"></div>'
           . '<div class="b3d-cards"><i></i><i></i><i></i></div>'
           . '</div></div>';
        break;

      /* ── Software Development — modular architecture ─────── */
      case 'software':
        echo '<div class="blk3d">'
           . '<span class="blk-link ln1"></span><span class="blk-link ln2"></span>'
           . '<span class="blk-link ln3"></span><span class="blk-link ln4"></span>'
           . '<span class="blk b6"></span>'
           . '<span class="blk b1"></span><span class="blk b2"></span><span class="blk b3"></span>'
           . '<span class="blk b4"></span><span class="blk b5"></span>'
           . '</div>';
        break;

      /* ── Mobile Apps — 3D smartphone ─────────────────────── */
      case 'apps':
        echo '<div class="ph3d"><div class="ph-halo"></div><div class="ph-body">'
           . '<div class="ph-notch"></div>'
           . '<div class="ph-screen">'
           . '<div class="ph-row hl"></div><div class="ph-row sm"></div><div class="ph-row sm2"></div>'
           . '<div class="ph-cards"><i></i><i></i></div>'
           . '</div>'
           . '<div class="ph-screen-alt">'
           . '<div class="ph-row hl" style="background:linear-gradient(135deg,rgba(55,211,230,.55),rgba(139,92,246,.35))"></div>'
           . '<div class="ph-cards alt"><i></i><i></i></div>'
           . '<div class="ph-row sm"></div><div class="ph-row sm2"></div>'
           . '</div>'
           . '<div class="ph-home"></div>'
           . '</div></div>';
        break;

      /* ── E-Commerce — floating product environment ───────── */
      case 'ecommerce':
        echo '<div class="cart3d">'
           . '<div class="pbox"><div class="pface"></div><div class="pface top"></div><div class="pface side"></div></div>'
           . '<div class="ptag">-20%</div>'
           . '<span class="pcoin pc1"></span><span class="pcoin pc2"></span>'
           . '<div class="pgrid"><i class="on"></i><i></i><i></i><i></i></div>'
           . '</div>';
        break;

      /* ── SEO & Marketing — 3D analytics dashboard ────────── */
      case 'seo':
        echo '<div class="chart3d">'
           . '<div class="cfloor"></div>'
           . '<div class="cbar cb1"></div><div class="cbar cb2"></div>'
           . '<div class="cbar cb3"></div><div class="cbar cb4"></div>'
           . '<svg class="cspark" viewBox="0 0 140 40" preserveAspectRatio="none">'
           . '<defs><linearGradient id="sparkGrad" x1="0" y1="0" x2="1" y2="0">'
           . '<stop offset="0" stop-color="#ff4d3e"/><stop offset="1" stop-color="#ffb648"/>'
           . '</linearGradient></defs>'
           . '<path d="M2,34 C20,30 28,22 44,24 C60,26 66,12 84,14 C102,16 112,6 138,4"/>'
           . '</svg>'
           . '<span class="cdot"></span>'
           . '</div>';
        break;

      /* ── UI/UX Design — overlapping interface layers ─────── */
      case 'uiux':
        echo '<div class="lay3d">'
           . '<div class="lay lay1"><i class="lh"></i><i class="ls"></i><i class="ls2"></i></div>'
           . '<div class="lay lay2"><i class="lh"></i><i class="ls"></i><i class="ls2"></i></div>'
           . '<div class="lay lay3"><i class="lh"></i><i class="ls"></i><i class="ls2"></i></div>'
           . '</div>';
        break;

      /* ── Shopify — commerce interface ────────────────────── */
      case 'shopify':
        echo '<div class="shop3d">'
           . '<div class="awning"></div>'
           . '<div class="sgrid"><i class="on"></i><i></i><i></i><i></i><i class="on"></i><i></i></div>'
           . '<div class="sbar"></div>'
           . '</div>';
        break;

      /* ── AI Solutions — layered neural network ───────────── */
      case 'ai':
        echo '<div class="nn3d">'
           . '<div class="nn-core" aria-hidden="true"></div>'
           . '<svg class="nn-web" viewBox="0 0 150 120" preserveAspectRatio="none" aria-hidden="true">'
           . '<defs><linearGradient id="nnGrad" x1="0" y1="0" x2="1" y2="0">'
           . '<stop offset="0" stop-color="#ff4d3e"/><stop offset="1" stop-color="#ffb648"/>'
           . '</linearGradient></defs>'
           /* input → hidden */
           . '<line x1="16" y1="22" x2="75" y2="14"/><line x1="16" y1="22" x2="75" y2="45"/>'
           . '<line x1="16" y1="22" x2="75" y2="75" class="hot"/><line x1="16" y1="22" x2="75" y2="106"/>'
           . '<line x1="16" y1="60" x2="75" y2="14"/><line x1="16" y1="60" x2="75" y2="45" class="hot"/>'
           . '<line x1="16" y1="60" x2="75" y2="75"/><line x1="16" y1="60" x2="75" y2="106"/>'
           . '<line x1="16" y1="98" x2="75" y2="14"/><line x1="16" y1="98" x2="75" y2="45"/>'
           . '<line x1="16" y1="98" x2="75" y2="75"/><line x1="16" y1="98" x2="75" y2="106" class="hot"/>'
           /* hidden → output */
           . '<line x1="75" y1="14" x2="134" y2="36"/><line x1="75" y1="14" x2="134" y2="84"/>'
           . '<line x1="75" y1="45" x2="134" y2="36" class="hot"/><line x1="75" y1="45" x2="134" y2="84"/>'
           . '<line x1="75" y1="75" x2="134" y2="36"/><line x1="75" y1="75" x2="134" y2="84" class="hot"/>'
           . '<line x1="75" y1="106" x2="134" y2="36"/><line x1="75" y1="106" x2="134" y2="84"/>'
           . '</svg>'
           . '<span class="nn-node in1"></span><span class="nn-node in2"></span><span class="nn-node in3"></span>'
           . '<span class="nn-node h1"></span><span class="nn-node h2"></span><span class="nn-node h3"></span><span class="nn-node h4"></span>'
           . '<span class="nn-node o1"></span><span class="nn-node o2"></span>'
           . '</div>';
        break;
    }

    echo '</div></div>';
  }
}
