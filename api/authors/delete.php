<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

require('../../config/database.php');
require('../../model/author.php');

$database = new Database();
$db = $database->connect();

$data = json_decode(file_get_contents("php://input"));

if(!isset($data->id)){
    http_response_code(400);
    echo json_encode(
        array('message' => 'ID Not Provided')
    );
} else {
    $id = $data->id;
    $author = new Author($db,null,$id);

    if($author->delete()) {
        http_response_code(200);
        echo json_encode(
            array('message' => 'Author Deleted')
        );
    } else {
        http_response_code(501);
        echo json_encode(
            array('message' => 'Author Not Deleted')
        );
    }
}