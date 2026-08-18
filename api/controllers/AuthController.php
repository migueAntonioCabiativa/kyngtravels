<?php

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../models/User.php";
require_once __DIR__ . "/../middleware/Jwt.php";
require_once __DIR__ . "/../middleware/RateLimiter.php";

class AuthController
{
    private PDO $db;
    private User $user;

    public function __construct()
    {
        global $pdo;

        $this->db = $pdo;
        $this->user = new User($this->db);
    }

    public function login(string $method): void
    {
        switch ($method) {
            case 'POST':
                $this->handleLogin();
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
    
    function handleLogin(): void
    {

        $data = json_decode(
            file_get_contents("php://input"),
            true
        );

        if (!$data) {
            http_response_code(400);

            echo json_encode([
                "success" => false,
                "message" => "JSON inválido"
            ]);

            return;
        }

        $email = trim($data["email"] ?? "");
        $password = $data["password"] ?? "";

        if ($email === "" || $password === "") {
            http_response_code(400);

            echo json_encode([
                "success" => false,
                "message" => "Email y contraseña son obligatorios"
            ]);

            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);

            echo json_encode([
                "success" => false,
                "message" => "El formato del email no es válido"
            ]);

            return;
        }

        $identifier = ($_SERVER["REMOTE_ADDR"] ?? "unknown") . "|" . strtolower($email);

        if (RateLimiter::tooManyAttempts($identifier)) {
            http_response_code(429);

            echo json_encode([
                "success" => false,
                "message" => "Demasiados intentos fallidos. Intenta de nuevo en " . RateLimiter::retryAfter($identifier) . " segundos"
            ]);

            return;
        }

        try {

            $user = $this->user->findByEmail($email);

            // Mismo mensaje para usuario inexistente o password incorrecta (evita user enumeration)
            if (!$user || !password_verify($password, $user["password"])) {
                RateLimiter::registerFailedAttempt($identifier);

                http_response_code(401);

                echo json_encode([
                    "success" => false,
                    "message" => "Credenciales incorrectas"
                ]);

                return;
            }

            RateLimiter::reset($identifier);

            // Si el hash quedó con un algoritmo/costo desactualizado, se regenera de forma transparente
            if (password_needs_rehash($user["password"], PASSWORD_DEFAULT)) {
                $this->user->updatePassword((int) $user["id"], $password);
            }

            // No devolver la contraseña
            unset($user["password"]);

            $token = Jwt::encode([
                "sub" => (int) $user["id"],
                "email" => $user["email"],
                "iat" => time(),
                "exp" => time() + (int) env("JWT_TTL", 3600),
            ]);

            http_response_code(200);

            echo json_encode([
                "success" => true,
                "message" => "Login correcto",
                "token" => $token,
                "user" => $user
            ]);

        } catch (PDOException $e) {

            http_response_code(500);

            echo json_encode([
                "success" => false,
                "message" => "Error interno del servidor"
            ]);
        }
    }
}

?>