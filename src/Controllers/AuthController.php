<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Repositories\UsuarioRepository;
use App\Models\OTP;

class AuthController extends Controller
{
    private UsuarioRepository $usuarioRepo;
    private OTP $otp;
    private \Mailer $mailer;

    public function __construct()
    {
        parent::__construct();
        $this->usuarioRepo = new UsuarioRepository();
        $this->otp = new OTP();
        $this->mailer = new \Mailer();
    }

    public function showLoginForm(): void
    {
        if (isset($_SESSION['usuario'])) {
            $this->redirect(BASE_URL . '/');
        }
        $error = $_GET['error'] ?? '';
        $this->view('auth/login', ['error' => $error]);
    }

    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect(BASE_URL . '/login');
        }

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            $this->redirect(BASE_URL . '/login?error=Correo y contraseña son requeridos');
        }

        $usuario = $this->usuarioRepo->findByEmail($email);

        if (!$usuario || !password_verify($password, $usuario['password_hash'])) {
            $this->redirect(BASE_URL . '/login?error=Credenciales incorrectas');
        }

        $otpResult = $this->otp->generarCodigo($email);
        if (!$otpResult['success']) {
            $this->redirect(BASE_URL . '/login?error=' . urlencode($otpResult['error']));
        }

        $_SESSION['login_temp'] = [
            'id' => $usuario['id_usuario'],
            'nombre' => $usuario['nombres'] . ' ' . $usuario['apellidos'],
            'email' => $usuario['email'],
            'roles' => $usuario['roles_todos'] ?? '',
            'codigo_otp' => $otpResult['codigo']
        ];

        $enviado = $this->mailer->enviarCodigoOTP($email, $otpResult['codigo'], $usuario['nombres']);

        if (!$enviado) {
            unset($_SESSION['login_temp']);
            $this->redirect(BASE_URL . '/login?error=Error al enviar código de verificación');
        }

        $this->redirect(BASE_URL . '/verificar-otp-login');
    }

    public function showRegisterForm(): void
    {
        if (isset($_SESSION['usuario'])) {
            $this->redirect(BASE_URL . '/');
        }
        $error = $_GET['error'] ?? '';
        $this->view('auth/register', ['error' => $error]);
    }

    public function register(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect(BASE_URL . '/registro');
        }

        $nombres = trim($_POST['nombres'] ?? '');
        $apellidos = trim($_POST['apellidos'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $telefono = trim($_POST['telefono'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($nombres) || empty($apellidos) || empty($email) || empty($password)) {
            $this->redirect(BASE_URL . '/registro?error=Todos los campos son obligatorios');
        }

        if (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $email)) {
            $this->redirect(BASE_URL . '/registro?error=Formato de correo inválido');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->redirect(BASE_URL . '/registro?error=Correo electrónico inválido');
        }

        if (strlen($password) < 6) {
            $this->redirect(BASE_URL . '/registro?error=La contraseña debe tener al menos 6 caracteres');
        }

        if (preg_match('/^[0-9]+$/', $password) || preg_match('/^[a-zA-Z]+$/', $password)) {
            error_log("Advertencia: Contraseña débil para email: $email");
        }

        if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $nombres)) {
            $this->redirect(BASE_URL . '/registro?error=Los nombres solo pueden contener letras');
        }

        if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $apellidos)) {
            $this->redirect(BASE_URL . '/registro?error=Los apellidos solo pueden contener letras');
        }

        if (!empty($telefono) && !preg_match('/^[0-9]{7,15}$/', $telefono)) {
            $this->redirect(BASE_URL . '/registro?error=El teléfono solo debe contener números (7-15 dígitos)');
        }

        if ($this->usuarioRepo->emailExists($email)) {
            $this->redirect(BASE_URL . '/registro?error=El email ya está registrado');
        }

        $_SESSION['registro_temp'] = [
            'nombres' => $nombres,
            'apellidos' => $apellidos,
            'email' => $email,
            'telefono' => $telefono,
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
            'roles_seleccionados' => []
        ];

        $this->redirect(BASE_URL . '/elegir-roles');
    }

    public function showRoleSelection(): void
    {
        if (!isset($_SESSION['registro_temp'])) {
            $this->redirect(BASE_URL . '/registro');
        }

        $error = '';
        $temp = $_SESSION['registro_temp'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $rolesSeleccionados = $_POST['roles'] ?? [];
            $avatarSeleccionado = $_POST['avatar'] ?? '';

            if (empty($rolesSeleccionados)) {
                $error = 'Selecciona al menos un rol para continuar';
            } else {
                $_SESSION['registro_temp']['roles_seleccionados'] = $rolesSeleccionados;
                $_SESSION['registro_temp']['avatar'] = $avatarSeleccionado;
                $this->redirect(BASE_URL . '/enviar-otp');
            }
        }

        $db = $this->getDB();
        $stmt = $db->prepare("SELECT id_rol, nombre_rol FROM roles WHERE nombre_rol IN ('Cliente', 'Emprendedor', 'Repartidor')");
        $stmt->execute();
        $rolesDisponibles = $stmt->fetchAll();

        $avataresDefault = [];
        for ($i = 1; $i <= 8; $i++) {
            $avataresDefault[] = "assets/avatars/default/avatar_{$i}.jpg";
        }

        $this->view('auth/choose-roles', [
            'temp' => $temp,
            'error' => $error,
            'roles_disponibles' => $rolesDisponibles,
            'avatares_default' => $avataresDefault
        ]);
    }

    public function showVerificarOtp(): void
    {
        if (!isset($_SESSION['registro_temp'])) {
            $this->redirect(BASE_URL . '/registro');
        }
        $error = $_GET['error'] ?? '';
        $email = $_SESSION['registro_temp']['email'];
        $resent = isset($_GET['resent']) ? 1 : 0;
        $this->view('auth/verify-otp', ['error' => $error, 'email' => $email, 'resent' => $resent]);
    }

    public function showVerificarOtpLogin(): void
    {
        if (!isset($_SESSION['login_temp'])) {
            $this->redirect(BASE_URL . '/login');
        }
        $error = $_GET['error'] ?? '';
        $email = $_SESSION['login_temp']['email'];
        $this->view('auth/verify-otp-login', ['error' => $error, 'email' => $email]);
    }

    public function verifyOtp(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect(BASE_URL . '/verificar-otp');
        }

        if (!isset($_SESSION['registro_temp'])) {
            $this->redirect(BASE_URL . '/registro');
        }

        $codigo = $_POST['codigo'] ?? '';
        $temp = $_SESSION['registro_temp'];

        $result = $this->otp->verificarCodigo($temp['email'], $codigo);

        if (!$result['success']) {
            $this->redirect(BASE_URL . '/verificar-otp?error=' . urlencode($result['error']));
        }

        $db = $this->getDB();
        $db->beginTransaction();

        try {
            if ($this->usuarioRepo->emailExists($temp['email'])) {
                throw new \Exception("El email ya está registrado");
            }

            $idUsuario = $this->usuarioRepo->insert($temp);

            $rolesNombres = explode(',', $temp['roles_seleccionados']);
            foreach ($rolesNombres as $rolNombre) {
                $rolId = $this->usuarioRepo->getRolIdByName(trim($rolNombre));
                if ($rolId) {
                    $this->usuarioRepo->insertUsuarioRol($idUsuario, $rolId);
                }
            }

            $avatarFinal = $temp['avatar'] ?? 'assets/avatars/default/avatar_1.jpg';

            if (strpos($avatarFinal, 'uploads/temp_avatars/') === 0) {
                $tempPath = BASE_PATH . 'public/' . $avatarFinal;
                $extension = pathinfo($tempPath, PATHINFO_EXTENSION);
                $destinoDir = BASE_PATH . 'public/uploads/avatars/';

                if (!file_exists($destinoDir)) {
                    mkdir($destinoDir, 0777, true);
                }

                $nombreFinal = 'avatar_' . $idUsuario . '_' . time() . '.' . $extension;
                $destino = $destinoDir . $nombreFinal;
                $avatarFinalDb = 'uploads/avatars/' . $nombreFinal;

                if (file_exists($tempPath)) {
                    rename($tempPath, $destino);
                    $avatarFinal = $avatarFinalDb;
                    $this->usuarioRepo->updateAvatar($idUsuario, $avatarFinal);
                }
            } else {
                $this->usuarioRepo->updateAvatar($idUsuario, $avatarFinal);
            }

            $db->commit();

            $rolesInfo = $this->usuarioRepo->getUserRolesInfo($idUsuario);
            $rolesStr = $rolesInfo ? ($rolesInfo['roles'] ?? '') : '';
            $totalRoles = $rolesInfo ? (int)$rolesInfo['total'] : 0;
            $rolesArray = $rolesInfo ? explode(',', $rolesStr) : [];

            $_SESSION['usuario'] = [
                'id' => $idUsuario,
                'nombre' => $temp['nombres'] . ' ' . $temp['apellidos'],
                'email' => $temp['email'],
                'roles_todos' => $rolesStr
            ];

            unset($_SESSION['registro_temp']);

            if ($totalRoles > 1) {
                $this->redirect(BASE_URL . '/selector-rol');
            } else {
                $_SESSION['rol_activo'] = trim($rolesArray[0]);
                $this->redirect(BASE_URL . '/dashboard');
            }

        } catch (\Exception $e) {
            $db->rollBack();
            error_log("Error al crear usuario: " . $e->getMessage());
            $this->redirect(BASE_URL . '/registro?error=Error al crear usuario. Intenta nuevamente.');
        }
    }

    public function verifyOtpLogin(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect(BASE_URL . '/login');
        }

        if (!isset($_SESSION['login_temp'])) {
            $this->redirect(BASE_URL . '/login');
        }

        $codigo = $_POST['codigo'] ?? '';
        $temp = $_SESSION['login_temp'];

        $result = $this->otp->verificarCodigo($temp['email'], $codigo);

        if (!$result['success']) {
            $this->redirect(BASE_URL . '/verificar-otp-login?error=' . urlencode($result['error']));
        }

        $_SESSION['usuario'] = [
            'id' => $temp['id'],
            'nombre' => $temp['nombre'],
            'email' => $temp['email'],
            'roles_todos' => $temp['roles'] ?? ''
        ];

        $rolesArray = explode(',', $temp['roles'] ?? '');
        $totalRoles = count($rolesArray);

        unset($_SESSION['login_temp']);

        if ($totalRoles > 1) {
            $this->redirect(BASE_URL . '/selector-rol');
        } else {
            $rolUnico = trim($rolesArray[0]);
            $_SESSION['rol_activo'] = $rolUnico;
            $this->redirect(BASE_URL . '/dashboard');
        }
    }

    public function sendOtp(): void
    {
        if (!isset($_SESSION['registro_temp'])) {
            $this->redirect(BASE_URL . '/registro');
        }

        $temp = $_SESSION['registro_temp'];

        if (empty($temp['roles_seleccionados'])) {
            $this->redirect(BASE_URL . '/elegir-roles');
        }

        $otpResult = $this->otp->generarCodigo($temp['email']);

        if (!$otpResult['success']) {
            $this->redirect(BASE_URL . '/elegir-roles?error=' . urlencode($otpResult['error']));
        }

        $_SESSION['registro_temp']['codigo_otp'] = $otpResult['codigo'];

        $enviado = $this->mailer->enviarCodigoOTP($temp['email'], $otpResult['codigo'], $temp['nombres']);

        if (!$enviado) {
            unset($_SESSION['registro_temp']['codigo_otp']);
            $this->redirect(BASE_URL . '/elegir-roles?error=Error al enviar el código de verificación');
        }

        $this->redirect(BASE_URL . '/verificar-otp');
    }

    public function resendOtp(): void
    {
        if (!isset($_SESSION['registro_temp'])) {
            $this->redirect(BASE_URL . '/registro');
        }

        $temp = $_SESSION['registro_temp'];

        $otpResult = $this->otp->generarCodigo($temp['email']);

        if (!$otpResult['success']) {
            $this->redirect(BASE_URL . '/verificar-otp?error=' . urlencode($otpResult['error']));
        }

        $_SESSION['registro_temp']['codigo_otp'] = $otpResult['codigo'];

        $enviado = $this->mailer->enviarCodigoOTP($temp['email'], $otpResult['codigo'], $temp['nombres']);

        if (!$enviado) {
            $this->redirect(BASE_URL . '/verificar-otp?error=Error al reenviar el código');
        }

        $this->redirect(BASE_URL . '/verificar-otp?resent=1');
    }

    public function resendOtpLogin(): void
    {
        if (!isset($_SESSION['login_temp'])) {
            $this->redirect(BASE_URL . '/login');
        }

        $temp = $_SESSION['login_temp'];

        $otpResult = $this->otp->generarCodigo($temp['email']);

        if (!$otpResult['success']) {
            $this->redirect(BASE_URL . '/verificar-otp-login?error=' . urlencode($otpResult['error']));
        }

        $_SESSION['login_temp']['codigo_otp'] = $otpResult['codigo'];

        $enviado = $this->mailer->enviarCodigoOTP($temp['email'], $otpResult['codigo'], explode(' ', $temp['nombre'])[0]);

        if (!$enviado) {
            $this->redirect(BASE_URL . '/verificar-otp-login?error=Error al reenviar el código');
        }

        $this->redirect(BASE_URL . '/verificar-otp-login?resent=1');
    }

    public function logout(): void
    {
        session_destroy();
        $this->redirect(BASE_URL . '/login');
    }

    public function showSelectorRol(): void
    {
        $this->requireAuth();

        $usuario = $_SESSION['usuario'];
        $db = $this->getDB();

        $stmt = $db->prepare("
            SELECT r.id_rol, r.nombre_rol 
            FROM usuario_roles ur
            JOIN roles r ON ur.id_rol = r.id_rol
            WHERE ur.id_usuario = ?
        ");
        $stmt->execute([$usuario['id']]);
        $rolesDisponibles = $stmt->fetchAll();

        if (count($rolesDisponibles) <= 1) {
            $rolUnico = $rolesDisponibles[0]['nombre_rol'];
            $_SESSION['rol_activo'] = $rolUnico;
            $this->redirect(BASE_URL . '/dashboard');
        }

        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $rolSeleccionado = $_POST['rol'] ?? '';
            $rolValido = false;
            foreach ($rolesDisponibles as $rol) {
                if ($rol['nombre_rol'] === $rolSeleccionado) {
                    $rolValido = true;
                    break;
                }
            }

            if ($rolValido) {
                $_SESSION['rol_activo'] = $rolSeleccionado;
                $this->redirect(BASE_URL . '/dashboard');
            } else {
                $error = 'Rol no válido';
            }
        }

        $this->view('auth/selector-rol', [
            'usuario' => $usuario,
            'roles_disponibles' => $rolesDisponibles,
            'error' => $error
        ]);
    }

    public function guardarTempAvatar(): void
    {
        $tempDir = BASE_PATH . 'public/uploads/temp_avatars/';
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0777, true);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['temp_avatar'])) {
            $file = $_FILES['temp_avatar'];

            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $file['tmp_name']);
            finfo_close($finfo);

            if (!in_array($mimeType, $allowedTypes)) {
                $this->json(['success' => false, 'error' => 'Tipo de archivo no válido. Solo imágenes JPG, PNG, GIF, WEBP.']);
                return;
            }

            if ($file['size'] > 5 * 1024 * 1024) {
                $this->json(['success' => false, 'error' => 'La imagen es demasiado grande. Máximo 5MB.']);
                return;
            }

            $sessionId = session_id();
            $nombreArchivo = 'temp_' . $sessionId . '_' . time() . '.jpg';
            $rutaTemporal = $tempDir . $nombreArchivo;
            $rutaDb = 'uploads/temp_avatars/' . $nombreArchivo;

            $img = null;
            switch ($mimeType) {
                case 'image/jpeg':
                case 'image/jpg':
                    $img = imagecreatefromjpeg($file['tmp_name']);
                    break;
                case 'image/png':
                    $img = imagecreatefrompng($file['tmp_name']);
                    break;
                case 'image/gif':
                    $img = imagecreatefromgif($file['tmp_name']);
                    break;
                case 'image/webp':
                    $img = imagecreatefromwebp($file['tmp_name']);
                    break;
            }

            if (!$img) {
                $this->json(['success' => false, 'error' => 'Error al procesar la imagen.']);
                return;
            }

            $width = imagesx($img);
            $height = imagesy($img);
            $maxSize = 400;
            if ($width > $maxSize || $height > $maxSize) {
                $ratio = min($maxSize / $width, $maxSize / $height);
                $newWidth = (int)round($width * $ratio);
                $newHeight = (int)round($height * $ratio);
                $resized = imagecreatetruecolor($newWidth, $newHeight);
                imagecopyresampled($resized, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                imagedestroy($img);
                $img = $resized;
            }

            if (imagejpeg($img, $rutaTemporal, 90)) {
                imagedestroy($img);
                $this->json([
                    'success' => true,
                    'temp_url' => $rutaDb,
                    'temp_path' => $rutaTemporal
                ]);
            } else {
                imagedestroy($img);
                $this->json(['success' => false, 'error' => 'Error al guardar la imagen en el servidor.']);
            }
        }

        $this->json(['success' => false, 'error' => 'No se recibió archivo']);
    }
}
