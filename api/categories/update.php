<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

require('../../config/database.php');
require('../../model/category.php');

$database = new Database();
$db = $database->connect();

$data = json_decode(file_get_contents("php://input"));

if(!isset($data->category)){
    http_response_code(400);
    echo json_encode(
        array('message' => 'Category Not Provided')
    );
} else if(!isset($data->id)) {
    http_response_code(400);
    echo json_encode(
        array('message' => 'ID Not Provided')
    );
} else {
    $id = $data->id;
    $cat_name = $data->category;

    $category = new Category($db, $cat_name, $id);

    if($category->update()) {
        http_response_code(200);
        echo json_encode(
            array('message' => 'Category Updated')
        );
    } else {
        http_response_code(501);
        echo json_encode(
            array('message' => 'Category Not Updated')
        );
    }
}
