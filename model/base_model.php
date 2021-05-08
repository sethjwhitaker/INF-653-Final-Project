<?php
class BaseModel {

    private $conn;
    private $tableName;
    private $rowName;

    public $value;
    public $id;


    public function __construct($db, $tableName, $rowName, $value, $id) {
        $this->conn = $db;
        $this->tableName = $tableName;
        $this->rowName = $rowName;
        $this->value = $value;
        $this->id = $id;
    }

    public function read() {

        $query = 'SELECT * FROM ' 
            . $this->tableName .
            ' ORDER BY ' 
            . $this->rowName;

        $statement = $this->conn->prepare($query);
        $statement->execute();
        $results = $statement->fetchAll();
        $statement->closeCursor();

        return $results;
    }

    public function read_single(){
        $query = 'SELECT * FROM ' 
            . $this->tableName . 
            ' WHERE id = :id
            LIMIT 0,1';

        $statement = $this->conn->prepare($query);
        $statement->bindValue(":id", $this->id);
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();
        
        return $result;
    }

    public function create() {
        $query = 'INSERT INTO ' 
            . $this->tableName . 
            ' SET '
            . $this->rowName .
            ' = :value';

        $statement = $this->conn->prepare($query);
        $statement-> bindValue(':value', $this->value);

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
        $query = 'UPDATE ' 
            . $this->tableName . 
            ' SET '
            . $this->rowName .
            ' = :value WHERE id = :id';

        $statement = $this->conn->prepare($query);
        $statement-> bindValue(':value', $this->value);
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
        $query = 'DELETE FROM ' 
            . $this->tableName . 
            ' WHERE id = :id';

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