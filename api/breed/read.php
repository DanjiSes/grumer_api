<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Breed.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate breed object
  $breed = new Breed($db);

  // Breed query
  $result = $breed->read();

  // Get row count
  $num = $result->rowCount();

  // Check if any clients
  if ($num > 0) {
    // Clients array
    $breeds_arr = array();
    $breeds_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $breeds_item = array(
        'id' => $id,
        'name' => $name,
        'animal_name' => $animal_name
      );

      array_push($breeds_arr['data'], $breeds_item);
    }

  }
  // Turn to JSON & output
  echo json_encode($breeds_arr);