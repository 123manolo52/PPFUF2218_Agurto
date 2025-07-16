# Desarrollo de componentes para la integración con repositorio

##  Objetivo

El alumnado debe comprender y aplicar el manejo de ficheros **XML** como sistema de almacenamiento estructurado, integrándolo en una aplicación web desarrollada con **PHP**.  
Deberán **modificar, ampliar y documentar** un CRUD existente basado en este tipo de almacenamiento.

---

##  Enunciado del ejercicio

Se te proporciona una aplicación web funcional que permite **insertar y eliminar coches** registrados en un fichero XML.

Deberás realizar las siguientes tareas:

---

### 1.  Analizar el funcionamiento de cada fichero proporcionado

- Explica en un documento `.md` el propósito de cada archivo:
  - Archivos **PHP**
  - Archivo **XML**
  - Esquema **XSD**
  - Hoja de estilo **XSL**

---

### 2.  Ampliar la funcionalidad del CRUD

- Añadir una opción para **modificar** un coche ya existente.
- Mostrar un listado de coches con una interfaz visual **más atractiva** utilizando `coches.xsl`.

---

### 3.  Validación de esquema XML

- Validar que los datos del XML cumplen con el esquema `coches.xsd` tras cada operación (inserción, modificación, eliminación).

---

### 4.  Control de errores

Implementa mensajes de error o alertas para los siguientes casos:

- Inserción de **matrícula duplicada**
- Eliminación o modificación de un coche que **no existe**

---

### 5.  Crear el script `buscar_coche.php`

- Permite buscar coches por **marca** o **modelo** desde un formulario HTML.

---

### 6.  Documentación técnica

Crea un archivo `README.md` (este archivo) que incluya:

- La **estructura del sistema** (carpetas y archivos)
- Cómo se realiza cada operación (insertar, eliminar, modificar, buscar)
- Validaciones aplicadas
- Capturas de pantalla de las **pruebas funcionales**

---

### 7.  Modo de entrega

- Comparte con el docente un **repositorio Git** con el nombre:  
  `E2_[Nombre_del_alumno]`

---

## 💪 ¡Ánimo!

Este ejercicio te permitirá poner en práctica el desarrollo de sistemas web integrados con XML, un formato ampliamente utilizado en entornos profesionales.

