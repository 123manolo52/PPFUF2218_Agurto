## 🔐 Gestión de Usuarios y Roles

Se definieron los siguientes roles personalizados dentro del archivo `usuarios.xml`:

| Rol          | Permisos                                                           |
|--------------|--------------------------------------------------------------------|
| administrador| Insertar, modificar, eliminar y buscar coches                     |
| empleado     | Insertar y modificar coches solamente                             |
| consultor    | Buscar y consultar coches sin modificar ni eliminar               |

- Los usuarios se autentican desde el XML mediante `login.php`.
- El rol se guarda en `$_SESSION['rol']` y condiciona las acciones visibles en el panel.
- `logout.php` destruye la sesión activa y redirige al login.

---

## ⚙️ Operaciones Disponibles

### ➕ Insertar coche
- Valida todos los campos requeridos.
- Verifica matrícula única para evitar duplicados.
- Disponible para los roles `administrador` y `empleado`.

### ✏️ Modificar coche
- Permite editar los datos existentes de un coche.
- Aplica validaciones básicas por campo.
- Disponible para `administrador` y `empleado`.

### 🗑️ Eliminar coche
- Elimina por coincidencia exacta de matrícula (`trim()` aplicado).
- Exclusivo para el rol `administrador`.

### 🔍 Buscar coche
- Búsqueda mejorada por 7 campos:  
  `matrícula`, `marca`, `modelo`, `color`, `puertas`, `precio`, `tipo de venta`.
- Formulario con desplegable y campo de entrada.
- Disponible para todos los roles.

---

## 🛡️ Validación XML con XSD

Se implementó `esquema.xsd` para validar la estructura de `coches.xml`.  
La validación se realiza con PHP utilizando `DOMDocument::schemaValidate()` desde el script `validar_xml.php`.

Validaciones estructurales:
- Matrícula como atributo obligatorio.
- Marca, modelo, color como cadenas (`xs:string`).
- Puertas como número entero (`xs:integer`).
- Precio como decimal (`xs:decimal`) con atributo `venta` obligatorio.

✅ Esto garantiza que el sistema no opere sobre XML mal estructurado.

---

## 🧪 Scripts Técnicos de Diagnóstico

### `test_eliminar.php`
- Elimina una matrícula directamente mediante `GET`.
- Protegido por sesión activa y rol `administrador`.
- Útil para validar comportamiento del XML sin interfaz gráfica.

### `validar_xml.php`
- Comprueba que el XML cumple con el esquema XSD.
- Muestra errores internos si la estructura es inválida.
- Puede incluirse como capa de seguridad previa a operaciones.

---

## ✅ Mejoras Aplicadas al Proyecto

- 🔧 Transición a XML con validación por esquema XSD.
- 🔐 Gestión dinámica de roles, incluyendo el nuevo rol intermedio `empleado`.
- 🔍 Búsqueda avanzada por múltiples campos.
- 🧼 Comparación de datos con `trim()` para evitar errores invisibles.
- 📦 Separación de lógica PHP y presentación visual mediante Bootstrap.
- 🧪 Scripts de prueba independientes para diagnóstico seguro.
- 🎯 Control granular de acciones por rol, elevando la robustez del sistema.

---

## 📸 Capturas Recomendadas

> Se recomienda incluir imágenes funcionales del sistema:
> - Pantalla de login con roles diferenciados.
> - Panel con acciones visibles según cada rol.
> - Formularios de inserción y modificación.
> - Resultados de búsqueda.
> - Mensajes de éxito, error y validación XML.

---

## 🚀 Entrega Oficial

**Repositorio GitHub:**  
Nombre: `PPF/UF2218/MANUEL`

**Contenido entregado:**
- Código fuente: PHP + XML + XSD.
- Documentación técnica (`README.md`).
- Capturas funcionales del sistema.

---

## 👤 Autor

**Manuel**  
Proyecto desarrollado en el módulo **UF2218**, con enfoque en autenticación, validación estructural y gestión de datos XML en entorno PHP profesional.



