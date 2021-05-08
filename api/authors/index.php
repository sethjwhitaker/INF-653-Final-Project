<?php 
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require('../../config/database.php');
require('../../model/author.php');

$database = new Database();
$db = $database->connect();

$author = new Author($db);

$results = $author->read();

if(!empty($results)) {
    http_response_code(200);
    $arr = array();
    foreach($results as $result) {
        array_push($arr,
            array(
                'id' => $result['id'],
                'author' => $result['author']
            )
        );
    }
    echo json_encode($arr);
} else {
    http_response_code(404);
    echo json_encode(
        array('message' => 'No Authors Found')
    );
}
