# JACHAmarket — Marketplace Multiroles

Plataforma web de comercio electrónico donde emprendedores crean y personalizan sus tiendas online, clientes compran productos, repartidores gestionan entregas y administradores controlan el sistema.

---

## Tecnologías

| | |
|---|---|
| **Backend** | PHP 8.x con PSR-4 autoload |
| **Frontend** | HTML5, CSS3, JavaScript vanilla |
| **Base de Datos** | MySQL / MariaDB con InnoDB |
| **Servidor** | Apache con mod_rewrite |
| **Entorno** | XAMPP |
| **Mail** | PHPMailer (Gmail SMTP) |
| **Iconos** | Font Awesome 6.5.1 |
| **Fuentes** | Google Fonts |

---

## Funcionalidades

### Autenticación y Usuarios
- Registro con validación de contraseña en tiempo real
- Verificación OTP por email (6 dígitos, 10 min de expiración)
- Login con OTP
- Selección de roles al registrarse (Cliente, Emprendedor, Repartidor)
- Selección/carga de avatar
- Cambio de rol activo desde el dashboard
- Perfil de usuario con edición de datos

### Tiendas (Storefront)
- **10 plantillas visuales**: Moderno, Elegante, Tecnológico, Electrodomésticos, ModaViva, Sabores, Artesano, GlowUp, FullFit, HogarDulce (+ default)
- Personalización por negocio: colores (primario, secundario, fondo, texto), modo oscuro, tipografía, logo, banner
- Subida de logo y banner con preview en tiempo real
- Carrito de compras con localStorage
- Filtro por categorías y ordenamiento (precio, nombre)
- Compra rápida con modal (cantidad, dirección, método de pago)
- Productos con atributos JSON (marca, tipo, especificaciones)
- Bloqueo de compra para el propio dueño del negocio

### Dashboard del Emprendedor
- Crear y gestionar negocios
- Personalizar tienda (colores, logo, banner, tipografía) con vista previa en vivo
- CRUD de productos con imagen (límite 500 KB)
- Ver tienda pública propia

### Panel de Administración
- Estadísticas del sistema (usuarios, negocios, productos, pedidos)
- Gestión de usuarios (editar roles, eliminar)
- Gestión de negocios (eliminar)
- Reporte de ventas por negocio y plantilla
- Seed de datos demo
- Reset completo de la base de datos

### Sistema de Pedidos
- Creación de pedidos con múltiples items
- Compra rápida (1 clic)
- Código de seguimiento único (JACHA-XXXXXXXX)
- Historial de pedidos por cliente
- Estados logísticos: Recibido → Preparando → En_Ruta → Entregado / Cancelado

### Sistema de Repartidores
- Dashboard con estadísticas (entregas hoy, totales, ganancias)
- Ver pedidos pendientes de entrega
- Asignarse entregas
- Marcar pedido como entregado
- Historial de entregas

### Base de Datos
- 17 tablas con relaciones, particionamiento, índices compuestos
- Procedimiento almacenado: `sp_reporte_ventas_emprendimiento`
- Función: `fn_calcular_ganancia_neta`
- Trigger: `trg_actualizar_stock_venta`
- Tabla de auditoría: `logs_auditoria`

---

## Roles del Sistema

| Rol | Acceso |
|---|---|
| **Administrador** | Panel admin, gestión de usuarios/negocios, reportes de ventas, reset BD, seed demo |
| **Emprendedor** | Crear/personalizar tiendas, CRUD productos, ver tienda propia |
| **Cliente** | Explorar tiendas, comprar productos, carrito, historial de pedidos |
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
source sql/top_3.sql
```
O importa `sql/top_3.sql` desde phpMyAdmin.

4. Configura el mail en `config/mail.php` para el envío de OTP.

5. Accede a:
```
http://localhost/PROYECTO_GESTION_1_2026_JARJACHAS_JACHAMARKET
```

> **Nota:** Para crear un super administrador o configurar datos iniciales, pídelo directamente desde la terminal y se hará automáticamente.

---

## Estructura del Proyecto

```
PROYECTO_GESTION_1_2026_JARJACHAS_JACHAMARKET/
├── config/                      # Configuración (BD, mail, base URL)
├── public/                      # Raíz web
│   ├── index.php                # Front controller
│   ├── serve.php                # Servidor de imágenes
│   ├── assets/
│   │   ├── css/                 # Estilos globales
│   │   ├── images/              # Imágenes del sistema
│   │   └── avatars/             # Avatares por defecto
│   └── uploads/                 # Subidas de usuarios (logos, banners)
├── src/
│   ├── Controllers/             # Lógica de controladores
│   ├── Core/                    # Router y Controller base
│   ├── Models/                  # Modelos (OTP)
│   ├── Repositories/            # Acceso a datos (queries SQL)
│   └── Views/                   # Plantillas
│       ├── auth/                # Login, registro, OTP
│       ├── dashboard/           # Dashboard + previews de temas
│       ├── pages/               # Landing, explorar, demo
│       ├── perfil/              # Perfil de usuario
│       └── shop/                # Tienda pública + temas (themes/)
├── docs/                        # Diagramas y documentación
│   ├── Diagramas de casos de uso/
│   ├── Diagramas de Clases/
│   ├── Diagramas PERT/
│   ├── Modelo Fisico/
│   └── Documentos/
├── sql/                         # Schema completo (top_3.sql)
├── vendor/                      # Composer dependencies
├── .htaccess                    # Rewrite rules (Apache)
└── composer.json
```

---

## Rutas Principales

### Públicas
| Ruta | Descripción |
|---|---|
| `/` | Landing page |
| `/explorar` | Explorar tiendas |
| `/tienda/{id}` | Tienda pública de un negocio |
| `/plantillas-disponibles` | Ver plantillas disponibles |
| `/plantilla/{id}` | Detalle de una plantilla |
| `/db-demo` | Demo técnico de la BD |

### Autenticación
| Ruta | Descripción |
|---|---|
| `/login` | Iniciar sesión |
| `/registro` | Registrarse |
| `/elegir-roles` | Seleccionar roles después del registro |
| `/verificar-otp` | Verificar OTP (registro) |
| `/verificar-otp-login` | Verificar OTP (login) |
| `/enviar-otp` | Enviar código OTP |
| `/reenviar-otp` | Reenviar OTP (registro) |
| `/reenviar-otp-login` | Reenviar OTP (login) |
| `/logout` | Cerrar sesión |

### Dashboard
| Ruta | Descripción |
|---|---|
| `/dashboard` | Dashboard principal |
| `/mis-estadisticas` | Estadísticas de cliente |
| `/mis-pedidos` | Historial de pedidos del cliente |
| `/crear-negocio` | Crear nuevo negocio |
| `/plantillas` | Personalizar tienda (colores, logo, banner) |
| `/productos` | CRUD de productos |
| `/gestionar-negocios` | Gestionar negocios propios |
| `/repartidores-admin` | Gestionar repartidores del negocio |

### Perfil
| Ruta | Descripción |
|---|---|
| `/perfil` | Ver/editar perfil |
| `/perfil/actualizar` | Actualizar datos de perfil |
| `/perfil/quitar-repartidor` | Quitar rol de repartidor |
| `/perfil/eliminar-negocio` | Eliminar negocio propio |

### Administración
| Ruta | Descripción |
|---|---|
| `/admin` | Panel de administración |
| `/admin/ventas` | Reporte de ventas |
| `/admin/editar-usuario` | Editar usuario |
| `/admin/eliminar-usuario` | Eliminar usuario |
| `/admin/eliminar-negocio` | Eliminar negocio |
| `/admin/reiniciar-bd` | Resetear base de datos |
| `/admin/seed-demo` | Poblar datos de demostración |

### Repartidor
| Ruta | Descripción |
|---|---|
| `/dashboard-repartidor` | Dashboard del repartidor |
| `/repartidor/pedidos-pendientes` | Pedidos disponibles para entregar |
| `/repartidor/asignar` | Asignarse un pedido |
| `/repartidor/entregar` | Marcar pedido como entregado |

### API (JSON)
| Ruta | Descripción |
|---|---|
| `POST /pedido/crear` | Crear pedido desde el carrito |
| `POST /pedido/comprar-rapido` | Compra rápida de un producto |
| `POST /guardar-temp-avatar` | Guardar avatar temporal |

---

## Documentación Técnica

Los diagramas del sistema están en la carpeta `docs/` en formato PlantUML:

| Carpeta | Contenido |
|---|---|
| `docs/Diagramas de casos de uso/` | 11 diagramas de casos de uso por módulo |
| `docs/Diagramas de Clases/` | Diagrama de clases alto nivel y bajo nivel |
| `docs/Diagramas PERT/` | 5 diagramas PERT + ruta crítica |
| `docs/Modelo Fisico/` | Modelo físico de la base de datos |

---

## Próximas implementaciones

- **Cálculo de margen de ganancia** — Agregar campo `precio_costo` a productos y reporte de márgenes por producto/negocio.
- **Módulo de inventario por sucursal** — Variantes de producto con SKU y stock distribuido por sucursal.
- **Kardex** — Registro histórico de movimientos de stock (entradas, salidas, ajustes) con trazabilidad.
- **Gestión de categorías jerárquicas** — Árbol de categorías con subcategorías.
- **Notificaciones** — Alertas de stock mínimo y notificaciones en tiempo real.

> **Nota:** La integración de pagos (QR, Tarjeta, Transferencia) es una simulación del flujo transaccional con fines académicos. No se conecta a una pasarela de pagos real ni procesa transacciones financieras verdaderas.

---

## Archivos ignorados (no se suben al repo)

- `vendor/` — dependencias de Composer
- `.env` — variables de entorno
- `public/uploads/` — imágenes de productos subidas
- `public/assets/uploads/` — logos y banners subidos
- `*.log` — archivos de log
