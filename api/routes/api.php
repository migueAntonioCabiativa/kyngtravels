<?php
// 2. Capturar Ruta y Método HTTP
$method = $_SERVER['REQUEST_METHOD'];
$route = isset($_GET['route']) ? rtrim($_GET['route'], '/') : '';

$parts = explode('/', $route);

// 3. Evaluar qué entidad está llamando el cliente

switch ($parts[0]) {
    case 'kyng':
        switch ($parts[1] ?? '') {
            case 'users':
                require_once __DIR__ . '/../middleware/AuthMiddleware.php';
                require_once __DIR__ . '/../controllers/UserController.php';
                AuthMiddleware::handle();
                $controller = new UserController();
                $controller->procesarPeticion($method);
                break;

            case 'productos':
                require_once __DIR__ . '/../controllers/ProductoController.php';
                $controller = new ProductoController();
                $controller->procesarPeticion($method);
                break;

            default:
                http_response_code(404);
                echo json_encode(["error" => "La entidad o endpoint '$route' no existe"]);
                break;
        }
        break;

    case 'login':
        require_once __DIR__ . '/../controllers/AuthController.php';
        $controller = new AuthController();
        $controller->login($method);
        break;
        
}

?>