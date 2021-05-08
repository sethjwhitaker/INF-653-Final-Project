<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require('../../config/database.php');
require('../../model/author.php');

$database = new Database();
$db = $database->connect();

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if(!empty($id)) {
    echo $id;
    $author = new Author($db,null,$id);
    $result = $author->read_single();
    if(!empty($result)) {
        http_response_code(200);
        echo json_encode(
            array(
                'id' => $result['id'],
                'author' => $result['author']
            )
        );
    } else {
        http_response_code(404);
        echo json_encode(
            array('message' => 'Author With ID ' . $id . ' Not Found')
        );
    }
} else {
    http_response_code(400);
    echo json_encode(
        array('message' => 'ID Not Provided')
    );
}