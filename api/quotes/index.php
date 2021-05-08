<?php 
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require('../../config/database.php');
require('../../model/quote.php');

$database = new Database();
$db = $database->connect();

$cat_id = filter_input(INPUT_GET, "categoryId", FILTER_VALIDATE_INT);
$auth_id = filter_input(INPUT_GET, "authorId", FILTER_VALIDATE_INT);
$limit = filter_input(INPUT_GET, "limit", FILTER_VALIDATE_INT);

$quote = new Quote($db, null, null, $cat_id, $auth_id, $limit);

$results = $quote->read();

if(!empty($results)) {
    $arr = array();
    foreach($results as $result) {
        array_push($arr,
            array(
                'id' => $result['id'],
                'quote' => $result['quote'],
                'author' => $result['author'],
                'category' => $result['category']
            )
        );
    }
    http_response_code(200);
    echo json_encode($arr);
} else {
    http_response_code(404);
    echo json_encode(
        array('message' => 'No Quotes Found')
    );
}