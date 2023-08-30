<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../../../../vendor/autoload.php';
use \Firebase\JWT\JWT;
use Firebase\JWT\Key;

include_once '../../config/Database.php';
include_once '../../models/Data.php';

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

$database = new Database();

if (!$database) {
    echo json_encode(["debug" => "Failed to instantiate Database."]);
    exit;
}

$db = $database->connect();

if (!$db) {
    echo json_encode(["debug" => "Failed to connect to database."]);
    exit;
}

$data = json_decode(file_get_contents("php://input"));

if (!$data) {
    echo json_encode(["debug" => "Failed to decode input JSON."]);
    exit;
}

$headersReq = apache_request_headers();
$jwt = str_replace("Bearer ", "", $headersReq["Authorization"] ?? '');

if (!$jwt) {
    echo json_encode(["debug" => "JWT not found in Authorization header."]);
    exit;
}

// Step 1: Define your keys by kid
$keys = [
    "your_secret_key" => "your_secret_key"
];
// Step 2: Decode the header to get the kid (without verification)
$jwt_parts = explode('.', $jwt);
$jwt_header_json = base64_decode($jwt_parts[0]);
$jwt_header = json_decode($jwt_header_json, true);
$kid = $jwt_header['kid'] ?? null;

// Check if the kid is known to us
if (!isset($keys[$kid])) {
    http_response_code(401);
    echo json_encode(["message" => "Access denied.", "debug" => "Unknown key identifier."]);
    exit;
}

try {
    $key = $keys[$kid];
    //$decoded = JWT::decode($jwt, $key, ['HS256']);
    $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
    $post = new Data($db);
    $post->ue = $data->ue ?? '';
    $post->imsi = $data->imsi ?? '';
    $post->profile = $data->profile ?? '';
    $post->customer_id = $data->customer_id ?? '';

    if ($post->create()) {
        echo json_encode(["message" => "Subscription Created"]);
    } else {
        echo json_encode(["message" => "Subscription Not Created", "debug" => "Failed to create subscription in database."]);
    }
} catch (Exception $e) {
    http_response_code(401);
    echo json_encode(["message" => "Access denied.", "debug" => "Exception caught: " . $e->getMessage()]);
}
?>

