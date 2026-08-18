<?php

class User
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getAll(): array
    {
        $sql = "
            SELECT
                id,
                first_name,
                last_name
            FROM user
        ";

        $stmt = $this->db->query($sql);

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    public function findById(int $id): ?array
    {
        $sql = "
            SELECT
                id,
                first_name,
                last_name,
                email
            FROM user
            WHERE id = :id
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ":id" => $id
        ]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }

    public function findByEmail(string $email): ?array
    {
        $sql = "
            SELECT
                id,
                email,
                password
            FROM user
            WHERE email = :email
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ":email" => $email
        ]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }

    public function create(string $first_name, string $last_name, string $email, string $password): bool
    {
        $sql = "
            INSERT INTO user (first_name, last_name, email, password)
            VALUES (:first_name, :last_name, :email, :password)
        ";
        try {
            $stmt = $this->db->prepare($sql);
    
            $result = $stmt->execute([
                ":first_name" => $first_name,
                ":last_name" => $last_name,
                ":email" => $email,
                ":password" => password_hash($password, PASSWORD_DEFAULT)
            ]);
            if (!$result) {
                throw new Exception("Error al ejecutar la consulta SQL para crear el usuario.", 500);
            }
        } catch (PDOException $e) {
            http_response_code($e->getCode() ?: 500);
            echo json_encode([
                "success" => false,
                "message" => "Error al crear el usuario: " . $e->getMessage()
            ]);
            return false;
        } catch (Exception $e) {
            http_response_code($e->getCode() ?: 500);
            echo json_encode([              
                "success" => false,
                "message" => "Error al crear el usuario: " . $e->getMessage()
            ]);
            return false;
        }
        
        
        echo json_encode([
            "success" => true,
            "message" => "Usuario creado exitosamente",
            "user_id" => $this->db->lastInsertId()
        ]);
        return true;
    }

    public function update(int $id, string $first_name, string $last_name, string $email): bool
    {
        $sql = "
            UPDATE user
            SET first_name = :first_name, last_name = :last_name, email = :email
            WHERE id = :id
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ":id" => $id,
            ":first_name" => $name,
            ":email" => $email,
        ]);
    }

    public function delete(int $id): bool
    {
        $sql = "
            DELETE FROM users
            WHERE id = :id
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ":id" => $id,
        ]);
    }

    public function updatePassword(int $id, string $newPassword): bool
    {
        $sql = "
            UPDATE users
            SET password = :password
            WHERE id = :id
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ":id" => $id,
            ":password" => password_hash($newPassword, PASSWORD_DEFAULT),
        ]);
    }
}

?>