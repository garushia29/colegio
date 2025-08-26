<?php

/**
 * Clase Estudiante - Modelo para gestionar los estudiantes en la base de datos
 */
class Estudiante
{
    private $pdo;
    private $table = 'estudiantes';

    /**
     * Constructor de la clase
     * @param PDO $pdo Conexión a la base de datos
     */
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Obtener todos los estudiantes
     * @return array Lista de estudiantes
     */
    public function getAll()
    {
        try {
            $query = "SELECT e.*, c.grado, c.seccion FROM {$this->table} e 
                      LEFT JOIN cursos c ON e.curso_id = c.id 
                      ORDER BY  e.nombre";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error al obtener estudiantes: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Obtener estudiantes por curso
     * @param int $cursoId ID del curso
     * @return array Lista de estudiantes del curso
     */
    public function getByCurso($cursoId)
    {
        try {
            $cursoId = filter_var($cursoId, FILTER_VALIDATE_INT);
            if (!$cursoId) {
                return [];
            }

            $query = "SELECT * FROM {$this->table} WHERE curso_id = ? ORDER BY apellidos, nombres";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$cursoId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error al obtener estudiantes por curso: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Obtener un estudiante por su ID
     * @param int $id ID del estudiante a buscar
     * @return array|false Datos del estudiante o false si no existe
     */
    public function getById($id)
    {
        try {
            $id = filter_var($id, FILTER_VALIDATE_INT);
            if (!$id) {
                return false;
            }

            $query = "SELECT e.*, c.grado, c.seccion FROM {$this->table} e 
                      LEFT JOIN cursos c ON e.curso_id = c.id 
                      WHERE e.id = ?";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error al obtener estudiante por ID: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Crear un nuevo estudiante
     * @param array $data Datos del estudiante
     * @return int|false ID del estudiante creado o false si falla
     */
    public function create($data)
    {
        try {
            // Validar datos obligatorios
            if (empty($data['nombre']) || empty($data['apellido_paterno']) || empty($data['curso_id'])) {
                return false;
            }

            // Sanitizar datos
            $numero = isset($data['numero']) ? htmlspecialchars(trim($data['numero'])) : null;
            $ci = isset($data['ci']) ? htmlspecialchars(trim($data['ci'])) : null;
            $nombre = htmlspecialchars(trim($data['nombre']));
            $apellido_paterno = htmlspecialchars(trim($data['apellido_paterno']));
            $apellido_materno = isset($data['apellido_materno']) ? htmlspecialchars(trim($data['apellido_materno'])) : null;
            $nombre_completo = trim($nombre . ' ' . $apellido_paterno . ' ' . $apellido_materno);
            $fecha_nacimiento = isset($data['fecha_nacimiento']) ? htmlspecialchars(trim($data['fecha_nacimiento'])) : null;
            $genero = isset($data['genero']) ? htmlspecialchars(trim($data['genero'])) : null;
            $direccion = isset($data['direccion']) ? htmlspecialchars(trim($data['direccion'])) : null;
            $telefono = isset($data['telefono']) ? htmlspecialchars(trim($data['telefono'])) : null;
            $nombre_tutor = isset($data['nombre_tutor']) ? htmlspecialchars(trim($data['nombre_tutor'])) : null;
            $telefono_tutor = isset($data['telefono_tutor']) ? htmlspecialchars(trim($data['telefono_tutor'])) : null;
            $email_tutor = isset($data['email_tutor']) ? htmlspecialchars(trim($data['email_tutor'])) : null;
            $curso_id = filter_var($data['curso_id'], FILTER_VALIDATE_INT);
            $estado = isset($data['estado']) ? htmlspecialchars(trim($data['estado'])) : "activo";

            // Preparar query
            $query = "INSERT INTO {$this->table} 
            (numero, ci, nombre, apellido_paterno, apellido_materno, nombre_completo, fecha_nacimiento, genero, direccion, telefono, nombre_tutor, telefono_tutor, email_tutor, curso_id, estado, created_at, updated_at) 
            VALUES (:numero, :ci, :nombre, :apellido_paterno, :apellido_materno, :nombre_completo, :fecha_nacimiento, :genero, :direccion, :telefono, :nombre_tutor, :telefono_tutor, :email_tutor, :curso_id, :estado, NOW(), NOW())";

            $stmt = $this->pdo->prepare($query);

            // Enlazar parámetros
            $stmt->bindParam(':numero', $numero);
            $stmt->bindParam(':ci', $ci);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellido_paterno', $apellido_paterno);
            $stmt->bindParam(':apellido_materno', $apellido_materno);
            $stmt->bindParam(':nombre_completo', $nombre_completo);
            $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento);
            $stmt->bindParam(':genero', $genero);
            $stmt->bindParam(':direccion', $direccion);
            $stmt->bindParam(':telefono', $telefono);
            $stmt->bindParam(':nombre_tutor', $nombre_tutor);
            $stmt->bindParam(':telefono_tutor', $telefono_tutor);
            $stmt->bindParam(':email_tutor', $email_tutor);
            $stmt->bindParam(':curso_id', $curso_id, PDO::PARAM_INT);
            $stmt->bindParam(':estado', $estado);

            // Ejecutar
            $stmt->execute();

            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            // die('Error al crear estudiante: ' . $e->getMessage());
            error_log('Error al crear estudiante: ' . $e->getMessage());
            return false;
        }
    }


    /**
     * Actualizar un estudiante existente
     * @param int $id ID del estudiante a actualizar
     * @param array $data Datos actualizados del estudiante
     * @return bool Resultado de la operación
     */
    public function update($id, $data)
    {
        try {
            // Validar ID y datos obligatorios
            $id = filter_var($id, FILTER_VALIDATE_INT);
            if (!$id || empty($data['nombre']) || empty($data['apellido_paterno']) || empty($data['curso_id'])) {
                return false;
            }

            // Sanitizar datos
            $numero = isset($data['numero']) ? htmlspecialchars(trim($data['numero'])) : null;
            $ci = isset($data['ci']) ? htmlspecialchars(trim($data['ci'])) : null;
            $nombre = htmlspecialchars(trim($data['nombre']));
            $apellido_paterno = htmlspecialchars(trim($data['apellido_paterno']));
            $apellido_materno = isset($data['apellido_materno']) ? htmlspecialchars(trim($data['apellido_materno'])) : null;
            $nombre_completo = trim($nombre . ' ' . $apellido_paterno . ' ' . $apellido_materno);
            $fecha_nacimiento = isset($data['fecha_nacimiento']) ? htmlspecialchars(trim($data['fecha_nacimiento'])) : null;
            $genero = isset($data['genero']) ? htmlspecialchars(trim($data['genero'])) : null;
            $direccion = isset($data['direccion']) ? htmlspecialchars(trim($data['direccion'])) : null;
            $telefono = isset($data['telefono']) ? htmlspecialchars(trim($data['telefono'])) : null;
            $nombre_tutor = isset($data['nombre_tutor']) ? htmlspecialchars(trim($data['nombre_tutor'])) : null;
            $telefono_tutor = isset($data['telefono_tutor']) ? htmlspecialchars(trim($data['telefono_tutor'])) : null;
            $email_tutor = isset($data['email_tutor']) ? htmlspecialchars(trim($data['email_tutor'])) : null;
            $curso_id = filter_var($data['curso_id'], FILTER_VALIDATE_INT);
            $estado = isset($data['estado']) ? htmlspecialchars(trim($data['estado'])) : "activo";

            $query = "UPDATE {$this->table} SET 
                      numero = ?, ci = ?, nombre = ?, apellido_paterno = ?, apellido_materno = ?, 
                      nombre_completo = ?, fecha_nacimiento = ?, genero = ?, direccion = ?, 
                      telefono = ?, nombre_tutor = ?, telefono_tutor = ?, email_tutor = ?, 
                      curso_id = ?, estado = ?, updated_at = NOW() 
                      WHERE id = ?";
            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute([
                $numero, $ci, $nombre, $apellido_paterno, $apellido_materno, 
                $nombre_completo, $fecha_nacimiento, $genero, $direccion, 
                $telefono, $nombre_tutor, $telefono_tutor, $email_tutor, 
                $curso_id, $estado, $id
            ]);
            return $result;
        } catch (PDOException $e) {
            die('Error al actualizar estudiante: ' . $e->getMessage());
            // error_log('Error al actualizar estudiante: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Eliminar un estudiante
     * @param int $id ID del estudiante a eliminar
     * @return bool Resultado de la operación
     */
    public function delete($id)
    {
        try {
            // Validar ID
            $id = filter_var($id, FILTER_VALIDATE_INT);
            if (!$id) {
                return false;
            }

            $query = "DELETE FROM {$this->table} WHERE id = ?";
            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute([$id]);
            return $result;
        } catch (PDOException $e) {
            error_log('Error al eliminar estudiante: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Buscar estudiantes por nombre, apellidos o cédula
     * @param string $search Término de búsqueda
     * @return array Lista de estudiantes que coinciden con la búsqueda
     */
    public function search($search)
    {
        try {
            $search = htmlspecialchars(trim($search));
            if (empty($search)) {
                return $this->getAll();
            }

            $query = "SELECT e.*, c.grado, c.seccion FROM {$this->table} e 
                      LEFT JOIN cursos c ON e.curso_id = c.id 
                      WHERE e.nombre LIKE ? OR e.apellido_paterno LIKE ? OR e.ci LIKE ?
                      ORDER BY e.nombre";
            $stmt = $this->pdo->prepare($query);
            $searchTerm = "%$search%";
            $stmt->execute([$searchTerm, $searchTerm, $searchTerm]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error al buscar estudiantes: ' . $e->getMessage());
            return [];
        }
    }

    //obtener estudiantes por curso con informacion completa
    public function getByCursoCompleto($curso_id)
{
    try {
        $query = "SELECT e.*, c.grado, c.seccion 
                  FROM {$this->table} e 
                  LEFT JOIN cursos c ON e.curso_id = c.id 
                  WHERE e.curso_id = ? 
                  ORDER BY e.apellido_paterno, e.nombre";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$curso_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log('Error al obtener estudiantes por curso: ' . $e->getMessage());
        return [];
    }
}
}
