# JACHAmarket — Marketplace Multiroles

Plataforma web de comercio electrónico donde emprendedores pueden crear y personalizar sus tiendas online, clientes pueden comprar productos, repartidores gestionan entregas, y administradores controlan el sistema.

---

## Tecnologías

| | |
|---|---|
| **Backend** | PHP 8.x con PSR-4 autoload |
| **Frontend** | HTML5, CSS3, JavaScript (vanilla) |
| **Base de Datos** | MySQL / MariaDB con InnoDB |
| **Servidor** | PHP built-in server (`php -S`) o Apache |
| **Mail** | PHPMailer (Gmail SMTP) |
| **Gráficos** | Chart.js 4, FullCalendar 5 |
| **Iconos** | Font Awesome 6.5.1 |
| **Fuentes** | Google Fonts (Inter, Cormorant Garamond, DM Sans) |

---

## Funcionalidades

### Sistema de Autenticación
- Registro con validación de contraseña en tiempo real
- Verificación OTP por email (6 dígitos, 10 min de expiración)
- Login con OTP
- Selección de roles al registrarse (Cliente, Emprendedor, Repartidor)
- Selección/carga de avatar
- Cambio de rol activo desde el dashboard
- **Protección CSRF** en formularios de login y registro
- **Recuperación de contraseña** por email con token de 1 hora

### Tiendas (Storefront)
- 12 plantillas visuales con previews interactivos
- Personalización por negocio: colores, modo oscuro, tipografía, logo, banner, FAQ
- Subida de logo y banner con preview
- Carrito de compras con localStorage
- Filtro por categorías y ordenamiento (precio, nombre)
- Compra rápida con modal
- Productos con atributos JSON

### Dashboard del Emprendedor
- Crear y gestionar negocios
- Personalizar tienda (colores, logo, banner, tipografía, FAQ)
- CRUD de productos con imagen
- Vista previa en tiempo real de la personalización
- **Gestionar repartidores**: vincular/desvincular con estado de solicitud

### Dashboard del Repartidor
- Ver pedidos pendientes de entrega
- Asignarse pedidos
- Marcar como entregado
- **Calendario FullCalendar** con pedidos activos e historial
- **Solicitudes de vinculación**: aceptar o rechazar invitaciones de emprendedores
- Estadísticas: entregas hoy, ganancias, activos

### Panel de Administración
- Estadísticas del sistema (usuarios, negocios, productos, pedidos)
- Gestión de usuarios (editar roles, eliminar)
- Gestión de negocios (eliminar)
- **Analítica avanzada**: gráficos de ventas mensuales, top negocios, distribución de estados, métodos de pago, registros de usuarios
- Reporte de ventas por negocio y plantilla
- Seed de datos demo
- Reset completo de la base de datos

### Sistema de Pedidos
- Creación de pedidos con items múltiples
- Compra rápida (1 clic)
- Código de seguimiento (JACHA-XXXXXXXX)
- Estados logísticos: Preparando → En_Ruta → Entregado / Cancelado
- Estados de pago: Pendiente → Completado / Fallido / Reembolsado

### Base de Datos (Características Avanzadas)
- 17+ tablas con relaciones
- Particionamiento de pedidos por mes (13 particiones)
- Índice compuesto en productos
- Procedimiento almacenado: `sp_reporte_ventas_emprendimiento`
- Función: `fn_calcular_ganancia_neta`
- Trigger: `trg_actualizar_stock_venta`
- Tabla de auditoría: `logs_auditoria`
- 5000 productos de prueba

---

## Roles del Sistema

| Rol | Acceso |
|---|---|
| **Administrador** | Panel admin, gestión de usuarios/negocios, analítica, reportes de ventas, reset BD, seed demo |
| **Emprendedor** | Crear/personalizar tiendas, CRUD productos, gestionar repartidores |
| **Cliente** | Explorar tiendas, comprar productos, carrito de compras, historial de pedidos |
| **Repartidor** | Solicitudes de vinculación, pedidos pendientes, asignarse entregas, calendario |

Los usuarios pueden tener múltiples roles y cambiar entre ellos desde el dashboard.

---

## Diagramas de Secuencia

### 1. Registro de Usuario con OTP

```mermaid
sequenceDiagram
    actor U as Usuario
    participant V as Vista (register.php)
    participant C as AuthController
    participant R as UsuarioRepository
    participant O as Modelo OTP
    participant M as Mailer

    U->>V: Completa formulario de registro
    V->>C: POST /registro (con csrf_token)
    C->>C: validate_csrf_token()
    C->>R: emailExists(email)
    R-->>C: false
    C->>V: redirect /elegir-roles (session: registro_temp)

    U->>V: Selecciona roles + avatar
    V->>C: POST /elegir-roles
    C->>V: redirect /enviar-otp

    U->>V: Solicita registro
    V->>C: GET /enviar-otp
    C->>O: generarCodigo(email)
    O-->>C: {codigo, success}
    C->>M: enviarCodigoOTP(email, codigo)
    M-->>C: true
    C->>V: redirect /verificar-otp

    U->>V: Ingresa código OTP
    V->>C: POST /verificar-otp
    C->>O: verificarCodigo(email, codigo)
    O-->>C: {success: true}
    C->>R: insert(usuario)
    C->>R: insertUsuarioRol(id, rol)
    R-->>C: ok
    C->>C: Crea sesión usuario
    C->>V: redirect /dashboard
```

### 2. Inicio de Sesión con OTP

```mermaid
sequenceDiagram
    actor U as Usuario
    participant V as login.php
    participant C as AuthController
    participant R as UsuarioRepository
    participant O as Modelo OTP
    participant M as Mailer

    U->>V: Ingresa email + contraseña
    V->>C: POST /login (con csrf_token)
    C->>C: validate_csrf_token()
    C->>R: findByEmail(email)
    R-->>C: usuario
    C->>C: password_verify(password, hash)
    C->>O: generarCodigo(email)
    O-->>C: {codigo, success}
    C->>C: Guarda login_temp en sesión
    C->>M: enviarCodigoOTP(email, codigo)
    M-->>C: true
    C->>V: redirect /verificar-otp-login

    U->>V: Ingresa código OTP
    V->>C: POST /verificar-otp-login
    C->>O: verificarCodigo(email, codigo)
    O-->>C: {success: true}
    C->>C: Crea sesión de usuario
    C->>V: redirect /dashboard
```

### 3. Vinculación de Repartidor (Solicitud con Estado)

```mermaid
sequenceDiagram
    actor E as Emprendedor
    actor R as Repartidor
    participant DC as DashboardController
    participant ER as EmprendimientoRepository
    participant V as Vista

    E->>V: Ingresa email del repartidor
    V->>DC: POST /repartidores-admin/vincular
    DC->>ER: findByIdAndPropietario(id_emp, id_prop)
    ER-->>DC: emprendimiento
    DC->>ER: findByEmail(email)
    ER-->>DC: usuario_repartidor
    DC->>ER: getRolesNombres(repartidor.id)
    ER-->>DC: ['Repartidor']
    DC->>ER: agregarRepartidor(id_emp, id_rep)
    Note right of ER: INSERT con estado = 'Pendiente'
    ER-->>DC: ok
    DC-->>E: redirect con success

    Note over R: El repartidor revisa sus solicitudes

    R->>V: Visita /repartidor-solicitudes
    V->>DC: GET /repartidor-solicitudes
    DC->>ER: listarSolicitudesRepartidor(id_rep)
    ER-->>DC: [{nombre_comercial, estado, ...}]
    DC-->>R: Muestra solicitudes pendientes

    R->>V: Hace clic en "Aceptar"
    V->>DC: POST /repartidor-solicitudes (accion=aceptar)
    DC->>ER: actualizarEstadoRepartidor(id_emp, id_rep, 'Aceptado')
    ER-->>DC: ok
    DC-->>R: redirect con success

    Note over E: El emprendedor ve el cambio
    E->>V: Visita /repartidores-admin
    V->>DC: GET /repartidores-admin
    DC->>ER: listarRepartidores(id_emp)
    ER-->>DC: [{estado: 'Aceptado', ...}]
    DC-->>E: Muestra badge verde "Aceptado"
```

### 4. Flujo Completo de Pedido

```mermaid
sequenceDiagram
    actor C as Cliente
    actor R as Repartidor
    participant PC as PedidoController
    participant PR as PedidoRepository
    participant DBC as DashboardController / principal.php

    C->>PC: POST /pedido/crear (items, dirección, pago)
    PC->>PR: crearPedido(datos)
    Note right of PR: INSERT pedido + detalles + envio_logistica
    Note right of PR: estado_logistico = 'Preparando'
    PR-->>PC: {id_pedido, codigo}
    PC-->>C: {success: true, codigo}

    Note over R: Repartidor ve pedidos pendientes

    R->>DBC: Visita dashboard-repartidor
    DBC->>PR: getPedidosPendientesRepartidor()
    PR-->>DBC: [{pedidos en 'Preparando'}]
    DBC-->>R: Lista de pedidos disponibles

    R->>DBC: POST /repartidor/asignar (id_pedido)
    DBC->>PR: asignarRepartidor(id_pedido, id_rep)
    Note right of PR: UPDATE envios_logistica SET id_repartidor
    Note right of PR: UPDATE pedidos SET estado = 'En_Ruta'
    PR-->>DBC: true
    DBC-->>R: {success: true}

    R->>DBC: POST /repartidor/entregar (id_pedido)
    DBC->>PR: marcarEntregado(id_pedido, id_rep)
    Note right of PR: UPDATE fecha_entrega
    Note right of PR: UPDATE estado = 'Entregado', pago = 'Completado'
    PR-->>DBC: true
    DBC-->>R: {success: true}
```

### 5. Recuperación de Contraseña

```mermaid
sequenceDiagram
    actor U as Usuario
    participant V as recuperar-password.php
    participant C as AuthController
    participant DB as Base de Datos
    participant M as Mailer

    U->>V: Ingresa su email
    V->>C: POST /recuperar-password (con csrf_token)
    C->>C: validate_csrf_token()
    C->>DB: SELECT usuario WHERE email = ? AND estado = 'Activo'
    DB-->>C: {id_usuario, nombres}

    Note right of C: Genera token de 32 bytes + expiración 1 hora
    C->>DB: UPDATE usuarios SET reset_token, reset_token_expiry
    DB-->>C: ok

    C->>M: enviarEnlaceRecuperacion(email, enlace, nombre)
    M-->>C: true

    C-->>V: Muestra mensaje de confirmación

    U->>V: Abre enlace del correo
    V->>C: GET /recuperar-password?token=XXXX
    C-->>V: Muestra formulario de nueva contraseña

    U->>V: Ingresa nueva contraseña
    V->>C: POST /reset-password (token + password + csrf)
    C->>C: validate_csrf_token()
    C->>DB: SELECT WHERE reset_token = ? AND expiry > NOW()
    DB-->>C: {id_usuario}
    C->>DB: UPDATE usuarios SET password_hash, reset_token=NULL
    DB-->>C: ok
    C-->>U: redirect /login (success)
```

### 6. Dashboard y Navegación por Roles

```mermaid
sequenceDiagram
    actor U as Usuario
    participant R as Router (index.php)
    participant DC as DashboardController
    participant UR as UsuarioRepository
    participant V as principal.php

    U->>R: GET /dashboard
    R->>DC: dashboard()
    DC->>DC: requireAuth()

    DC->>UR: getAvatar(user.id)
    DC->>UR: getRolesNombres(user.id)
    UR-->>DC: ['Cliente', 'Emprendedor']
    DC->>DC: Define rol_activo desde sesión

    alt Emprendedor
        DC->>UR: findByPropietario(user.id)
        UR-->>DC: [negocios...]
        DC-->>V: mis_negocios, stats
        V-->>U: Sidebar emprendedor + cards de negocios
    else Cliente
        DC->>UR: findAprobadosExcept(user.id)
        UR-->>DC: [negocios...]
        DC-->>V: otros_negocios
        V-->>U: Sidebar cliente + grid con búsqueda/filtros
    else Repartidor
        DC-->>V: rol_activo = Repartidor
        V-->>U: Sidebar repartidor + enlace a entregas
    else Administrador
        DC-->>V: es_admin = true
        V-->>U: Sidebar admin + enlace a /admin
    end

    U->>V: Cambia rol desde dropdown
    V->>DC: GET /dashboard?cambiar_rol=Emprendedor
    DC->>DC: Actualiza $_SESSION['rol_activo']
    DC-->>U: redirect /dashboard
```

---

## Instalación

### Requisitos
- PHP 8.x con extensiones: `pdo_mysql`, `gd`, `fileinfo`, `json`, `mbstring`
- MySQL / MariaDB
- Composer
- (Opcional) Apache con mod_rewrite

### Pasos

1. Clona el repositorio:
```bash
git clone <url-del-repo> PROYECTO_GESTION_1_2026_JARJACHAS_JACHAMARKET
```

2. Instala dependencias de Composer:
```bash
cd PROYECTO_GESTION_1_2026_JARJACHAS_JACHAMARKET
composer install
```

3. Crea la base de datos `db_jacha` y ejecuta el schema:
```sql
source sql/top_3.sql
```

4. (Opcional) Ejecuta migraciones adicionales:
```sql
source sql/vincular_repartidores.sql
source sql/recuperar_password.sql
```

5. Configura credenciales SMTP en `config/.env.php`:
```php
<?php
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_USER', 'tu_correo@gmail.com');
define('SMTP_PASS', 'tu_contraseña_de_aplicacion');
define('SMTP_PORT', 587);
define('SMTP_FROM', 'tu_correo@gmail.com');
define('SMTP_FROM_NAME', 'Jacha Marketplace');
```

6. Inicia el servidor:
```bash
php -S localhost:8000 -t public
```

7. Accede a: `http://localhost:8000`

---

## Super Administrador por Defecto

- **Email:** `mikypramos2905@gmail.com`
- **Password:** `Pomada-23`

O crea uno nuevo con `php setup-admin.php`.

---

## Estructura del Proyecto

```
PROYECTO_GESTION_1_2026_JARJACHAS_JACHAMARKET/
├── config/                  # Configuración (BD, mail, .env.php, base URL)
├── public/                  # Raíz web (index.php, assets, uploads)
│   └── assets/
│       ├── css/             # Estilos
│       ├── images/          # Imágenes del sistema
│       ├── js/              # JavaScript
│       └── uploads/         # Subidas de usuarios
├── src/
│   ├── Controllers/         # Controladores (Auth, Dashboard, Admin, etc.)
│   ├── Core/                # Router, Controller base
│   ├── Models/              # Modelos (OTP)
│   ├── Repositories/        # Acceso a datos
│   └── Views/               # Plantillas por módulo
│       ├── admin/           # Panel admin + analítica
│       ├── auth/            # Login, registro, OTP, recuperación
│       ├── dashboard/       # Principal, repartidores, solicitudes
│       ├── pages/           # Landing, explorar, plantillas
│       ├── perfil/          # Perfil de usuario
│       └── shop/            # Tiendas (themes/)
├── sql/                     # Schemas y migraciones
├── vendor/                  # Composer dependencies
├── setup-admin.php          # Script para crear super admin
├── composer.json
└── .gitignore
```

---

## Rutas Principales

| Ruta | Descripción |
|---|---|
| `/` | Landing page |
| `/login` | Iniciar sesión |
| `/registro` | Registrarse |
| `/recuperar-password` | Recuperación de contraseña |
| `/reset-password` | Cambiar contraseña (POST) |
| `/dashboard` | Dashboard principal (según rol) |
| `/tienda/{id}` | Tienda pública |
| `/productos` | Gestionar productos |
| `/plantillas` | Personalizar tienda |
| `/crear-negocio` | Crear nuevo negocio |
| `/repartidores-admin` | Gestionar repartidores (emprendedor) |
| `/repartidor-solicitudes` | Solicitudes de vinculación (repartidor) |
| `/dashboard-repartidor` | Panel de entregas + calendario |
| `/admin` | Panel de administración |
| `/admin/analytics` | Analítica con gráficos |
| `/admin/ventas` | Reporte de ventas |
| `/perfil` | Perfil de usuario |
| `/explorar` | Explorar tiendas |

---

## Archivos ignorados (no se suben al repo)

- `vendor/` — dependencias de Composer
- `.env` — variables de entorno
- `.env.php` — credenciales SMTP
- `public/uploads/` — imágenes de productos subidas
- `public/assets/uploads/` — logos y banners subidos
- `*.log` — archivos de log
