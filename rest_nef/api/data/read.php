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
  
  // Customer data query
  $result = $data->read();
  // Get row count
  $num = $result->rowCount();

  // Check if any data
  if($num > 0) {
    // Data array
    $data_arr = array();
    $data_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $data_item = array(
        'id' => $id,
        'ue' => $ue,
        'imsi' => $imsi,
        'profile' => $profile,
        'customer_id' => $customer_id,
        'customer_name' => $customer_name
      );

      // Push to "data"
      array_push($data_arr['data'], $data_item);
    }

    // Turn to JSON & output
    echo json_encode($data_arr);


  } else {
    // No data
    echo json_encode(
        array('message' => 'No Data Found')
    );
  }