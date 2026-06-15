<?php
$current_page = $current_page ?? 'dashboard';
$es_admin = $es_admin ?? false;
?>
<div class="sidebar" id="sidebar">
    <div class="sidebar-header rainbow-header">
        <a href="<?= BASE_URL ?>/" class="logo-link">
            <img src="<?= BASE_URL ?>/assets/images/logo_empresa.png" alt="Jacha">
        </a>
    </div>

    <nav class="sidebar-nav" id="sidebarNav">
        <a href="<?= BASE_URL ?>/dashboard" class="<?= $current_page === 'dashboard' ? 'active' : '' ?>">
            <i class="fas fa-th-large"></i> Dashboard
        </a>

        <?php if ($rol_activo === 'Administrador'): ?>
            <a href="#admin-usuarios" class="<?= $current_page === 'admin-usuarios' ? 'active' : '' ?>">
                <i class="fas fa-users"></i> Usuarios
            </a>
            <a href="#admin-negocios" class="<?= $current_page === 'admin-negocios' ? 'active' : '' ?>">
                <i class="fas fa-store"></i> Negocios
            </a>
            <a href="<?= BASE_URL ?>/admin/ventas" class="<?= $current_page === 'admin-ventas' ? 'active' : '' ?>">
                <i class="fas fa-chart-bar"></i> Ventas
            </a>

        <?php elseif ($rol_activo === 'Emprendedor'): ?>
            <a href="<?= BASE_URL ?>/productos" class="<?= $current_page === 'productos' ? 'active' : '' ?>">
                <i class="fas fa-cube"></i> Productos
            </a>
            <a href="<?= BASE_URL ?>/categorias" class="<?= $current_page === 'categorias' ? 'active' : '' ?>">
                <i class="fas fa-tags"></i> Categorías
            </a>
            <a href="<?= BASE_URL ?>/gestionar-negocios" class="<?= $current_page === 'gestionar-negocios' ? 'active' : '' ?>">
                <i class="fas fa-store-alt"></i> Gestionar negocios
            </a>
            <a href="<?= BASE_URL ?>/repartidores-admin" class="<?= $current_page === 'repartidores' ? 'active' : '' ?>">
                <i class="fas fa-truck"></i> Repartidores
            </a>
            <a href="<?= BASE_URL ?>/plantillas-disponibles" class="<?= $current_page === 'nuevo-negocio' ? 'active' : '' ?>">
                <i class="fas fa-plus-circle"></i> Nuevo negocio
            </a>
            <div class="sidebar-divider"></div>
            <a href="<?= BASE_URL ?>/herramientas" class="<?= $current_page === 'herramientas' ? 'active' : '' ?>">
                <i class="fas fa-tools"></i> Herramientas
            </a>
            <a href="<?= BASE_URL ?>/sucursales" class="<?= $current_page === 'sucursales' ? 'active' : '' ?>">
                <i class="fas fa-code-branch"></i> Sucursales
            </a>
            <a href="<?= BASE_URL ?>/inventario" class="<?= $current_page === 'inventario' ? 'active' : '' ?>">
                <i class="fas fa-boxes"></i> Inventario
            </a>
            <a href="<?= BASE_URL ?>/kardex" class="<?= $current_page === 'kardex' ? 'active' : '' ?>">
                <i class="fas fa-history"></i> Kardex
            </a>

        <?php elseif ($rol_activo === 'Cliente'): ?>
            <a href="<?= BASE_URL ?>/mis-estadisticas" class="<?= $current_page === 'mis-estadisticas' ? 'active' : '' ?>">
                <i class="fas fa-chart-pie"></i> Mis estadísticas
            </a>
            <a href="<?= BASE_URL ?>/mis-pedidos" class="<?= $current_page === 'mis-pedidos' ? 'active' : '' ?>">
                <i class="fas fa-shopping-bag"></i> Mis pedidos
            </a>

            <?php if ($es_admin): ?>
                <div class="sidebar-divider"></div>
                <a href="<?= BASE_URL ?>/admin" class="<?= $current_page === 'admin' ? 'active' : '' ?>">
                    <i class="fas fa-shield-alt"></i> Panel Admin
                </a>
                <a href="<?= BASE_URL ?>/admin/ventas" class="<?= $current_page === 'admin-ventas' ? 'active' : '' ?>">
                    <i class="fas fa-chart-bar"></i> Ventas
                </a>
            <?php endif; ?>

        <?php elseif ($rol_activo === 'Repartidor'): ?>
            <a href="<?= BASE_URL ?>/dashboard-repartidor" class="<?= $current_page === 'entregas' ? 'active' : '' ?>">
                <i class="fas fa-truck"></i> Entregas
            </a>
            <a href="<?= BASE_URL ?>/mis-pedidos" class="<?= $current_page === 'mis-pedidos' ? 'active' : '' ?>">
                <i class="fas fa-clipboard-list"></i> Mis pedidos
            </a>
        <?php endif; ?>

        <div class="sidebar-footer-links">
            <a href="<?= BASE_URL ?>/perfil" class="<?= $current_page === 'perfil' ? 'active' : '' ?>">
                <i class="fas fa-user"></i> Mi Perfil
            </a>
            <a href="<?= BASE_URL ?>/logout" class="logout-link">
                <i class="fas fa-sign-out-alt"></i> Cerrar sesión
            </a>
        </div>
    </nav>
</div>
<div class="overlay" id="overlay"></div>

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

    var navItems = document.querySelectorAll('#sidebarNav > a');
    navItems.forEach(function(item, idx) {
        item.style.opacity = '0';
        item.style.transform = 'translateX(-16px)';
        item.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        setTimeout(function() {
            item.style.opacity = '1';
            item.style.transform = 'translateX(0)';
        }, 80 + idx * 40);
    });

    navItems.forEach(function(link) {
        link.addEventListener('click', function() {
            if (window.innerWidth < 769) {
                sidebar.classList.remove('open');
                overlay.classList.remove('active');
            }
        });
    });
});
</script>
