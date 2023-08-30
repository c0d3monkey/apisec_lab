<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../../vendor/autoload.php';
use \Firebase\JWT\JWT;

include_once './config/Database.php';
include_once './models/Data.php';

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

$data = json_decode(file_get_contents("php://input"));

$customer_name = $data->customer_name;
$password = $data->password; // You might want to hash the password and then check it against the DB

// Check if customer exists with that name and password
$query = "SELECT id FROM customer WHERE name = ? AND password = ?";
$stmt = $db->prepare($query);
$stmt->execute([$customer_name, $password]);

$matches = $stmt->rowCount();
// Debugging info
$debuggingData = [
    "input_name" => $customer_name,
    "input_password" => $password, // Do note that showing the password in debugging might not be ideal for production
    "matches" => $matches
];

if ($matches) {
    // Generate JWT token
    $key = "your_secret_key";  // Make this a long, random string

    $token = [
        "iss" => "http://yourdomain.com",
        "aud" => "http://yourdomain.com",
        "iat" => time(),
        "exp" => time() + 3600,  // Token valid for 1 hour
        "data" => [
            "customer_id" => $stmt->fetchColumn()
        ]
    ];

    //$jwt = JWT::encode($token, $key);

    echo json_encode([
        "jwt" => JWT::encode($token, $key,'HS256'),
        "debug" => $debuggingData
    ]);
} else {
    echo json_encode([
        "message" => "Invalid credentials",
        "debug" => $debuggingData
    ]);
}
?>
