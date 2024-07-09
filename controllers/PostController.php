<?php

require_once '../models/Post.php';
require_once '../config/database.php';

class PostController {
    private $db;
    private $post;

    public function __construct($db) {
        $this->db = $db;
        $this->post = new Post($db);
    }

    public function getAllPosts() {
        $stmt = $this->post->read();
        $num = $stmt->rowCount();
    
        if ($num > 0) {
            $posts_arr = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $post_item = [
                    'id' => $id,
                    'title' => $title,
                    'body' => $body,
                    'author' => $author,
                    'created_at' => $created_at,
                    'updated_at' => $updated_at
                ];
                array_push($posts_arr, $post_item);
            }
            echo json_encode($posts_arr);
        } else {
            echo json_encode(['message' => 'Aucun post trouvé']);
        }
    }

    // Récupérer un post par ID
    public function getPostById($id) {
        $this->post->read_single($id);

        if ($this->post->id) {
            $post_item = [
                'id' => $this->post->id,
                'title' => $this->post->title,
                'body' => $this->post->body,
                'author' => $this->post->author,
                'created_at' => $this->post->created_at,
                'updated_at' => $this->post->updated_at
            ];
            echo json_encode(['status' => 200, 'message' => 'OK', 'data' => $post_item]);
        } else {
            echo json_encode(['status' => 404, 'message' => 'Post non trouvé']);
        }
    }
        //cree un post 
        public function createPost($data) {
            if (!empty($data['title']) && !empty($data['body']) && !empty($data['author'])) {
                $this->post->title = $data['title'];
                $this->post->body = $data['body'];
                $this->post->author = $data['author'];
        
                if ($this->post->create()) {
                    echo json_encode(['status' => 201, 'message' => 'Post créé avec succès']);
                } else {
                    echo json_encode(['status' => 500, 'message' => 'Impossible de créer le post']);
                }
            } else {
                echo json_encode(['status' => 400, 'message' => 'Title, body et author sont requis']);
            }
        }
        

        //mettre a jour un post 
        public function updatePost($id, $data) {
            $this->post->read_single($id);

            if (!empty($data['title']) && !empty($data['body']) && !empty($data['author'])) {
                $this->post->title = $data['title'];
                $this->post->body = $data['body'];
                $this->post->author = $data['author'];

                if ($this->post->update($id)) {
                    echo json_encode(['status' => 200, 'message' => 'Post mis a jour avec succes']);
                }else {
                    echo json_encode(['status' => 500, 'message' => 'Impossible de mettre a jour le post']);
                } 
                } else {
                    echo json_encode(['status' => 400, 'message' => 'Title, body et author requis']);
                }
                }

                //supprimer un post par ID
                public function deletePost($id) {
                    $this->post->read_single($id);

                    if ($this->post->id) {
                        if ($this->post->delete($id)) {
                            echo json_encode(['status' => 200, 'message' => 'post supprimé avec succes']);
                        } else {
                            echo json_encode(['status' => 500, 'message' => 'impossible de supprimer le post']);
                        }
                    } else {
                        echo json_encode(['status' => 400, 'message' => 'post non trouvé']);
                    }
                }
            }



