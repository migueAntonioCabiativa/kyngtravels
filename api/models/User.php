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
                user_name as username,
                first_name,
                last_name,
                email,
                created_at
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
                user_name as username,
                first_name,
                last_name,
                created_at,
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

    public function findByUsername(string $username): ?array
    {
        $sql = "
            SELECT
                id,
                user_name as username,
                password
            FROM user
            WHERE user_name = :username
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ":username" => $username
        ]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }

    public function create(string $username, string $first_name, string $last_name, string $email, string $password): bool
    {
        $sql = "
            INSERT INTO user (user_name, first_name, last_name, email, password)
            VALUES (:username, :first_name, :last_name, :email, :password)
        ";
        try {
            $stmt = $this->db->prepare($sql);
    
            $result = $stmt->execute([
                ":username" => $username,
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
            ":first_name" => $first_name,
            ":last_name" => $last_name,
            ":email" => $email,
        ]);
    }

    public function delete(int $id): bool
    {
        $sql = "
            DELETE FROM user
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
            UPDATE user
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