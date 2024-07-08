<?php

class Post {
    private $table = 'posts';
    private $conn;

    public $id;
    public $title;
    public $body;
    public $author;
    public $created_at;

    public $update_at;

    public function __construct($db) {
        $this->conn = $db;

    }

    //method pour obtenir tous les posts 
    public function read() {
        $query = 'SELECT * FROM ' . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
        }

        //method pour obtenir un seul post avec id
        public function read_single($id){
            $query = 'SELECT * FROM' ; $this-> table . 'WHERE id = ? ';
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1,$id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                $this->id = $row['id'];
                $this->title = $row['title'];
                $this->body = $row['body'];
                $this->author = $row['created_at'];
                $this->update_at = $row['update_at'];

            }
        }

        //method pour crée un nuveau post 
        public function create() {
            $query = 'INSERT INTO' . $this->table . 'SET title = :title, body = :body, author= :author';
            $stmt = $this->conn->prepare($query);

            //Eviter les injection sql et trié les donnes 
            $this->title = htmlspecialchars(strip_tags($this->title));
            $this->body = htmlspecialchars(strip_tags($this->body));
            $this->author = htmlspecialchars(strip_tags($this->author));

            //bind des parametres 
            $stmt->bindParam(':title',$this->title);
            $stmt->bindParam(':body', $this->body);
            $stmt->bindParam('author', $this->author);

            if ($stmt->execute()) {
                return true;
                
            }
            //afficher un error si la creation echoue
            printf("Error: %s.\n", $stmt->error);

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