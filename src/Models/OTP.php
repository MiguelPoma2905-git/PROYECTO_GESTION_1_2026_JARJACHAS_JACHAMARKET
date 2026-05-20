<?php
namespace App\Models;

class OTP
{
    private \PDO $conn;

    public function __construct()
    {
        $this->conn = \getDB();
    }

    public function generarCodigo(string $email): array
    {
        $stmt = $this->conn->prepare("DELETE FROM otp_verificacion WHERE expira_en < NOW()");
        $stmt->execute();

        $stmt = $this->conn->prepare("
            SELECT COUNT(*) as intentos FROM otp_verificacion 
            WHERE email = ? AND creado_en > DATE_SUB(NOW(), INTERVAL 1 HOUR)
        ");
        $stmt->execute([$email]);
        $result = $stmt->fetch();

        if ($result['intentos'] >= 3) {
            return ['success' => false, 'error' => 'Demasiados intentos. Espera 1 hora.'];
        }

        $codigo = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $expira = date('Y-m-d H:i:s', strtotime('+10 minutes'));

        $stmt = $this->conn->prepare("
            INSERT INTO otp_verificacion (email, codigo, expira_en) 
            VALUES (?, ?, ?)
        ");

        if ($stmt->execute([$email, $codigo, $expira])) {
            return ['success' => true, 'codigo' => $codigo];
        }

        return ['success' => false, 'error' => 'Error generando código'];
    }

    public function verificarCodigo(string $email, string $codigoIngresado): array
    {
        $stmt = $this->conn->prepare("
            SELECT id_otp, codigo, expira_en, intentos 
            FROM otp_verificacion 
            WHERE email = ? AND usado = 0 
            ORDER BY creado_en DESC LIMIT 1
        ");
        $stmt->execute([$email]);
        $otp = $stmt->fetch();

        if (!$otp) {
            return ['success' => false, 'error' => 'No hay código válido para este correo'];
        }

        if (strtotime($otp['expira_en']) < time()) {
            return ['success' => false, 'error' => 'El código ha expirado. Solicita uno nuevo.'];
        }

        $stmt = $this->conn->prepare("UPDATE otp_verificacion SET intentos = intentos + 1 WHERE id_otp = ?");
        $stmt->execute([$otp['id_otp']]);

        if ($otp['intentos'] >= 5) {
            return ['success' => false, 'error' => 'Demasiados intentos fallidos. Solicita un nuevo código.'];
        }

        if ($otp['codigo'] === $codigoIngresado) {
            $stmt = $this->conn->prepare("UPDATE otp_verificacion SET usado = 1 WHERE id_otp = ?");
            $stmt->execute([$otp['id_otp']]);
            return ['success' => true];
        }

        return ['success' => false, 'error' => 'Código incorrecto'];
    }
}
