<?php
require_once __DIR__ . '/../Models/OTP.php';
require_once __DIR__ . '/../../config/mail.php';

class AuthController {
    private $otp;
    private $mailer;
    
    public function __construct() {
        $this->otp = new OTP();
        $this->mailer = new Mailer();
    }
    
    public function login($email, $password) {
        $db = getDB();
        $stmt = $db->prepare("
            SELECT u.*, r.nombre_rol 
            FROM usuarios u 
            JOIN roles r ON u.id_rol = r.id_rol 
            WHERE u.email = ? AND u.estado = 'Activo'
        ");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch();
        
        if ($usuario && password_verify($password, $usuario['password_hash'])) {
            $_SESSION['usuario'] = [
                'id' => $usuario['id_usuario'],
                'nombre' => $usuario['nombres'] . ' ' . $usuario['apellidos'],
                'email' => $usuario['email'],
                'rol' => $usuario['nombre_rol']
            ];
            return ['success' => true];
        }
        
        return ['success' => false, 'error' => 'Credenciales incorrectas'];
    }
    
    public function registrar($datos) {
        // Validar
        if (!filter_var($datos['email'], FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'error' => 'Email inválido'];
        }
        
        if (strlen($datos['password']) < 6) {
            return ['success' => false, 'error' => 'La contraseña debe tener al menos 6 caracteres'];
        }
        
        $db = getDB();
        
        // Verificar si ya existe
        $stmt = $db->prepare("SELECT id_usuario FROM usuarios WHERE email = ?");
        $stmt->execute([$datos['email']]);
        if ($stmt->fetch()) {
            return ['success' => false, 'error' => 'El email ya está registrado'];
        }
        
        // Generar código OTP
        $result = $this->otp->generarCodigo($datos['email']);
        if (!$result['success']) {
            return $result;
        }
        
        // Guardar temporalmente en sesión
        $_SESSION['registro_temp'] = [
            'nombres' => $datos['nombres'],
            'apellidos' => $datos['apellidos'],
            'email' => $datos['email'],
            'password' => password_hash($datos['password'], PASSWORD_DEFAULT),
            'codigo_otp' => $result['codigo']
        ];
        
        // Enviar correo
        $enviado = $this->mailer->enviarCodigoOTP($datos['email'], $result['codigo'], $datos['nombres']);
        
        if ($enviado) {
            return ['success' => true, 'require_otp' => true];
        }
        
        return ['success' => false, 'error' => 'Error enviando código de verificación'];
    }
    
    public function verificarOTP($codigo) {
        if (!isset($_SESSION['registro_temp'])) {
            return ['success' => false, 'error' => 'No hay registro pendiente'];
        }
        
        $temp = $_SESSION['registro_temp'];
        
        // Verificar OTP
        $otpCheck = $this->otp->verificarCodigo($temp['email'], $codigo);
        
        if (!$otpCheck['success']) {
            return $otpCheck;
        }
        
        // Crear usuario
        $db = getDB();
        
        // Obtener rol de cliente (por defecto)
        $stmt = $db->prepare("SELECT id_rol FROM roles WHERE nombre_rol = 'Cliente'");
        $stmt->execute();
        $rol = $stmt->fetch();
        
        $stmt = $db->prepare("
            INSERT INTO usuarios (nombres, apellidos, email, password_hash, id_rol) 
            VALUES (?, ?, ?, ?, ?)
        ");
        
        if ($stmt->execute([$temp['nombres'], $temp['apellidos'], $temp['email'], $temp['password'], $rol['id_rol']])) {
            unset($_SESSION['registro_temp']);
            return ['success' => true];
        }
        
        return ['success' => false, 'error' => 'Error creando usuario'];
    }
    
    public function logout() {
        session_destroy();
        return ['success' => true];
    }
}
?>