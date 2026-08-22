<?php

require_once __DIR__ . '/env.php';
loadEnv(__DIR__ . '/../.env');

$config = [
    'host' => env('DB_HOST', 'localhost'),
    'port' => env('DB_PORT', '3306'),
    'database' => env('DB_NAME', 'kyngtravels'),
    'username' => env('DB_USER', 'root'),
    'password' => env('DB_PASS', ''),
    'charset' => env('DB_CHARSET', 'utf8mb4'),
];

// Deja $pdo disponible en scope global para los controladores (`global $pdo;`)
if (!isset($GLOBALS['pdo'])) {
    try {
        $GLOBALS['pdo'] = new PDO(
            sprintf(
                'mysql:host=%s;port=%s;dbname=%s;charset=%s',
                $config['host'],
                $config['port'],
                $config['database'],
                $config['charset']
            ),
            $config['username'],
            $config['password'],
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]
        );
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'No se pudo conectar a la base de datos',
            'error' => $e->getMessage(),
        ]);
        exit;
    }
}

return $config;
