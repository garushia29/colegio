<?php
/**
 * Clase Curso - Modelo para gestionar los cursos en la base de datos
 */
class Curso {
    private $pdo;
    private $table = 'cursos';

    /**
     * Constructor de la clase
     * @param PDO $pdo Conexión a la base de datos
     */
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Obtener todos los cursos con conteo de estudiantes
     * @return array Lista de cursos con el conteo de estudiantes
     */
    public function getAll() {
        try {
            $query = "SELECT c.*, COUNT(e.id) as total_estudiantes FROM {$this->table} c 
                      LEFT JOIN estudiantes e ON c.id = e.curso_id 
                      WHERE c.id IS NOT NULL 
                      GROUP BY c.id 
                      ORDER BY c.grado, c.seccion";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log('Error al obtener cursos: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Obtener un curso por su ID
     * @param int $id ID del curso a buscar
     * @return array|false Datos del curso o false si no existe
     */
    public function getById($id) {
        try {
            $id = filter_var($id, FILTER_VALIDATE_INT);
            if (!$id) {
                return false;
            }
            
            $query = "SELECT * FROM {$this->table} WHERE id = ?";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log('Error al obtener curso por ID: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Crear un nuevo curso
     * @param array $data Datos del curso (grado, seccion)
     * @return int|false ID del curso creado o false si falla
     */
    public function create($data) {
        try {
            // Validar datos
            if (empty($data['grado']) || empty($data['seccion'])) {
                return false;
            }
            
            // Sanitizar datos
            $grado = htmlspecialchars(trim($data['grado']));
            $seccion = htmlspecialchars(trim($data['seccion']));
            $descripcion = isset($data['descripcion']) ? htmlspecialchars(trim($data['descripcion'])) : '';
            $año_escolar = isset($data['año_escolar']) ? htmlspecialchars(trim($data['año_escolar'])) : date('Y');
                        
            $query = "INSERT INTO {$this->table} (grado, seccion, descripcion, año_escolar) VALUES (?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$grado, $seccion, $descripcion, $año_escolar]);
            return $this->pdo->lastInsertId();
        } catch(PDOException $e) {
            error_log('Error al crear curso: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Actualizar un curso existente
     * @param int $id ID del curso a actualizar
     * @param array $data Datos actualizados del curso
     * @return bool Resultado de la operación
     */
    public function update($id, $data) {
        try {
            // Validar ID y datos
            $id = filter_var($id, FILTER_VALIDATE_INT);
            if (!$id || empty($data['grado']) || empty($data['seccion'])) {
                return false;
            }
            
            // Sanitizar datos
            $grado = htmlspecialchars(trim($data['grado']));
            $seccion = htmlspecialchars(trim($data['seccion']));
            
            $query = "UPDATE {$this->table} SET grado = ?, seccion = ? WHERE id = ?";
            $stmt = $this->pdo->prepare($query);
            $result = $stmt->execute([$grado, $seccion, $id]);
            return $result;
        } catch(PDOException $e) {
            error_log('Error al actualizar curso: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Eliminar un curso
     * @param int $id ID del curso a eliminar
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
            error_log('Error al eliminar curso: ' . $e->getMessage());
            return false;
        }
    }
}