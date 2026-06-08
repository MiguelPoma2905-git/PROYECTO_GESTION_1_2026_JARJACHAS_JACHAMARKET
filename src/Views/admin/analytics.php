<!DOCTYPE html>
<html lang="es" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analítica - Jacha Marketplace</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles.css?v=6">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <style>
        :root { --admin-bg: #0a0a0f; --admin-card: #12121a; --admin-border: rgba(255,255,255,0.06); --admin-accent: #6366f1; --admin-text: #f1f5f9; --admin-muted: #94a3b8; --admin-dim: #475569; }
        [data-theme="light"] { --admin-bg: #f8fafc; --admin-card: #ffffff; --admin-border: rgba(0,0,0,0.08); --admin-text: #0f172a; --admin-muted: #64748b; --admin-dim: #94a3b8; }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Inter',system-ui,sans-serif; background:var(--admin-bg); color:var(--admin-text); min-height:100vh; }
        .wrap { max-width:1400px; margin:0 auto; }
        .hero { background:linear-gradient(135deg,#0f0f1a 0%,#1a1a2e 50%,#0f0f1a 100%); padding:40px 40px 32px; position:relative; overflow:hidden; }
        [data-theme="light"] .hero { background:linear-gradient(135deg,#eef2ff 0%,#e0e7ff 50%,#eef2ff 100%); }
        .hero::before { content:''; position:absolute; top:-50%; right:-20%; width:500px; height:500px; background:radial-gradient(circle,rgba(99,102,241,0.12) 0%,transparent 60%); pointer-events:none; }
        .hero-inner { position:relative; z-index:1; display:flex; align-items:center; justify-content:space-between; }
        .hero h1 { font-family:'Cormorant Garamond',serif; font-size:36px; font-weight:500; background:linear-gradient(135deg,#fff,#94a3b8); -webkit-background-clip:text; background-clip:text; color:transparent; }
        [data-theme="light"] .hero h1 { background:linear-gradient(135deg,#1e293b,#6366f1); -webkit-background-clip:text; background-clip:text; color:transparent; }
        .hero .back { color:var(--admin-muted); text-decoration:none; font-size:13px; display:flex; align-items:center; gap:6px; padding:8px 16px; border-radius:8px; background:rgba(255,255,255,0.04); transition:all .2s; }
        .hero .back:hover { color:#fff; background:rgba(255,255,255,0.08); }
        [data-theme="light"] .hero .back:hover { color:#1e293b; background:rgba(0,0,0,0.06); }
        .body { padding:32px 40px; }

        .stats-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:32px; }
        .stat-card { background:var(--admin-card); border:1px solid var(--admin-border); border-radius:16px; padding:24px; position:relative; overflow:hidden; }
        .stat-card .num { font-size:28px; font-weight:700; color:var(--admin-text); }
        .stat-card .lab { font-size:10px; color:var(--admin-dim); text-transform:uppercase; letter-spacing:1px; margin-top:4px; font-weight:500; }
        .stat-card .icon { position:absolute; top:16px; right:16px; font-size:20px; opacity:0.15; }

        .charts-grid { display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:32px; }
        .chart-card { background:var(--admin-card); border:1px solid var(--admin-border); border-radius:20px; padding:24px; }
        .chart-card.full { grid-column:1/-1; }
        .chart-card h3 { font-family:'Cormorant Garamond',serif; font-size:20px; font-weight:500; color:var(--admin-text); margin-bottom:16px; }
        .chart-card h3 .sub { font-size:12px; color:var(--admin-dim); font-family:'Inter',sans-serif; font-weight:400; }
        .chart-wrap { position:relative; height:280px; }
        .chart-wrap.tall { height:350px; }

        .recent-table { width:100%; border-collapse:collapse; }
        .recent-table th { text-align:left; padding:10px 14px; font-size:10px; font-weight:600; color:var(--admin-dim); text-transform:uppercase; letter-spacing:1px; border-bottom:1px solid var(--admin-border); }
        .recent-table td { padding:10px 14px; font-size:12px; color:var(--admin-text); border-bottom:1px solid var(--admin-border); }
        .recent-table tr:last-child td { border-bottom:none; }
        .badge-st { display:inline-block; padding:2px 8px; border-radius:4px; font-size:10px; font-weight:600; }
        .badge-st.Entregado { background:rgba(16,185,129,0.12); color:#10b981; }
        .badge-st.En_Ruta { background:rgba(99,102,241,0.12); color:#6366f1; }
        .badge-st.Preparando { background:rgba(245,158,11,0.12); color:#f59e0b; }

        .loading { text-align:center; padding:60px; color:var(--admin-dim); }
        .loading i { font-size:32px; margin-bottom:12px; }
        .error-msg { text-align:center; padding:40px; color:var(--admin-dim); }

        @media(max-width:1024px){ .stats-grid{grid-template-columns:repeat(2,1fr)} .charts-grid{grid-template-columns:1fr} }
        @media(max-width:768px){
            .hero{padding:24px 20px} .body{padding:24px 20px}
            .stats-grid{grid-template-columns:1fr}
            .chart-wrap{height:220px}
            .chart-wrap.tall{height:280px}
        }
    </style>
</head>
<body>
<div class="wrap">
    <div class="hero">
        <div class="hero-inner">
            <h1><i class="fas fa-chart-pie" style="margin-right:12px;color:#6366f1"></i>Analítica y Reportes</h1>
            <a href="<?= BASE_URL ?>/admin" class="back"><i class="fas fa-arrow-left"></i> Volver al panel</a>
        </div>
    </div>
    <div class="body">

        <div class="stats-grid" id="statsGrid">
            <div class="stat-card"><div class="num" id="statUsuarios">—</div><div class="lab">Usuarios</div><div class="icon"><i class="fas fa-users"></i></div></div>
            <div class="stat-card"><div class="num" id="statNegocios">—</div><div class="lab">Negocios</div><div class="icon"><i class="fas fa-store"></i></div></div>
            <div class="stat-card"><div class="num" id="statProductos">—</div><div class="lab">Productos</div><div class="icon"><i class="fas fa-box"></i></div></div>
            <div class="stat-card"><div class="num" id="statPedidos">—</div><div class="lab">Pedidos</div><div class="icon"><i class="fas fa-truck"></i></div></div>
        </div>

        <div class="charts-grid" id="chartsContainer">
            <div class="loading" id="loadingMsg"><i class="fas fa-spinner fa-spin"></i><p>Cargando datos...</p></div>
        </div>
    </div>
</div>

<script>
(function() {
    var theme = localStorage.getItem('jacha_theme') || 'dark';
    document.documentElement.setAttribute('data-theme', theme);
})();

document.addEventListener('DOMContentLoaded', function() {
    var colors = {
        dark: { grid: 'rgba(255,255,255,0.06)', text: '#94a3b8' },
        light: { grid: 'rgba(0,0,0,0.06)', text: '#64748b' }
    };

    fetch('<?= BASE_URL ?>/admin/analytics-data')
        .then(function(r) { return r.json(); })
        .then(function(data) {
            if (!data.success) { document.getElementById('chartsContainer').innerHTML = '<div class="error-msg"><p>Error al cargar datos</p></div>'; return; }

            var d = data;
            var t = document.documentElement.getAttribute('data-theme') || 'dark';
            var c = colors[t];

            // Stats
            document.getElementById('statUsuarios').textContent = d.resumen.total_usuarios;
            document.getElementById('statNegocios').textContent = d.resumen.total_negocios;
            document.getElementById('statProductos').textContent = d.resumen.total_productos;
            document.getElementById('statPedidos').textContent = d.resumen.total_pedidos;

            var container = document.getElementById('chartsContainer');
            container.innerHTML = '';

            // --- Monthly Sales Chart ---
            var meses = d.ventas_mensuales.map(function(v) { return v.mes; });
            var ventas = d.ventas_mensuales.map(function(v) { return parseFloat(v.total_ventas); });
            var pedidosM = d.ventas_mensuales.map(function(v) { return parseInt(v.total_pedidos); });

            container.appendChild(createChartCard('Ventas mensuales', '<span class="sub">Últimos 12 meses</span>', 'tall', function(canvas) {
                new Chart(canvas, {
                    type: 'line',
                    data: {
                        labels: meses,
                        datasets: [
                            { label: 'Ventas (Bs.)', data: ventas, borderColor: '#6366f1', backgroundColor: 'rgba(99,102,241,0.1)', fill: true, tension: 0.4, yAxisID: 'y' },
                            { label: 'Pedidos', data: pedidosM, borderColor: '#10b981', backgroundColor: 'rgba(16,185,129,0.1)', fill: true, tension: 0.4, yAxisID: 'y1' }
                        ]
                    },
                    options: {
                        responsive: true, maintainAspectRatio: false,
                        interaction: { mode: 'index', intersect: false },
                        plugins: { legend: { labels: { color: c.text, font: { size: 11 } } } },
                        scales: {
                            x: { grid: { color: c.grid }, ticks: { color: c.text, font: { size: 10 } } },
                            y: { grid: { color: c.grid }, ticks: { color: c.text, font: { size: 10 } }, beginAtZero: true, title: { display: true, text: 'Bs.', color: c.text, font: { size: 10 } } },
                            y1: { grid: { display: false }, ticks: { color: c.text, font: { size: 10 } }, beginAtZero: true, position: 'right', title: { display: true, text: 'Pedidos', color: c.text, font: { size: 10 } } }
                        }
                    }
                });
            }));

            // --- Top Businesses ---
            var negNombres = d.top_negocios.map(function(n) { return n.nombre_comercial; });
            var negVentas = d.top_negocios.map(function(n) { return parseFloat(n.total_ventas); });
            var negPedidos = d.top_negocios.map(function(n) { return parseInt(n.total_pedidos); });

            container.appendChild(createChartCard('Top negocios por ingresos', '<span class="sub">Los 5 más vendidos</span>', '', function(canvas) {
                new Chart(canvas, {
                    type: 'bar',
                    data: {
                        labels: negNombres,
                        datasets: [
                            { label: 'Ventas (Bs.)', data: negVentas, backgroundColor: 'rgba(99,102,241,0.7)', borderColor: '#6366f1', borderWidth: 1 },
                            { label: 'Pedidos', data: negPedidos, backgroundColor: 'rgba(16,185,129,0.7)', borderColor: '#10b981', borderWidth: 1 }
                        ]
                    },
                    options: {
                        responsive: true, maintainAspectRatio: false,
                        plugins: { legend: { labels: { color: c.text, font: { size: 11 } } } },
                        scales: {
                            x: { grid: { color: c.grid }, ticks: { color: c.text, font: { size: 10 } } },
                            y: { grid: { color: c.grid }, ticks: { color: c.text, font: { size: 10 } }, beginAtZero: true }
                        }
                    }
                });
            }));

            // --- Orders by Status ---
            var estados = d.pedidos_por_estado.map(function(e) { return e.estado_logistico; });
            var totales = d.pedidos_por_estado.map(function(e) { return parseInt(e.total); });
            var colores = { Entregado: '#10b981', En_Ruta: '#6366f1', Preparando: '#f59e0b', Cancelado: '#ef4444', Recibido: '#8b5cf6' };
            var bg = estados.map(function(e) { return colores[e] || '#94a3b8'; });

            container.appendChild(createChartCard('Estado de pedidos', '<span class="sub">Distribución general</span>', '', function(canvas) {
                new Chart(canvas, {
                    type: 'doughnut',
                    data: {
                        labels: estados,
                        datasets: [{ data: totales, backgroundColor: bg, borderWidth: 0 }]
                    },
                    options: {
                        responsive: true, maintainAspectRatio: false,
                        plugins: {
                            legend: { position: 'bottom', labels: { color: c.text, font: { size: 11 }, padding: 16 } }
                        }
                    }
                });
            }));

            // --- Payment Methods ---
            var metodos = d.pagos.map(function(p) { return p.metodo_pago; });
            var montos = d.pagos.map(function(p) { return parseFloat(p.total_ventas); });
            var coloresPago = { QR: '#6366f1', Efectivo: '#10b981', Tarjeta: '#f59e0b', Transferencia: '#8b5cf6' };
            var bgPago = metodos.map(function(m) { return coloresPago[m] || '#94a3b8'; });

            container.appendChild(createChartCard('Métodos de pago', '<span class="sub">Volumen por tipo</span>', '', function(canvas) {
                new Chart(canvas, {
                    type: 'doughnut',
                    data: {
                        labels: metodos,
                        datasets: [{ data: montos, backgroundColor: bgPago, borderWidth: 0 }]
                    },
                    options: {
                        responsive: true, maintainAspectRatio: false,
                        plugins: {
                            legend: { position: 'bottom', labels: { color: c.text, font: { size: 11 }, padding: 16 } }
                        }
                    }
                });
            }));

            // --- User registrations ---
            var regMeses = d.registros.map(function(r) { return r.mes; });
            var regTotal = d.registros.map(function(r) { return parseInt(r.total_usuarios); });

            container.appendChild(createChartCard('Registros de usuarios', '<span class="sub">Últimos 12 meses</span>', 'tall', function(canvas) {
                new Chart(canvas, {
                    type: 'line',
                    data: {
                        labels: regMeses,
                        datasets: [{ label: 'Nuevos usuarios', data: regTotal, borderColor: '#8b5cf6', backgroundColor: 'rgba(139,92,246,0.1)', fill: true, tension: 0.4 }]
                    },
                    options: {
                        responsive: true, maintainAspectRatio: false,
                        plugins: { legend: { labels: { color: c.text, font: { size: 11 } } } },
                        scales: {
                            x: { grid: { color: c.grid }, ticks: { color: c.text, font: { size: 10 } } },
                            y: { grid: { color: c.grid }, ticks: { color: c.text, font: { size: 10 } }, beginAtZero: true }
                        }
                    }
                });
            }));

            // --- Recent orders table ---
            container.appendChild(createTableCard('Pedidos recientes', '<span class="sub">Últimos 10</span>', d.pedidos_recientes));

        })
        .catch(function(err) {
            document.getElementById('chartsContainer').innerHTML = '<div class="error-msg"><p>Error de conexión: ' + err.message + '</p></div>';
        });
});

function createChartCard(title, subtitle, extraClass, initFn) {
    var div = document.createElement('div');
    div.className = 'chart-card' + (subtitle.includes('Ventas mensuales') || subtitle.includes('Registros') ? ' full' : '');
    div.innerHTML = '<h3>' + title + ' ' + subtitle + '</h3><div class="chart-wrap ' + extraClass + '"><canvas></canvas></div>';
    setTimeout(function() {
        var canvas = div.querySelector('canvas');
        if (canvas) { initFn(canvas); }
    }, 50);
    return div;
}

function createTableCard(title, subtitle, rows) {
    var div = document.createElement('div');
    div.className = 'chart-card full';
    var html = '<h3>' + title + ' ' + subtitle + '</h3>';
    if (rows.length > 0) {
        html += '<table class="recent-table"><thead><tr><th>Código</th><th>Cliente</th><th>Negocio</th><th>Total</th><th>Estado</th><th>Fecha</th></tr></thead><tbody>';
        rows.forEach(function(r) {
            html += '<tr><td style="font-weight:600;color:#6366f1;font-size:11px">' + r.codigo_seguimiento + '</td>';
            html += '<td>' + r.cliente_nombre + ' ' + r.cliente_apellidos + '</td>';
            html += '<td>' + r.nombre_comercial + '</td>';
            html += '<td><strong>Bs. ' + parseFloat(r.total).toFixed(2) + '</strong></td>';
            html += '<td><span class="badge-st ' + r.estado_logistico + '">' + r.estado_logistico.replace('_', ' ') + '</span></td>';
            html += '<td style="color:var(--admin-dim);font-size:11px">' + r.fecha_creacion + '</td></tr>';
        });
        html += '</tbody></table>';
    } else {
        html += '<div style="text-align:center;padding:40px;color:var(--admin-dim)"><p>No hay pedidos registrados</p></div>';
    }
    div.innerHTML = html;
    return div;
}
</script>
</body>
</html>
