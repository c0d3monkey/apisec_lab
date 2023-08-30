<?php
require_once '../../vendor/autoload.php';
use \Firebase\JWT\JWT;

include_once '../../config/Database.php';
include_once '../../models/Data.php';

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

$database = new Database();
$db = $database->connect();
$data = json_decode(file_get_contents("php://input"));

$headers = apache_request_headers();
$jwt = $headers["Authorization"] ?? '';

if ($jwt) {
    try {
        $key = "your_secret_key";
        $decoded = JWT::decode($jwt, $key, ['HS256']);

        $post = new Data($db);
        $post->ue = $data->ue;
        $post->imsi = $data->imsi;
        $post->profile = $data->profile;
        $post->customer_id = $data->customer_id;

        if ($post->create()) {
            echo json_encode(["message" => "Subscription Created"]);
        } else {
            echo json_encode(["message" => "Subscription Not Created"]);
        }

    } catch (Exception $e) {
        http_response_code(401);
        echo json_encode(["message" => "Access denied."]);
    }
} else {
    http_response_code(401);
    echo json_encode(["message" => "Access denied."]);
}
?>

