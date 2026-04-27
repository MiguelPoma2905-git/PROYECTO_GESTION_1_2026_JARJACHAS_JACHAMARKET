<?php
require_once __DIR__ . '/config.php';

require_once __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer {
    private $mail;
    
    public function __construct() {
        $this->mail = new PHPMailer(true);
        $this->mail->SMTPDebug = 0;
        $this->mail->isSMTP();
        $this->mail->Host = 'smtp.gmail.com';
        $this->mail->SMTPAuth = true;
        $this->mail->Username = 'mikypramos2905@gmail.com';
        $this->mail->Password = 'gqdgstlicrqweylt';
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->Port = 587;
        $this->mail->setFrom('mikypramos2905@gmail.com', 'Jacha Marketplace');
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
            
            $logoPath = __DIR__ . '/../public/assets/images/logo_2.png';
            if (file_exists($logoPath)) {
                $this->mail->AddEmbeddedImage($logoPath, 'logo_jacha', 'logo_2.png');
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
                * {
                    margin: 0;
                    padding: 0;
                    box-sizing: border-box;
                }
                
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
                    background: #1a1a1a;
                    border-radius: 16px;
                    overflow: hidden;
                    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
                }
                
                .email-content {
                    padding: 48px 40px;
                }
                
                .logo-container {
                    text-align: center;
                    margin-bottom: 40px;
                }
                
                .logo-img {
                    max-width: 280px;
                    width: 100%;
                    height: auto;
                    display: inline-block;
                }
                
                .divider {
                    width: 60px;
                    height: 2px;
                    background: linear-gradient(90deg, #fa7136, #1a4147);
                    margin: 0 auto 32px auto;
                }
                
                .title {
                    text-align: center;
                    font-size: 24px;
                    font-weight: 500;
                    color: #ffffff;
                    margin-bottom: 16px;
                    letter-spacing: -0.3px;
                }
                
                .greeting {
                    text-align: center;
                    color: #a0a0a0;
                    font-size: 15px;
                    margin-bottom: 8px;
                }
                
                .greeting strong {
                    color: #ffffff;
                    font-weight: 500;
                }
                
                .instruction {
                    text-align: center;
                    color: #a0a0a0;
                    font-size: 14px;
                    margin-bottom: 32px;
                    line-height: 1.5;
                }
                
                .code-box {
                    background: #252525;
                    border: 1px solid #333333;
                    border-radius: 12px;
                    padding: 28px 20px;
                    margin: 24px 0;
                    text-align: center;
                }
                
                .code-label {
                    font-size: 11px;
                    text-transform: uppercase;
                    letter-spacing: 2px;
                    color: #fa7136;
                    margin-bottom: 16px;
                    font-weight: 500;
                }
                
                .code-value {
                    font-size: 40px;
                    font-weight: 700;
                    letter-spacing: 8px;
                    color: #fa7136;
                    font-family: "SF Mono", Monaco, "Cascadia Code", monospace;
                    line-height: 1.2;
                }
                
                .expiry-info {
                    text-align: center;
                    font-size: 12px;
                    color: #666666;
                    margin-top: 24px;
                }
                
                .footer {
                    text-align: center;
                    padding-top: 32px;
                    margin-top: 32px;
                    border-top: 1px solid #2a2a2a;
                }
                
                .footer-text {
                    font-size: 11px;
                    color: #555555;
                    line-height: 1.5;
                }
                
                .footer-colors {
                    margin-top: 12px;
                    font-size: 10px;
                    color: #444444;
                }
                
                .color-dot {
                    display: inline-block;
                    width: 10px;
                    height: 10px;
                    border-radius: 50%;
                    margin: 0 4px;
                }
                
                .color-primary {
                    background-color: #fa7136;
                }
                
                .color-secondary {
                    background-color: #1a4147;
                }
                
                @media (max-width: 480px) {
                    .email-content {
                        padding: 32px 24px;
                    }
                    
                    .logo-img {
                        max-width: 200px;
                    }
                    
                    .code-value {
                        font-size: 28px;
                        letter-spacing: 4px;
                    }
                    
                    .title {
                        font-size: 20px;
                    }
                }
            </style>
        </head>
        <body>
            <div class="email-container">
                <div class="email-card">
                    <div class="email-content">
                        <div class="logo-container">
                            <img src="cid:logo_jacha" alt="Jacha Logo" class="logo-img">
                        </div>
                        
                        <div class="divider"></div>
                        
                        <div class="title">
                            Verifica tu identidad
                        </div>
                        
                        <div class="greeting">
                            Hola, <strong>' . htmlspecialchars($nombre) . '</strong>
                        </div>
                        
                        <div class="instruction">
                            Usa el siguiente código para completar tu registro.<br>
                            Este código es válido por 10 minutos.
                        </div>
                        
                        <div class="code-box">
                            <div class="code-label">
                                CÓDIGO DE VERIFICACIÓN
                            </div>
                            <div class="code-value">
                                ' . $codigo . '
                            </div>
                        </div>
                        
                        <div class="expiry-info">
                            El código expira en 10 minutos
                        </div>
                        
                        <div class="footer">
                            <div class="footer-text">
                                Si no solicitaste este código, puedes ignorar este correo.<br>
                                La seguridad de tu cuenta es importante para nosotros.
                            </div>
                            <div class="footer-colors">
                                <span class="color-dot color-primary"></span>
                                <span class="color-dot color-secondary"></span>
                                Jacha Marketplace - Potenciando emprendimientos bolivianos
                            </div>
                        </div>
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