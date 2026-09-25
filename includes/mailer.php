<?php
/**
 * includes/mailer.php
 * Lightweight SMTP mailer using PHP's built-in socket functions.
 * Connects over SSL (port 465) — no PHPMailer dependency.
 */

class SMTPMailer {
  private $host;
  private $port;
  private $user;
  private $pass;
  private $timeout;
  private $sock;
  private $lastError = '';

  public function __construct(string $host, int $port, string $user, string $pass, int $timeout = 20) {
    $this->host    = $host;
    $this->port    = $port;
    $this->user    = $user;
    $this->pass    = $pass;
    $this->timeout = $timeout;
  }

  public function getLastError(): string { return $this->lastError; }

  /**
   * Send an email.
   *
   * @param string $to      Recipient address
   * @param string $toName  Recipient display name
   * @param string $subject Subject line (plain UTF-8, will be encoded)
   * @param string $html    Full HTML body
   * @param string $from    From address (defaults to $user)
   * @param string $fromName From display name
   * @param string $replyTo Reply-To address
   */
  public function send(
    string $to,
    string $toName,
    string $subject,
    string $html,
    string $from    = '',
    string $fromName = 'Softex Technologies',
    string $replyTo = ''
  ): bool {
    if (!$from) $from = $this->user;
    if (!$replyTo) $replyTo = $from;

    /* ── Encode subject ─────────────────────── */
    $encSubject = '=?UTF-8?B?' . base64_encode($subject) . '?=';

    /* ── Build MIME message ─────────────────── */
    $boundary = 'softex_' . md5(uniqid());
    $msgId    = '<' . time() . '.' . md5($to) . '@softex.pk>';
    $date     = date('r');

    $headers  = "Date: {$date}\r\n";
    $headers .= "Message-ID: {$msgId}\r\n";
    $headers .= "From: =?UTF-8?B?" . base64_encode($fromName) . "?= <{$from}>\r\n";
    $headers .= "To: =?UTF-8?B?" . base64_encode($toName) . "?= <{$to}>\r\n";
    $headers .= "Reply-To: {$replyTo}\r\n";
    $headers .= "Subject: {$encSubject}\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: multipart/alternative; boundary=\"{$boundary}\"\r\n";
    $headers .= "X-Mailer: SoftexMailer/1.0\r\n";
    $headers .= "X-Priority: 3\r\n";

    $plainText = strip_tags(str_replace(['<br>', '<br/>', '<br />'], "\n", $html));
    $plainText = html_entity_decode($plainText, ENT_QUOTES, 'UTF-8');
    $plainText = preg_replace('/\n{3,}/', "\n\n", trim($plainText));

    $body  = "--{$boundary}\r\n";
    $body .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $body .= "Content-Transfer-Encoding: quoted-printable\r\n\r\n";
    $body .= quoted_printable_encode($plainText) . "\r\n";
    $body .= "--{$boundary}\r\n";
    $body .= "Content-Type: text/html; charset=UTF-8\r\n";
    $body .= "Content-Transfer-Encoding: quoted-printable\r\n\r\n";
    $body .= quoted_printable_encode($html) . "\r\n";
    $body .= "--{$boundary}--\r\n";

    $message = $headers . "\r\n" . $body;

    /* ── Connect ────────────────────────────── */
    try {
      $ctx = stream_context_create([
        'ssl' => [
          'verify_peer'       => false,
          'verify_peer_name'  => false,
          'allow_self_signed' => true,
        ]
      ]);

      $this->sock = stream_socket_client(
        "ssl://{$this->host}:{$this->port}",
        $errno, $errstr,
        $this->timeout,
        STREAM_CLIENT_CONNECT,
        $ctx
      );

      if (!$this->sock) {
        $this->lastError = "Connection failed: {$errstr} ({$errno})";
        return false;
      }
      stream_set_timeout($this->sock, $this->timeout);

      /* ── SMTP handshake ──────────────────── */
      if (!$this->expect('220')) return false;
      if (!$this->cmd("EHLO softex.pk", '250')) return false;
      if (!$this->cmd("AUTH LOGIN", '334')) return false;
      if (!$this->cmd(base64_encode($this->user), '334')) return false;
      if (!$this->cmd(base64_encode($this->pass), '235')) return false;
      if (!$this->cmd("MAIL FROM:<{$from}>", '250')) return false;
      if (!$this->cmd("RCPT TO:<{$to}>", '250')) return false;
      if (!$this->cmd("DATA", '354')) return false;

      // Send message data
      fputs($this->sock, $message . "\r\n.\r\n");
      if (!$this->expect('250')) return false;

      $this->cmd("QUIT", '221');
      fclose($this->sock);
      return true;

    } catch (Throwable $e) {
      $this->lastError = $e->getMessage();
      if ($this->sock) @fclose($this->sock);
      return false;
    }
  }

  private function cmd(string $cmd, string $expect): bool {
    fputs($this->sock, $cmd . "\r\n");
    return $this->expect($expect);
  }

  private function expect(string $code): bool {
    $response = '';
    while (($line = fgets($this->sock, 515)) !== false) {
      $response .= $line;
      if (substr($line, 3, 1) === ' ') break;
    }
    if (substr(trim($response), 0, 3) !== $code) {
      $this->lastError = "Expected {$code}, got: " . trim($response);
      return false;
    }
    return true;
  }
}

/* ── Global mailer singleton ────────────────── */
function getSMTPMailer(): SMTPMailer {
  static $m = null;
  if (!$m) {
    $m = new SMTPMailer(
      'mail.softex.pk',   // SMTP host
      465,                // SSL port
      'info@softex.pk',   // username
      'Meta*Data123'      // password
    );
  }
  return $m;
}
