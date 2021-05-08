<?php
require("config/database.php");
require("model/author.php");
require("model/category.php");
require("model/quote.php");

$database = new Database();
$db = $database->connect();

$action = filter_input(INPUT_GET, "action",  FILTER_SANITIZE_STRING);
if(!$action) {
    $action = "home";
}

$authorId = filter_input(INPUT_GET, "authorId", FILTER_SANITIZE_STRING);
$categoryId = filter_input(INPUT_GET, "categoryId", FILTER_SANITIZE_STRING);
$limit = filter_input(INPUT_GET, "limit", FILTER_SANITIZE_STRING);

switch ($action) {
    case "home":
        $authordb = new Author($db);
        $authors = $authordb->read();
        $categorydb = new Category($db);
        $categories = $categorydb->read();
        $quotedb = new Quote($db, null, null, $categoryId, $authorId, $limit);
        $quotes = $quotedb->read();
        require("./view/home.php");
        break;
    
}