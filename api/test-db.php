<?php

require_once __DIR__ . '/config/env.php';

$config = require __DIR__ . '/config/database.php';

$host = $config['host'];
$port = $config['port'];
$db   = $config['database'];
$user = $config['username'];
$pass = $config['password'];
$charset = $config['charset'];

header('Content-Type: application/json; charset=utf-8');

try {
    $dsn = sprintf(
        'mysql:host=%s;port=%s;dbname=%s;charset=%s',
        $host,
        $port,
        $db,
        $charset
    );

    $pdo = new PDO(
        $dsn,
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );

    $stmt = $pdo->query('SELECT * FROM user');
    $result = $stmt->fetch();

    echo json_encode([
        'success' => true,
        'message' => 'Conexión a la base de datos exitosa.',
        'database' => [
            'host' => $host,
            'port' => $port,
            'name' => $db,
            'user' => $user,
        ],
        'test_query' => $result,
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
    http_response_code(500);

    echo json_encode([
        'success' => false,
        'message' => 'No se pudo conectar a la base de datos.',
        'error' => $e->getMessage(),
        'database' => [
            'host' => $host,
            'port' => $port,
            'name' => $db,
            'user' => $user,
        ],
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}

?>