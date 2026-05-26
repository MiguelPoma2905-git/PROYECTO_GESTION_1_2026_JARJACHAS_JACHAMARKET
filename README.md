# JACHAmarket — Marketplace Multiroles

Plataforma web de comercio electrónico donde emprendedores pueden crear y personalizar sus tiendas online, clientes pueden comprar productos, repartidores gestionan entregas, y administradores controlan el sistema.

---

## Tecnologías

| | |
|---|---|
| **Backend** | PHP 8.x con PSR-4 autoload |
| **Frontend** | HTML5, CSS3, JavaScript (vanilla) |
| **Base de Datos** | MySQL / MariaDB con InnoDB |
| **Servidor** | Apache con mod_rewrite |
| **Entorno** | XAMPP |
| **Mail** | PHPMailer (Gmail SMTP) |
| **Iconos** | Font Awesome 6.5.1 |
| **Fuentes** | Google Fonts |

---

## Funcionalidades

### Sistema de Autenticación
- Registro con validación de contraseña en tiempo real
- Verificación OTP por email (6 dígitos, 10 min de expiración)
- Login con OTP
- Selección de roles al registrarse (Cliente, Emprendedor, Repartidor)
- Selección/carga de avatar
- Cambio de rol activo desde el dashboard

### Tiendas (Storefront)
- 3 plantillas visuales: ElectroHogar (oscuro), Tecnológico (azul claro), General
- Personalización por negocio: colores (primario, secundario, fondo, texto), modo oscuro, tipografía, logo, banner
- Subida de logo y banner con preview
- Carrito de compras con localStorage
- Filtro por categorías y ordenamiento (precio, nombre)
- Compra rápida con modal (cantidad, dirección, método de pago, QR)
- Productos con atributos JSON (marca, tipo, especificaciones)
- Bloqueo de compra para el propio dueño

### Dashboard del Emprendedor
- Crear y gestionar negocios
- Personalizar tienda (colores, logo, banner, tipografía)
- CRUD de productos con imagen
- Vista previa en tiempo real de la personalización

### Panel de Administración
- Estadísticas del sistema (usuarios, negocios, productos, pedidos)
- Gestión de usuarios (editar roles, eliminar)
- Gestión de negocios (eliminar)
- Reporte de ventas por negocio y plantilla
- Seed de datos demo (electrodomésticos)
- Reset completo de la base de datos

### Sistema de Pedidos
- Creación de pedidos con items múltiples
- Compra rápida (1 clic)
- Código de seguimiento (JACHA-XXXXXXXX)
- Estados logísticos: Recibido → Preparando → En_Ruta → Entregado / Cancelado
- Estados de pago: Pendiente → Completado / Fallido / Reembolsado

### Sistema de Repartidores
- Ver pedidos pendientes de entrega
- Asignar repartidor a pedido
- Marcar pedido como entregado
- API JSON para integración

### Base de Datos (Características Avanzadas)
- 17 tablas con relaciones
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
| **Administrador** | Panel admin, gestión de usuarios/negocios, reportes de ventas, reset BD, seed demo |
| **Emprendedor** | Crear/personalizar tiendas, CRUD productos, ver tienda propia |
| **Cliente** | Explorar tiendas, comprar productos, carrito de compras |
| **Repartidor** | Ver pedidos pendientes, asignarse entregas, marcar como entregado |

Los usuarios pueden tener múltiples roles y cambiar entre ellos desde el dashboard.

---

## Instalación

### Requisitos
- XAMPP (Apache + MySQL + PHP 8+)
- Composer
- Extensiones PHP: `pdo_mysql`, `gd`, `fileinfo`, `json`, `mbstring`
- Apache mod_rewrite habilitado

### Pasos

1. Clona el repositorio en `C:\xampp\htdocs\`:
```bash
cd C:\xampp\htdocs
git clone <url-del-repo> PROYECTO_GESTION_1_2026_JARJACHAS_JACHAMARKET
```

2. Instala dependencias de Composer:
```bash
cd PROYECTO_GESTION_1_2026_JARJACHAS_JACHAMARKET
composer install
```

3. Crea la base de datos `db_jacha` en MySQL y ejecuta el schema:
```sql
-- Abre phpMyAdmin o MySQL CLI y ejecuta:
source sql/top_3.sql
```
O importa `sql/top_3.sql` desde phpMyAdmin.

4. Configura el mail en `config/mail.php` para OTP:
```php
// Usa credenciales de Gmail SMTP
```

5. Accede a:
```
http://localhost/PROYECTO_GESTION_1_2026_JARJACHAS_JACHAMARKET
```

---

## Crear Super Administrador

### Opción 1: Script automático (recomendado)

Ejecuta `setup-admin.bat` (Windows) desde la raíz del proyecto:

```
Haz doble clic en setup-admin.bat
```

O desde terminal:

```bash
php setup-admin.php
```

El script te pedirá:
- Email
- Nombres y apellidos
- Teléfono (opcional)
- Contraseña

Y automáticamente:
1. Se conecta a la base de datos
2. Crea los roles si no existen
3. Crea el usuario con contraseña hasheada (bcrypt)
4. Asigna el rol **Administrador** + **Cliente**
5. Confirma la creación

### Opción 2: SQL directo

```sql
-- 1. Insertar usuario
INSERT INTO usuarios (nombres, apellidos, email, password_hash, estado)
VALUES ('Admin', 'Sistema', 'admin@email.com', '$2y$10$...hash...', 'Activo');

-- 2. Obtener IDs
SET @id_usuario = LAST_INSERT_ID();
SET @id_admin = (SELECT id_rol FROM roles WHERE nombre_rol = 'Administrador');
SET @id_cliente = (SELECT id_rol FROM roles WHERE nombre_rol = 'Cliente');

-- 3. Asignar roles
INSERT INTO usuario_roles (id_usuario, id_rol) VALUES (@id_usuario, @id_admin);
INSERT INTO usuario_roles (id_usuario, id_rol) VALUES (@id_usuario, @id_cliente);
```

Para generar el hash de la contraseña usa: `php -r "echo password_hash('tu_password', PASSWORD_DEFAULT);"`

### Opción 3: Usuario pre-seeded

El schema incluye un super admin por defecto:
- **Email:** `mikypramos2905@gmail.com`
- **Password:** `Pomada-23`

---

## Estructura del Proyecto

```
PROYECTO_GESTION_1_2026_JARJACHAS_JACHAMARKET/
├── config/                  # Configuración (BD, mail, base URL)
├── public/                  # Raíz web (index.php, assets, uploads)
│   └── assets/
│       ├── css/             # Estilos
│       ├── images/          # Imágenes del sistema
│       ├── js/              # JavaScript
│       └── uploads/         # Subidas de usuarios (logos, banners)
├── src/
│   ├── Controllers/         # Controladores
│   ├── Core/                # Router, Controller base
│   ├── Models/              # Modelos (OTP)
│   ├── Repositories/        # Acceso a datos
│   └── Views/               # Plantillas (auth, dashboard, shop, admin, perfil)
├── sql/                     # Schema completo (top_3.sql)
├── vendor/                  # Composer dependencies
├── setup-admin.bat          # Script para crear super admin (Windows)
├── setup-admin.php          # Script PHP para crear super admin
├── .htaccess                # Rewrite rules (Apache)
└── composer.json
```

---

## Rutas Principales

| Ruta | Descripción |
|---|---|
| `/` | Landing page |
| `/login` | Iniciar sesión |
| `/registro` | Registrarse |
| `/dashboard` | Dashboard principal |
| `/tienda/{id}` | Tienda pública |
| `/productos` | Gestionar productos |
| `/plantillas` | Personalizar tienda |
| `/crear-negocio` | Crear nuevo negocio |
| `/admin` | Panel de administración |
| `/admin/ventas` | Reporte de ventas |
| `/perfil` | Perfil de usuario |
| `/explorar` | Explorar tiendas |
| `/db-demo` | Demo técnico de BD |

---

## Archivos ignorados (no se suben al repo)

- `vendor/` — dependencias de Composer
- `.env` — variables de entorno
- `public/uploads/` — imágenes de productos subidas
- `public/assets/uploads/` — logos y banners subidos
- `*.log` — archivos de log
- `public/uploads/`, `public/assets/uploads/` — uploads temporales (ignorados por git)
