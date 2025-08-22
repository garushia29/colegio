# Sistema de Gestión Escolar - Colegio JIM

Este sistema permite la gestión de cursos y estudiantes para una institución educativa.

## Estructura del Proyecto

```
colegio_jim/
├── app/
│   ├── config/
│   │   └── database.php
│   ├── controllers/
│   │   ├── AuthController.php
│   │   ├── CursoController.php
│   │   └── EstudianteController.php
│   ├── models/
│   │   ├── Curso.php
│   │   └── Estudiante.php
│   └── views/
│       ├── cursos/
│       │   ├── create.php
│       │   └── index.php
│       ├── estudiantes/
│       │   ├── create.php
│       │   ├── edit.php
│       │   ├── index.php
│       │   ├── por_curso.php
│       │   └── view.php
│       └── login_form.php
├── database/
│   ├── cursos.sql
│   ├── estudiantes.sql
│   └── install.sql
├── public/
│   ├── css/
│   ├── img/
│   ├── cursos/
│   │   ├── index.php
│   │   └── ver_estudiantes.php
│   ├── estudiantes/
│   │   ├── actualizar_estudiante.php
│   │   ├── agregar_estudiante.php
│   │   ├── editar_estudiante.php
│   │   ├── eliminar_estudiante.php
│   │   ├── guardar_estudiante.php
│   │   ├── index.php
│   │   ├── por_curso.php
│   │   └── ver_estudiante.php
│   ├── agregar_curso.php
│   ├── guardar_curso.php
│   ├── index.php
│   ├── login.php
│   └── logout.php
└── .htaccess
```

## Instalación

1. Clona este repositorio en tu servidor web local (por ejemplo, en la carpeta `www` de Laragon).
2. Importa la base de datos ejecutando el script `database/install.sql` en tu gestor de base de datos MySQL.
3. Configura la conexión a la base de datos en `app/config/database.php` si es necesario.
4. Accede al sistema a través de tu navegador: `http://colegio_jim.test` (si usas Laragon) o la URL correspondiente según tu configuración.

## Credenciales por defecto

- Usuario: admin
- Contraseña: admin123

## Funcionalidades

### Gestión de Cursos
- Listar todos los cursos
- Crear nuevos cursos
- Ver estudiantes por curso

### Gestión de Estudiantes
- Listar todos los estudiantes
- Crear nuevos estudiantes
- Editar información de estudiantes
- Ver detalles de un estudiante
- Eliminar estudiantes
- Filtrar estudiantes por curso

## Tecnologías utilizadas

- PHP 7.4+
- MySQL 5.7+
- HTML5
- CSS3
- Bootstrap 5
- JavaScript