<?php

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../models/User.php";

class UserController
{
    private PDO $db;
    private User $user;

    public function __construct()
    {
        global $pdo;

        $this->db = $pdo;
        $this->user = new User($this->db);
    }

    public function procesarPeticion(string $method): void
    {
        switch ($method) {
            case 'GET':
                $data = $this->user->getAll();
                http_response_code(200);
                echo json_encode([
                    "success" => true,
                    "data" => $data
                ]);
                break;
            case 'POST':
                $data = json_decode(file_get_contents("php://input"), true);
                $first_name = $data["first_name"] ?? "";
                $last_name = $data["last_name"] ?? "";
                $email = $data["email"] ?? "";
                $password = $data["password"] ?? "";

                $this->user->create($first_name, $last_name, $email, $password);

                http_response_code(201); // Created
                echo json_encode([
                    "success" => true,
                    "message" => "Usuario creado exitosamente"
                ]);
                break;
            case 'PUT':
                $data = json_decode(file_get_contents("php://input"), true);
                $id = $data["id"] ?? 0;
                $name = $data["name"] ?? "";
                $email = $data["email"] ?? "";

                $this->user->update($id, $name, $email);
                break;
            case 'DELETE':
                $data = json_decode(file_get_contents("php://input"), true);
                $id = $data["id"] ?? 0;

                $this->user->delete($id);
                break;
            default:
                http_response_code(405);
                echo json_encode([
                    "success" => false,
                    "message" => "Método no permitido"
                ]);
                break;
        }
    }
}

?>