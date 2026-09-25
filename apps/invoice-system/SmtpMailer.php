<?php
/**
 * Custom SMTP Mailer with Attachments
 * Implements standard SMTP protocol transport socket transactions
 * supporting TLS/SSL encryption and Base64 attachment packaging.
 */

class SmtpMailer {
    private $host;
    private $port;
    private $username;
    private $password;
    private $secure; // 'tls', 'ssl', or ''
    private $timeout = 10;
    private $errors = [];

    public function __construct($host, $port, $username, $password, $secure = 'tls') {
        $this->host = $host;
        $this->port = $port;
        $this->username = $username;
        $this->password = $password;
        $this->secure = strtolower($secure);
    }

    /**
     * Get error logs
     */
    public function get_errors() {
        return $this->errors;
    }

    /**
     * Send email with attachment
     */
    public function send($to, $subject, $body_html, $from_email, $from_name, $attachment_path = '', $attachment_name = '') {
        // Validate inputs
        if (empty($to) || empty($subject) || empty($body_html)) {
            $this->errors[] = "Required fields (To, Subject, Body) are empty.";
            return false;
        }

        // Establish socket connection
        $host_address = $this->host;
        if ($this->secure === 'ssl') {
            $host_address = 'ssl://' . $this->host;
        }

        $socket = @stream_socket_client(
            $host_address . ':' . $this->port,
            $errno,
            $errstr,
            $this->timeout,
            STREAM_CLIENT_CONNECT
        );

        if (!$socket) {
            $this->errors[] = "Socket connection failed: $errstr ($errno)";
            return false;
        }

        // Helper to read server response
        $get_response = function($socket) {
            $response = '';
            while ($str = fgets($socket, 515)) {
                $response .= $str;
                if (substr($str, 3, 1) == ' ') {
                    break;
                }
            }
            return $response;
        };

        // Read initial greeting
        $greeting = $get_response($socket);
        if (substr($greeting, 0, 3) !== '220') {
            $this->errors[] = "Server greeting error: " . $greeting;
            fclose($socket);
            return false;
        }

        // HELO/EHLO handshake
        fwrite($socket, "EHLO " . $_SERVER['SERVER_NAME'] . "\r\n");
        $ehlo_resp = $get_response($socket);
        
        // STARTTLS negotiation if TLS is active
        if ($this->secure === 'tls') {
            fwrite($socket, "STARTTLS\r\n");
            $tls_resp = $get_response($socket);
            if (substr($tls_resp, 0, 3) !== '220') {
                $this->errors[] = "STARTTLS command failed: " . $tls_resp;
                fclose($socket);
                return false;
            }

            // Enable encryption on socket
            if (!stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
                $this->errors[] = "SSL/TLS crypto handshake failed.";
                fclose($socket);
                return false;
            }

            // Send EHLO again post-encryption
            fwrite($socket, "EHLO " . $_SERVER['SERVER_NAME'] . "\r\n");
            $ehlo_resp = $get_response($socket);
        }

        // SMTP Authentication (AUTH LOGIN)
        if (!empty($this->username) && !empty($this->password)) {
            fwrite($socket, "AUTH LOGIN\r\n");
            $auth_resp = $get_response($socket);
            if (substr($auth_resp, 0, 3) !== '334') {
                $this->errors[] = "AUTH LOGIN transaction failed: " . $auth_resp;
                fclose($socket);
                return false;
            }

            // Submit Base64 Username
            fwrite($socket, base64_encode($this->username) . "\r\n");
            $user_resp = $get_response($socket);
            if (substr($user_resp, 0, 3) !== '334') {
                $this->errors[] = "SMTP username validation failed: " . $user_resp;
                fclose($socket);
                return false;
            }

            // Submit Base64 Password
            fwrite($socket, base64_encode($this->password) . "\r\n");
            $pass_resp = $get_response($socket);
            if (substr($pass_resp, 0, 3) !== '235') {
                $this->errors[] = "SMTP password authentication failed: " . $pass_resp;
                fclose($socket);
                return false;
            }
        }

        // MAIL FROM transaction
        fwrite($socket, "MAIL FROM:<" . $from_email . ">\r\n");
        $mail_from_resp = $get_response($socket);
        if (substr($mail_from_resp, 0, 3) !== '250') {
            $this->errors[] = "MAIL FROM transaction rejected: " . $mail_from_resp;
            fclose($socket);
            return false;
        }

        // RCPT TO transaction
        fwrite($socket, "RCPT TO:<" . $to . ">\r\n");
        $rcpt_resp = $get_response($socket);
        if (substr($rcpt_resp, 0, 3) !== '250' && substr($rcpt_resp, 0, 3) !== '251') {
            $this->errors[] = "RCPT TO target rejected: " . $rcpt_resp;
            fclose($socket);
            return false;
        }

        // Start DATA writing block
        fwrite($socket, "DATA\r\n");
        $data_resp = $get_response($socket);
        if (substr($data_resp, 0, 3) !== '354') {
            $this->errors[] = "DATA initialization failed: " . $data_resp;
            fclose($socket);
            return false;
        }

        // Create MIME Multipart structure boundary hash
        $boundary = "----=_Part_" . md5(uniqid(time()));

        // Format Email Headers
        $headers = "From: " . $from_name . " <" . $from_email . ">\r\n";
        $headers .= "To: <" . $to . ">\r\n";
        $headers .= "Subject: " . $subject . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: multipart/mixed; boundary=\"" . $boundary . "\"\r\n";
        $headers .= "X-Mailer: Softex SMTP Mailer Engine\r\n";
        $headers .= "\r\n";

        // Assemble MIME email content
        $msg_content = "This is a multi-part message in MIME format.\r\n\r\n";
        
        // 1. Plain Text / HTML Body part
        $msg_content .= "--" . $boundary . "\r\n";
        $msg_content .= "Content-Type: text/html; charset=\"UTF-8\"\r\n";
        $msg_content .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
        $msg_content .= $body_html . "\r\n\r\n";

        // 2. File attachment Part (if present and valid)
        if (!empty($attachment_path) && file_exists($attachment_path)) {
            $file_data = file_get_contents($attachment_path);
            $file_encoded = chunk_split(base64_encode($file_data));
            if (empty($attachment_name)) {
                $attachment_name = basename($attachment_path);
            }

            $msg_content .= "--" . $boundary . "\r\n";
            $msg_content .= "Content-Type: application/pdf; name=\"" . $attachment_name . "\"\r\n";
            $msg_content .= "Content-Disposition: attachment; filename=\"" . $attachment_name . "\"\r\n";
            $msg_content .= "Content-Transfer-Encoding: base64\r\n\r\n";
            $msg_content .= $file_encoded . "\r\n\r\n";
        }

        // End Multipart Boundary closing
        $msg_content .= "--" . $boundary . "--\r\n";

        // Write content to SMTP socket and send final terminal dot
        fwrite($socket, $headers . $msg_content . "\r\n.\r\n");
        $final_resp = $get_response($socket);
        if (substr($final_resp, 0, 3) !== '250') {
            $this->errors[] = "Email sending transaction failed: " . $final_resp;
            fclose($socket);
            return false;
        }

        // Quit SMTP Connection
        fwrite($socket, "QUIT\r\n");
        fclose($socket);
        return true;
    }
}
