# PPF/UF2218/MANUEL

Aplicación web desarrollada en PHP orientada a la **gestión de coches** con operaciones CRUD, control de acceso por roles, almacenamiento XML y validación estructural mediante XSD.  
Este sistema simula un concesionario digital completo, robusto y adaptable.

---

## 📁 Estructura del proyecto

```plaintext
PPF/UF2218/MANUEL/
├── login.php              → Acceso con usuarios definidos en XML
├── logout.php             → Cierre seguro de sesión
├── panel.php              → Panel principal con acciones según rol
├── insertar_coche.php     → Inserta nuevos coches al XML
├── modificar_coche.php    → Modifica datos existentes
├── eliminar_coche.php     → Elimina coche por matrícula
├── buscar_coche.php       → Búsqueda avanzada (por 7 campos)
├── validar_xml.php        → Verifica estructura del XML con esquema.xsd
├── test_eliminar.php      → Prueba directa de eliminación desde XML
├── README.md              → Documentación técnica del sistema
└── /files/
    ├── coches.xml         → Base de datos XML de coches
    ├── esquema.xsd        → Esquema de validación formal XSD
    └── usuarios.xml       → Usuarios con roles para autenticación
🔐 Gestión de Usuarios y Roles
Se definieron los siguientes roles personalizados dentro del archivo usuarios.xml:

Rol	Permisos
administrador	Insertar, modificar, eliminar y buscar coches
empleado	Insertar y modificar coches solamente
consultor	Buscar y consultar coches sin modificar ni eliminar
Los usuarios se autentican desde el XML con login.php.

El rol se guarda en $_SESSION['rol'] y controla las acciones disponibles.

logout.php destruye la sesión y devuelve al login.

⚙️ Operaciones Disponibles
➕ Insertar coche
Valida todos los campos necesarios

Verifica matrícula única para evitar duplicados

Disponible para administrador y empleado

✏️ Modificar coche
Permite editar los datos existentes

Aplica validaciones básicas por campo

Disponible para administrador y empleado

🗑️ Eliminar coche
Elimina por coincidencia exacta de matrícula (trim() aplicado)

Exclusivo para administrador

🔍 Buscar coche
Mejora implementada: búsqueda por 7 campos

Matrícula, marca, modelo, color, puertas, precio, tipo de venta

Interfaz con desplegable + campo de texto

Disponible para todos los roles

🛡️ Validación XML con XSD
Implementamos esquema.xsd para validar la estructura del XML. La validación se realiza con PHP (DOMDocument::schemaValidate()) desde el script validar_xml.php:

Matrícula como atributo obligatorio

Marca, modelo, color como cadenas (xs:string)

Puertas como número entero (xs:integer)

Precio como decimal (xs:decimal) con atributo venta obligatorio

✅ Esto garantiza que el sistema nunca cargue ni modifique un XML mal estructurado.

🧪 Scripts Técnicos de Diagnóstico
test_eliminar.php
Elimina una matrícula directamente usando GET

Protegido por sesión activa y rol de administrador

Útil para verificar si el XML responde bien fuera de la interfaz

validar_xml.php
Comprueba si el XML cumple el esquema definido

Muestra errores internos si la estructura falla

Puede incluirse en otros scripts como capa de seguridad

✅ Mejoras Aplicadas al Proyecto
🔧 Transición a XML con validación XSD, para evitar estructura débil

🔐 Implementación de roles dinámicos, incluyendo rol intermedio empleado

🔍 Búsqueda avanzada por múltiples campos mediante formulario con desplegable

🧼 Comparaciones seguras usando trim() para evitar fallos invisibles

📦 Separación clara entre lógica PHP y presentación visual con Bootstrap

🧪 Herramientas técnicas para pruebas específicas sin romper el flujo principal

🎯 Control granular de acciones por rol, aumentando la profesionalidad del sistema

📸 Capturas Recomendadas
Incluir imágenes de:

Pantalla de login con roles definidos

Vista del panel según cada rol

Formulario de inserción y modificación

Resultados de búsqueda

Mensajes de éxito y validación de errores

🚀 Entrega Oficial
Repositorio GitHub: Nombre: PPF/UF2218/MANUEL Contenido del repositorio:

Código fuente (PHP + XML + XSD)

Documentación técnica

Capturas funcionales

👤 Autor
Manuel Proyecto desarrollado en el módulo UF2218, con enfoque avanzado en autenticación, validación estructural y manejo de datos en PHP.


