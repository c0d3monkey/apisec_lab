<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Data.php';

  // Instantiate DA & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate data object
  $data = new Data($db);

  // Get ID
  $data->id = isset($_GET['id']) ? $_GET['id'] : die();

  // Get data
  $data->read_single();

  // Create array
  $data_arr = array(
    'id' => $data->id,
    'ue' => $data->ue,
    'imsi' => $data->imsi,
    'profile' => $data->profile,
    'customer_id' => $data->customer_id,
    'customer_name' => $data->customer_name
  );

  // Make JSON
  print_r(json_encode($data_arr));

