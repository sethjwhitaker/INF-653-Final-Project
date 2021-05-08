<?php
require_once("base_model.php");

class Category extends BaseModel {
    public function __construct($db, $value=null, $id=null) {
        parent::__construct($db, "categories", "category", $value, $id);
    }
}