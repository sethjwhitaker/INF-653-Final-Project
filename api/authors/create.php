<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

require('../../config/database.php');
require('../../model/author.php');

$database = new Database();
$db = $database->connect();

$data = json_decode(file_get_contents("php://input"));

if(!isset($data->author)){
    http_response_code(400);
    echo json_encode(
        array('message' => 'Author Not Provided')
    );
} else {
    $auth_name = $data->author;
    $author = new Author($db, $auth_name);

    if($author->create()) {
        http_response_code(201);
        echo json_encode(
            array('message' => 'Author Created')
        );
    } else {
        http_response_code(501);
        echo json_encode(
            array('message' => 'Author Not Created')
        );
    }
}

