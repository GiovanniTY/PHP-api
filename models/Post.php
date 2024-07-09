<?php

class Post {
    private $table = 'posts';
    private $conn;

    public $id;
    public $title;
    public $body;
    public $author;
    public $created_at;

    public $updated_at;

    public function __construct($db) {
        $this->conn = $db;

    }

    //method pour obtenir tous les posts 
    public function read() {
        $query = " SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
        }

        //method pour obtenir un seul post avec id
        public function read_single($id){
            $query = " SELECT * FROM " . $this->table . " WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1,$id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            print_r($id);
            if ($row) {
                $this->id = $row['id'];
                $this->title = $row['title'];
                $this->body = $row['body'];
                $this->author = $row['created_at'];
                $this->updated_at = $row['updated_at'];
            } else {
                $this->id = null;
            }
        }

        //method pour crée un nuveau post 
        public function create() {
            // Prépare la requête SQL
            $query = "INSERT INTO posts (title, body, author) VALUES (:title, :body, :author)";
        
            // Prépare la déclaration préparée de la requête
            $stmt = $this->conn->prepare($query);
        
            // Nettoie et associe les paramètres
            $this->title = htmlspecialchars(strip_tags($this->title));
            $this->body = htmlspecialchars(strip_tags($this->body));
            $this->author = htmlspecialchars(strip_tags($this->author));
        
            // Lie les paramètres
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':body', $this->body);
            $stmt->bindParam(':author', $this->author);
        
            // Exécute la requête
            if($stmt->execute()) {
                return true;
            }
        
            // Si cela échoue, affiche un message d'erreur
            printf("Erreur : %s.\n", $stmt->error);
        
            return false;
        }
        

        //method pour mettre a jour un post 
        public function update($id){
            $query= 'UPDATE ' . $this->table . 'SET title = :title , body = :body, author = :author
            WHERE id = :id';
            $stmt = $this->conn->prepare($query);

            //trier les donnes pour prevenir les injection sql
            $this->id = htmlspecialchars(strip_tags($id));
            $this->title = htmlspecialchars(strip_tags($this->title));
            $this->body = htmlspecialchars(strip_tags($this->body));
            $this->author = htmlspecialchars(strip_tags($this->author));

            //bind des parametres 
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':title',$this->title);
            $stmt->bindParam(':body',$this->body);
            $stmt->bindParam(':author', $this->author);

            if($stmt->execute()) {
                return true;
            }
            printf("Error: %s.\n", $stmt->error);

            return false;

        }
        //method pour supprimer un post 
        public function delete($id) {
            $query = 'DELETE FROM ' . $this->table . 
            ' WHERE id = :id';
            $stmt = $this->conn->prepare($query);

            //trier les donnes 

            $this->id = htmlspecialchars(strip_tags($id));

            $stmt->bindParam(':id', $this->id);

            if ($stmt->execute()) {
                return true;
            }

            printf("Error: %s.\n", $stmt->error);
            return false;
        }

}