<?php
// api.php

// Incluir el controlador de usuarios
include_once(__DIR__ . '/../controlador/user-controller.php');



// Configuración de CORS (si es necesario) 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header('Content-Type: application/json');


if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}   

// Obtener el método HTTP
$method = $_SERVER['REQUEST_METHOD'];

// Instanciar el controlador de usuarios
$userController = new UserController();

// Lógica de rutas
switch ($method) {
    case 'GET':
        // Si se pasa un ID en la URL, se obtiene un solo usuario
        if (isset($_GET['id'])) {
            $userController->getById($_GET['id']);
        } else {
            // Si no se pasa ID, obtener todos los usuarios
            $userController->getAll();
        }
        break;

    case 'POST':
        // Crear un nuevo usuario
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($data['name']) && isset($data['email'])) {
            $userController->create($data['name'], $data['email']);
        } else {
            echo json_encode(["message" => "Faltan datos para crear el usuario"]);
        }
        break;

    case 'PUT':
        // Actualizar un usuario
        if (isset($_GET['id'])) {
            $data = json_decode(file_get_contents('php://input'), true);
            if (isset($data['name']) && isset($data['email'])) {
                $userController->update($_GET['id'], $data['name'], $data['email']);
            } else {
                echo json_encode(["message" => "Faltan datos para actualizar el usuario"]);
            }
        } else {
            echo json_encode(["message" => "ID de usuario no especificado"]);
        }
        break;

    case 'DELETE':
        // Eliminar un usuario
        if (isset($_GET['id'])) {
            $userController->delete($_GET['id']);
        } else {
            echo json_encode(["message" => "ID de usuario no especificado"]);
        }
        break;

    default:
        echo json_encode(["message" => "Método no soportado"]);
        break;
}


?>
