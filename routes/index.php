<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../config/database.php';
require_once '../controllers/PostController.php';

// Connexion à la base de données
$database = new Database();
$db = $database->getConnection();

// Créer une instance du contrôleur PostController
$postController = new PostController($db);

// Récupérer la méthode de requête et le chemin d'accès
$request_method = $_SERVER["REQUEST_METHOD"];
$path_info = $_SERVER["PATH_INFO"] ?? '';

// Définir les en-têtes de réponse
header("Content-Type: application/json; charset=UTF-8");

// Gérer les différentes méthodes de requête
switch ($request_method) {
    case 'GET':
        if ($path_info == '/api/posts') {
            $postController->getAllPosts();
        } elseif (preg_match('/\/api\/post\/(\d+)/', $path_info, $matches)) {
            $postController->getPostById($matches[1]);
        }
        break;
    case 'POST':
        if ($path_info == '/api/post') {
            $data = json_decode(file_get_contents("php://input"), true);
            $postController->createPost($data);
        }
        break;
    case 'PUT':
        if (preg_match('/\/api\/post\/(\d+)/', $path_info, $matches)) {
            $data = json_decode(file_get_contents("php://input"), true);
            $postController->updatePost($matches[1], $data);
        }
        break;
    case 'DELETE':
        if (preg_match('/\/api\/post\/(\d+)/', $path_info, $matches)) {
            $postController->deletePost($matches[1]);
        }
        break;
    default:
        header("HTTP/1.0 405 Method Not Allowed");
        echo json_encode(['status' => 405, 'message' => 'Méthode non autorisée']);
        break;
}
require_once '../config/database.php';

?>
