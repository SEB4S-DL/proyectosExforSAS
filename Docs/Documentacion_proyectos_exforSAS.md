
# 📁 Sistema de Gestión de Proyectos y Usuarios

Este sistema permite crear, editar, eliminar y asignar usuarios a proyectos.  
Construido en **PHP puro**, con consultas seguras (prepared statements) usando **MySQLi**, 
y frontend dinámico con **Fetch API** + **SweetAlert2** para interacción moderna.

---

## 🗂️ Estructura del Proyecto

```
proyectosExforSAS/
│
├── config/
│   └── config.php
│
├── db/
│   └── conection.php
│
├── functions/
│   ├── crearUsuario.php
│   ├── crearProyecto.php
│   ├── eliminarProyecto.php
│   ├── editarProyecto.php
│   ├── asignarUsuario.php
│   ├── eliminarUsuarioDeProyecto.php
│
├── pages/
│   ├── usuarios.php
│   ├── proyectosPorUsuario.php
│   ├── añadirUsuario.php
│   ├── crearProyecto.php
│   ├── crearUsuario.php
│
├── public/
│   └── index.php
│
├── assets/
│   ├── css/
│   └── js/
│
└── layout.php
```

---

## 🛠️ Base de Datos

```sql
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    email VARCHAR(100),
    estado TINYINT DEFAULT 1
);

CREATE TABLE proyectos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    descripcion TEXT,
    estado TINYINT DEFAULT 1
);

CREATE TABLE usuario_proyecto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    proyecto_id INT,
    estado TINYINT DEFAULT 1,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    FOREIGN KEY (proyecto_id) REFERENCES proyectos(id)
);
```

---

## 🔌 Endpoints y Funcionalidad

| Archivo                                | Método | Descripción                                 |
|----------------------------------------|--------|---------------------------------------------|
| `crearUsuario.php`                     | POST   | Crea un nuevo usuario                       |
| `crearProyecto.php`                    | POST   | Crea un nuevo proyecto                      |
| `editarProyecto.php`                   | POST   | Edita nombre y descripción de un proyecto   |
| `eliminarProyecto.php`                 | POST   | Desactiva un proyecto                       |
| `asignarUsuario.php`                   | POST   | Asigna un usuario a un proyecto             |
| `eliminarUsuarioDeProyecto.php`        | POST   | Desactiva usuario de un proyecto            |

---

## ✍️ Validaciones Frontend

- Realizadas con **JavaScript**.
- Validación con **expresiones regulares**.
- Manejo de errores con SweetAlert2.
- Campos controlados: `nombre`, `email`, `descripción`.

---

## 🎨 Estilo y UI

- **CSS puro** con diseño responsive.
- Footer fijo al fondo.
- Layout general usando `layout.php` y `ob_start()`.
- Uso de `fetch()` para formularios asincrónicos.

---

## 🧪 Pruebas Manuales sugeridas

- Crear proyecto con nombre válido e inválido.
- Crear usuario con email inválido.
- Asignar el mismo usuario dos veces al mismo proyecto.
- Eliminar proyecto y verificar que se oculte visualmente.
- Ver proyectos de un usuario desde `usuarios.php`.

---

Desarrollado por: **Sebas Duque** 🚀
