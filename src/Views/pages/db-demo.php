<!DOCTYPE html>
<html lang="es" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Demostración BD - Jacha Marketplace</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Cormorant+Garamond:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles.css?v=6">
    <style>
        .header { border-bottom: 1px solid rgba(255,255,255,0.08); padding: 20px 32px; background: rgba(10,10,10,0.8); backdrop-filter: blur(16px); position: sticky; top: 0; z-index: 100; }
        .header-content { max-width: 1400px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; }
        .robot-icon { background: none; border: none; font-size: 28px; cursor: pointer; transition: transform 0.2s; }
        .robot-icon:hover { transform: scale(1.1); }
        .hero { text-align: center; padding: 60px 24px 40px; background: linear-gradient(135deg, rgba(26,65,71,0.3), rgba(0,0,0,0.05)); }
        .stat-card .number { font-size: 36px; font-weight: 600; color: var(--text); font-family: Georgia, serif; }
        .search-input:focus { outline: none; border-color: var(--border-hi); }
        .btn-search { padding: 12px 28px; background: var(--text); border: none; border-radius: 12px; color: var(--bg); font-weight: 500; cursor: pointer; transition: all 0.2s; }
        .pagination .active { background: var(--text); color: var(--bg); border-color: var(--text); }
        .question-card h4 { font-size: 18px; font-weight: 500; margin-bottom: 12px; color: var(--text); }
        .question-card p { color: #aaa; font-size: 14px; line-height: 1.6; margin-bottom: 12px; }
        .question-card .answer { color: #4caf50; font-size: 14px; border-top: 1px solid #2a2a2a; padding-top: 12px; margin-top: 8px; }
        @media (max-width: 1024px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } .comparison { grid-template-columns: 1fr; } }
        @media (max-width: 768px) { .container { padding: 32px 20px; } .hero h1 { font-size: 32px; } .stats-grid { grid-template-columns: 1fr; } .search-bar { flex-direction: column; } }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <a href="<?= BASE_URL ?>/"><img src="<?= BASE_URL ?>/assets/images/logo_empresa.png" alt="Jacha" style="height:28px;width:auto"></a>
            <div style="display: flex; align-items: center; gap: 20px;">
                <button class="robot-icon" id="robotBtn">🤖</button>
                <button class="theme-toggle" id="themeToggle" title="Cambiar tema" style="margin-left:12px;flex-shrink:0">&#9790;</button>
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
                <span class="status-badge <?= $cumple_5000 ? 'status-success' : 'status-info' ?>"><?= $cumple_5000 ? '15% cumplido' : '15% pendiente' ?></span>
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
                <h3>Preguntas teóricas para el grupo</h3>
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
    
    <span class="watermark"><img src="<?= BASE_URL ?>/assets/images/logo1.jpg" alt=""></span>

    <script>
(function() {
    var theme = localStorage.getItem('jacha_theme') || 'dark';
    document.documentElement.setAttribute('data-theme', theme);
})();
</script>
<script>
(function() {
    var themeToggle = document.getElementById('themeToggle');
    var currentTheme = localStorage.getItem('jacha_theme') || 'dark';
    if (themeToggle) {
        themeToggle.innerHTML = currentTheme === 'dark' ? '\u2600' : '\u263E';
        themeToggle.addEventListener('click', function() {
            var theme = document.documentElement.getAttribute('data-theme');
            var newTheme = theme === 'light' ? 'dark' : 'light';
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('jacha_theme', newTheme);
            themeToggle.innerHTML = newTheme === 'dark' ? '\u2600' : '\u263E';
        });
    }
})();
</script>
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
