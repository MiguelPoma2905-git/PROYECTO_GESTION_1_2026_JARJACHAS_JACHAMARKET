<!DOCTYPE html>
<html lang="es" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/styles.css?v=6">
    <style>
        :root {
            --admin-bg: #0a0a0f;
            --admin-card: #12121a;
            --admin-border: rgba(255,255,255,0.06);
            --admin-accent: #6366f1;
            --admin-text: #f1f5f9;
            --admin-muted: #94a3b8;
            --admin-dim: #475569;
        }
        [data-theme="light"] {
            --admin-bg: #f8fafc;
            --admin-card: #ffffff;
            --admin-border: rgba(0,0,0,0.08);
            --admin-text: #0f172a;
            --admin-muted: #64748b;
            --admin-dim: #94a3b8;
        }
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family:'Inter',system-ui,sans-serif;
            background:var(--admin-bg); color:var(--admin-text);
            min-height:100vh;
        }
        .edit-wrap { max-width:800px; margin:0 auto; padding:40px 32px; }

        .edit-hero {
            background:linear-gradient(135deg,#0f0f1a 0%,#1a1a2e 50%,#0f0f1a 100%);
            padding:40px; border-radius:24px; margin-bottom:32px; position:relative; overflow:hidden;
        }
        [data-theme="light"] .edit-hero {
            background:linear-gradient(135deg,#eef2ff 0%,#e0e7ff 50%,#eef2ff 100%);
        }
        .edit-hero::before {
            content:''; position:absolute; top:-40%; right:-10%;
            width:400px; height:400px;
            background:radial-gradient(circle,rgba(99,102,241,0.12) 0%,transparent 60%);
            pointer-events:none;
        }
        .edit-hero-inner { position:relative; z-index:1; display:flex; align-items:center; justify-content:space-between; }
        .edit-hero h1 {
            font-family:'Cormorant Garamond',serif; font-size:32px; font-weight:500;
            background:linear-gradient(135deg,#fff,#94a3b8);
            -webkit-background-clip:text; background-clip:text; color:transparent;
        }
        [data-theme="light"] .edit-hero h1 {
            background:linear-gradient(135deg,#1e293b,#6366f1);
            -webkit-background-clip:text; background-clip:text; color:transparent;
        }
        .edit-hero .back {
            color:var(--admin-muted); text-decoration:none; font-size:13px;
            display:flex; align-items:center; gap:6px; transition:all .2s;
            padding:8px 16px; border-radius:8px; background:rgba(255,255,255,0.04);
        }
        .edit-hero .back:hover { color:#fff; background:rgba(255,255,255,0.08); }
        [data-theme="light"] .edit-hero .back:hover { color:#1e293b; background:rgba(0,0,0,0.06); }

        .form-card {
            background:var(--admin-card); border:1px solid var(--admin-border);
            border-radius:20px; padding:36px;
        }
        .form-section {
            font-size:11px; font-weight:600; color:var(--admin-dim);
            text-transform:uppercase; letter-spacing:1.5px;
            padding-bottom:12px; border-bottom:1px solid var(--admin-border);
            margin-bottom:24px; display:flex; align-items:center; gap:10px;
        }
        .form-section i { color:var(--admin-accent); font-size:14px; }
        .form-row { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
        .f-group { margin-bottom:20px; }
        .f-group label { display:block; font-size:11px; color:var(--admin-dim); text-transform:uppercase; letter-spacing:.5px; margin-bottom:6px; font-weight:600; }
        .f-group input,.f-group textarea,.f-group select {
            width:100%; background:rgba(255,255,255,0.03); border:1px solid var(--admin-border);
            border-radius:10px; padding:12px 16px; color:var(--admin-text);
            font-size:14px; font-family:'Inter',sans-serif; transition:all .2s;
        }
        .f-group input:focus,.f-group textarea:focus,.f-group select:focus { outline:none; border-color:var(--admin-accent); box-shadow:0 0 0 3px rgba(99,102,241,0.1); }
        .f-group textarea { resize:vertical; min-height:80px; }
        .f-group select { cursor:pointer; }
        .f-group select option { background:#12121a; color:#f1f5f9; }
        [data-theme="light"] .f-group select option { background:#fff; color:#0f172a; }
        .checkbox-group { display:flex; gap:12px; flex-wrap:wrap; }
        .checkbox-group label {
            display:flex; align-items:center; gap:8px;
            font-size:13px; color:var(--admin-muted); cursor:pointer;
            text-transform:none; letter-spacing:0; font-weight:400;
            padding:8px 16px; border-radius:8px; border:1px solid var(--admin-border);
            transition:all .2s;
        }
        .checkbox-group label:hover { border-color:var(--admin-accent); background:rgba(99,102,241,0.04); }
        .checkbox-group input[type="checkbox"] { width:auto; accent-color:#6366f1; }
        .msg {
            background:rgba(16,185,129,0.08); border:1px solid rgba(16,185,129,0.2);
            padding:14px 20px; border-radius:12px; margin-bottom:24px;
            font-size:13px; color:#10b981; display:flex; align-items:center; gap:10px;
        }
        .msg.err { background:rgba(239,68,68,0.08); border-color:rgba(239,68,68,0.2); color:#ef4444; }
        .btn-save {
            background:linear-gradient(135deg,#6366f1,#8b5cf6); color:#fff;
            border:none; padding:14px 36px; border-radius:12px;
            font-size:14px; font-weight:600; cursor:pointer;
            transition:all .3s; display:flex; align-items:center; gap:10px;
        }
        .btn-save:hover { transform:translateY(-2px); box-shadow:0 8px 30px rgba(99,102,241,0.3); }
        .btn-save i { font-size:14px; }
        .note { font-size:12px; color:var(--admin-dim); margin-top:4px; }
        @media(max-width:600px){ .form-row{grid-template-columns:1fr} .edit-wrap{padding:24px 16px} .edit-hero{padding:24px} .edit-hero-inner{flex-direction:column;align-items:flex-start;gap:16px} }
    </style>
</head>
<body>
<div class="edit-wrap">

    <div class="edit-hero">
        <div class="edit-hero-inner">
            <h1><i class="fas fa-user-edit" style="margin-right:12px;color:#6366f1"></i>Editar Usuario</h1>
            <a href="<?= BASE_URL ?>/admin" class="back"><i class="fas fa-arrow-left"></i> Volver al panel</a>
        </div>
    </div>

    <?php if ($success): ?>
        <div class="msg"><i class="fas fa-check-circle"></i> <?= htmlspecialchars($success) ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="msg err"><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="form-card">
        <form method="POST" action="<?= BASE_URL ?>/admin/editar-usuario/guardar">
            <input type="hidden" name="id" value="<?= $user['id_usuario'] ?>">

            <div class="form-section"><i class="fas fa-user"></i> Información personal</div>
            <div class="form-row">
                <div class="f-group">
                    <label>Nombres</label>
                    <input type="text" name="nombres" value="<?= htmlspecialchars($user['nombres']) ?>" required>
                </div>
                <div class="f-group">
                    <label>Apellidos</label>
                    <input type="text" name="apellidos" value="<?= htmlspecialchars($user['apellidos']) ?>" required>
                </div>
            </div>

            <div class="form-row">
                <div class="f-group">
                    <label>Email</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                </div>
                <div class="f-group">
                    <label>Teléfono</label>
                    <input type="text" name="telefono" value="<?= htmlspecialchars($user['telefono'] ?? '') ?>">
                </div>
            </div>

            <div class="form-row">
                <div class="f-group">
                    <label>Ubicación</label>
                    <input type="text" name="ubicacion" value="<?= htmlspecialchars($user['ubicacion'] ?? '') ?>">
                </div>
                <div class="f-group">
                    <label>Estado</label>
                    <select name="estado">
                        <option value="Activo" <?= ($user['estado'] ?? '') === 'Activo' ? 'selected' : '' ?>>Activo</option>
                        <option value="Inactivo" <?= ($user['estado'] ?? '') === 'Inactivo' ? 'selected' : '' ?>>Inactivo</option>
                        <option value="Bloqueado" <?= ($user['estado'] ?? '') === 'Bloqueado' ? 'selected' : '' ?>>Bloqueado</option>
                    </select>
                </div>
            </div>

            <div class="f-group">
                <label>Biografía</label>
                <textarea name="bio"><?= htmlspecialchars($user['bio'] ?? '') ?></textarea>
            </div>

            <div class="form-section" style="margin-top:32px"><i class="fas fa-shield-halved"></i> Roles</div>
            <div class="f-group">
                <?php if ($user['email'] === 'mikypramos2905@gmail.com'): ?>
                    <p class="note"><i class="fas fa-lock" style="color:#6366f1;margin-right:6px"></i>Los roles del super administrador no se pueden modificar.</p>
                <?php else: ?>
                    <div class="checkbox-group">
                    <?php foreach ($roles as $rol): ?>
                        <label>
                            <input type="checkbox" name="roles[]" value="<?= $rol['id_rol'] ?>"
                                <?= in_array($rol['id_rol'], $user_role_ids) ? 'checked' : '' ?>>
                            <?= htmlspecialchars($rol['nombre_rol']) ?>
                        </label>
                    <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-section" style="margin-top:32px"><i class="fas fa-key"></i> Cambiar contraseña</div>
            <div class="f-group">
                <label>Nueva contraseña (dejar vacío para mantener)</label>
                <input type="password" name="password" placeholder="Mínimo 6 caracteres" minlength="6">
            </div>

            <div style="margin-top:32px;display:flex;gap:12px">
                <button type="submit" class="btn-save"><i class="fas fa-check"></i> Guardar cambios</button>
                <a href="<?= BASE_URL ?>/admin" style="padding:14px 28px;border-radius:12px;border:1px solid var(--admin-border);color:var(--admin-muted);text-decoration:none;font-size:13px;font-weight:500;display:flex;align-items:center;gap:8px;transition:all .2s;" onmouseover="this.style.borderColor='var(--admin-accent)';this.style.color='var(--admin-text)'" onmouseout="this.style.borderColor='';this.style.color=''"><i class="fas fa-times"></i> Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script>
(function() {
    var theme = localStorage.getItem('jacha_theme') || 'dark';
    document.documentElement.setAttribute('data-theme', theme);
})();
</script>
</body>
</html>
