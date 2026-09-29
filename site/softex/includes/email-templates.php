<?php
/**
 * includes/email-templates.php
 * buildAdminEmail()  → notification to info@softex.pk
 * buildClientEmail() → confirmation to visitor
 */

function buildAdminEmail(array $d): string {
  $ts   = date('l, F j, Y \a\t g:i A');
  $name = htmlspecialchars($d['name']);
  $email= htmlspecialchars($d['email']);
  $ph   = $d['phone'] ?: '<span style="color:#475569">Not provided</span>';
  $svc  = htmlspecialchars($d['service']);
  $sub  = htmlspecialchars($d['subject']);
  $msg  = nl2br(htmlspecialchars($d['message']));
  $yr   = $d['year'];

  return <<<HTML
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>New Enquiry — Softex</title></head>
<body style="margin:0;padding:0;background:#020308;font-family:'Segoe UI',Arial,sans-serif">
<div style="display:none;max-height:0;overflow:hidden">New enquiry from {$name}: {$sub}</div>
<table width="100%" cellpadding="0" cellspacing="0" style="background:#020308;padding:28px 14px">
<tr><td align="center">
<table width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%">

<!-- Header -->
<tr><td style="border-radius:16px 16px 0 0;overflow:hidden">
  <div style="height:3px;background:linear-gradient(90deg,#c2510a,#f97316,#fb923c,#06b6d4,#f97316,#c2510a)"></div>
  <div style="background:linear-gradient(135deg,#05080f 0%,#0d1525 100%);padding:24px 32px">
    <table width="100%" cellpadding="0" cellspacing="0"><tr>
      <td>
        <div style="display:inline-block;background:linear-gradient(135deg,#f97316,#c2510a);border-radius:9px;padding:7px 12px">
          <span style="font-size:15px;font-weight:900;color:#fff;letter-spacing:1px">SX</span>
        </div>
        <span style="font-size:18px;font-weight:800;color:#f1f5f9;margin-left:10px;vertical-align:middle">Softex Technologies</span>
      </td>
      <td align="right">
        <span style="display:inline-block;background:rgba(249,115,22,0.12);border:1px solid rgba(249,115,22,0.3);border-radius:100px;padding:4px 12px;font-size:10px;font-weight:700;color:#fb923c;letter-spacing:0.1em;text-transform:uppercase">🔔 NEW ENQUIRY</span>
      </td>
    </tr></table>
  </div>
</td></tr>

<!-- Body -->
<tr><td style="background:#05080f;border-left:1px solid rgba(249,115,22,0.1);border-right:1px solid rgba(249,115,22,0.1);padding:30px 32px">
  <h1 style="margin:0 0 5px;font-size:20px;font-weight:800;color:#f1f5f9">New project enquiry received</h1>
  <p style="margin:0 0 24px;font-size:12px;color:#475569">{$ts}</p>

  <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:20px">
    <tr>
      <td width="48%" style="padding:0 5px 10px 0;vertical-align:top">
        <div style="background:#0d1525;border:1px solid rgba(249,115,22,0.15);border-left:3px solid #f97316;border-radius:8px;padding:12px 14px">
          <p style="margin:0 0 3px;font-size:9px;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;color:#f97316">Full Name</p>
          <p style="margin:0;font-size:13px;font-weight:600;color:#f1f5f9">{$name}</p>
        </div>
      </td>
      <td width="52%" style="padding:0 0 10px 5px;vertical-align:top">
        <div style="background:#0d1525;border:1px solid rgba(249,115,22,0.15);border-left:3px solid #f97316;border-radius:8px;padding:12px 14px">
          <p style="margin:0 0 3px;font-size:9px;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;color:#f97316">Email</p>
          <p style="margin:0;font-size:13px;font-weight:600"><a href="mailto:{$email}" style="color:#fb923c;text-decoration:none">{$email}</a></p>
        </div>
      </td>
    </tr>
    <tr>
      <td width="48%" style="padding:0 5px 10px 0;vertical-align:top">
        <div style="background:#0d1525;border:1px solid rgba(249,115,22,0.15);border-left:3px solid #f97316;border-radius:8px;padding:12px 14px">
          <p style="margin:0 0 3px;font-size:9px;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;color:#f97316">Phone</p>
          <p style="margin:0;font-size:13px;font-weight:600;color:#f1f5f9">{$ph}</p>
        </div>
      </td>
      <td width="52%" style="padding:0 0 10px 5px;vertical-align:top">
        <div style="background:#0d1525;border:1px solid rgba(249,115,22,0.15);border-left:3px solid #f97316;border-radius:8px;padding:12px 14px">
          <p style="margin:0 0 3px;font-size:9px;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;color:#f97316">Service</p>
          <p style="margin:0;font-size:13px;font-weight:600;color:#f1f5f9">{$svc}</p>
        </div>
      </td>
    </tr>
    <tr>
      <td colspan="2" style="padding:0 0 10px">
        <div style="background:#0d1525;border:1px solid rgba(249,115,22,0.15);border-left:3px solid #f97316;border-radius:8px;padding:12px 14px">
          <p style="margin:0 0 3px;font-size:9px;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;color:#f97316">Subject</p>
          <p style="margin:0;font-size:13px;font-weight:600;color:#f1f5f9">{$sub}</p>
        </div>
      </td>
    </tr>
  </table>

  <div style="background:#080d1a;border:1px solid rgba(249,115,22,0.15);border-radius:10px;padding:16px 18px;margin-bottom:24px">
    <p style="margin:0 0 8px;font-size:9px;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;color:#f97316">Message</p>
    <p style="margin:0;font-size:13px;color:#94a3b8;line-height:1.8">{$msg}</p>
  </div>

  <div style="text-align:center">
    <a href="mailto:{$email}?subject=Re: {$sub}"
       style="display:inline-block;background:linear-gradient(135deg,#f97316,#c2510a);color:#fff;font-size:13px;font-weight:700;padding:12px 28px;border-radius:8px;text-decoration:none;box-shadow:0 4px 14px rgba(249,115,22,0.4)">
      Reply to {$name} →
    </a>
  </div>
</td></tr>

<!-- Footer -->
<tr><td style="background:#020308;border:1px solid rgba(249,115,22,0.08);border-top:0;border-radius:0 0 16px 16px;padding:16px 32px;text-align:center">
  <p style="margin:0;font-size:10px;color:#334155;line-height:1.8">
    Automated notification from softex.pk contact system<br>
    © {$yr} <a href="https://www.softex.pk" style="color:#f97316;text-decoration:none">Softex Technologies</a> · Lahore, Pakistan
  </p>
</td></tr>

</table></td></tr></table>
</body></html>
HTML;
}

function buildClientEmail(array $d): string {
  $fn  = htmlspecialchars(explode(' ', trim($d['name']))[0]);
  $svc = htmlspecialchars($d['service']);
  $sub = htmlspecialchars($d['subject']);
  $yr  = $d['year'];

  return <<<HTML
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Message Received — Softex Technologies</title></head>
<body style="margin:0;padding:0;background:#020308;font-family:'Segoe UI',Arial,sans-serif">
<div style="display:none;max-height:0;overflow:hidden">Hi {$fn}, we've received your message and will respond within 24 hours.</div>

<table width="100%" cellpadding="0" cellspacing="0" style="background:#020308;padding:28px 14px">
<tr><td align="center">
<table width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%">

<!-- Header -->
<tr><td style="border-radius:16px 16px 0 0;overflow:hidden">
  <div style="height:3px;background:linear-gradient(90deg,#c2510a,#f97316,#fb923c,#06b6d4,#f97316,#c2510a)"></div>
  <div style="background:linear-gradient(135deg,#05080f 0%,#0d1525 100%);padding:28px 32px 32px">
    <table width="100%" cellpadding="0" cellspacing="0"><tr>
      <td>
        <div style="display:inline-block;background:linear-gradient(135deg,#f97316,#c2510a);border-radius:9px;padding:7px 12px">
          <span style="font-size:15px;font-weight:900;color:#fff">SX</span>
        </div>
        <span style="font-size:18px;font-weight:800;color:#f1f5f9;margin-left:10px;vertical-align:middle">Softex<span style="color:#f97316">.</span></span>
      </td>
    </tr></table>

    <div style="text-align:center;margin-top:24px">
      <div style="width:62px;height:62px;background:rgba(16,185,129,0.1);border:1.5px solid rgba(16,185,129,0.3);border-radius:50%;margin:0 auto 16px;text-align:center;line-height:62px;font-size:26px">✅</div>
      <h1 style="margin:0 0 8px;font-size:22px;font-weight:800;color:#f1f5f9;letter-spacing:-0.4px">Thank you, {$fn}!</h1>
      <p style="margin:0;font-size:13px;color:#475569;line-height:1.7">
        We've received your message and will respond within <strong style="color:#f1f5f9">24 business hours</strong>.
      </p>
    </div>
  </div>
</td></tr>

<!-- Body -->
<tr><td style="background:#05080f;border-left:1px solid rgba(249,115,22,0.1);border-right:1px solid rgba(249,115,22,0.1);padding:28px 32px">

  <div style="height:1px;background:linear-gradient(90deg,transparent,rgba(249,115,22,0.2),rgba(6,182,212,0.15),rgba(249,115,22,0.2),transparent);margin-bottom:22px"></div>

  <!-- Summary -->
  <p style="margin:0 0 11px;font-size:9px;font-weight:700;letter-spacing:0.14em;text-transform:uppercase;color:#f97316">Your Submission</p>
  <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:22px">
    <tr>
      <td width="50%" style="padding-right:5px">
        <div style="background:#0d1525;border:1px solid rgba(249,115,22,0.12);border-radius:8px;padding:11px 13px">
          <p style="margin:0 0 2px;font-size:9px;color:#475569;text-transform:uppercase;letter-spacing:0.1em">Service</p>
          <p style="margin:0;font-size:12px;font-weight:600;color:#f1f5f9">{$svc}</p>
        </div>
      </td>
      <td width="50%" style="padding-left:5px">
        <div style="background:#0d1525;border:1px solid rgba(249,115,22,0.12);border-radius:8px;padding:11px 13px">
          <p style="margin:0 0 2px;font-size:9px;color:#475569;text-transform:uppercase;letter-spacing:0.1em">Subject</p>
          <p style="margin:0;font-size:12px;font-weight:600;color:#f1f5f9">{$sub}</p>
        </div>
      </td>
    </tr>
  </table>

  <!-- What next -->
  <p style="margin:0 0 14px;font-size:9px;font-weight:700;letter-spacing:0.14em;text-transform:uppercase;color:#f97316">What Happens Next</p>

  <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:12px"><tr>
    <td width="42" valign="top">
      <div style="width:34px;height:34px;background:rgba(249,115,22,0.1);border:1px solid rgba(249,115,22,0.28);border-radius:50%;text-align:center;line-height:34px;font-size:11px;font-weight:800;color:#f97316">1</div>
    </td>
    <td valign="top" style="padding-left:8px">
      <p style="margin:0 0 2px;font-size:12px;font-weight:700;color:#f1f5f9">Team Review</p>
      <p style="margin:0;font-size:11px;color:#475569;line-height:1.6">Our team personally reviews your enquiry before responding — no automated replies.</p>
    </td>
  </tr></table>

  <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:12px"><tr>
    <td width="42" valign="top">
      <div style="width:34px;height:34px;background:rgba(249,115,22,0.1);border:1px solid rgba(249,115,22,0.28);border-radius:50%;text-align:center;line-height:34px;font-size:11px;font-weight:800;color:#f97316">2</div>
    </td>
    <td valign="top" style="padding-left:8px">
      <p style="margin:0 0 2px;font-size:12px;font-weight:700;color:#f1f5f9">Free Consultation</p>
      <p style="margin:0;font-size:11px;color:#475569;line-height:1.6">We'll schedule a discovery call to understand your project scope and goals.</p>
    </td>
  </tr></table>

  <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px"><tr>
    <td width="42" valign="top">
      <div style="width:34px;height:34px;background:rgba(249,115,22,0.1);border:1px solid rgba(249,115,22,0.28);border-radius:50%;text-align:center;line-height:34px;font-size:11px;font-weight:800;color:#f97316">3</div>
    </td>
    <td valign="top" style="padding-left:8px">
      <p style="margin:0 0 2px;font-size:12px;font-weight:700;color:#f1f5f9">Detailed Proposal</p>
      <p style="margin:0;font-size:11px;color:#475569;line-height:1.6">You receive a transparent proposal — deliverables, timeline, and all-inclusive pricing.</p>
    </td>
  </tr></table>

  <div style="text-align:center;margin-bottom:24px">
    <a href="https://www.softex.pk/portfolio.php"
       style="display:inline-block;background:linear-gradient(135deg,#f97316,#c2510a);color:#fff;font-size:12px;font-weight:700;padding:11px 26px;border-radius:8px;text-decoration:none;box-shadow:0 4px 12px rgba(249,115,22,0.35)">
      Explore Our Portfolio →
    </a>
  </div>

  <div style="height:1px;background:linear-gradient(90deg,transparent,rgba(249,115,22,0.15),transparent);margin-bottom:20px"></div>

  <div style="background:#080d1a;border:1px solid rgba(249,115,22,0.1);border-radius:10px;padding:13px 16px;text-align:center">
    <p style="margin:0 0 4px;font-size:11px;color:#475569">Need urgent assistance?</p>
    <p style="margin:0;font-size:12px">
      <a href="mailto:info@softex.pk" style="color:#fb923c;text-decoration:none;font-weight:600">info@softex.pk</a>
      &nbsp; | &nbsp;
      <a href="tel:+923450789192" style="color:#fb923c;text-decoration:none;font-weight:600">+92 345 0789192</a>
    </p>
  </div>

</td></tr>

<!-- Footer -->
<tr><td style="background:#020308;border:1px solid rgba(249,115,22,0.06);border-top:0;border-radius:0 0 16px 16px;padding:18px 32px;text-align:center">
  <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:12px"><tr><td align="center">
    <a href="https://facebook.com/softexpak/" style="display:inline-block;margin:0 3px;width:28px;height:28px;background:#0d1525;border-radius:5px;text-align:center;line-height:28px;font-size:10px;color:#475569;text-decoration:none">f</a>
    <a href="https://twitter.com/softexpak/" style="display:inline-block;margin:0 3px;width:28px;height:28px;background:#0d1525;border-radius:5px;text-align:center;line-height:28px;font-size:10px;color:#475569;text-decoration:none">𝕏</a>
    <a href="https://instagram.com/sotexpak/" style="display:inline-block;margin:0 3px;width:28px;height:28px;background:#0d1525;border-radius:5px;text-align:center;line-height:28px;font-size:10px;color:#475569;text-decoration:none">ig</a>
    <a href="https://linkedin.com/company/sotexpak/" style="display:inline-block;margin:0 3px;width:28px;height:28px;background:#0d1525;border-radius:5px;text-align:center;line-height:28px;font-size:10px;color:#475569;text-decoration:none">in</a>
  </td></tr></table>
  <p style="margin:0;font-size:10px;color:#1e293b;line-height:1.8">
    © {$yr} <a href="https://www.softex.pk" style="color:#f97316;text-decoration:none">Softex Technologies</a> · Lahore, Pakistan<br>
    <span style="color:#0f172a;font-size:9px">You received this because you submitted a contact form on our website.</span>
  </p>
</td></tr>

</table></td></tr></table>
</body></html>
HTML;
}
