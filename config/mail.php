<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/.env.php';

require_once __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer {
    private $mail;
    
    public function __construct() {
        $this->mail = new PHPMailer(true);
        $this->mail->SMTPDebug = 0;
        $this->mail->isSMTP();
        $this->mail->Host = SMTP_HOST;
        $this->mail->SMTPAuth = true;
        $this->mail->Username = SMTP_USER;
        $this->mail->Password = SMTP_PASS;
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->Port = SMTP_PORT;
        $this->mail->setFrom(SMTP_FROM, SMTP_FROM_NAME);
        $this->mail->isHTML(true);
        $this->mail->CharSet = 'UTF-8';
    }
    
    public function enviarCodigoOTP($email, $codigo, $nombre = 'Usuario') {
        try {
            $this->mail->clearAddresses();
            $this->mail->addAddress($email, $nombre);
            $this->mail->Subject = 'Código de Verificación - Jacha Marketplace';
            
            $this->mail->Body = $this->generarHTMLCorreo($codigo, $nombre);
            $this->mail->AltBody = "Tu código de verificación es: $codigo\n\nExpira en 10 minutos.\n\n© Jacha Marketplace";
            
            $logoPath = __DIR__ . '/../public/assets/images/logo_empresa.png';
            if (file_exists($logoPath)) {
                $this->mail->AddEmbeddedImage($logoPath, 'logo_jacha', 'logo_empresa.png');
            }
            
            return $this->mail->send();
        } catch (Exception $e) {
            error_log("Error enviando correo: " . $this->mail->ErrorInfo);
            return false;
        }
    }
    
    private function generarHTMLCorreo($codigo, $nombre) {
        return '
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Código de Verificación - Jacha Marketplace</title>
            <style>
                * { margin: 0; padding: 0; box-sizing: border-box; }
                body {
                    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
                    background-color: #0a0a0a;
                    margin: 0;
                    padding: 0;
                }
                .email-container {
                    max-width: 560px;
                    margin: 0 auto;
                    background-color: #0a0a0a;
                    padding: 40px 20px;
                }
                .email-card {
                    background: #141414;
                    border-radius: 24px;
                    overflow: hidden;
                    border: 1px solid rgba(255,255,255,0.08);
                    box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5);
                }
                .email-content { padding: 48px 40px; }
                .logo-container { text-align: center; margin-bottom: 32px; }
                .logo-img { max-width: 200px; width: 100%; height: auto; display: inline-block; }
                .divider {
                    width: 48px;
                    height: 1px;
                    background: rgba(255,255,255,0.15);
                    margin: 0 auto 32px auto;
                }
                .title {
                    text-align: center;
                    font-family: Georgia, "Times New Roman", Times, serif;
                    font-size: 24px;
                    font-weight: 400;
                    color: #ffffff;
                    margin-bottom: 16px;
                }
                .greeting {
                    text-align: center;
                    color: #888;
                    font-size: 14px;
                    margin-bottom: 8px;
                }
                .greeting strong { color: #ffffff; font-weight: 500; }
                .instruction {
                    text-align: center;
                    color: #888;
                    font-size: 13px;
                    margin-bottom: 32px;
                    line-height: 1.5;
                }
                .code-box {
                    background: #1a1a1a;
                    border: 1px solid rgba(255,255,255,0.1);
                    border-radius: 16px;
                    padding: 28px 20px;
                    margin: 24px 0;
                    text-align: center;
                }
                .code-label {
                    font-size: 10px;
                    text-transform: uppercase;
                    letter-spacing: 2px;
                    color: #aaa;
                    margin-bottom: 16px;
                }
                .code-value {
                    font-size: 40px;
                    font-weight: 600;
                    letter-spacing: 8px;
                    color: #ffffff;
                    font-family: monospace;
                }
                .expiry-info {
                    text-align: center;
                    font-size: 11px;
                    color: #555;
                    margin-top: 24px;
                }
                .footer {
                    text-align: center;
                    padding-top: 32px;
                    margin-top: 32px;
                    border-top: 1px solid rgba(255,255,255,0.08);
                }
                .footer-text { font-size: 10px; color: #555; line-height: 1.5; }
                .footer-copyright { margin-top: 16px; font-size: 9px; color: #444; }
                @media (max-width: 480px) {
                    .email-content { padding: 32px 24px; }
                    .code-value { font-size: 28px; letter-spacing: 4px; }
                    .title { font-size: 20px; }
                    .logo-img { max-width: 160px; }
                }
            </style>
        </head>
        <body>
            <div class="email-container">
                <div class="email-card">
                    <div class="email-content">
                        <div class="logo-container">
                            <img src="cid:logo_jacha" alt="Jacha" class="logo-img">
                        </div>
                        <div class="divider"></div>
                        <div class="title">Verifica tu identidad</div>
                        <div class="greeting">Hola, <strong>' . htmlspecialchars($nombre) . '</strong></div>
                        <div class="instruction">Usa el siguiente código para completar tu registro.<br>Este código es válido por 10 minutos.</div>
                        <div class="code-box">
                            <div class="code-label">Código de verificación</div>
                            <div class="code-value">' . $codigo . '</div>
                        </div>
                        <div class="expiry-info">El código expira en 10 minutos</div>
                        <div class="footer">
                            <div class="footer-text">Si no solicitaste este código, puedes ignorar este correo.<br>La seguridad de tu cuenta es importante.</div>
                            <div class="footer-copyright">© 2026 Jacha Marketplace</div>
                        </div>
                    </div>
                </div>
            </div>
        </body>
        </html>';
    }
    
    public function enviarEnlaceRecuperacion($email, $enlace, $nombre = 'Usuario') {
        try {
            $this->mail->clearAddresses();
            $this->mail->addAddress($email, $nombre);
            $this->mail->Subject = 'Recuperación de contraseña - Jacha Marketplace';

            $this->mail->Body = $this->generarHTMLRecuperacion($enlace, $nombre);
            $this->mail->AltBody = "Hola $nombre,\n\nPara restablecer tu contraseña, visita el siguiente enlace:\n$enlace\n\nSi no solicitaste esto, ignora este correo.\n\n© Jacha Marketplace";

            return $this->mail->send();
        } catch (Exception $e) {
            error_log("Error enviando correo de recuperación: " . $this->mail->ErrorInfo);
            return false;
        }
    }

    private function generarHTMLRecuperacion($enlace, $nombre) {
        return '
        <!DOCTYPE html>
        <html lang="es">
        <head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
        <title>Recuperación de contraseña</title>
        <style>
            * { margin:0; padding:0; box-sizing:border-box; }
            body { font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Helvetica,Arial,sans-serif; background:#0a0a0a; margin:0; padding:0; }
            .email-container { max-width:560px; margin:0 auto; background:#0a0a0a; padding:40px 20px; }
            .email-card { background:#141414; border-radius:24px; overflow:hidden; border:1px solid rgba(255,255,255,0.08); box-shadow:0 25px 50px -12px rgba(0,0,0,0.5); }
            .email-content { padding:48px 40px; }
            .divider { width:48px; height:1px; background:rgba(255,255,255,0.15); margin:0 auto 32px auto; }
            .title { text-align:center; font-family:Georgia,"Times New Roman",Times,serif; font-size:24px; font-weight:400; color:#ffffff; margin-bottom:16px; }
            .text { text-align:center; color:#888; font-size:14px; margin-bottom:24px; line-height:1.6; }
            .btn-wrap { text-align:center; margin:32px 0; }
            .btn-reset { display:inline-block; padding:14px 36px; background:#ffffff; color:#0a0a0a; text-decoration:none; border-radius:12px; font-size:14px; font-weight:600; }
            .footer { text-align:center; padding-top:32px; margin-top:32px; border-top:1px solid rgba(255,255,255,0.08); }
            .footer-text { font-size:10px; color:#555; line-height:1.5; }
            @media (max-width:480px) { .email-content { padding:32px 24px; } .title { font-size:20px; } }
        </style>
        </head>
        <body>
        <div class="email-container">
            <div class="email-card">
                <div class="email-content">
                    <div class="divider"></div>
                    <div class="title">Recupera tu contraseña</div>
                    <div class="text">Hola, <strong>' . htmlspecialchars($nombre) . '</strong><br><br>Recibimos una solicitud para restablecer la contraseña de tu cuenta. Haz clic en el botón de abajo para crear una nueva contraseña.</div>
                    <div class="btn-wrap"><a href="' . $enlace . '" class="btn-reset">Restablecer contraseña</a></div>
                    <div class="text" style="font-size:12px;color:#555">Si no solicitaste este cambio, puedes ignorar este correo.<br>El enlace expira en 1 hora.</div>
                    <div class="footer"><div class="footer-text">© 2026 Jacha Marketplace</div></div>
                </div>
            </div>
        </div>
        </body>
        </html>';
    }

    public function testConnection() {
        try {
            $this->mail->smtpConnect();
            $this->mail->smtpClose();
            return ['success' => true, 'message' => 'Conexión SMTP exitosa'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $this->mail->ErrorInfo];
        }
    }
}
?>