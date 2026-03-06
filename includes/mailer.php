<?php
// includes/mailer.php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';

/**
 * Sends an email using a database template.
 * 
 * @param PDO $pdo The PDO connection instance
 * @param string $to Email address of recipient
 * @param string $template_type 'welcome' or 'password_reset'
 * @param array $variables Associative array of variables to parse in the subject/body (e.g. ['nome' => 'João'])
 * @return bool True on success, False on failure
 */
function send_system_email($pdo, $to, $template_type, $variables = [])
{
    try {
        // 1. Fetch SMTP settings
        $stmt = $pdo->query("SELECT smtp_host, smtp_user, smtp_pass, smtp_port, smtp_secure FROM settings WHERE id = 1");
        $settings = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$settings || empty($settings['smtp_host'])) {
            error_log("Mailer Error: SMTP settings not configured in database.");
            return false;
        }

        // 2. Fetch Template
        $stmt = $pdo->prepare("SELECT subject, body_html FROM email_templates WHERE type = ?");
        $stmt->execute([$template_type]);
        $template = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$template) {
            error_log("Mailer Error: Template type '$template_type' not found.");
            return false;
        }

        $subject = $template['subject'];
        $body = $template['body_html'];

        // 3. Parse Variables
        foreach ($variables as $key => $value) {
            $placeholder = '{{' . $key . '}}';
            $subject = str_replace($placeholder, $value, $subject);
            $body = str_replace($placeholder, $value, $body);
        }

        // 4. Configure PHPMailer
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = $settings['smtp_host'];
        $mail->SMTPAuth = !empty($settings['smtp_user']);
        $mail->Username = $settings['smtp_user'];
        $mail->Password = $settings['smtp_pass'];

        if ($settings['smtp_secure'] === 'ssl') {
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        }
        elseif ($settings['smtp_secure'] === 'tls') {
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        }
        else {
            $mail->SMTPAutoTLS = false;
        }

        $mail->Port = (int)$settings['smtp_port'];

        $mail->setFrom($settings['smtp_user'], 'CGADRB Notificações');
        $mail->addAddress($to);

        $mail->CharSet = 'UTF-8';
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;

        $mail->send();
        return true;

    }
    catch (Exception $e) {
        error_log("Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
    catch (\PDOException $e) {
        error_log("Mailer PDO Error: " . $e->getMessage());
        return false;
    }
}
?>
