<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: DELETE');
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

  // Delete id
  $post->id = $data->id;

  // Delete request
  if($post->delete()) {
    echo json_encode(
        array('message' => 'Subscription delete')
    );
}  else {
    echo json_encode(
        array('message' => 'Subscription Not delete')
    );
}