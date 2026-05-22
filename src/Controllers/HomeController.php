<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Repositories\EmprendimientoRepository;
use App\Repositories\PlantillaRepository;

class HomeController extends Controller
{
    private EmprendimientoRepository $emprendimientoRepo;
    private PlantillaRepository $plantillaRepo;

    public function __construct()
    {
        parent::__construct();
        $this->emprendimientoRepo = new EmprendimientoRepository();
        $this->plantillaRepo = new PlantillaRepository();
    }

    public function index(): void
    {
        $usuario = $_SESSION['usuario'] ?? null;
        $isLoggedIn = $usuario !== null;
        $rolActivo = $_SESSION['rol_activo'] ?? ($usuario['rol'] ?? 'Cliente');
        $isVendedor = $isLoggedIn && $rolActivo === 'Emprendedor';
        $isCliente = $isLoggedIn && $rolActivo === 'Cliente';
        $isRepartidor = $isLoggedIn && $rolActivo === 'Repartidor';

        $escaparates = $this->emprendimientoRepo->findFeatured();
        $ambientes = $this->plantillaRepo->findAllActive();

        $db = $this->getDB();
        $totalNegocios = (int)$db->query("SELECT COUNT(*) FROM emprendimientos WHERE estado = 'Aprobado'")->fetchColumn();
        $totalProductos = (int)$db->query("SELECT COUNT(*) FROM productos WHERE estado = 'Publicado'")->fetchColumn();
        $totalUsuarios = (int)$db->query("SELECT COUNT(*) FROM usuarios")->fetchColumn();
        $totalPedidos = (int)$db->query("SELECT COUNT(*) FROM pedidos")->fetchColumn();

        $this->view('pages/home', [
            'usuario' => $usuario,
            'is_logged_in' => $isLoggedIn,
            'is_vendedor' => $isVendedor,
            'is_cliente' => $isCliente,
            'is_repartidor' => $isRepartidor,
            'rol_activo' => $rolActivo,
            'escaparates' => $escaparates,
            'ambientes' => $ambientes,
            'total_negocios' => $totalNegocios,
            'total_productos' => $totalProductos,
            'total_usuarios' => $totalUsuarios,
            'total_pedidos' => $totalPedidos
        ]);
    }

    public function explorar(): void
    {
        $usuario = $_SESSION['usuario'] ?? null;
        $isLoggedIn = $usuario !== null;

        $negocios = $this->emprendimientoRepo->findAprobadosExcept(0);

        $this->view('pages/explorar', [
            'usuario' => $usuario,
            'is_logged_in' => $isLoggedIn,
            'negocios' => $negocios
        ]);
    }

    public function dbDemo(): void
    {
        $usuario = $_SESSION['usuario'] ?? null;
        $db = $this->getDB();

        // 1. Análisis de tablas transaccionales
        $stmt = $db->query("
            SELECT 
                'productos' AS tabla, COUNT(*) AS registros, 'Alta' AS transaccionalidad
            FROM productos
            UNION ALL
            SELECT 'pedidos', COUNT(*), 'Alta' FROM pedidos
            UNION ALL
            SELECT 'detalles_pedido', COUNT(*), 'Muy Alta' FROM detalles_pedido
            UNION ALL
            SELECT 'usuarios', COUNT(*), 'Media' FROM usuarios
            UNION ALL
            SELECT 'emprendimientos', COUNT(*), 'Baja' FROM emprendimientos
            ORDER BY registros DESC
        ");
        $tablas = $stmt->fetchAll();

        // 2. Población
        $stmt = $db->query("SELECT COUNT(*) as total FROM productos");
        $totalProductos = (int)$stmt->fetch()['total'];
        $cumple5000 = $totalProductos >= 5000;

        // 3. Índice prueba
        $stmt = $db->query("SELECT MIN(id_emprendimiento) as id FROM emprendimientos");
        $idEmprendimiento = $stmt->fetch()['id'] ?? 1;

        $stmtCheck = $db->query("SHOW INDEX FROM productos WHERE Key_name = 'idx_productos_emprendimiento_precio'");
        $indiceExiste = $stmtCheck->rowCount() > 0;

        $startSin = microtime(true);
        $db->query("SELECT COUNT(*) FROM productos IGNORE INDEX (idx_productos_emprendimiento_precio) WHERE id_emprendimiento = $idEmprendimiento AND precio_base > 500")->fetch();
        $timeSin = round((microtime(true) - $startSin) * 1000, 2);

        if (!$indiceExiste) {
            $db->exec("CREATE INDEX idx_productos_emprendimiento_precio ON productos(id_emprendimiento, precio_base)");
        }

        $startCon = microtime(true);
        $db->query("SELECT COUNT(*) FROM productos WHERE id_emprendimiento = $idEmprendimiento AND precio_base > 500")->fetch();
        $timeCon = round((microtime(true) - $startCon) * 1000, 2);

        $mejora = $timeSin > 0 ? round((1 - $timeCon / $timeSin) * 100) : 0;

        // 4. Particiones
        $stmt = $db->query("SHOW CREATE TABLE pedidos");
        $createTable = $stmt->fetch();
        $tieneParticiones = strpos($createTable['Create Table'], 'PARTITION BY') !== false;

        // 5. Procedimiento
        $stmt = $db->query("SHOW PROCEDURE STATUS WHERE Name = 'sp_reporte_ventas_emprendimiento'");
        $procedimientoExiste = $stmt->rowCount() > 0;
        $reporte = null;
        if ($procedimientoExiste) {
            try {
                $stmt = $db->query("CALL sp_reporte_ventas_emprendimiento($idEmprendimiento, '2025-01-01', '2025-12-31')");
                $reporte = $stmt->fetch();
            } catch (\Exception $e) { $reporte = null; }
        }

        // 6. Función
        $stmt = $db->query("SHOW FUNCTION STATUS WHERE Name = 'fn_calcular_ganancia_neta'");
        $funcionExiste = $stmt->rowCount() > 0;
        $pruebaFuncion = null;
        if ($funcionExiste) {
            $stmt = $db->query("SELECT fn_calcular_ganancia_neta(500, 350, 13) AS ganancia");
            $pruebaFuncion = $stmt->fetch();
        }

        // 7. Trigger
        $stmt = $db->query("SHOW TRIGGERS WHERE `Trigger` = 'trg_actualizar_stock_venta'");
        $triggerExiste = $stmt->rowCount() > 0;

        // 8. Búsqueda
        $busqueda = $_GET['search'] ?? '';
        $filtroPrecio = $_GET['precio'] ?? '';
        $pagina = (int)($_GET['page'] ?? 1);
        $porPagina = 20;
        $offset = ($pagina - 1) * $porPagina;

        $sqlBase = "SELECT p.*, e.nombre_comercial FROM productos p JOIN emprendimientos e ON p.id_emprendimiento = e.id_emprendimiento WHERE 1=1";
        $params = [];

        if (!empty($busqueda)) {
            $sqlBase .= " AND p.nombre LIKE ?";
            $params[] = "%$busqueda%";
        }
        if (!empty($filtroPrecio)) {
            if ($filtroPrecio == 'menor_100') {
                $sqlBase .= " AND p.precio_base < 100";
            } elseif ($filtroPrecio == '100_500') {
                $sqlBase .= " AND p.precio_base BETWEEN 100 AND 500";
            } elseif ($filtroPrecio == 'mayor_500') {
                $sqlBase .= " AND p.precio_base > 500";
            }
        }

        $stmtCount = $db->prepare(str_replace("p.*, e.nombre_comercial", "COUNT(*)", $sqlBase));
        $stmtCount->execute($params);
        $totalRegistros = (int)$stmtCount->fetchColumn();

        $sql = $sqlBase . " LIMIT $porPagina OFFSET $offset";
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $productos = $stmt->fetchAll();
        $totalPaginas = ceil($totalRegistros / $porPagina);

        $this->view('pages/db-demo', [
            'tablas' => $tablas,
            'total_productos' => $totalProductos,
            'cumple_5000' => $cumple5000,
            'time_sin' => $timeSin, 'time_con' => $timeCon,
            'mejora' => $mejora, 'indice_existe' => $indiceExiste,
            'tiene_particiones' => $tieneParticiones,
            'procedimiento_existe' => $procedimientoExiste,
            'reporte' => $reporte,
            'funcion_existe' => $funcionExiste,
            'prueba_funcion' => $pruebaFuncion,
            'trigger_existe' => $triggerExiste,
            'busqueda' => $busqueda, 'filtro_precio' => $filtroPrecio,
            'pagina' => $pagina, 'por_pagina' => $porPagina,
            'productos' => $productos, 'total_registros' => $totalRegistros,
            'total_paginas' => $totalPaginas
        ]);
    }
}
