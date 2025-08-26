<?php
class Usuario
{
    private $pdo;

    private $table = 'usuarios';

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function findByUsername($username)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAll()
    {
        $stmt = $this->pdo->query("SELECT * FROM {$this->table} ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $stmt = $this->pdo->prepare("INSERT INTO {$this->table} (username, password) VALUES (?, ?)");
        return $stmt->execute([
            $data['username'],

            password_hash($data['password'], PASSWORD_BCRYPT),

        ]);
    }

    public function update($id, $data)
    {
       // Si el campo contraseña viene vacío, no lo actualizamos
    if (!empty($data['password'])) {
        $stmt = $this->pdo->prepare("UPDATE {$this->table} SET username=?, password=? WHERE id=?");
        return $stmt->execute([
            $data['username'],
            password_hash($data['password'], PASSWORD_BCRYPT),
            $id
        ]);
    } else {
        // Solo actualizamos el username
        $stmt = $this->pdo->prepare("UPDATE {$this->table} SET username=? WHERE id=?");
        return $stmt->execute([
            $data['username'],
            $id
        ]);
    }
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM usuarios WHERE id=?");
        return $stmt->execute([$id]);
    }

    
}
