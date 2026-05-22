<?php
/**
 * Script para crear un Super Administrador en JACHAmarket
 * 
 * Uso: php setup-admin.php
 *      o双击 setup-admin.bat (Windows)
 */

// ─── Configurar output para consola ───
if (PHP_SAPI !== 'cli') {
    die("Este script solo se ejecuta desde la terminal.\n");
}

echo "╔══════════════════════════════════════════╗\n";
echo "║     CREAR SUPER ADMIN - JACHAmarket      ║\n";
echo "╚══════════════════════════════════════════╝\n\n";

// ─── Base de datos ───
$dbConfig = __DIR__ . '/config/database.php';
if (!file_exists($dbConfig)) {
    die("ERROR: No se encuentra config/database.php\n");
}
require_once $dbConfig;

try {
    $db = new Database();
    $conn = $db->getConnection();
    echo "[OK] Conexión a la base de datos exitosa\n";
} catch (Exception $e) {
    die("ERROR: No se pudo conectar a la BD: " . $e->getMessage() . "\n");
}

// ─── Asegurar que los roles existen ───
$roles = ['Administrador', 'Emprendedor', 'Cliente', 'Repartidor'];
$stmt = $conn->prepare("SELECT COUNT(*) FROM roles");
$stmt->execute();
if ((int)$stmt->fetchColumn() === 0) {
    $insert = $conn->prepare("INSERT INTO roles (nombre_rol) VALUES (?)");
    foreach ($roles as $rol) {
        $insert->execute([$rol]);
    }
    echo "[OK] Roles creados automaticamente\n";
} else {
    echo "[OK] Roles ya existen\n";
}

// ─── Pedir datos del admin ───
echo "\n";

echo "Email del super admin: ";
$email = trim(fgets(STDIN));
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("ERROR: Email invalido\n");
}

// Verificar si ya existe
$stmt = $conn->prepare("SELECT id_usuario FROM usuarios WHERE email = ?");
$stmt->execute([$email]);
if ($stmt->fetch()) {
    die("ERROR: El email '$email' ya esta registrado\n");
}

echo "Nombres: ";
$nombres = trim(fgets(STDIN));
if ($nombres === '') die("ERROR: Los nombres son obligatorios\n");

echo "Apellidos: ";
$apellidos = trim(fgets(STDIN));
if ($apellidos === '') die("ERROR: Los apellidos son obligatorios\n");

echo "Telefono (opcional, Enter para omitir): ";
$telefono = trim(fgets(STDIN));

echo "Contrasena: ";
$password = trim(fgets(STDIN));
echo "\n";

if (strlen($password) < 6) {
    die("ERROR: La contrasena debe tener al menos 6 caracteres\n");
}

echo "Confirmar contrasena: ";
$confirm = trim(fgets(STDIN));
echo "\n";

if ($password !== $confirm) {
    die("ERROR: Las contrasenas no coinciden\n");
}

// ─── Crear usuario ───
$hash = password_hash($password, PASSWORD_DEFAULT);

$conn->beginTransaction();
try {
    $stmt = $conn->prepare("
        INSERT INTO usuarios (nombres, apellidos, email, password_hash, telefono, estado)
        VALUES (?, ?, ?, ?, ?, 'Activo')
    ");
    $stmt->execute([$nombres, $apellidos, $email, $hash, $telefono ?: null]);
    $idUsuario = (int)$conn->lastInsertId();

    // Asignar rol Administrador + Cliente
    $stmt = $conn->prepare("SELECT id_rol FROM roles WHERE nombre_rol = ?");
    $stmt->execute(['Administrador']);
    $idAdmin = (int)$stmt->fetchColumn();

    $stmt = $conn->prepare("INSERT INTO usuario_roles (id_usuario, id_rol) VALUES (?, ?)");
    $stmt->execute([$idUsuario, $idAdmin]);

    // Tambien asignar Cliente (opcional util)
    $stmt = $conn->prepare("SELECT id_rol FROM roles WHERE nombre_rol = ?");
    $stmt->execute(['Cliente']);
    $idCliente = (int)$stmt->fetchColumn();
    $stmt = $conn->prepare("INSERT IGNORE INTO usuario_roles (id_usuario, id_rol) VALUES (?, ?)");
    $stmt->execute([$idUsuario, $idCliente]);

    $conn->commit();

    echo "\n✅ SUPER ADMIN CREADO EXITOSAMENTE\n";
    echo "   Email:      $email\n";
    echo "   Nombre:     $nombres $apellidos\n";
    echo "   ID Usuario: $idUsuario\n";
    echo "   Rol:        Administrador\n";
    echo "\nIngresa en: " . ($_SERVER['HTTP_HOST'] ?? 'http://localhost/PROYECTO_GESTION_1_2026_JARJACHAS_JACHAMARKET') . "/login\n";

} catch (Exception $e) {
    $conn->rollBack();
    die("ERROR: " . $e->getMessage() . "\n");
}
