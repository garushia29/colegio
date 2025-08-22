<?php
/**
 * Clase Estudiante - Modelo para gestionar los estudiantes en la base de datos
 */
class Estudiante {
    private $pdo;
    private $table = 'estudiantes';

    /**
     * Constructor de la clase
     * @param PDO $pdo Conexión a la base de datos
     */
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Obtener todos los estudiantes
     * @return array Lista de estudiantes
     */
    public function getAll() {
        try {
            $query = "SELECT e.*, c.grado, c.seccion FROM {$this->table} e 
                      LEFT JOIN cursos c ON e.curso_id = c.id 
                      ORDER BY e.apellidos, e.nombres";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log('Error al obtener estudiantes: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Obtener estudiantes por curso
     * @param int $cursoId ID del curso
     * @return array Lista de estudiantes del curso
     */
    public function getByCurso($cursoId) {
        try {
            $cursoId = filter_var($cursoId, FILTER_VALIDATE_INT);
            if (!$cursoId) {
                return [];
            }
            
            $query = "SELECT * FROM {$this->table} WHERE curso_id = ? ORDER BY apellidos, nombres";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$cursoId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log('Error al obtener estudiantes por curso: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Obtener un estudiante por su ID
     * @param int $id ID del estudiante a buscar
     * @return array|false Datos del estudiante o false si no existe
     */
    public function getById($id) {
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
        } catch(PDOException $e) {
            error_log('Error al obtener estudiante por ID: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Crear un nuevo estudiante
     * @param array $data Datos del estudiante
     * @return int|false ID del estudiante creado o false si falla
     */
    public function create($data) {
        try {
            // Validar datos obligatorios
            if (empty($data['nombres']) || empty($data['apellidos']) || empty($data['curso_id'])) {
                return false;
            }
            
            // Sanitizar datos
            $nombres = htmlspecialchars(trim($data['nombres']));
            $apellidos = htmlspecialchars(trim($data['apellidos']));
            $curso_id = filter_var($data['curso_id'], FILTER_VALIDATE_INT);
            $cedula = isset($data['cedula']) ? htmlspecialchars(trim($data['cedula'])) : null;
            $fecha_nacimiento = isset($data['fecha_nacimiento']) ? htmlspecialchars(trim($data['fecha_nacimiento'])) : null;
            $direccion = isset($data['direccion']) ? htmlspecialchars(trim($data['direccion'])) : null;
            $telefono = isset($data['telefono']) ? htmlspecialchars(trim($data['telefono'])) : null;
            $email = isset($data['email']) ? htmlspecialchars(trim($data['email'])) : null;
            
            $query = "INSERT INTO {$this->table} (nombres, apellidos, curso_id, cedula, fecha_nacimiento, direccion, telefono, email) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$nombres, $apellidos, $curso_id, $cedula, $fecha_nacimiento, $direccion, $telefono, $email]);
            return $this->pdo->lastInsertId();
        } catch(PDOException $e) {
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
    public function update($id, $data) {
        try {
            // Validar ID y datos obligatorios
            $id = filter_var($id, FILTER_VALIDATE_INT);
            if (!$id || empty($data['nombres']) || empty($data['apellidos']) || empty($data['curso_id'])) {
                return false;
            }
            
            // Sanitizar datos
            $nombres = htmlspecialchars(trim($data['nombres']));
            $apellidos = htmlspecialchars(trim($data['apellidos']));
            $curso_id = filter_var($data['curso_id'], FILTER_VALIDATE_INT);
            $cedula = isset($data['cedula']) ? htmlspecialchars(trim($data['cedula'])) : null;
            $fecha_nacimiento = isset($data['fecha_nacimiento']) ? htmlspecialchars(trim($data['fecha_nacimiento'])) : null;
            $direccion = isset($data['direccion']) ? htmlspecialchars(trim($data['direccion'])) : null;
            $telefono = isset($data['telefono']) ? htmlspecialchars(trim($data['telefono'])) : null;
            $email = isset($data['email']) ? htmlspecialchars(trim($data['email'])) : null;
            
            $query = "UPDATE {$this->table} SET nombres = ?, apellidos = ?, curso_id = ?, 
                      cedula = ?, fecha_nacimiento = ?, direccion = ?, telefono = ?, email = ? 
                      WHERE id = ?";
            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute([$nombres, $apellidos, $curso_id, $cedula, $fecha_nacimiento, $direccion, $telefono, $email, $id]);
            return $result;
        } catch(PDOException $e) {
            error_log('Error al actualizar estudiante: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Eliminar un estudiante
     * @param int $id ID del estudiante a eliminar
     * @return bool Resultado de la operación
     */
    public function delete($id) {
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
        } catch(PDOException $e) {
            error_log('Error al eliminar estudiante: ' . $e->getMessage());
            return false;
        }
    }
}