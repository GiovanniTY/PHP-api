<?php

require_once '../config/database.php';
require_once '../controllers/PostController.php';

$postController = new PostController($pdo);

// Routeur simple pour les endpoints
$request_method = $_SERVER['REQUEST_METHOD'];
$path_info = $_SERVER['PATH_INFO'];

switch ($request_method) {
    case 'GET':
        if ($path_info === '/api/posts') {
            $postController->getPosts();
        } elseif (preg_match('/\/api\/post\/(\d+)/', $path_info, $matches)) {
            $postId = $matches[1];
            $postController->getPostById($postId);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Endpoint non trouvé']);
        }
        break;
    case 'POST':
        if ($path_info === '/api/post') {
            $postController->createPost();
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Endpoint non trouvé']);
        }
        break;
    case 'PUT':
        if (preg_match('/\/api\/post\/(\d+)/', $path_info, $matches)) {
            $postId = $matches[1];
            $postController->updatePost($postId);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Endpoint non trouvé']);
        }
        break;
    case 'DELETE':
        if (preg_match('/\/api\/post\/(\d+)/', $path_info, $matches)) {
            $postId = $matches[1];
            $postController->deletePost($postId);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Endpoint non trouvé']);
        }
        break;
    default:
        http_response_code(405);
        echo json_encode(['message' => 'Méthode non autorisée']);
        break;
}
