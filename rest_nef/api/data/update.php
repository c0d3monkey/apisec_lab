<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
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

  // update id
  $post->id = $data->id;

  $post->ue = $data->ue;
  $post->imsi = $data->imsi;
  $post->profile = $data->profile;
  $post->customer_id = $data->customer_id;

  // Update request
  if($post->update()) {
    echo json_encode(
        array('message' => 'Subscription Updated')
    );
}  else {
    echo json_encode(
        array('message' => 'Subscription Not Updated')
    );
}