<?php
/**
 * includes/header.php — Softex Technologies v6 (3D Digital Experience)
 * New PNG logo · Heavy SEO · Schema.org · Self-hosted fonts & icons
 * SEO metadata, schema markup and navigation structure preserved from v5.
 */
$_pt = isset($pageTitle)
  ? $pageTitle . ' | Softex Technologies Pakistan'
  : 'Softex Technologies | Web Design, Software Development & AI Solutions Pakistan';
$_pd = $pageDesc    ?? 'Softex Technologies — Pakistan\'s leading web design, software development, mobile app & AI solutions company in Lahore. 150+ projects delivered since 2015. Serving clients globally.';
$_pk = $pageKeywords ?? 'web design Pakistan, software development Lahore, mobile app development Pakistan, AI solutions, e-commerce development, Shopify WooCommerce Pakistan, SEO digital marketing, Softex Technologies';
$_can = 'https://www.softex.pk' . strtok($_SERVER['REQUEST_URI'], '?');
$_pg  = basename($_SERVER['PHP_SELF'], '.php');

// ── Schema: Organization
$schema_org = json_encode([
  '@context'=>'https://schema.org','@type'=>'Organization',
  'name'=>'Softex Technologies','url'=>'https://www.softex.pk',
  'logo'=>'https://www.softex.pk/assets/logo.png',
  'image'=>'https://www.softex.pk/assets/logo.png',
  'description'=>'Pakistan\'s leading web design, software development, mobile apps and AI solutions company based in Lahore.',
  'foundingDate'=>'2015',
  'numberOfEmployees'=>'20',
  'address'=>['@type'=>'PostalAddress','addressLocality'=>'Lahore','addressRegion'=>'Punjab','addressCountry'=>'PK'],
  'contactPoint'=>['@type'=>'ContactPoint','telephone'=>'+92-345-0789192','contactType'=>'customer service','email'=>'info@softex.pk','availableLanguage'=>['English','Urdu']],
  'sameAs'=>['https://www.facebook.com/softexpak/','https://twitter.com/softexpak/','https://www.instagram.com/sotexpak/','https://www.linkedin.com/company/sotexpak/'],
  'areaServed'=>['Pakistan','United States','United Kingdom','Canada','Australia'],
  'priceRange'=>'$$',
  'award'=>['SEO Company Badge 2019','The Landy Award'],
]);

// ── Schema: LocalBusiness
$schema_local = json_encode([
  '@context'=>'https://schema.org',
  '@type'=>['LocalBusiness','ProfessionalService'],
  'name'=>'Softex Technologies',
  'url'=>'https://www.softex.pk',
  'telephone'=>'+92-345-0789192',
  'email'=>'info@softex.pk',
  'image'=>'https://www.softex.pk/assets/logo.png',
  'address'=>['@type'=>'PostalAddress','streetAddress'=>'Lahore','addressLocality'=>'Lahore','addressRegion'=>'Punjab','addressCountry'=>'PK'],
  'geo'=>['@type'=>'GeoCoordinates','latitude'=>'31.5204','longitude'=>'74.3587'],
  'openingHoursSpecification'=>[['@type'=>'OpeningHoursSpecification','dayOfWeek'=>['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'],'opens'=>'09:00','closes'=>'18:00']],
  'aggregateRating'=>['@type'=>'AggregateRating','ratingValue'=>'5','reviewCount'=>'47','bestRating'=>'5'],
  'priceRange'=>'$$',
]);

// ── Schema: WebSite (homepage only)
$schema_web = ($_pg==='index') ? json_encode([
  '@context'=>'https://schema.org','@type'=>'WebSite',
  'name'=>'Softex Technologies','url'=>'https://www.softex.pk',
  'description'=>'Pakistan\'s leading AI-powered web design and software development company',
  'potentialAction'=>['@type'=>'SearchAction','target'=>'https://www.softex.pk/portfolio.php?q={search_term_string}','query-input'=>'required name=search_term_string'],
]) : null;

// ── Schema: Breadcrumb
$bc_map = [
  'about'=>[['Home','https://www.softex.pk'],['About Us','https://www.softex.pk/about.php']],
  'services'=>[['Home','https://www.softex.pk'],['Services','https://www.softex.pk/services.php']],
  'portfolio'=>[['Home','https://www.softex.pk'],['Portfolio','https://www.softex.pk/portfolio.php']],
  'contact'=>[['Home','https://www.softex.pk'],['Contact','https://www.softex.pk/contact.php']],
];
$schema_bc = null;
if (isset($bc_map[$_pg])) {
  $items = [];
  foreach ($bc_map[$_pg] as $i => $b) {
    $items[] = ['@type'=>'ListItem','position'=>$i+1,'name'=>$b[0],'item'=>$b[1]];
  }
  $schema_bc = json_encode(['@context'=>'https://schema.org','@type'=>'BreadcrumbList','itemListElement'=>$items]);
}
?>
<!DOCTYPE html>
<html lang="en" prefix="og: https://ogp.me/ns#" class="no-js">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<script>document.documentElement.classList.replace('no-js','js');</script>

<meta name="theme-color" content="#04050A">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-capable" content="yes">

<!-- ═══ Primary SEO ════════════════════════ -->
<title><?= htmlspecialchars($_pt) ?></title>
<meta name="description"   content="<?= htmlspecialchars($_pd) ?>">
<meta name="keywords"      content="<?= htmlspecialchars($_pk) ?>">
<meta name="author"        content="Softex Technologies">
<meta name="robots"        content="index,follow,max-image-preview:large,max-snippet:-1,max-video-preview:-1">
<meta name="googlebot"     content="index,follow">
<meta name="revisit-after" content="5 days">
<meta name="language"      content="English">
<meta name="rating"        content="general">
<meta name="geo.region"    content="PK-PB">
<meta name="geo.placename" content="Lahore, Pakistan">
<meta name="geo.position"  content="31.5204;74.3587">
<meta name="ICBM"          content="31.5204, 74.3587">
<meta name="copyright"     content="Softex Technologies 2015-<?= date('Y') ?>">
<meta name="category"      content="Web Design, Software Development, AI Solutions">
<meta name="classification" content="Business">
<meta name="coverage"      content="Worldwide">
<meta name="distribution"  content="Global">
<meta name="target"        content="all">
<link rel="canonical"      href="<?= htmlspecialchars($_can) ?>">

<!-- ═══ Open Graph ═════════════════════════ -->
<meta property="og:type"         content="website">
<meta property="og:site_name"    content="Softex Technologies">
<meta property="og:title"        content="<?= htmlspecialchars($_pt) ?>">
<meta property="og:description"  content="<?= htmlspecialchars($_pd) ?>">
<meta property="og:url"          content="<?= htmlspecialchars($_can) ?>">
<meta property="og:image"        content="https://www.softex.pk/assets/logo.png">
<meta property="og:image:width"  content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt"    content="Softex Technologies — AI-Powered Web & Software Development">
<meta property="og:locale"       content="en_US">

<!-- ═══ Twitter Card ══════════════════════ -->
<meta name="twitter:card"        content="summary_large_image">
<meta name="twitter:site"        content="@softexpak">
<meta name="twitter:creator"     content="@softexpak">
<meta name="twitter:title"       content="<?= htmlspecialchars($_pt) ?>">
<meta name="twitter:description" content="<?= htmlspecialchars($_pd) ?>">
<meta name="twitter:image"       content="https://www.softex.pk/assets/logo.png">

<!-- ═══ Favicon ════════════════════════════ -->
<link rel="icon"             type="image/png"  href="assets/softex_vertical_pp.png">
<link rel="shortcut icon"    type="image/png"  href="assets/softex_vertical_pp.png">
<link rel="apple-touch-icon"                   href="assets/softex_vertical_pp.png">
<meta name="msapplication-TileImage"           content="assets/softex_vertical_pp.png">
<meta name="msapplication-TileColor"           content="#ff4d3e">
<meta name="theme-color"                       content="#04050A">

<!-- ═══ Alternate / hreflang ══════════════ -->
<link rel="alternate" hreflang="en"        href="<?= htmlspecialchars($_can) ?>">
<link rel="alternate" hreflang="x-default" href="<?= htmlspecialchars($_can) ?>">

<!-- ═══ Schema.org ════════════════════════ -->
<script type="application/ld+json"><?= $schema_org ?></script>
<script type="application/ld+json"><?= $schema_local ?></script>
<?php if($schema_web): ?><script type="application/ld+json"><?= $schema_web ?></script><?php endif; ?>
<?php if($schema_bc):  ?><script type="application/ld+json"><?= $schema_bc ?></script><?php endif; ?>

<!-- ═══ Styles (self-hosted — no third-party requests) ═══ -->
<link rel="preload" as="font" type="font/woff2" href="fonts/exo-2-latin-wght-normal.woff2" crossorigin>
<link rel="preload" as="font" type="font/woff2" href="fonts/space-grotesk-latin-wght-normal.woff2" crossorigin>
<link rel="stylesheet" href="css/fonts.css">
<link rel="stylesheet" href="css/fontawesome.min.css">
<link rel="stylesheet" href="css/style.css">
</head>
<body class="pg-<?= htmlspecialchars($_pg) ?>" data-page="<?= htmlspecialchars($_pg) ?>">

<a class="skip-link" href="#main-content">Skip to content</a>

<!-- ══════════════════════════════════════════
     PRELOADER — real logo · orbiting ring · progress
     (skipped on repeat visits within the session)
══════════════════════════════════════════ -->
<div id="preloader" aria-hidden="true">
  <div class="pl-inner">
    <div class="pl-core">
      <div class="pl-ring r1"></div>
      <div class="pl-ring r2"></div>
      <div class="pl-ring r3"></div>
      <img class="pl-logo" src="assets/logo.png" alt="">
    </div>
    <div class="pl-bar"><span class="pl-fill"></span></div>
    <div class="pl-status">Initialising digital experience</div>
  </div>
</div>

<!-- ══════════════════════════════════════════
     CUSTOM CURSOR (desktop only, enabled by JS)
══════════════════════════════════════════ -->
<div class="cursor-dot" id="cursorDot" aria-hidden="true"></div>
<div class="cursor-ring" id="cursorRing" aria-hidden="true"></div>

<!-- ══════════════════════════════════════════
     GLOBAL DIGITAL ATMOSPHERE (subtle particle field)
══════════════════════════════════════════ -->
<canvas id="atmosphere" class="atmosphere" data-scene="atmosphere" aria-hidden="true"></canvas>

<!-- ══════════════════════════════════════════
     SITE HEADER
══════════════════════════════════════════ -->
<header class="site-header" id="siteHeader" role="banner">
  <div class="wrap">
    <div class="header-inner">

      <a href="index.php" class="logo" aria-label="Softex Technologies — Home">
        <img class="logo-img" src="assets/logo.png" alt="Softex Technologies" width="auto" height="44">
      </a>

      <nav class="main-nav" role="navigation" aria-label="Main navigation">
        <a href="index.php">Home</a>
        <a href="about.php">About</a>
        <a href="services.php">Services</a>
        <a href="portfolio.php">Portfolio</a>
        <a href="contact.php">Contact</a>
      </nav>

      <div class="hdr-cta">
        <a href="tel:+923450789192" class="hdr-phone">
          <i class="fas fa-phone"></i> +92 345 0789192
        </a>
        <a href="contact.php" class="btn btn-primary">
          Start a Project <i class="fas fa-arrow-right"></i>
        </a>
      </div>

      <button class="hamburger" id="hamburger"
              aria-label="Toggle menu" aria-expanded="false" aria-controls="mobileMenu">
        <span></span><span></span><span></span>
      </button>

    </div>
  </div>
</header>

<nav class="mob-nav" id="mobileMenu" role="navigation" aria-label="Mobile navigation">
  <a href="index.php"><i class="fas fa-home" style="color:var(--or);width:18px"></i>&nbsp; Home</a>
  <a href="about.php"><i class="fas fa-users" style="color:var(--or);width:18px"></i>&nbsp; About Us</a>
  <a href="services.php"><i class="fas fa-code" style="color:var(--or);width:18px"></i>&nbsp; Services</a>
  <a href="portfolio.php"><i class="fas fa-briefcase" style="color:var(--or);width:18px"></i>&nbsp; Portfolio</a>
  <a href="contact.php"><i class="fas fa-envelope" style="color:var(--or);width:18px"></i>&nbsp; Contact</a>
  <a href="contact.php" class="btn btn-primary btn-block" style="justify-content:center">
    <i class="fas fa-rocket"></i> Start a Project
  </a>
</nav>
