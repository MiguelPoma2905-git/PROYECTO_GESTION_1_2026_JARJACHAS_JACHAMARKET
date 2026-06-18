<?php
$current_page = $current_page ?? 'dashboard';
$rol_activo = $rol_activo ?? '';
$uname = htmlspecialchars($usuario['nombre'] ?? 'Usuario');
$urole = htmlspecialchars($rol_activo);
$avatar = isset($avatar_usuario) && $avatar_usuario ? BASE_URL . '/' . $avatar_usuario : null;
$roleIcons = ['Administrador' => 'fa-crown', 'Emprendedor' => 'fa-store', 'Cliente' => 'fa-user', 'Repartidor' => 'fa-truck'];
$roleIcon = $roleIcons[$rol_activo] ?? 'fa-user';
?>
<div class="sidebar" id="sidebar">
    <div class="sidebar-user">
        <div class="sidebar-user-avatar">
            <?php if ($avatar): ?>
            <img src="<?= $avatar ?>" alt="Avatar">
            <?php else: ?>
            <div class="sidebar-user-avatar-placeholder"><?= strtoupper(substr($uname, 0, 1)) ?></div>
            <?php endif; ?>
            <span class="sidebar-user-status"></span>
        </div>
        <div class="sidebar-user-info">
            <div class="sidebar-user-name"><?= $uname ?></div>
            <div class="sidebar-user-role"><i class="fas <?= $roleIcon ?>"></i> <?= $urole ?></div>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="s-label">Navegaci&oacute;n</div>
        <a href="<?= BASE_URL ?>/dashboard" class="<?= $current_page === 'dashboard' ? 'active' : '' ?>"><i class="fas fa-th-large"></i> <span>Dashboard</span></a>

        <?php if ($rol_activo === 'Administrador'): ?>
        <div class="s-label">Administraci&oacute;n</div>
        <a href="#admin-usuarios" class="<?= $current_page === 'admin-usuarios' ? 'active' : '' ?>"><i class="fas fa-users"></i> <span>Usuarios</span></a>
        <a href="#admin-negocios" class="<?= $current_page === 'admin-negocios' ? 'active' : '' ?>"><i class="fas fa-store"></i> <span>Negocios</span></a>
        <a href="<?= BASE_URL ?>/admin/ventas" class="<?= $current_page === 'admin-ventas' ? 'active' : '' ?>"><i class="fas fa-chart-bar"></i> <span>Ventas</span></a>

        <?php elseif ($rol_activo === 'Emprendedor'): ?>
        <div class="s-label">Gesti&oacute;n</div>
        <a href="<?= BASE_URL ?>/gestionar-negocios" class="<?= $current_page === 'gestionar-negocios' ? 'active' : '' ?>"><i class="fas fa-store-alt"></i> <span>Mis negocios</span></a>
        <a href="<?= BASE_URL ?>/productos" class="<?= $current_page === 'productos' ? 'active' : '' ?>"><i class="fas fa-cube"></i> <span>Productos</span></a>
        <a href="<?= BASE_URL ?>/categorias" class="<?= $current_page === 'categorias' ? 'active' : '' ?>"><i class="fas fa-folder"></i> <span>Categor&iacute;as</span></a>
        <a href="<?= BASE_URL ?>/inventario" class="<?= $current_page === 'inventario' ? 'active' : '' ?>"><i class="fas fa-boxes"></i> <span>Inventario</span></a>
        <a href="<?= BASE_URL ?>/kardex" class="<?= $current_page === 'kardex' ? 'active' : '' ?>"><i class="fas fa-history"></i> <span>Kardex</span></a>
        <a href="<?= BASE_URL ?>/sucursales" class="<?= $current_page === 'sucursales' ? 'active' : '' ?>"><i class="fas fa-code-branch"></i> <span>Sucursales</span></a>
        <div class="s-label">Operaciones</div>
        <a href="<?= BASE_URL ?>/repartidores-admin" class="<?= $current_page === 'repartidores-admin' ? 'active' : '' ?>"><i class="fas fa-truck"></i> <span>Repartidores</span></a>
        <a href="<?= BASE_URL ?>/herramientas" class="<?= $current_page === 'herramientas' ? 'active' : '' ?>"><i class="fas fa-tools"></i> <span>Herramientas</span></a>

        <?php elseif ($rol_activo === 'Cliente'): ?>
        <div class="s-label">Mi cuenta</div>
        <a href="<?= BASE_URL ?>/mis-estadisticas" class="<?= $current_page === 'mis-estadisticas' ? 'active' : '' ?>"><i class="fas fa-chart-pie"></i> <span>Mis estad&iacute;sticas</span></a>
        <a href="<?= BASE_URL ?>/mis-pedidos" class="<?= $current_page === 'mis-pedidos' ? 'active' : '' ?>"><i class="fas fa-shopping-bag"></i> <span>Mis pedidos</span></a>

        <?php elseif ($rol_activo === 'Repartidor'): ?>
        <div class="s-label">Entregas</div>
        <a href="<?= BASE_URL ?>/dashboard-repartidor" class="<?= $current_page === 'dashboard-repartidor' ? 'active' : '' ?>"><i class="fas fa-truck"></i> <span>Entregas</span></a>
        <?php endif; ?>
    </nav>

    <div class="sidebar-footer">
        <a href="<?= BASE_URL ?>/perfil" class="s-footer-link" title="Perfil"><i class="fas fa-user-cog"></i> <span>Perfil</span></a>
        <a href="<?= BASE_URL ?>/logout" class="s-footer-link s-logout" title="Cerrar sesi&oacute;n"><i class="fas fa-sign-out-alt"></i> <span>Cerrar sesi&oacute;n</span></a>
    </div>
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
