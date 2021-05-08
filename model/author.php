<?php
require_once("base_model.php");

class Author extends BaseModel {
    public function __construct($db, $value=null, $id=null) {
        parent::__construct($db, "authors", "author", $value, $id);
    }
}