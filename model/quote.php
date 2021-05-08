<?php
class Quote {

    private $conn;

    public $id;
    public $quote;
    public $cat_id;
    public $auth_id;
    public $limit;

    public $category;
    public $author;


    public function __construct($db, $id=null, $quote=null, $cat_id=null, $auth_id=null, $limit=null) {
        $this->conn = $db;
        $this->id = $id;
        $this->quote = $quote;
        $this->cat_id = $cat_id;
        $this->auth_id = $auth_id;
        $this->limit = $limit;
    }

    public function read() {

        $query = 'SELECT q.id, q.quote, c.category, a.author FROM quotes q
            JOIN categories c ON q.category_id = c.id
            JOIN authors a ON q.author_id = a.id';

        // add optional params
        if(!empty($this->cat_id) && !empty($this->auth_id)) {
            $query .= ' WHERE category_id = :cat_id
                        AND author_id = :auth_id';
        } else if (!empty($this->cat_id)) {
            $query .= ' WHERE category_id = :cat_id';
        } else if (!empty($this->auth_id)) {
            $query .= ' WHERE author_id = :auth_id';
        }
        if(!empty($this->limit)) {
            $query .= ' LIMIT 0,:limit';
        }
        

        $statement = $this->conn->prepare($query);


        // bind optional values
        if(!empty($this->cat_id) && !empty($this->auth_id)) {
            $statement->bindValue(':cat_id', $this->cat_id);
            $statement->bindValue(':auth_id', $this->auth_id);
        } else if (!empty($this->cat_id)) {
            $statement->bindValue(':cat_id', $this->cat_id);
        } else if (!empty($this->auth_id)) {
            $statement->bindValue(':auth_id', $this->auth_id);
        }
        if(!empty($this->limit)) {
            $statement->bindValue(':limit', $this->limit, PDO::PARAM_INT);
        }


        $statement->execute();
        $results = $statement->fetchAll();
        $statement->closeCursor();

        return $results;
    }

    public function read_single(){
        $query = 'SELECT q.id, q.quote, c.category, a.author FROM quotes q
            JOIN categories c ON q.category_id = c.id
            JOIN authors a ON q.author_id = a.id
            WHERE q.id = :id
            LIMIT 0,1';


        $statement = $this->conn->prepare($query);
        $statement->bindValue(':id', $this->id);
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();

        return $result;
    }

    public function create() {
        $query = 'INSERT INTO quotes SET
            quote = :quote,
            category_id = :cat_id,
            author_id = :auth_id';

        $statement = $this->conn->prepare($query);
        $statement-> bindValue(':quote', $this->quote);
        $statement-> bindValue(':cat_id', $this->cat_id);
        $statement-> bindValue(':auth_id', $this->auth_id);

        if($statement->execute()) {
            $statement->closeCursor();
            return true;
        } else {
            http_response_code(501);
            echo json_encode(
                array("error" => "$s.\n", $statement->error)
            );
            $statement->closeCursor();
            return false;
        }
    }

    public function update() {
        $query = 'UPDATE quotes SET 
            quote = :quote,
            category_id = :cat_id,
            author_id = :auth_id
            WHERE id = :id';

        $statement = $this->conn->prepare($query);
        $statement-> bindValue(':quote', $this->quote);
        $statement-> bindValue(':cat_id', $this->cat_id);
        $statement-> bindValue(':auth_id', $this->auth_id);
        $statement-> bindValue(':id', $this->id);

        if($statement->execute()) {
            $statement->closeCursor();
            return true;
        } else {
            http_response_code(501);
            echo json_encode(
                array("error" => "$s.\n", $statement->error)
            );
            $statement->closeCursor();
            return false;
        }

    }

    public function delete() {
        $query = 'DELETE FROM quotes 
            WHERE id = :id';

        $statement = $this->conn->prepare($query);
        $statement-> bindParam(':id', $this->id);

        if($statement->execute()) {
            $statement->closeCursor();
            return true;
        } else {
            http_response_code(501);
            echo json_encode(
                array("error" => "$s.\n", $statement->error)
            );
            $statement->closeCursor();
            return false;
        }
    }
}