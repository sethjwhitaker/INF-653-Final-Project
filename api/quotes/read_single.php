<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require('../../config/database.php');
require('../../model/quote.php');

$database = new Database();
$db = $database->connect();

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if(!empty($id)) {
    $quote = new Quote($db, $id, $id);
    $result = $quote->read_single();
    if(!empty($result)) {
        http_response_code(200);
        echo json_encode(
            array(
                'id' => $result['id'],
                'quote' => $result['quote'],
                'author' => $result['author'],
                'category' => $result['category']
            )
        );
    } else {
        http_response_code(404);
        echo json_encode(
            array('message' => 'Quote With ID ' . $id . ' Not Found')
        );
    }
} else {
    http_response_code(400);
    echo json_encode(
        array('message' => 'ID Not Provided')
    );
}