<?php
$current_page = $current_page ?? 'dashboard';
$rol_activo = $rol_activo ?? '';
?>
<div class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <a href="<?= BASE_URL ?>/">
            <img src="<?= BASE_URL ?>/assets/images/logo_empresa.png" alt="JachaMarket">
        </a>
    </div>
    <nav class="sidebar-nav">
        <div class="s-label">Navegación</div>
        <a href="<?= BASE_URL ?>/dashboard" class="<?= $current_page === 'dashboard' ? 'active' : '' ?>"><i class="fas fa-th-large"></i> Dashboard</a>

        <?php if ($rol_activo === 'Administrador'): ?>
        <div class="s-label">Administración</div>
        <a href="#admin-usuarios" class="<?= $current_page === 'admin-usuarios' ? 'active' : '' ?>"><i class="fas fa-users"></i> Usuarios</a>
        <a href="#admin-negocios" class="<?= $current_page === 'admin-negocios' ? 'active' : '' ?>"><i class="fas fa-store"></i> Negocios</a>
        <a href="<?= BASE_URL ?>/admin/ventas" class="<?= $current_page === 'admin-ventas' ? 'active' : '' ?>"><i class="fas fa-chart-bar"></i> Ventas</a>

        <?php elseif ($rol_activo === 'Emprendedor'): ?>
        <div class="s-label">Gestión</div>
        <a href="<?= BASE_URL ?>/gestionar-negocios" class="<?= $current_page === 'gestionar-negocios' ? 'active' : '' ?>"><i class="fas fa-store-alt"></i> Mis negocios</a>
        <a href="<?= BASE_URL ?>/productos" class="<?= $current_page === 'productos' ? 'active' : '' ?>"><i class="fas fa-cube"></i> Productos</a>
        <a href="<?= BASE_URL ?>/categorias" class="<?= $current_page === 'categorias' ? 'active' : '' ?>"><i class="fas fa-folder"></i> Categorías</a>
        <a href="<?= BASE_URL ?>/inventario" class="<?= $current_page === 'inventario' ? 'active' : '' ?>"><i class="fas fa-boxes"></i> Inventario</a>
        <a href="<?= BASE_URL ?>/kardex" class="<?= $current_page === 'kardex' ? 'active' : '' ?>"><i class="fas fa-history"></i> Kardex</a>
        <a href="<?= BASE_URL ?>/sucursales" class="<?= $current_page === 'sucursales' ? 'active' : '' ?>"><i class="fas fa-code-branch"></i> Sucursales</a>
        <div class="s-label">Operaciones</div>
        <a href="<?= BASE_URL ?>/repartidores-admin" class="<?= $current_page === 'repartidores-admin' ? 'active' : '' ?>"><i class="fas fa-truck"></i> Repartidores</a>
        <a href="<?= BASE_URL ?>/plantillas-disponibles" class="<?= $current_page === 'plantillas-disponibles' ? 'active' : '' ?>"><i class="fas fa-plus-circle"></i> Nuevo negocio</a>
        <a href="<?= BASE_URL ?>/herramientas" class="<?= $current_page === 'herramientas' ? 'active' : '' ?>"><i class="fas fa-tools"></i> Herramientas</a>

        <?php elseif ($rol_activo === 'Cliente'): ?>
        <div class="s-label">Mi cuenta</div>
        <a href="<?= BASE_URL ?>/mis-estadisticas" class="<?= $current_page === 'mis-estadisticas' ? 'active' : '' ?>"><i class="fas fa-chart-pie"></i> Mis estadísticas</a>
        <a href="<?= BASE_URL ?>/mis-pedidos" class="<?= $current_page === 'mis-pedidos' ? 'active' : '' ?>"><i class="fas fa-shopping-bag"></i> Mis pedidos</a>

        <?php elseif ($rol_activo === 'Repartidor'): ?>
        <div class="s-label">Entregas</div>
        <a href="<?= BASE_URL ?>/dashboard-repartidor" class="<?= $current_page === 'dashboard-repartidor' ? 'active' : '' ?>"><i class="fas fa-truck"></i> Entregas</a>
        <?php endif; ?>
    </nav>

    <div class="sidebar-footer">
        <a href="<?= BASE_URL ?>/logout" class="s-logout"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a>
    </div>
</div>

<div class="overlay" id="overlay"></div>

<style>
    [data-theme="light"] .sidebar-brand img { filter: brightness(0); }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var sidebar = document.getElementById('sidebar');
    var overlay = document.getElementById('overlay');
    if (overlay) {
        overlay.addEventListener('click', function() {
            sidebar.classList.remove('open');
            overlay.classList.remove('active');
        });
    }
    document.querySelectorAll('.sidebar-nav a').forEach(function(link) {
        link.addEventListener('click', function() {
            if (window.innerWidth < 769) {
                sidebar.classList.remove('open');
                overlay.classList.remove('active');
            }
        });
    });
});
</script>
