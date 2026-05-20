<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Demostración BD - Jacha Marketplace</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Cormorant+Garamond:wght@400;500&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: #0a0a0a;
            color: #e8e8e8;
            line-height: 1.5;
        }
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url('<?= BASE_URL ?>/assets/images/fondo_1.jpg');
            background-size: cover;
            background-position: center;
            opacity: 0.06;
            pointer-events: none;
        }
        
        .header {
            border-bottom: 1px solid rgba(255,255,255,0.08);
            padding: 20px 32px;
            background: rgba(10,10,10,0.8);
            backdrop-filter: blur(16px);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .header-content {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logo { font-family: 'Cormorant Garamond', serif; font-size: 26px; color: #fff; text-decoration: none; }
        .logo span { color: #888; font-weight: 300; }
        .back-btn { color: #aaa; text-decoration: none; font-size: 14px; transition: color 0.2s; }
        .back-btn:hover { color: #fff; }
        .robot-icon {
            background: none;
            border: none;
            font-size: 28px;
            cursor: pointer;
            transition: transform 0.2s;
        }
        .robot-icon:hover { transform: scale(1.1); }
        
        .hero {
            text-align: center;
            padding: 60px 24px 40px;
            background: linear-gradient(135deg, rgba(26,65,71,0.3), rgba(250,113,54,0.1));
        }
        .hero h1 { font-family: Georgia, serif; font-size: 42px; font-weight: 400; margin-bottom: 16px; color: #fff; }
        .hero p { color: #888; font-size: 16px; max-width: 700px; margin: 0 auto; }
        
        .container { max-width: 1400px; margin: 0 auto; padding: 48px 32px; }
        
        .card {
            background: #121212;
            border: 1px solid #2a2a2a;
            border-radius: 24px;
            margin-bottom: 32px;
            overflow: hidden;
            transition: all 0.3s;
        }
        .card:hover { border-color: #3a3a3a; }
        .card-header {
            padding: 24px 28px;
            border-bottom: 1px solid #2a2a2a;
            background: #161616;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
        }
        .card-header h2 { font-family: Georgia, serif; font-size: 22px; font-weight: 400; color: #fff; }
        .card-header p { font-size: 13px; color: #888; margin-top: 6px; }
        .card-body { padding: 28px; }
        
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 20px; }
        .stat-card {
            background: #1a1a1a;
            border-radius: 16px;
            padding: 20px;
            text-align: center;
            border: 1px solid #2a2a2a;
        }
        .stat-card .number { font-size: 36px; font-weight: 600; color: #fa7136; font-family: Georgia, serif; }
        .stat-card .label { font-size: 12px; color: #888; margin-top: 8px; text-transform: uppercase; letter-spacing: 1px; }
        
        .comparison { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
        .comparison-box {
            background: #1a1a1a;
            border-radius: 16px;
            padding: 24px;
            text-align: center;
            border: 1px solid #2a2a2a;
        }
        .comparison-box .title { font-size: 13px; color: #888; margin-bottom: 12px; text-transform: uppercase; }
        .comparison-box .time { font-size: 42px; font-weight: 600; color: #fff; font-family: monospace; }
        .comparison-box .unit { font-size: 12px; color: #666; }
        .improvement-badge {
            background: rgba(76,175,80,0.12);
            border: 1px solid rgba(76,175,80,0.3);
            border-radius: 40px;
            padding: 12px 24px;
            text-align: center;
            margin-top: 20px;
        }
        .improvement-badge .percent { font-size: 24px; font-weight: 700; color: #4caf50; }
        .improvement-badge .text { font-size: 13px; color: #aaa; }
        
        .status-badge { display: inline-flex; align-items: center; gap: 6px; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 500; }
        .status-success { background: rgba(76,175,80,0.15); color: #4caf50; }
        .status-info { background: rgba(33,150,243,0.15); color: #2196f3; }
        
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 12px; font-size: 12px; font-weight: 600; color: #888; border-bottom: 1px solid #2a2a2a; }
        td { padding: 12px; font-size: 13px; border-bottom: 1px solid #2a2a2a; }
        
        .code-block {
            background: #0d0d0d;
            border-radius: 12px;
            padding: 16px;
            font-family: monospace;
            font-size: 12px;
            color: #4caf50;
            overflow-x: auto;
            border: 1px solid #2a2a2a;
        }
        
        .search-bar {
            display: flex;
            gap: 16px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }
        .search-input {
            flex: 2;
            padding: 12px 16px;
            background: #1a1a1a;
            border: 1px solid #2a2a2a;
            border-radius: 12px;
            color: #fff;
            font-size: 14px;
        }
        .search-input:focus { outline: none; border-color: #fa7136; }
        .filter-select {
            flex: 1;
            padding: 12px 16px;
            background: #1a1a1a;
            border: 1px solid #2a2a2a;
            border-radius: 12px;
            color: #fff;
            cursor: pointer;
        }
        .btn-search {
            padding: 12px 28px;
            background: #fa7136;
            border: none;
            border-radius: 12px;
            color: white;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-search:hover { background: #e05a2a; transform: translateY(-1px); }
        
        .pagination {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-top: 24px;
            flex-wrap: wrap;
        }
        .pagination a, .pagination span {
            padding: 8px 14px;
            background: #1a1a1a;
            border: 1px solid #2a2a2a;
            border-radius: 8px;
            color: #aaa;
            text-decoration: none;
            font-size: 13px;
            transition: all 0.2s;
        }
        .pagination a:hover { background: #333; color: #fff; }
        .pagination .active { background: #fa7136; color: #fff; border-color: #fa7136; }
        
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.9);
            backdrop-filter: blur(8px);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }
        .modal.active { display: flex; }
        .modal-content {
            background: #1a1a1a;
            border-radius: 28px;
            max-width: 700px;
            width: 90%;
            max-height: 85vh;
            overflow-y: auto;
            border: 1px solid #3a3a3a;
        }
        .modal-header {
            padding: 24px 28px;
            border-bottom: 1px solid #2a2a2a;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .modal-header h3 { font-size: 24px; font-weight: 400; font-family: Georgia, serif; }
        .close-modal {
            background: none;
            border: none;
            color: #888;
            font-size: 28px;
            cursor: pointer;
        }
        .close-modal:hover { color: #fff; }
        .modal-body { padding: 28px; }
        .question-card {
            background: #121212;
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid #2a2a2a;
        }
        .question-card h4 { font-size: 18px; font-weight: 500; margin-bottom: 12px; color: #fa7136; }
        .question-card p { color: #aaa; font-size: 14px; line-height: 1.6; margin-bottom: 12px; }
        .question-card .answer { color: #4caf50; font-size: 14px; border-top: 1px solid #2a2a2a; padding-top: 12px; margin-top: 8px; }
        
        .watermark { position: fixed; bottom: 12px; right: 12px; font-size: 9px; color: rgba(255,255,255,0.04); pointer-events: none; font-family: monospace; }
        
        @media (max-width: 1024px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } .comparison { grid-template-columns: 1fr; } }
        @media (max-width: 768px) { .container { padding: 32px 20px; } .hero h1 { font-size: 32px; } .stats-grid { grid-template-columns: 1fr; } .search-bar { flex-direction: column; } }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <a href="<?= BASE_URL ?>/" class="logo">JACHA<span>market</span></a>
            <div style="display: flex; align-items: center; gap: 20px;">
                <button class="robot-icon" id="robotBtn">🤖</button>
                <a href="<?= BASE_URL ?>/" class="back-btn">← Volver</a>
            </div>
        </div>
    </div>
    
    <div class="hero">
        <h1>Demostración de Base de Datos</h1>
        <p>Análisis de rendimiento, índices, particiones, procedimientos y triggers | Total de <?= number_format($total_productos) ?> productos registrados</p>
    </div>
    
    <div class="container">
        
        <div class="card">
            <div class="card-header">
                <h2>Análisis de tablas transaccionales</h2>
                <span class="status-badge status-success">✓ 10% evaluación</span>
            </div>
            <div class="card-body">
                <table>
                    <thead><tr><th>Tabla</th><th>Registros</th><th>Nivel</th><th>Justificación</th></tr></thead>
                    <tbody>
                        <tr><td><strong>detalles_pedido</strong></td><td><?= number_format($tablas[2]['registros'] ?? 0) ?></td><td><span class="status-badge status-success">Muy Alta</span></td><td>Cada pedido genera múltiples registros</td></tr>
                        <tr><td><strong>pedidos</strong></td><td><?= number_format($tablas[1]['registros'] ?? 0) ?></td><td><span class="status-badge status-success">Alta</span></td><td>Cada compra genera un registro</td></tr>
                        <tr><td><strong>productos</strong></td><td><?= number_format($tablas[0]['registros'] ?? 0) ?></td><td><span class="status-badge status-info">Media-Alta</span></td><td>Catálogo de productos por negocio</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h2>Población masiva de datos + Explorador</h2>
                <span class="status-badge <?= $cumple_5000 ? 'status-success' : 'status-info' ?>"><?= $cumple_5000 ? '✓ 15% cumplido' : '⚠ 15% pendiente' ?></span>
            </div>
            <div class="card-body">
                <div class="stats-grid">
                    <div class="stat-card"><div class="number"><?= number_format($total_productos) ?></div><div class="label">Productos registrados</div></div>
                    <div class="stat-card"><div class="number">5,000</div><div class="label">Meta requerida</div></div>
                    <div class="stat-card"><div class="number"><?= round(($total_productos / 5000) * 100) ?>%</div><div class="label">Cumplimiento</div></div>
                    <div class="stat-card"><div class="number">2</div><div class="label">Negocios</div></div>
                </div>
                
                <form method="GET" class="search-bar" id="searchForm" action="<?= BASE_URL ?>/db-demo">
                    <input type="text" name="search" class="search-input" placeholder="Buscar producto..." value="<?= htmlspecialchars($busqueda) ?>">
                    <select name="precio" class="filter-select">
                        <option value="">Todos los precios</option>
                        <option value="menor_100" <?= $filtro_precio == 'menor_100' ? 'selected' : '' ?>>Menor a Bs 100</option>
                        <option value="100_500" <?= $filtro_precio == '100_500' ? 'selected' : '' ?>>Bs 100 - Bs 500</option>
                        <option value="mayor_500" <?= $filtro_precio == 'mayor_500' ? 'selected' : '' ?>>Mayor a Bs 500</option>
                    </select>
                    <button type="submit" class="btn-search">Buscar</button>
                    <?php if (!empty($busqueda) || !empty($filtro_precio)): ?>
                        <a href="<?= BASE_URL ?>/db-demo" class="btn-search" style="background: #333;">Limpiar</a>
                    <?php endif; ?>
                </form>
                
                <div style="margin-bottom: 16px; display: flex; justify-content: space-between; align-items: center;">
                    <span style="color: #888; font-size: 13px;">Mostrando <?= count($productos) ?> de <?= number_format($total_registros) ?> productos</span>
                </div>
                
                <?php if (count($productos) > 0): ?>
                <div style="overflow-x: auto;">
                    <table>
                        <thead><tr><th>ID</th><th>Producto</th><th>Negocio</th><th>Precio</th><th>Stock</th></tr></thead>
                        <tbody>
                            <?php foreach ($productos as $prod): ?>
                            <tr>
                                <td>#<?= $prod['id_producto'] ?></td>
                                <td><?= htmlspecialchars(substr($prod['nombre'], 0, 50)) ?></td>
                                <td><?= htmlspecialchars($prod['nombre_comercial']) ?></td>
                                <td>Bs <?= number_format($prod['precio_base'], 2) ?></td>
                                <td><?= $prod['stock'] ?> unidades</td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <?php if ($total_paginas > 1): ?>
                <div class="pagination">
                    <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                        <a href="<?= BASE_URL ?>/db-demo?search=<?= urlencode($busqueda) ?>&precio=<?= urlencode($filtro_precio) ?>&page=<?= $i ?>" class="<?= $i == $pagina ? 'active' : '' ?>"><?= $i ?></a>
                    <?php endfor; ?>
                </div>
                <?php endif; ?>
                <?php else: ?>
                <div class="improvement-badge" style="border-color: rgba(255,193,7,0.3);"><span class="text">No se encontraron productos con los filtros aplicados.</span></div>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h2>Optimización con índices</h2>
                <span class="status-badge status-success">✓ 15% evaluación</span>
            </div>
            <div class="card-body">
                <div class="comparison">
                    <div class="comparison-box"><div class="title">Sin índice</div><div class="time"><?= $time_sin ?> ms</div><div class="unit">tiempo de respuesta</div></div>
                    <div class="comparison-box"><div class="title">Con índice</div><div class="time"><?= $time_con ?> ms</div><div class="unit">tiempo de respuesta</div></div>
                </div>
                <div class="improvement-badge"><span class="percent">+<?= $mejora ?>% de mejora</span><span class="text">El índice idx_productos_emprendimiento_precio acelera las búsquedas</span></div>
                <div class="code-block" style="margin-top: 20px;">CREATE INDEX idx_productos_emprendimiento_precio ON productos(id_emprendimiento, precio_base);</div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h2>Optimización con particiones</h2>
                <span class="status-badge status-success">✓ 15% evaluación</span>
            </div>
            <div class="card-body">
                <?php if ($tiene_particiones): ?>
                <div class="improvement-badge" style="margin-bottom: 20px;"><span class="percent">✓ Particiones activas</span><span class="text">Tabla pedidos particionada mensualmente</span></div>
                <div class="code-block">PARTITION BY RANGE COLUMNS(fecha_creacion) ( PARTITION p_ene_2025 VALUES LESS THAN ('2025-02-01'), PARTITION p_feb_2025... )</div>
                <div class="improvement-badge" style="margin-top: 20px; background: rgba(33,150,243,0.05);"><span class="text">Beneficio: Consultas por fecha solo escanean la partición relevante</span></div>
                <?php else: ?>
                <div class="improvement-badge" style="border-color: rgba(255,193,7,0.3);"><span class="text">Particiones no configuradas en esta instalación</span></div>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h2>Procedimiento almacenado</h2>
                <span class="status-badge status-success">✓ 15% evaluación</span>
            </div>
            <div class="card-body">
                <?php if ($procedimiento_existe): ?>
                <div class="stats-grid" style="grid-template-columns: repeat(3, 1fr);">
                    <div class="stat-card"><div class="number"><?= number_format($reporte['total_pedidos'] ?? 0) ?></div><div class="label">Total pedidos</div></div>
                    <div class="stat-card"><div class="number">TecnoStore</div><div class="label">Negocio</div></div>
                    <div class="stat-card"><div class="number">2025</div><div class="label">Período</div></div>
                </div>
                <div class="code-block">CALL sp_reporte_ventas_emprendimiento(1, '2025-01-01', '2025-12-31');</div>
                <?php else: ?>
                <div class="improvement-badge" style="border-color: rgba(255,193,7,0.3);"><span class="text">Procedimiento no encontrado</span></div>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h2>Función personalizada</h2>
                <span class="status-badge status-success">✓ 10% evaluación</span>
            </div>
            <div class="card-body">
                <div class="stats-grid" style="grid-template-columns: repeat(3, 1fr);">
                    <div class="stat-card"><div class="number">Bs 500</div><div class="label">Precio venta</div></div>
                    <div class="stat-card"><div class="number">Bs 350</div><div class="label">Costo</div></div>
                    <div class="stat-card"><div class="number">Bs <?= number_format($prueba_funcion['ganancia'] ?? 0, 2) ?></div><div class="label">Ganancia neta (13% impuesto)</div></div>
                </div>
                <div class="code-block">SELECT fn_calcular_ganancia_neta(500, 350, 13); -- Resultado: 130.50</div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h2>Trigger automatizado</h2>
                <span class="status-badge status-success">✓ 10% evaluación</span>
            </div>
            <div class="card-body">
                <?php if ($trigger_existe): ?>
                <div class="code-block">
                    CREATE TRIGGER trg_actualizar_stock_venta<br>
                    AFTER INSERT ON detalles_pedido<br>
                    FOR EACH ROW<br>
                    BEGIN<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;UPDATE productos SET stock = stock - NEW.cantidad WHERE id_producto = NEW.id_variante;<br>
                    END
                </div>
                <div class="improvement-badge" style="margin-top: 20px;"><span class="percent">✓ Trigger activo</span><span class="text">El stock se descuenta automáticamente al registrar una venta</span></div>
                <?php else: ?>
                <div class="improvement-badge" style="border-color: rgba(255,193,7,0.3);"><span class="text">Trigger no encontrado</span></div>
                <?php endif; ?>
            </div>
        </div>
        
    </div>
    
    <div class="modal" id="preguntasModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>🤖 Preguntas teóricas para el grupo</h3>
                <button class="close-modal" id="closeModalBtn">&times;</button>
            </div>
            <div class="modal-body">
                <div class="question-card">
                    <h4>Pregunta 1</h4>
                    <p>¿Qué ventaja ofrece el uso de índices compuestos frente a índices simples en una base de datos transaccional?</p>
                    <div class="answer">Los índices compuestos permiten optimizar consultas que filtran por múltiples columnas simultáneamente. En este proyecto, el índice idx_productos_emprendimiento_precio combina id_emprendimiento y precio_base, acelerando búsquedas como "productos de un negocio con precio mayor a X". La mejora fue del <?= $mejora ?>% en tiempo de respuesta.</div>
                </div>
                <div class="question-card">
                    <h4>Pregunta 2</h4>
                    <p>¿En qué casos las particiones de tabla no son recomendables y por qué?</p>
                    <div class="answer">Las particiones no son recomendables cuando: (1) Las consultas no filtran por la clave de partición (fecha en este caso), (2) La tabla es pequeña (menos de 1M registros), (3) Se realizan muchas actualizaciones que cruzan particiones. Para Jacha Marketplace, la partición por fecha es adecuada porque los reportes de ventas filtran por períodos de tiempo.</div>
                </div>
                <div class="question-card">
                    <h4>Pregunta 3</h4>
                    <p>¿Cómo afecta un trigger al rendimiento de la base de datos y cuándo es recomendable usarlo?</p>
                    <div class="answer">Los triggers añaden sobrecarga porque se ejecutan automáticamente en cada operación. Son recomendables para: auditoría, validación de integridad, y automatización como el descuento de stock. En Jacha, el trigger trg_actualizar_stock_venta descuenta inventario sin necesidad de lógica adicional en la aplicación.</div>
                </div>
                <div class="question-card">
                    <h4>Pregunta 4</h4>
                    <p>¿Qué diferencias existen entre un procedimiento almacenado y una función en MySQL?</p>
                    <div class="answer">Un procedimiento almacenado puede realizar múltiples operaciones (INSERT, UPDATE, DELETE) y no retorna un valor obligatoriamente. Una función debe retornar un único valor y se puede usar dentro de consultas SELECT. En Jacha, sp_reporte_ventas_emprendimiento genera reportes completos, mientras que fn_calcular_ganancia_neta calcula valores específicos.</div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="watermark">JACHA DATABASE DEMO</div>
    
    <script>
        const modal = document.getElementById('preguntasModal');
        const robotBtn = document.getElementById('robotBtn');
        const closeModalBtn = document.getElementById('closeModalBtn');
        
        robotBtn.onclick = () => modal.classList.add('active');
        closeModalBtn.onclick = () => modal.classList.remove('active');
        modal.onclick = (e) => { if (e.target === modal) modal.classList.remove('active'); };
    </script>
</body>
</html>
