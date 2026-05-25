<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - Jacha</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Cormorant+Garamond:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles.css?v=4">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Inter',system-ui,sans-serif; background:#080808; color:#e0e0e0; min-height:100vh; }
        .wrap { max-width:1000px; margin:0 auto; padding:40px 32px; }
        .top { display:flex; align-items:center; justify-content:space-between; margin-bottom:40px; }
        .top h1 { font-family:'Cormorant Garamond',serif; font-size:34px; font-weight:400; color:#fff; }
        .top .back { color:#888; text-decoration:none; font-size:13px; transition:color .2s; }
        .top .back:hover { color:#fff; }
        .msg { background:rgba(255,255,255,0.04); border-left:3px solid #2ecc71; padding:12px 18px; border-radius:8px; margin-bottom:24px; font-size:13px; color:#ccc; }
        .err { border-left-color:#e74c3c; color:#e74c3c; }
        .grid { display:grid; grid-template-columns:1fr 1fr; gap:24px; }
        .card { background:#111; border:1px solid rgba(255,255,255,0.06); border-radius:16px; padding:28px; }
        .card h2 { font-family:'Cormorant Garamond',serif; font-size:22px; font-weight:400; color:#fff; margin-bottom:24px; padding-bottom:12px; border-bottom:1px solid rgba(255,255,255,0.06); }
        .card.full { grid-column:1/-1; }
        .f-group { margin-bottom:18px; }
        .f-group label { display:block; font-size:11px; color:#666; text-transform:uppercase; letter-spacing:1px; margin-bottom:6px; font-weight:500; }
        .f-group input, .f-group textarea { width:100%; padding:12px 14px; background:rgba(255,255,255,0.04); border:1px solid rgba(255,255,255,0.08); border-radius:10px; color:#e0e0e0; font-size:14px; font-family:inherit; transition:all .2s; }
        .f-group input:focus, .f-group textarea:focus { outline:none; border-color:rgba(255,255,255,0.2); background:rgba(255,255,255,0.06); }
        .f-group input::placeholder, .f-group textarea::placeholder { color:#555; }
        .f-group textarea { resize:vertical; min-height:80px; }
        .f-group input[type="file"] { padding:8px; font-size:12px; }
        .btn { background:#fff; color:#080808; border:none; padding:12px 28px; border-radius:10px; font-size:13px; font-weight:600; cursor:pointer; transition:all .2s; }
        .btn:hover { transform:translateY(-2px); box-shadow:0 6px 20px rgba(255,255,255,0.1); }
        .btn-sm { padding:7px 16px; font-size:11px; }
        .btn-danger { background:rgba(231,76,60,0.15); color:#e74c3c; border:1px solid rgba(231,76,60,0.2); }
        .btn-danger:hover { background:rgba(231,76,60,0.25); box-shadow:0 6px 20px rgba(231,76,60,0.15); }
        .btn-outline { background:transparent; color:#888; border:1px solid rgba(255,255,255,0.1); }
        .btn-outline:hover { border-color:rgba(255,255,255,0.2); color:#fff; }
        .avatar-section { text-align:center; margin-bottom:24px; }
        .avatar-preview { width:150px; height:150px; border-radius:50%; margin-bottom:12px; background:linear-gradient(135deg,#333,#555); display:flex; align-items:center; justify-content:center; font-size:56px; font-weight:600; color:#fff; margin:0 auto 12px; cursor:pointer; transition:opacity .2s; position:relative; overflow:hidden; }
        .avatar-preview:hover { opacity:0.85; }
        .avatar-preview img { width:100%; height:100%; object-fit:cover; }
        .avatar-preview .overlay-text { position:absolute; bottom:0; left:0; right:0; background:rgba(0,0,0,0.5); color:#fff; font-size:10px; padding:4px; text-align:center; opacity:0; transition:opacity .2s; }
        .avatar-preview:hover .overlay-text { opacity:1; }
        .avatar-btn-wrap { display:flex; justify-content:center; gap:8px; }
        .role-badge { display:inline-block; background:rgba(255,255,255,0.06); padding:4px 12px; border-radius:6px; font-size:11px; color:#888; margin:3px 4px; }
        .role-badge.admin { background:rgba(52,152,219,0.15); color:#3498DB; }
        .role-badge.repartidor { background:rgba(231,76,60,0.12); color:#e74c3c; }
        .del-section { background:rgba(231,76,60,0.04); border:1px solid rgba(231,76,60,0.12); border-radius:12px; padding:20px; margin-top:16px; }
        .del-section h4 { color:#e74c3c; font-size:14px; margin-bottom:8px; }
        .del-section p { font-size:12px; color:#666; margin-bottom:12px; }
        .negocio-item { display:flex; align-items:center; justify-content:space-between; padding:12px 0; border-bottom:1px solid rgba(255,255,255,0.04); }
        .negocio-item:last-child { border-bottom:none; }
        .negocio-item .name { font-size:14px; color:#e0e0e0; }
        .negocio-item .sub { font-size:11px; color:#666; }
        .inline-form { display:inline; }
        @media(max-width:768px){ .grid{grid-template-columns:1fr} .wrap{padding:24px 16px} }
    </style>
</head>
<body>
<div class="wrap">
    <div class="top">
        <h1>Mi Perfil</h1>
        <a href="<?= BASE_URL ?>/dashboard" class="back">&larr; Volver al dashboard</a>
    </div>

    <?php if ($success): ?>
        <div class="msg"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="msg err"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="grid">
        <div class="card">
            <h2>Foto de perfil</h2>
            <div class="avatar-section">
                <form method="POST" action="<?= BASE_URL ?>/perfil/actualizar" enctype="multipart/form-data" id="avatarForm">
                    <div class="avatar-preview" id="avatarPreview" title="Haz clic para cambiar foto">
                        <?php if ($avatar && $avatar !== 'assets/avatars/default/avatar_1.jpg'): ?>
                            <img src="<?= BASE_URL ?>/<?= $avatar ?>" alt="Avatar">
                        <?php else: ?>
                            <?= $inicial ?>
                        <?php endif; ?>
                        <span class="overlay-text">Cambiar foto</span>
                    </div>
                    <input type="file" name="avatar" accept="image/jpeg,image/png,image/webp" id="avatarInput" style="display:none">
                    <div class="avatar-btn-wrap">
                        <button type="button" class="btn btn-sm btn-outline" onclick="document.getElementById('avatarInput').click()">Subir foto</button>
                    </div>
                </form>
            </div>

            <h2 style="margin-top:24px">Mis Roles</h2>
            <div style="text-align:center">
                <?php foreach ($roles_nombres as $rol): ?>
                    <span class="role-badge <?= $rol === 'Administrador' ? 'admin' : '' ?> <?= $rol === 'Repartidor' ? 'repartidor' : '' ?>">
                        <?= $rol === 'Emprendedor' ? 'Vendedor' : $rol ?>
                    </span>
                <?php endforeach; ?>
            </div>

            <?php if (in_array('Repartidor', $roles_nombres)): ?>
            <div class="del-section">
                <h4>Quitar rol Repartidor</h4>
                <p>Si ya no deseas realizar entregas, puedes eliminar este rol. No podrás ver pedidos de reparto.</p>
                <form method="POST" action="<?= BASE_URL ?>/perfil/quitar-repartidor" onsubmit="return confirm('¿Eliminar el rol Repartidor? Puedes volver a agregarlo después.');">
                    <button type="submit" class="btn btn-sm btn-danger">Quitar rol Repartidor</button>
                </form>
            </div>
            <?php endif; ?>
        </div>

        <div class="card">
            <h2>Editar datos</h2>
            <form method="POST" action="<?= BASE_URL ?>/perfil/actualizar">
                <div class="f-group">
                    <label>Nombres</label>
                    <input type="text" name="nombres" value="<?= htmlspecialchars($usuario['nombres'] ?? '') ?>" required>
                </div>
                <div class="f-group">
                    <label>Apellidos</label>
                    <input type="text" name="apellidos" value="<?= htmlspecialchars($usuario['apellidos'] ?? '') ?>" required>
                </div>
                <div class="f-group">
                    <label>Email</label>
                    <input type="email" value="<?= htmlspecialchars($usuario['email'] ?? '') ?>" disabled style="opacity:0.5">
                    <span style="font-size:10px;color:#555">El email no se puede cambiar</span>
                </div>
                <div class="f-group">
                    <label>Teléfono</label>
                    <input type="text" name="telefono" value="<?= htmlspecialchars($usuario['telefono'] ?? '') ?>" placeholder="Ej: 71234567">
                </div>
                <div class="f-group">
                    <label>Ubicación</label>
                    <input type="text" name="ubicacion" value="<?= htmlspecialchars($usuario['ubicacion'] ?? '') ?>" placeholder="Ej: La Paz, Bolivia">
                </div>
                <div class="f-group">
                    <label>Biografía</label>
                    <textarea name="bio" placeholder="Cuéntanos sobre ti..."><?= htmlspecialchars($usuario['bio'] ?? '') ?></textarea>
                </div>
                <div class="f-group">
                    <label>Nueva contraseña (dejar vacío para mantener)</label>
                    <input type="password" name="password" placeholder="••••••••">
                </div>
                <button type="submit" class="btn">Guardar cambios</button>
            </form>
        </div>

        <?php if (count($mis_negocios) > 0): ?>
        <div class="card full">
            <h2>Mis Negocios</h2>
            <?php foreach ($mis_negocios as $n): ?>
            <div class="negocio-item">
                <div>
                    <div class="name"><?= htmlspecialchars($n['nombre_comercial']) ?></div>
                    <div class="sub"><?= $n['total_productos'] ?> productos · <?= $n['plantilla_nombre'] ?? 'Moderno' ?></div>
                </div>
                <form class="inline-form" method="POST" action="<?= BASE_URL ?>/perfil/eliminar-negocio" onsubmit="return confirm('¿Eliminar el negocio <?= htmlspecialchars($n['nombre_comercial']) ?>? Se borrarán todos sus productos.');">
                    <input type="hidden" name="id_negocio" value="<?= $n['id_emprendimiento'] ?>">
                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                </form>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</div>
<script>
(function() {
    var preview = document.getElementById('avatarPreview');
    var input = document.getElementById('avatarInput');
    if (preview && input) {
        preview.addEventListener('click', function() { input.click(); });
        input.addEventListener('change', function() {
            if (this.files.length > 0) this.form.submit();
        });
    }
})();
</script>
</body>
</html>
