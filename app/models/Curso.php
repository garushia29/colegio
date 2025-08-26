<?php
class Curso
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll()
    {
        $stmt = $this->pdo->query("SELECT * FROM cursos ORDER BY grado, seccion");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $stmt = $this->pdo->prepare("INSERT INTO cursos (grado, seccion, descripcion, año_escolar) 
                                     VALUES (:grado, :seccion, :descripcion, :anio_escolar)");
        $stmt->execute([
            ':grado' => $data['grado'],
            ':seccion' => $data['seccion'],
            ':descripcion' => $data['descripcion'],
            ':anio_escolar' => $data['año_escolar']
        ]);
    }

    public function update($id, $data)
    {
        $stmt = $this->pdo->prepare("UPDATE cursos 
                                    SET grado = :grado, 
                                        seccion = :seccion, 
                                        descripcion = :descripcion, 
                                        año_escolar = :anio_escolar
                                    WHERE id = :id");
        $stmt->execute([
            ':grado' => $data['grado'],
            ':seccion' => $data['seccion'],
            ':descripcion' => $data['descripcion'],
            ':anio_escolar' => $data['año_escolar'],
            ':id' => $id
        ]);
    }
    public function findById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM cursos WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // public function getEstudiantes($curso_id) {
    //     $stmt = $this->pdo->prepare("SELECT * FROM estudiantes WHERE curso_id = :curso_id ORDER BY nombre");
    //     $stmt->execute([':curso_id' => $curso_id]);
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }

    // Obtener estudiantes por curso con búsqueda y paginación
    public function getEstudiantes($curso_id, $offset = 0)
    {
        $sql = "SELECT * FROM estudiantes WHERE curso_id = :curso_id";
        $params = [':curso_id' => $curso_id];

        // if (!empty($search)) {
        //     $sql .= " AND (nombre LIKE :search OR apellido_paterno LIKE :search OR apellido_materno LIKE :search)";
        //     $params[':search'] = "%$search%";
        // }

        // $sql .= " ORDER BY nombre LIMIT :limit OFFSET :offset";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':curso_id', $curso_id, PDO::PARAM_INT);
        // $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        // $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);

        

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Contar estudiantes (para paginación)
    public function countEstudiantes($curso_id, $search = '')
    {
        $sql = "SELECT COUNT(*) FROM estudiantes WHERE curso_id = :curso_id";
        $params = [':curso_id' => $curso_id];

        if (!empty($search)) {
            $sql .= " AND (nombre LIKE :search OR apellido_paterno LIKE :search OR apellido_materno LIKE :search)";
            $params[':search'] = "%$search%";
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return (int)$stmt->fetchColumn();
    }

    /**
     * Eliminar un curso
     * @param int $id ID del curso a eliminar
     * @return bool Resultado de la operación
     */
    public function delete($id)
    {
        try {
            $id = filter_var($id, FILTER_VALIDATE_INT);
            if (!$id) {
                return false;
            }

            $stmt = $this->pdo->prepare("DELETE FROM cursos WHERE id = ?");
            $result = $stmt->execute([$id]);
            return $result;
        } catch (PDOException $e) {
            error_log('Error al eliminar curso: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Buscar cursos por grado, sección o descripción
     * @param string $search Término de búsqueda
     * @return array Lista de cursos que coinciden con la búsqueda
     */
    public function search($search)
    {
        try {
            $search = htmlspecialchars(trim($search));
            if (empty($search)) {
                return $this->getAll();
            }

            $stmt = $this->pdo->prepare("SELECT c.*, COUNT(e.id) as total_estudiantes 
                                         FROM cursos c 
                                         LEFT JOIN estudiantes e ON c.id = e.curso_id 
                                         WHERE c.grado LIKE ? OR c.seccion LIKE ? OR c.descripcion LIKE ?
                                         GROUP BY c.id 
                                         ORDER BY c.grado, c.seccion");
            $searchTerm = "%$search%";
            $stmt->execute([$searchTerm, $searchTerm, $searchTerm]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error al buscar cursos: ' . $e->getMessage());
            return [];
        }
    }


    public function getCursoConEstudiantes($id)
    {
        // Traer datos del curso
        $stmt = $this->pdo->prepare("SELECT * FROM cursos WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $curso = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$curso) return null;

        // Traer estudiantes del curso
        $stmt2 = $this->pdo->prepare("SELECT * FROM estudiantes WHERE curso_id = :id");
        $stmt2->execute(['id' => $id]);
        $curso['estudiantes'] = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        return $curso;
    }
}
