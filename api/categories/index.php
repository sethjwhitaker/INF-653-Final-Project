<?php 
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require('../../config/database.php');
require('../../model/category.php');

$database = new Database();
$db = $database->connect();

$category = new Category($db);

$results = $category->read();

if(!empty($results)) {
    http_response_code(200);
    $arr = array();
    foreach($results as $result) {
        array_push($arr,
            array(
                'id' => $result['id'],
                'category' => $result['category']
            )
        );
    }
    echo json_encode($arr);
} else {
    http_response_code(404);
    echo json_encode(
        array('message' => 'No Categories Found')
    );
}
