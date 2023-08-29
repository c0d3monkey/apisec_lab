<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization');


  include_once '../../config/Database.php';
  include_once '../../models/Data.php';

  // Instantiate DA & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate data object
  $post = new Data($db);

  // Get the raw posted data
  $data = json_decode(file_get_contents("php://input"));

  $post->ue = $data->ue;
  $post->imsi = $data->imsi;
  $post->profile = $data->profile;
  $post->customer_id = $data->customer_id;

  // Create request
  if($post->create()) {
    echo json_encode(
        array('message' => 'Subscription Created')
    );
}  else {
    echo json_encode(
        array('message' => 'Subscription Not Created')
    );
}