<?php

require_once '../models/Post.php';

class PostController {
    private $db;
    private $post;

    public function __construct($db) {
        $this->db = $db;
        $this->post = new Post($db);
    }

    public function getAllPosts() {
        $stmt = $this->post->read();
        $num =$stmt->rowCount();

        if ($num > 0) {
            $posts_arr = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $post_item = array(
                    'id' => $id,
                    'title' => $title,
                    'body' => $body,
                    'author' => $author,
                    'created_at' => $created_at,
                    'update_at' => $update_at
                );
                array_push($posts_arr, $post_item);
            }
            echo json_encode($posts_arr);
        } else {
            echo json_encode(array('message' => 'aucun post touvé'));
        }
    }
}