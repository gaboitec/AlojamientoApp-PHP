# Proyecto de Aplicación Web de Alojamiento

Este proyecto es una aplicación web para la gestión de alojamientos que incluye funcionalidades de CRUD (Crear, Leer, Actualizar, Eliminar) y acceso de usuarios con diferentes roles. Este documento describe cómo configurar y usar la base de datos del proyecto.

---

## Estructura de Archivos Relacionados con la Base de Datos

```
project/
├── sql/
│   ├── schema.sql              # Esquema inicial de la base de datos
│   ├── data.sql                # Datos de prueba o iniciales
│   └── migrations/             # Cambios incrementales en el esquema
│       └── ...                 # Más migraciones
```

### Archivos Clave

1. **`schema.sql`**
   - Contiene el esquema inicial de la base de datos.
   - Incluye la creación de tablas, índices y relaciones.

2. **`data.sql`** (Opcional)
   - Incluye datos iniciales para pruebas, como un usuario administrador y algunos alojamientos de ejemplo.

3. **`migrations/`**
   - Contiene scripts SQL incrementales para cambios en el esquema de la base de datos.

---

## Configuración Inicial de la Base de Datos

### 1. Crear la Base de Datos
Ejecuta el siguiente comando en tu entorno MySQL para crear la base de datos:

```sql
CREATE DATABASE alojamiento CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
```

### 2. Importar el Esquema Inicial
Carga el archivo `schema.sql` para crear las tablas necesarias:

```bash
mysql -u [usuario] -p alojamiento < sql/schema.sql
```

### 3. (Opcional) Importar Datos Iniciales
Para cargar datos de prueba, utiliza el archivo `data.sql`:

```bash
mysql -u [usuario] -p alojamiento < sql/data.sql
```

---

## Actualizaciones de la Base de Datos

### Migraciones Incrementales
Cuando haya cambios en el esquema de la base de datos, estos se agregarán como archivos en la carpeta `sql/migrations/`. Para aplicar una migración:

1. Ve al directorio del proyecto.
2. Ejecuta el script de migración deseado:

   ```bash
   mysql -u [usuario] -p alojamiento < sql/migrations/[nombre_del_script].sql
   ```

3. Repite el paso 2 para cada migración pendiente.

---

## Notas para el Equipo

- **Roles de Usuario:** El sistema distingue entre usuarios normales y administradores. El usuario administrador inicial se crea en el archivo `data.sql`.
- **Configuración Local:** Cada desarrollador puede trabajar con su propia base de datos local mientras se configura la base de datos compartida.
- **Base de Datos Compartida:** Una vez configurada, los desarrolladores deberán actualizar la configuración de conexión en `config/database.php` para usar la base de datos central.

---
