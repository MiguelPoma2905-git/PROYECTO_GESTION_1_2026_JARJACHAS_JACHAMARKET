<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

$usuario = $_SESSION['usuario'];
$db = getDB();

// Verificar si ya tiene emprendimiento
$stmt = $db->prepare("SELECT * FROM emprendimientos WHERE id_propietario = ?");
$stmt->execute([$usuario['id']]);
$emprendimiento = $stmt->fetch();

if ($emprendimiento) {
    header('Location: plantillas.php');
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_comercial = $_POST['nombre_comercial'] ?? '';
    $nit = $_POST['nit'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    
    if (empty($nombre_comercial)) {
        $error = 'El nombre comercial es obligatorio';
    } else {
        $stmt = $db->prepare("
            INSERT INTO emprendimientos (id_propietario, nombre_comercial, nit, descripcion, estado)
            VALUES (?, ?, ?, ?, 'Aprobado')
        ");
        
        if ($stmt->execute([$usuario['id'], $nombre_comercial, $nit, $descripcion])) {
            header('Location: plantillas.php');
            exit;
        } else {
            $error = 'Error al crear el emprendimiento';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Mi Emprendimiento - Jacha</title>
    <link rel="stylesheet" href="assets/css/plantilla_base.css">
    <style>
        .form-container {
            max-width: 600px;
            margin: 40px auto;
            padding: 30px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .error {
            background: #ffebee;
            color: #c62828;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h1>🏪 Crear Mi Emprendimiento</h1>
            <p>Completa los datos de tu negocio para comenzar a vender</p>
            
            <?php if ($error): ?>
            <div class="error">❌ <?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label>🏷️ Nombre Comercial *</label>
                    <input type="text" name="nombre_comercial" required placeholder="Ej: Artesanías Los Andes">
                </div>
                
                <div class="form-group">
                    <label>📄 NIT (opcional)</label>
                    <input type="text" name="nit" placeholder="Ej: 1234567890">
                </div>
                
                <div class="form-group">
                    <label>📝 Descripción del negocio</label>
                    <textarea name="descripcion" rows="4" placeholder="Cuéntanos sobre tu emprendimiento..."></textarea>
                </div>
                
                <button type="submit" class="btn btn-primary" style="width:100%">Crear Mi Tienda</button>
            </form>
        </div>
    </div>
    
    <div class="brand-watermark" style="text-align:center; margin-top:20px;">
        JACHA Marketplace ❤️💙
    </div>
</body>
</html>