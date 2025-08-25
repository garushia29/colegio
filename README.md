# Sistema de Gestión Escolar - Colegio

Este sistema permite la gestión de cursos y estudiantes para una institución educativa.

## Estructura del Proyecto

```
colegio_jim/
├── app/
│   ├── config/
│   │   └── config.php
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
|       |   ├── show.php
|       |   ├── edit.php
│       ├── estudiantes/
│       │   ├── create.php
│       │   ├── edit.php
│       │   ├── index.php
│       │   ├── por_curso.php
│       │   └── show.php
│       └── login_form.php
├── database/
│   ├── database.sql
├── public/
│   ├── css/
│   ├── img/
│   ├── cursos/
│   │   ├── index.php
│   │  .htaccess
│   ├── index.php
│   ├── login.php
│   └── logout.php
└── .htaccess
```

## Instalación

1. Clona este repositorio en tu servidor web local (por ejemplo, en la carpeta `www` de Laragon).
2. Importa la base de datos ejecutando el script `database.sql` en tu gestor de base de datos MySQL.
3. Configura la conexión a la base de datos en `app/config/config.php` si es necesario.
4. Accede al sistema a través de tu navegador: `http://colegio.test` (si usas Laragon) o la URL correspondiente según tu configuración.

## Credenciales por defecto

- Usuario: admin
- Contraseña: password

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
