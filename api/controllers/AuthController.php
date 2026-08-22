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

        [$username, $password] = $this->credentialsFromBasicAuth();

        // Si no viene Basic Auth (ej. Postman), se aceptan las credenciales por JSON
        if ($username === null && $password === null) {
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

            $username = trim($data["user"] ?? "");
            $password = $data["password"] ?? "";
        }

        if ($username === "" || $password === "") {
            http_response_code(400);

            echo json_encode([
                "success" => false,
                "message" => "Usuario y contraseña son obligatorios"
            ]);

            return;
        }

        $identifier = ($_SERVER["REMOTE_ADDR"] ?? "unknown") . "|" . strtolower($username);

        if (RateLimiter::tooManyAttempts($identifier)) {
            http_response_code(429);

            echo json_encode([
                "success" => false,
                "message" => "Demasiados intentos fallidos. Intenta de nuevo en " . RateLimiter::retryAfter($identifier) . " segundos"
            ]);

            return;
        }

        try {

            $user = $this->user->findByUsername($username);

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
                "username" => $user["username"],
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

    // Permite loguearse enviando Authorization: Basic <user:pass> (ej. Postman Basic Auth)
    private function credentialsFromBasicAuth(): array
    {
        if (isset($_SERVER["PHP_AUTH_USER"])) {
            return [trim($_SERVER["PHP_AUTH_USER"]), $_SERVER["PHP_AUTH_PW"] ?? ""];
        }

        $header = $_SERVER["HTTP_AUTHORIZATION"] ?? $_SERVER["REDIRECT_HTTP_AUTHORIZATION"] ?? "";

        if (!preg_match('/^Basic\s+(.+)$/i', $header, $matches)) {
            return [null, null];
        }

        $decoded = base64_decode(trim($matches[1]), true);

        if ($decoded === false || !str_contains($decoded, ":")) {
            return [null, null];
        }

        [$user, $pass] = explode(":", $decoded, 2);

        return [trim($user), $pass];
    }
}

?>