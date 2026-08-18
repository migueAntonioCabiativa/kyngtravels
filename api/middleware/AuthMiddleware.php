<?php

require_once __DIR__ . "/Jwt.php";

// Valida el header Authorization: Bearer <token> y corta la petición si no es válido
class AuthMiddleware
{
    public static function handle(): array
    {
        $header = $_SERVER["HTTP_AUTHORIZATION"] ?? "";

        if (!preg_match('/^Bearer\s+(.+)$/i', $header, $matches)) {
            http_response_code(401);
            echo json_encode([
                "success" => false,
                "message" => "Token de autenticación requerido"
            ]);
            exit;
        }

        $payload = Jwt::decode(trim($matches[1]));

        if ($payload === null) {
            http_response_code(401);
            echo json_encode([
                "success" => false,
                "message" => "Token inválido o expirado"
            ]);
            exit;
        }

        return $payload;
    }
}
