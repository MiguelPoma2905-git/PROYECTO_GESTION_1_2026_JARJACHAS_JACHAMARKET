<?php
require_once __DIR__ . '/../config/database.php';

echo "<h1>Prueba de conexión a Base de Datos</h1>";

try {
    $db = getDB();
    echo "<p style='color:green'>✓ Conexión exitosa a la base de datos</p>";
    
    // Probar consulta simple
    $stmt = $db->query("SELECT COUNT(*) as total FROM usuarios");
    $result = $stmt->fetch();
    echo "<p>📊 Usuarios registrados: " . $result['total'] . "</p>";
    
    $stmt = $db->query("SELECT nombre_rol FROM roles");
    $roles = $stmt->fetchAll();
    echo "<p>📋 Roles disponibles:</p><ul>";
    foreach ($roles as $rol) {
        echo "<li>" . $rol['nombre_rol'] . "</li>";
    }
    echo "</ul>";
    
} catch (Exception $e) {
    echo "<p style='color:red'>✗ Error: " . $e->getMessage() . "</p>";
}
?>