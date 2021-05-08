<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

require('../../config/database.php');
require('../../model/quote.php');

$database = new Database();
$db = $database->connect();

$data = json_decode(file_get_contents("php://input"));

if(!isset($data->quote)){
    http_response_code(400);
    echo json_encode(
        array('message' => 'Quote Not Provided')
    );
} else if(!isset($data->categoryId)) {
    http_response_code(400);
    echo json_encode(
        array('message' => 'Category ID Not Provided')
    );
} else if(!isset($data->authorId)) {
    http_response_code(400);
    echo json_encode(
        array('message' => 'Author ID Not Provided')
    );
} else {
    $q = $data->quote;
    $c_id = $data->categoryId;
    $a_id = $data->authorId;
    $quote = new Quote($db, null, $q, $c_id, $a_id);

    if($quote->create()) {
        http_response_code(201);
        echo json_encode(
            array('message' => 'Quote Created')
        );
    } else {
        http_response_code(501);
        echo json_encode(
            array('message' => 'Quote Not Created')
        );
    }
}

